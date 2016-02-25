<?php
namespace Auth\Controller;

use News\Decorator\News;

class Auth {
    const INCORRECT_LOGIN_OR_PASSWORD = 'Неверный логин или пароль';
    const CORRECT_LOGIN_OR_PASSWORD = 'Вы вошли';
    const NEED_AUTH = 'Для доступа введите логин и пароль';
    const NO_RIGHTS = 'Нет прав';

    /** id групп пользователей */
    const GROUP_ADMIN = 1;
    const GROUP_OPERATOR = 2;
    const GROUP_GUEST = 3;
    const GROUP_MASTER = 4;


    /** @var null|\Auth\Model\Auth */
    private $model = null;
    /** @var null|\Auth\Decorator\Auth */
    private $decorator = null;

    public function __construct(\Auth\Model\Auth $model, \Auth\Decorator\Auth $decorator) {
        $this->setAuthModel($model);
        $this->setAuthDecorator($decorator);
    }

    public static function getUserGroups() {
        return [
            self::GROUP_ADMIN,
            self::GROUP_OPERATOR,
            self::GROUP_GUEST,
            self::GROUP_MASTER
        ];
    }

    public function checkRights($group_id) {
        if(!isset($_SESSION['login'])) {
            return false;
        }
        $data = $this->getAuthModel()->getUserDataByLogin($_SESSION['login']);
        return $data['group_id'] == $group_id;
    }

    public function getAuthModel() {
        return $this->model;
    }

    public function setAuthModel($model) {
        $this->model = $model;
    }

    public function getAuthDecorator() {
        return $this->decorator;
    }

    public function setAuthDecorator($decorator) {
        $this->decorator = $decorator;
    }

    public function getUserDataByLogin($login) {
        return $this->getAuthModel()->getUserDataByLogin($login);
    }

    public function actionAuth($msg_result) {
        echo $this->getAuthDecorator()->renderAuthForm();
        echo $msg_result;
    }

    public function actionAuthComplete($msg_result) {
            echo $msg_result;
            echo News::renderNewsEditLink().'<br/>';
            echo \Auth\Decorator\Auth::renderExitLink();
    }

    public function actionAuthProcess($login, $password) {
        if($this->validateLogin($login) && $this->validatePassword($password)) {
            $data = $this->getUserDataByLogin($login);
            if(empty($data)) {
                $this->clearSessionData();
                $this->redirectToIndex(self::INCORRECT_LOGIN_OR_PASSWORD);
            }
            if($this->checkLoginAndPassword($data, $login, $password)) {
                $this->saveDataToSession($login, $password);
                $this->redirectToIndex($this->getAuthDecorator()->renderHelloMsg($data['name']));
            }
            else {
                $this->clearSessionData();
                $this->redirectToIndex(self::INCORRECT_LOGIN_OR_PASSWORD);
            }
        }
        else {
            $this->clearSessionData();
            $this->redirectToIndex(self::INCORRECT_LOGIN_OR_PASSWORD);
        }
    }

    public function redirectToIndex($msg_result = null){
        $msg_result = !is_null($msg_result) ? '?msg_result='.$msg_result : $msg_result;
        $url = 'http://'.$_SERVER['HTTP_HOST'].'/admin/index.php'.$msg_result;
        echo
        '<script language="JavaScript">
        window.location.replace("'.$url.'");
        </script>';
    }


    private function validateLogin($login) {
        return (isset($login)&&!empty($login));
    }

    private function validatePassword($password) {
        return  (isset($password)&&!empty($password));
    }

    private function checkLoginAndPassword($data, $login, $password) {
        if(isset($data['login']) && isset($data['md5pass'])) {
            return  ($login == $data['login'] && md5($password) == $data['md5pass']);
        }
        return false;
    }

    private function saveDataToSession($login, $id) {
        $_SESSION['login'] = $login;
        $_SESSION['id'] = $id;
    }

    private function clearSessionData() {
        unset($_SESSION['login']);
        unset($_SESSION['id']);
    }

    public function actionExit() {
        $this->clearSessionData();
        $this->redirectToIndex();
    }


}