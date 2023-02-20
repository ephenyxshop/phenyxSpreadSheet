<?php

namespace Ephenyxshop\PhenyxSpreadsheet\Calculation;

use Ephenyxshop\PhenyxSpreadsheet\Exception as PhenyxSpreadsheetException;

class Exception extends PhenyxSpreadsheetException {

    /**
     * Error handler callback.
     *
     * @param mixed $code
     * @param mixed $string
     * @param mixed $file
     * @param mixed $line
     * @param mixed $context
     */
    public static function errorHandlerCallback($code, $string, $file, $line, $context): void{

        $e = new self($string, $code);
        $e->line = $line;
        $e->file = $file;

        throw $e;
    }
}
