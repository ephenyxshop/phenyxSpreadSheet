<?php

namespace EphenyxShop\PhenyxSpreadsheet\Writer\Ods;

use EphenyxShop\PhenyxSpreadsheet\Shared\XMLWriter;
use EphenyxShop\PhenyxSpreadsheet\Spreadsheet;
use EphenyxShop\PhenyxSpreadsheet\Worksheet\AutoFilter;
use EphenyxShop\PhenyxSpreadsheet\Worksheet\Worksheet;

class AutoFilters {

    /**
     * @var XMLWriter
     */
    private $objWriter;

    /**
     * @var Spreadsheet
     */
    private $spreadsheet;

    public function __construct(XMLWriter $objWriter, Spreadsheet $spreadsheet) {

        $this->objWriter = $objWriter;
        $this->spreadsheet = $spreadsheet;
    }

    public function write(): void{

        $wrapperWritten = false;
        $sheetCount = $this->spreadsheet->getSheetCount();

        for ($i = 0; $i < $sheetCount; ++$i) {
            $worksheet = $this->spreadsheet->getSheet($i);
            $autofilter = $worksheet->getAutoFilter();

            if ($autofilter !== null && !empty($autofilter->getRange())) {

                if ($wrapperWritten === false) {
                    $this->objWriter->startElement('table:database-ranges');
                    $wrapperWritten = true;
                }

                $this->objWriter->startElement('table:database-range');
                $this->objWriter->writeAttribute('table:orientation', 'column');
                $this->objWriter->writeAttribute('table:display-filter-buttons', 'true');
                $this->objWriter->writeAttribute(
                    'table:target-range-address',
                    $this->formatRange($worksheet, $autofilter)
                );
                $this->objWriter->endElement();
            }

        }

        if ($wrapperWritten === true) {
            $this->objWriter->endElement();
        }

    }

    protected function formatRange(Worksheet $worksheet, Autofilter $autofilter): string{

        $title = $worksheet->getTitle();
        $range = $autofilter->getRange();

        return "'{$title}'.{$range}";
    }

}
