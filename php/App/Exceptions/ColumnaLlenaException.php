<?php

namespace Joc4enRatlla\Exceptions;

use Exception;

class ColumnaLlenaException extends Exception {

    public function __construct($columna) {
        parent::__construct("La columna " . $columna . " está llena");
    }
}
?>