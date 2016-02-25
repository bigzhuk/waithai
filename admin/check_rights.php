<?php
session_start();
if(!isset($_SESSION['login']) || empty($_SESSION['login']) ||
   !isset($_SESSION['id']) || empty($_SESSION['id'])) {
    $decorator = new \Auth\Decorator\Auth();
    $controller = new \Auth\Controller\Auth(new Auth\Model\Auth(), $decorator);
    $need_auth_msg = $decorator->renderNeedAuthMsg(\Auth\Controller\Auth::NEED_AUTH);
    $controller->redirectToIndex($need_auth_msg);
    exit;
}