<?php

namespace Ephenyxshop\PhenyxSpreadsheet\Calculation\Engineering;

use Ephenyxshop\PhenyxSpreadsheet\Calculation\ArrayEnabled;
use Ephenyxshop\PhenyxSpreadsheet\Calculation\Exception;
use Ephenyxshop\PhenyxSpreadsheet\Calculation\Functions;
use Ephenyxshop\PhenyxSpreadsheet\Calculation\Information\ExcelError;

abstract class ConvertBase {

    use ArrayEnabled;

    protected static function validateValue($value): string {

        if (is_bool($value)) {

            if (Functions::getCompatibilityMode() !== Functions::COMPATIBILITY_OPENOFFICE) {
                throw new Exception(ExcelError::VALUE());
            }

            $value = (int) $value;
        }

        if (is_numeric($value)) {

            if (Functions::getCompatibilityMode() == Functions::COMPATIBILITY_GNUMERIC) {
                $value = floor((float) $value);
            }

        }

        return strtoupper((string) $value);
    }

    protected static function validatePlaces($places = null):  ? int {

        if ($places === null) {
            return $places;
        }

        if (is_numeric($places)) {

            if ($places < 0 || $places > 10) {
                throw new Exception(ExcelError::NAN());
            }

            return (int) $places;
        }

        throw new Exception(ExcelError::VALUE());
    }

    /**
     * Formats a number base string value with leading zeroes.
     *
     * @param string $value The "number" to pad
     * @param ?int $places The length that we want to pad this value
     *
     * @return string The padded "number"
     */
    protected static function nbrConversionFormat(string $value,  ? int $places) : string {

        if ($places !== null) {

            if (strlen($value) <= $places) {
                return substr(str_pad($value, $places, '0', STR_PAD_LEFT), -10);
            }

            return ExcelError::NAN();
        }

        return substr($value, -10);
    }

}