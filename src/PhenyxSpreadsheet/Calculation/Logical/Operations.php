<?php

namespace Ephenyxshop\PhenyxSpreadsheet\Calculation\Logical;

use Ephenyxshop\PhenyxSpreadsheet\Calculation\ArrayEnabled;
use Ephenyxshop\PhenyxSpreadsheet\Calculation\Calculation;
use Ephenyxshop\PhenyxSpreadsheet\Calculation\Functions;
use Ephenyxshop\PhenyxSpreadsheet\Calculation\Information\ExcelError;

class Operations {

    use ArrayEnabled;

    /**
     * LOGICAL_AND.
     *
     * Returns boolean TRUE if all its arguments are TRUE; returns FALSE if one or more argument is FALSE.
     *
     * Excel Function:
     *        =AND(logical1[,logical2[, ...]])
     *
     *        The arguments must evaluate to logical values such as TRUE or FALSE, or the arguments must be arrays
     *            or references that contain logical values.
     *
     *        Boolean arguments are treated as True or False as appropriate
     *        Integer or floating point arguments are treated as True, except for 0 or 0.0 which are False
     *        If any argument value is a string, or a Null, the function returns a #VALUE! error, unless the string
     *            holds the value TRUE or FALSE, in which case it is evaluated as the corresponding boolean value
     *
     * @param mixed ...$args Data values
     *
     * @return bool|string the logical AND of the arguments
     */
    public static function logicalAnd(...$args) {

        $args = Functions::flattenArray($args);

        if (count($args) == 0) {
            return ExcelError::VALUE();
        }

        $args = array_filter($args, function ($value) {

            return $value !== null || (is_string($value) && trim($value) == '');
        });

        $returnValue = self::countTrueValues($args);

        if (is_string($returnValue)) {
            return $returnValue;
        }

        $argCount = count($args);

        return ($returnValue > 0) && ($returnValue == $argCount);
    }

    /**
     * LOGICAL_OR.
     *
     * Returns boolean TRUE if any argument is TRUE; returns FALSE if all arguments are FALSE.
     *
     * Excel Function:
     *        =OR(logical1[,logical2[, ...]])
     *
     *        The arguments must evaluate to logical values such as TRUE or FALSE, or the arguments must be arrays
     *            or references that contain logical values.
     *
     *        Boolean arguments are treated as True or False as appropriate
     *        Integer or floating point arguments are treated as True, except for 0 or 0.0 which are False
     *        If any argument value is a string, or a Null, the function returns a #VALUE! error, unless the string
     *            holds the value TRUE or FALSE, in which case it is evaluated as the corresponding boolean value
     *
     * @param mixed $args Data values
     *
     * @return bool|string the logical OR of the arguments
     */
    public static function logicalOr(...$args) {

        $args = Functions::flattenArray($args);

        if (count($args) == 0) {
            return ExcelError::VALUE();
        }

        $args = array_filter($args, function ($value) {

            return $value !== null || (is_string($value) && trim($value) == '');
        });

        $returnValue = self::countTrueValues($args);

        if (is_string($returnValue)) {
            return $returnValue;
        }

        return $returnValue > 0;
    }

    /**
     * LOGICAL_XOR.
     *
     * Returns the Exclusive Or logical operation for one or more supplied conditions.
     * i.e. the Xor function returns TRUE if an odd number of the supplied conditions evaluate to TRUE,
     *      and FALSE otherwise.
     *
     * Excel Function:
     *        =XOR(logical1[,logical2[, ...]])
     *
     *        The arguments must evaluate to logical values such as TRUE or FALSE, or the arguments must be arrays
     *            or references that contain logical values.
     *
     *        Boolean arguments are treated as True or False as appropriate
     *        Integer or floating point arguments are treated as True, except for 0 or 0.0 which are False
     *        If any argument value is a string, or a Null, the function returns a #VALUE! error, unless the string
     *            holds the value TRUE or FALSE, in which case it is evaluated as the corresponding boolean value
     *
     * @param mixed $args Data values
     *
     * @return bool|string the logical XOR of the arguments
     */
    public static function logicalXor(...$args) {

        $args = Functions::flattenArray($args);

        if (count($args) == 0) {
            return ExcelError::VALUE();
        }

        $args = array_filter($args, function ($value) {

            return $value !== null || (is_string($value) && trim($value) == '');
        });

        $returnValue = self::countTrueValues($args);

        if (is_string($returnValue)) {
            return $returnValue;
        }

        return $returnValue % 2 == 1;
    }

    /**
     * NOT.
     *
     * Returns the boolean inverse of the argument.
     *
     * Excel Function:
     *        =NOT(logical)
     *
     *        The argument must evaluate to a logical value such as TRUE or FALSE
     *
     *        Boolean arguments are treated as True or False as appropriate
     *        Integer or floating point arguments are treated as True, except for 0 or 0.0 which are False
     *        If any argument value is a string, or a Null, the function returns a #VALUE! error, unless the string
     *            holds the value TRUE or FALSE, in which case it is evaluated as the corresponding boolean value
     *
     * @param mixed $logical A value or expression that can be evaluated to TRUE or FALSE
     *                      Or can be an array of values
     *
     * @return array|bool|string the boolean inverse of the argument
     *         If an array of values is passed as an argument, then the returned result will also be an array
     *            with the same dimensions
     */
    public static function NOT($logical = false) {

        if (is_array($logical)) {
            return self::evaluateSingleArgumentArray([self::, __FUNCTION__], $logical);
        }

        if (is_string($logical)) {
            $logical = mb_strtoupper($logical, 'UTF-8');

            if (($logical == 'TRUE') || ($logical == Calculation::getTRUE())) {
                return false;
            } else if (($logical == 'FALSE') || ($logical == Calculation::getFALSE())) {
                return true;
            }

            return ExcelError::VALUE();
        }

        return !$logical;
    }

    /**
     * @return int|string
     */
    private static function countTrueValues(array $args) {

        $trueValueCount = 0;

        foreach ($args as $arg) {
            // Is it a boolean value?

            if (is_bool($arg)) {
                $trueValueCount += $arg;
            } else if ((is_numeric($arg)) && (!is_string($arg))) {
                $trueValueCount += ((int) $arg != 0);
            } else if (is_string($arg)) {
                $arg = mb_strtoupper($arg, 'UTF-8');

                if (($arg == 'TRUE') || ($arg == Calculation::getTRUE())) {
                    $arg = true;
                } else if (($arg == 'FALSE') || ($arg == Calculation::getFALSE())) {
                    $arg = false;
                } else {
                    return ExcelError::VALUE();
                }

                $trueValueCount += ($arg != 0);
            }

        }

        return $trueValueCount;
    }

}