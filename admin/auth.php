<?php
require_once('../classes/autoload.php');
session_start();
if(isset($_POST['go_auth'])) {
    $auth_controller = new \Auth\Controller\Auth(new \Auth\Model\Auth(), new \Auth\Decorator\Auth());
    $auth_controller->actionAuthProcess($_POST['login'], $_POST['password']);
}