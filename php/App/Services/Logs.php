<?php
namespace Joc4enRatlla\Services;
use Monolog\Level;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
Class Logs {
    private $log;
    public function __construct(){
        $this->log = new Logger("Logger");
        $this->log->pushHandler(new StreamHandler($_SERVER["DOCUMENT_ROOT"] . '/../Logs/game.log', Level::Info));
        $this->log->pushHandler(new StreamHandler($_SERVER["DOCUMENT_ROOT"] . '/../Logs/error.log', Level::Error));
    }

    public function getLog() {
        return $this->log;
    }

    /**
    * @param $log
    */
    public function setLog($log) {
        $this->log = $log;
    }
}
?>