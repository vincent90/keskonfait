<?php

namespace App\Exceptions;

class NotImplementedException extends Exception {

    /**
     * For unimplemented methods.
     *
     * @param type $message message to display
     */
    public function __construct($message = null) {
        parent::__construct($message ? 'Not implemented: ' . $message : 'Not implemented.');
    }

}
