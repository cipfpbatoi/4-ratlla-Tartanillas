<?php
namespace Joc4enRatlla\Services;
include_once $_SERVER['DOCUMENT_ROOT'] . '/../vendor/autoload.php';
use PDO;
use PDOException;
class Db {
    public static function connect() {
        $conn = require $_SERVER['DOCUMENT_ROOT'] . '/../config/connection.php';
        try {
            $dsn = 'mysql:host=' . $conn['host'] . ';dbname='.$conn['dbname'];
            $usuari = $conn['username'];
            $contrasenya = $conn['password'];
            $pdo = new PDO($dsn, $usuari, $contrasenya);
        } catch (PDOException $e) { 
            echo $e->getMessage();
            exit();
        }
        return $pdo;
    }
}