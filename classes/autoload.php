<?php
ini_set("display_errors",1);
function __autoload($class_name) {
    $class_name = str_replace('\\', '/', $class_name);
    require_once($class_name . '.php');
}