<?php
namespace User\Controller;

class User {
    private static $inctance=null;
    private $id;

    private function __construct() {}

    private function __clone() {}

    public static function i() {
        if(is_null(self::$inctance)) {
            self::$inctance = new User();
        }
        return self::$inctance;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = (int)$id;
    }
}