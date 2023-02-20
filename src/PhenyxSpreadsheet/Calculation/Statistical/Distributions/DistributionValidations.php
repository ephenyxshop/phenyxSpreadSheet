<?php

namespace Ephenyxshop\PhenyxSpreadsheet\Calculation\Statistical\Distributions;

use Ephenyxshop\PhenyxSpreadsheet\Calculation\Exception;
use Ephenyxshop\PhenyxSpreadsheet\Calculation\Information\ExcelError;
use Ephenyxshop\PhenyxSpreadsheet\Calculation\Statistical\StatisticalValidations;

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
