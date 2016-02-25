<?php

namespace News\Model;

use DB\DB;
use DB\Escape;

class News {

    public function getTableName() {
        return 'news';
    }

    /**
     * Возврщает массив строк таблицы
     * @return array
     */
    public function getAllNews() {
        $data = array();
        $query = 'SELECT * FROM '.$this->getTableName();
        $result = DB::i()->getPDO()->query($query);
        while($row = $result->fetch()) {
            $data[] = $row;
        }
        return $data;
    }

    /**
     * Возврщает массив строк таблицы, дата начала публикации которых меньше либо равна сегодняшнему дню,
     * а дата конца публикации больше сегодняшнего дня
     * @return array
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

    /**
     * Возвращает массив с данными о новости эквивалентный строке в таблице
     * @param $id
     * @return array
     */
    public function getNewById($id) {
        $query = 'SELECT * FROM '.$this->getTableName().' WHERE id='.(int)$id;
        $result = DB::i()->getPDO()->query($query);
        if(!$result) {
            return array();
        }
        $row = $result->fetch();
        return $row;
    }

    public function addNew($title, $short_text, $full_text, $date_publish_start, $date_publish_end) {
        $query = 'INSERT INTO '.$this->getTableName().'
                  SET
                    title = '.Escape::i()->prepareTextToInsertIntoDB($title).',
                    short_text = '.Escape::i()->prepareTextToInsertIntoDB($short_text).',
                    full_text = '.Escape::i()->prepareTextToInsertIntoDB($full_text).',
                    date_publish_start = '.strtotime($date_publish_start).',
                    date_publish_end = '.strtotime($date_publish_end).',
                    date_update = UNIX_TIMESTAMP()';
        return  DB::i()->getPDO()->query($query);
    }

    public function updateNewById($id, $title, $short_text, $full_text, $date_publish_start, $date_publish_end) {
        $query = 'UPDATE '.$this->getTableName().'
                  SET
                    title = '.Escape::i()->prepareTextToInsertIntoDB($title).',
                    short_text = '.Escape::i()->prepareTextToInsertIntoDB($short_text).',
                    full_text = '.Escape::i()->prepareTextToInsertIntoDB($full_text).',
                    date_publish_start = '.strtotime($date_publish_start).',
                    date_publish_end = '.strtotime($date_publish_end).',
                    date_update = UNIX_TIMESTAMP()
                   WHERE id = '.(int)$id;
        return  DB::i()->getPDO()->query($query);
    }

    /**
     * Удаляет запись о новости из БД
     * @param $id
     * @return \PDOStatement
     */
    public function deleteNewById($id) {
        $query = 'DELETE FROM '.$this->getTableName().' WHERE id='.(int)$id;
        return  DB::i()->getPDO()->query($query)->rowCount();
    }

}


