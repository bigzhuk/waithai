<?php

namespace DB;

use PDO;
use PDOException;

class DB {
    private static $instance = null;

    private $host = 'localhost';
    private $dbname = 'waithai';
    private $user = 'root';
    private $password = '';
    private $charset = 'UTF8';


    private function __construct() {}
    private function __clone() {}

    public function getPDO() {
        try {
            $dbh = new PDO('mysql:host='.$this->host.';dbname='.$this->dbname.';charset='.$this->charset, $this->user, $this->password);
        } catch (PDOException $e) {
            die('Подключение не удалось: ' . $e->getMessage());
        }
        $dbh->exec('SET NAMES utf8');
        return $dbh;
    }

    public static function i() {
        if(is_null(self::$instance)) {
            self::$instance = new DB();
        }
        return self::$instance;
    }
}
