<?php
namespace Auth\Decorator;

class Auth {
    public function renderAuthForm()  {
        $out = '
        <div style="border: 0px solid blue; position:relative; top:100px; left:400px; height:200px; width:300px;">
            <form action="auth.php" method="post">
                <label>логин:</label><br/>
                <input name="login" type="text" size="15" maxlength="15"><br/>
                <label>пароль:</label><br/>
                <input name="password" type="password" size="15" maxlength="15"><br/><br/>
                <input type="submit" name="go_auth" value="войти"><br/><br/>
            </form>
        </div>';
        return $out;
    }

    public function renderHelloMsg($name) {
        if(empty($name)) {
            $out  = 'Привет, аноним<br/>';
        }
        else {
            $out = 'Привет, ' . $name . '<br/>';
        }
        return $out;
    }

    public static function renderExitLink() {
        $out  = !empty($_SESSION['login']) ?
            '<a href = "index.php?action=exit">Выйти</a>':  '<a href = "index.php">Войти</a>'
        ;
        return $out;
    }

    public function renderNeedAuthMsg($msg_text) {
        $out = '<div style="color:red; padding-top:20px">'.$msg_text.'</div>';
        return $out;
    }

    public function renderNoRightsMsg() {
        $out  = \Auth\Controller\Auth::NO_RIGHTS;
        return $out;
    }
}