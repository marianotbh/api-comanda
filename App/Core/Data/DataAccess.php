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
        $db_host = getenv('DB_HOST');
        $db_name = getenv('DB_NAME');
        $db_username = getenv('DB_USERNAME');
        $db_password = getenv('DB_PASSWORD');

        try {
            $this->pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8", $db_username, $db_password, array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
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

    function prepare($query)
    {
        return $this->pdo->prepare($query);
    }

    function __clone()
    {
        trigger_error('Do not clone this object', E_USER_ERROR);
    }
}
