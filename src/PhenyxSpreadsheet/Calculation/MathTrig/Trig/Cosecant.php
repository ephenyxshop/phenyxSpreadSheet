<?php

namespace EphenyxShop\PhenyxSpreadsheet\Calculation\MathTrig\Trig;

use EphenyxShop\PhenyxSpreadsheet\Calculation\ArrayEnabled;
use EphenyxShop\PhenyxSpreadsheet\Calculation\Exception;
use EphenyxShop\PhenyxSpreadsheet\Calculation\MathTrig\Helpers;

class Cosecant {

    use ArrayEnabled;

    /**
     * CSC.
     *
     * Returns the cosecant of an angle.
     *
     * @param array|float $angle Number, or can be an array of numbers
     *
     * @return array|float|string The cosecant of the angle
     *         If an array of numbers is passed as the argument, then the returned result will also be an array
     *            with the same dimensions
     */
    public static function csc($angle) {

        if (is_array($angle)) {
            return self::evaluateSingleArgumentArray([self::, __FUNCTION__], $angle);
        }

        try {
            $angle = Helpers::validateNumericNullBool($angle);
        } catch (Exception $e) {
            return $e->getMessage();
        }

        return Helpers::verySmallDenominator(1.0, sin($angle));
    }

    /**
     * CSCH.
     *
     * Returns the hyperbolic cosecant of an angle.
     *
     * @param array|float $angle Number, or can be an array of numbers
     *
     * @return array|float|string The hyperbolic cosecant of the angle
     *         If an array of numbers is passed as the argument, then the returned result will also be an array
     *            with the same dimensions
     */
    public static function csch($angle) {

        if (is_array($angle)) {
            return self::evaluateSingleArgumentArray([self::, __FUNCTION__], $angle);
        }

        try {
            $angle = Helpers::validateNumericNullBool($angle);
        } catch (Exception $e) {
            return $e->getMessage();
        }

        return Helpers::verySmallDenominator(1.0, sinh($angle));
    }

}
