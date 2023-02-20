<?php

namespace EphenyxShop\PhenyxSpreadsheet\Calculation\Statistical\Distributions;

use EphenyxShop\PhenyxSpreadsheet\Calculation\Exception;
use EphenyxShop\PhenyxSpreadsheet\Calculation\Information\ExcelError;
use EphenyxShop\PhenyxSpreadsheet\Calculation\Statistical\StatisticalValidations;

class DistributionValidations extends StatisticalValidations {

    /**
     * @param mixed $probability
     */
    public static function validateProbability($probability): float{

        $probability = self::validateFloat($probability);

        if ($probability < 0.0 || $probability > 1.0) {
            throw new Exception(ExcelError::NAN());
        }

        return $probability;
    }

}
