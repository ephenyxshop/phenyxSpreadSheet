<?php

namespace Ephenyxshop\PhenyxSpreadsheet\Collection;

use Ephenyxshop\PhenyxSpreadsheet\Settings;
use Ephenyxshop\PhenyxSpreadsheet\Worksheet\Worksheet;

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
