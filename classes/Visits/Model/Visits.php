<?php

namespace Visits\Model;

use DB\DB;
use DB\Escape;
use User\Controller\User;

class Visits {

    public function getTableName() {
        return 'visits';
    }

    /**
     * Возврщает массив строк таблицы
     * @return array
     */
    public function getAll() {
        $data = array();
        $query = 'SELECT * FROM '.$this->getTableName();
        $result = DB::i()->getPDO()->query($query);
        while($row = $result->fetch()) {
            $data[] = $row;
        }
        return $data;
    }

    /**
     * Возвращает массив с данными о новости эквивалентный строке в таблице
     * @param $id
     * @return array
     */
    public function getById($id) {
        $query = 'SELECT * FROM '.$this->getTableName().' WHERE id='.(int)$id;
        $result = DB::i()->getPDO()->query($query);
        if(!$result) {
            return array();
        }
        $row = $result->fetch();
        return $row;
    }

    public function add($date, $status_id, $quest_id, $service_id, $payment_type_id, $master_id, $notification_type_id) {
        $query = 'INSERT INTO '.$this->getTableName().'
                  SET
                    `date` = '.(int)$date.',
                    status_id = '.(int)$status_id.',
                    quest_id = '.(int)$quest_id.',
                    service_id = '.(int)$service_id.',
                    payment_type_id = '.(int)$payment_type_id.',
                    master_id = '.(int)$master_id.',
                    notification_type_id = '.(int)$notification_type_id.',
                    operator_id = '.User::i()->getId().',
                    date_update = UNIX_TIMESTAMP()';
        return  DB::i()->getPDO()->query($query);
    }

    public function updateById($id, $date, $status_id, $quest_id, $service_id, $payment_type_id, $master_id, $notification_type_id) {
        $query = 'UPDATE '.$this->getTableName().'
                  SET
                    `date` = '.(int)$date.',
                    status_id = '.(int)$status_id.',
                    quest_id = '.(int)$quest_id.',
                    service_id = '.(int)$service_id.',
                    payment_type_id = '.(int)$payment_type_id.',
                    master_id = '.(int)$master_id.',
                    notification_type_id = '.(int)$notification_type_id.',
                    operator_id = '.User::i()->getId().',
                    date_update = UNIX_TIMESTAMP()
                   WHERE id = '.(int)$id;
        return  DB::i()->getPDO()->query($query);
    }

    /**
     * Удаляет запись о новости из БД
     * @param $id
     * @return \PDOStatement
     */
    public function deleteById($id) {
        $query = 'DELETE FROM '.$this->getTableName().' WHERE id='.(int)$id;
        return  DB::i()->getPDO()->query($query)->rowCount();
    }


    /**
     * Возврщает массив строк таблицы, дата начала публикации которых меньше либо равна сегодняшнему дню,
     * а дата конца публикации больше сегодняшнего дня
     * @return array
     * @TODO поправить - это шаблон для запроса с условием
     */
    public function getAllPublishedNews() {
        $data = array();
        $query = 'SELECT * FROM '.$this->getTableName().'
                  WHERE date_publish_start <= UNIX_TIMESTAMP()
                  AND  (date_publish_end > UNIX_TIMESTAMP() || date_publish_end = 0)';
        $result = DB::i()->getPDO()->query($query);
        if(!$result) {
            return array();
        }
        while($row = $result->fetch()) {
            $data[] = $row;
        }
        return $data;
    }

}


