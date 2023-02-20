<?php

namespace EphenyxShop\PhenyxSpreadsheet\Calculation;

class ExceptionHandler {

    /**
     * Register errorhandler.
     */
    public function __construct() {

        set_error_handler([Exception::, 'errorHandlerCallback'], E_ALL);
    }

    /**
     * Unregister errorhandler.
     */
    public function __destruct() {

        restore_error_handler();
    }
}
