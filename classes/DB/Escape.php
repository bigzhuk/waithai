<?php

namespace DB;

class Escape {
    private static $instance = null;

    private function __construct() {}

    private function __clone() {}

    public static function i() {
        if(is_null(self::$instance)) {
            self::$instance = new Escape();
        }
        return self::$instance;
    }

    public function prepareTextToInsertIntoDB($text) {
        return $this->addQuotes(addslashes($text));
    }

    private function addQuotes($text) {
        return "'".$text."'";
    }

    public  function cleanLogin($login) {
        return preg_replace('|[^A-Z-a-z0-9_-]|','',$login);
    }

    public  function cleanPassword($password) {
        return preg_replace('|[^A-Z-a-z0-9_@\!\?-]|','',$password);
    }
}