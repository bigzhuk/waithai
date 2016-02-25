<?php
namespace Auth\Model;

use DB\DB;
use DB\Escape;

class Auth {

    public function getTableName() {
        return 'users';
    }

    /**
     * @param $login
     * @return bool|array
     */
    public function getUserDataByLogin($login) {
        $login = Escape::i()->cleanLogin($login);
        $query = 'SELECT * FROM '.$this->getTableName().' WHERE
                 login = "'.$login.'"
                 LIMIT 1';
        $result = DB::i()->getPDO()->query($query);
        if($result) {
            $row = $result->fetch();
            return $row;
        }
        return false;
    }


}