<?php

namespace EphenyxShop\PhenyxSpreadsheet\Style\ConditionalFormatting;

use EphenyxShop\PhenyxSpreadsheet\Cell\Cell;
use EphenyxShop\PhenyxSpreadsheet\Style\Conditional;
use EphenyxShop\PhenyxSpreadsheet\Style\Style;

class CellStyleAssessor {

    /**
     * @var CellMatcher
     */
    protected $cellMatcher;

    /**
     * @var StyleMerger
     */
    protected $styleMerger;

    public function __construct(Cell $cell, string $conditionalRange) {

        $this->cellMatcher = new CellMatcher($cell, $conditionalRange);
        $this->styleMerger = new StyleMerger($cell->getStyle());
    }

    /**
     * @param Conditional[] $conditionalStyles
     */
    public function matchConditions(array $conditionalStyles = []): Style {

        foreach ($conditionalStyles as $conditional) {
            /** @var Conditional $conditional */

            if ($this->cellMatcher->evaluateConditional($conditional) === true) {
                // Merging the conditional style into the base style goes in here
                $this->styleMerger->mergeStyle($conditional->getStyle());

                if ($conditional->getStopIfTrue() === true) {
                    break;
                }

            }

        }

        return $this->styleMerger->getStyle();
    }

}
