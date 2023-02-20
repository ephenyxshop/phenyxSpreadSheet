<?php

namespace EphenyxShop\PhenyxSpreadsheet\Calculation\Statistical;

abstract class MaxMinBase {

    protected static function datatypeAdjustmentAllowStrings($value) {

        if (is_bool($value)) {
            return (int) $value;
        } else if (is_string($value)) {
            return 0;
        }

        return $value;
    }

}
