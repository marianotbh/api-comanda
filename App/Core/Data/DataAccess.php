<?php

namespace App\Core\Data;

use \PDO;
use \PDOException;

class DataAccess
{
    /** @var DataAccess */
    private static $instance;
    /** @var PDO */
    private $pdo;

    private function __construct()
    {
        try {
            $this->pdo = new PDO('mysql:host=localhost;dbname=comanda;charset=utf8', 'comanda_user', 'comanda123', array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
            $this->pdo->exec("SET CHARACTER SET utf8");
        } catch (PDOException $e) {
            print $e->getMessage();
            die();
        }
    }

    static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new DataAccess();
        }
        return self::$instance;
    }

    function query($query)
    {
        return $this->pdo->query($query);
    }

    function prepare($query)
    {
        return $this->pdo->prepare($query);
    }

    function wherify($array)
    {
        $clause = implode(' AND ', array_map(function ($value, $key) {
            if (is_string($value)) {
                return "`" . $key . "` LIKE '%" . $value . "%'";
            } else {
                return "`" . $key . "` = '" . $value . "'";
            }
        }, $array, array_keys($array)));
        return strlen($clause) > 0 ? $clause : ' true ';
    }

    function __clone()
    {
        trigger_error('Do not clone this object', E_USER_ERROR);
    }
}
