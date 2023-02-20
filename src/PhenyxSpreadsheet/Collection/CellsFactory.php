<?php

namespace EphenyxShop\PhenyxSpreadsheet\Collection;

use EphenyxShop\PhenyxSpreadsheet\Settings;
use EphenyxShop\PhenyxSpreadsheet\Worksheet\Worksheet;

abstract class CellsFactory {

    /**
     * Initialise the cache storage.
     *
     * @param Worksheet $worksheet Enable cell caching for this worksheet
     *
     * @return Cells
     * */
    public static function getInstance(Worksheet $worksheet) {

        return new Cells($worksheet, Settings::getCache());
    }
}
