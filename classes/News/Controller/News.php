<?php

namespace News\Controller;

class News {
    /**
     * Типы результата
     */
    const RESULT_SUCCESS = 1;
    const RESULT_ERROR = 2;

    /**
     * Действия
     */
    const UPDATE = 1;
    const DELETE = 2;
    const SHOW = 3;
    const ADD = 4;

    /**
     * Причины ошибок
     */
    const EMPTY_ID = 1;
    const DB_ERROR = 2;

    /** @var null|\News\Model\News */
    private $model = null;
    /** @var null|\News\Decorator\News */
    private $decorator = null;

    public function __construct(\News\Model\News $model, \News\Decorator\News $decorator) {
        $this->setNewsModel($model);
        $this->setNewsDecorator($decorator);
    }

    public function getNewsModel() {
        return $this->model;
    }

    public function setNewsModel($model) {
        $this->model = $model;
    }

    public function getNewsDecorator() {
        return $this->decorator;
    }

    public function setNewsDecorator($decorator) {
        $this->decorator = $decorator;
    }

    /**
     * Действие по умолчанию
     * Выводит все новости в виде таблицы
     */
    public function actionIndex() {
        $out = '';
        if(isset($_GET['msg_action']) && !empty($_GET['msg_action'])) {
            $error_reason = isset($_GET['msg_err_reason']) ? $_GET['msg_err_reason'] : '';
            echo $this->getNewsDecorator()->renderResultMsg($_GET['msg_action'],$_GET['msg_result'], $error_reason);
        }
        $data = $this->getNewsModel()->getAllNews();
        $out .= $this->getNewsDecorator()->renderNewsTable($data);
        echo $out;
    }

    /**
     * Форма добавления новости
     */
    public function actionAdd() {
        $out = $this->getNewsDecorator()->renderNewEditForm();
        echo $out;
    }

    /**
     * Добавление новости
     */
    public function actionAddComplete() {
        $title = $_POST['title'];
        $short_text = $_POST['short_text'];
        $full_text = $_POST['full_text'];
        $date_publish_start = $_POST['date_publish_start'];
        $date_publish_end = $_POST['date_publish_end'];
        $result = $this->getNewsModel()->addNew($title, $short_text, $full_text, $date_publish_start, $date_publish_end);
        $result ?
            $this->redirectToIndex(self::ADD, self::RESULT_SUCCESS):
            $this->redirectToIndex(self::ADD, self::RESULT_ERROR, self::DB_ERROR);
    }


    /**
     * Форма редактирования новости
     */
    public function actionEdit() {
        $out = '';
        $id = isset($_GET['id']) ? (int)$_GET['id'] : null;
        if(empty($id)) {
            $out .= $this->getNewsDecorator()->renderResultMsg(self::SHOW, self::RESULT_ERROR, self::EMPTY_ID);
        }
        else {
            $new_row = $this->getNewsModel()->getNewById($id);
            $out .= $this->getNewsDecorator()->renderNewEditForm($new_row);
        }
        echo $out;
    }

    /**
     * Редактирование новости
     */
    public function actionEditComplete() {
        $out = '';
        $id = isset($_POST['id']) ? (int)$_POST['id'] : null;
        if(empty($id)) {
            $out .= $this->getNewsDecorator()->renderResultMsg(self::UPDATE, self::RESULT_ERROR, self::EMPTY_ID);
            echo $out;
            return null;
        }
        else {
            $id = (int)$_POST['id'];
            $title = $_POST['title'];
            $short_text = $_POST['short_text'];
            $full_text = $_POST['full_text'];
            $date_publish_start = $_POST['date_publish_start'];
            $date_publish_end = $_POST['date_publish_end'];
            $result = $this->getNewsModel()->updateNewById($id, $title, $short_text, $full_text, $date_publish_start, $date_publish_end);
            $result ?
                $this->redirectToIndex(self::UPDATE, self::RESULT_SUCCESS):
                $this->redirectToIndex(self::UPDATE, self::RESULT_ERROR, self::DB_ERROR);
        }
    }

    /**
     * Удаление новости
     */
    public function actionDelete() {
        $out = '';
        $id = isset($_GET['id']) ? (int)$_GET['id'] : null;
        if(empty($id)) {
            $out .= $this->getNewsDecorator()->renderResultMsg(self::DELETE, self::RESULT_ERROR, self::EMPTY_ID);
        }
        else{
            $result = $this->getNewsModel()->deleteNewById($id);
            $result ?
                $this->redirectToIndex(self::DELETE, self::RESULT_SUCCESS):
                $this->redirectToIndex(self::DELETE, self::RESULT_ERROR, self::DB_ERROR);
        }
        echo $out;

    }

    public function run() {
        if(!isset($_GET['action']) || empty($_GET['action'])) {
            $this->actionIndex();
            return null;
        }
        $method = 'action'.ucfirst($_GET['action']);
        if(method_exists($this, $method)) {
            $this->$method();
        }
        else {
            $this->actionIndex();
        }
    }

    public function redirectToIndex($action, $result, $error_reason_code = null) {
        $url = 'http://'.$_SERVER['HTTP_HOST'].'/admin/news.php?msg_action='.$action.'&msg_result='.$result;
        $url.= !is_null($error_reason_code) ? '&msg_err_reason='.$error_reason_code : '';
        echo
        '<script language="JavaScript">
        window.location.replace("'.$url.'");
        </script>';
    }




}