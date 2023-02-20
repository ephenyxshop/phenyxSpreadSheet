<?php

namespace Ephenyxshop\PhenyxSpreadsheet\Calculation\TextData;

use Ephenyxshop\PhenyxSpreadsheet\Calculation\Calculation;
use Ephenyxshop\PhenyxSpreadsheet\Calculation\Exception as CalcExp;
use Ephenyxshop\PhenyxSpreadsheet\Calculation\Functions;
use Ephenyxshop\PhenyxSpreadsheet\Calculation\Information\ExcelError;

class Helpers {

    public static function convertBooleanValue(bool $value): string {

        if (Functions::getCompatibilityMode() == Functions::COMPATIBILITY_OPENOFFICE) {
            return $value ? '1' : '0';
        }

        return ($value) ? Calculation::getTRUE() : Calculation::getFALSE();
    }

    /**
     * @param mixed $value String value from which to extract characters
     */
    public static function extractString($value): string {

        if (is_bool($value)) {
            return self::convertBooleanValue($value);
        }

        return (string) $value;
    }

    /**
     * @param mixed $value
     */
    public static function extractInt($value, int $minValue, int $gnumericNull = 0, bool $ooBoolOk = false): int {

        if ($value === null) {
            // usually 0, but sometimes 1 for Gnumeric
            $value = (Functions::getCompatibilityMode() === Functions::COMPATIBILITY_GNUMERIC) ? $gnumericNull : 0;
        }

        if (is_bool($value) && ($ooBoolOk || Functions::getCompatibilityMode() !== Functions::COMPATIBILITY_OPENOFFICE)) {
            $value = (int) $value;
        }

        if (!is_numeric($value)) {
            throw new CalcExp(ExcelError::VALUE());
        }

        $value = (int) $value;

        if ($value < $minValue) {
            throw new CalcExp(ExcelError::VALUE());
        }

        return (int) $value;
    }

    /**
     * @param mixed $value
     */
    public static function extractFloat($value): float {

        if ($value === null) {
            $value = 0.0;
        }

        if (is_bool($value)) {
            $value = (float) $value;
        }

        if (!is_numeric($value)) {
            throw new CalcExp(ExcelError::VALUE());
        }

        return (float) $value;
    }

    /**
     * @param mixed $value
     */
    public static function validateInt($value): int {

        if ($value === null) {
            $value = 0;
        } else if (is_bool($value)) {
            $value = (int) $value;
        }

        return (int) $value;
    }

}
