<?php

namespace Ephenyxshop\PhenyxSpreadsheet\Calculation\MathTrig;

use Ephenyxshop\PhenyxSpreadsheet\Calculation\Exception;
use Ephenyxshop\PhenyxSpreadsheet\Calculation\Functions;
use Ephenyxshop\PhenyxSpreadsheet\Calculation\Information\ExcelError;
use Ephenyxshop\PhenyxSpreadsheet\Calculation\Statistical;

class Subtotal {

    /**
     * @param mixed $cellReference
     * @param mixed $args
     */
    protected static function filterHiddenArgs($cellReference, $args): array
    {

        return array_filter(
            $args,
            function ($index) use ($cellReference) {

                [, $row] = explode('.', $index);

                return $cellReference->getWorksheet()->getRowDimension($row)->getVisible();
            },
            ARRAY_FILTER_USE_KEY
        );
    }

    /**
     * @param mixed $cellReference
     * @param mixed $args
     */
    protected static function filterFormulaArgs($cellReference, $args): array
    {

        return array_filter(
            $args,
            function ($index) use ($cellReference) {

                [, $row, $column] = explode('.', $index);
                $retVal = true;

                if ($cellReference->getWorksheet()->cellExists($column . $row)) {
                    //take this cell out if it contains the SUBTOTAL or AGGREGATE functions in a formula
                    $isFormula = $cellReference->getWorksheet()->getCell($column . $row)->isFormula();
                    $cellFormula = !preg_match(
                        '/^=.*\b(SUBTOTAL|AGGREGATE)\s*\(/i',
                        $cellReference->getWorksheet()->getCell($column . $row)->getValue() ?  ? ''
                    );

                    $retVal = !$isFormula || $cellFormula;
                }

                return $retVal;
            },
            ARRAY_FILTER_USE_KEY
        );
    }

    /** @var callable[] */
    private const CALL_FUNCTIONS = [
        1 => [Statistical\Averages::, 'average'], // 1 and 101
        [Statistical\Counts::, 'COUNT'], // 2 and 102
        [Statistical\Counts::, 'COUNTA'], // 3 and 103
        [Statistical\Maximum::, 'max'], // 4 and 104
        [Statistical\Minimum::, 'min'], // 5 and 105
        [Operations::, 'product'], // 6 and 106
        [Statistical\StandardDeviations::, 'STDEV'], // 7 and 107
        [Statistical\StandardDeviations::, 'STDEVP'], // 8 and 108
        [Sum::, 'sumIgnoringStrings'], // 9 and 109
        [Statistical\Variances::, 'VAR'], // 10 and 110
        [Statistical\Variances::, 'VARP'], // 111 and 111
    ];

    /**
     * SUBTOTAL.
     *
     * Returns a subtotal in a list or database.
     *
     * @param mixed $functionType
     *            A number 1 to 11 that specifies which function to
     *                    use in calculating subtotals within a range
     *                    list
     *            Numbers 101 to 111 shadow the functions of 1 to 11
     *                    but ignore any values in the range that are
     *                    in hidden rows
     * @param mixed[] $args A mixed data series of values
     *
     * @return float|string
     */
    public static function evaluate($functionType, ...$args) {

        $cellReference = array_pop($args);
        $aArgs = Functions::flattenArrayIndexed($args);

        try {
            $subtotal = (int) Helpers::validateNumericNullBool($functionType);
        } catch (Exception $e) {
            return $e->getMessage();
        }

        // Calculate

        if ($subtotal > 100) {
            $aArgs = self::filterHiddenArgs($cellReference, $aArgs);
            $subtotal -= 100;
        }

        $aArgs = self::filterFormulaArgs($cellReference, $aArgs);

        if (array_key_exists($subtotal, self::CALL_FUNCTIONS)) {
            /** @var callable */
            $call = self::CALL_FUNCTIONS[$subtotal];

            return call_user_func_array($call, $aArgs);
        }

        return ExcelError::VALUE();
    }

}