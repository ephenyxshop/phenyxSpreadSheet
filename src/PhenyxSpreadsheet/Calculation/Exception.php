<?php

namespace EphenyxShop\PhenyxSpreadsheet\Calculation;

use EphenyxShop\PhenyxSpreadsheet\Exception as PhenyxSpreadsheetException;

class Exception extends PhenyxSpreadsheetException
{
    public const CALCULATION_ENGINE_PUSH_TO_STACK = 1;

    /**
     * Error handler callback.
     *
     * @param mixed $code
     * @param mixed $string
     * @param mixed $file
     * @param mixed $line
     * @param mixed $context
     */
    public static function errorHandlerCallback($code, $string, $file, $line, /** @scrutinizer ignore-unused */ $context): void
    {
        $e = new self($string, $code);
        $e->line = $line;
        $e->file = $file;

        throw $e;
    }
}
