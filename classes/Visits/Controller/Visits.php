<?php

namespace Visits\Controller;
use Framework\MainController;

class Visits extends MainController{

    /** @var null|\Visits\Model\Visits */
    private $model = null;
    /** @var null|\Visits\Decorator\Visits */
    private $decorator = null;

    public function __construct(\Visits\Model\Visits $model, \Visits\Decorator\Visits $decorator) {
        $this->setModel($model);
        $this->setDecorator($decorator);
    }

    public function getModel() {
        return $this->model;
    }

    public function setModel($model) {
        $this->model = $model;
    }

    public function getDecorator() {
        return $this->decorator;
    }

    public function setDecorator($decorator) {
        $this->decorator = $decorator;
    }

    /**
     * Действие по умолчанию
     * Выводит все новости в виде таблицы
     */
    public function actionIndex() {
        $out = '';
        $data = $this->getModel()->getAll();
        $out .= $this->getDecorator()->renderTable($data);
        echo $out;
    }

    /**
     * Форма добавления новости
     */
    public function actionAdd() {
        $out = $this->getDecorator()->renderEditForm();
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
        $result = $this->getModel()->add($title, $short_text, $full_text, $date_publish_start, $date_publish_end);
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
            $out .= $this->getDecorator()->renderResultMsg(self::SHOW, self::RESULT_ERROR, self::EMPTY_ID);
        }
        else {
            $new_row = $this->getModel()->getById($id);
            $out .= $this->getDecorator()->renderEditForm($new_row);
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
            $out .= $this->getDecorator()->renderResultMsg(self::UPDATE, self::RESULT_ERROR, self::EMPTY_ID);
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
            $result = $this->getModel()->updateById($id, $title, $short_text, $full_text, $date_publish_start, $date_publish_end);
        }
    }

    /**
     * Удаление новости
     */
    public function actionDelete() {
        $out = '';
        $id = isset($_GET['id']) ? (int)$_GET['id'] : null;
        if(empty($id)) {
            $out .= $this->getDecorator()->renderResultMsg(self::DELETE, self::RESULT_ERROR, self::EMPTY_ID);
        }
        else{
            $result = $this->getModel()->deleteById($id);
        }
        echo $out;

    }
}