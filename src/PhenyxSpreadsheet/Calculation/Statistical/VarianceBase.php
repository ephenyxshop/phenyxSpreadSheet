<?php

namespace Ephenyxshop\PhenyxSpreadsheet\Calculation\Statistical;

use Ephenyxshop\PhenyxSpreadsheet\Calculation\Functions;

abstract class VarianceBase {

    protected static function datatypeAdjustmentAllowStrings($value) {

        if (is_bool($value)) {
            return (int) $value;
        } else if (is_string($value)) {
            return 0;
        }

        return $value;
    }

    protected static function datatypeAdjustmentBooleans($value) {

        if (is_bool($value) && (Functions::getCompatibilityMode() == Functions::COMPATIBILITY_OPENOFFICE)) {
            return (int) $value;
        }

        return $value;
    }

}
