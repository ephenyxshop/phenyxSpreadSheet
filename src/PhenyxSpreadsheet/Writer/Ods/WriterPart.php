<?php

namespace Ephenyxshop\PhenyxSpreadsheet\Writer\Ods;

use Ephenyxshop\PhenyxSpreadsheet\Writer\Ods;

abstract class WriterPart {

    /**
     * Parent Ods object.
     *
     * @var Ods
     */
    private $parentWriter;

    /**
     * Get Ods writer.
     *
     * @return Ods
     */
    public function getParentWriter() {

        return $this->parentWriter;
    }

    /**
     * Set parent Ods writer.
     */
    public function __construct(Ods $writer) {

        $this->parentWriter = $writer;
    }

    abstract public function write(): string;
}
