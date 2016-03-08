<!DOCTYPE html>
<html lang="ru">
<head>
    <?php require_once('header.php'); ?>
</head>
<body>
    <?php
    require_once('../classes/autoload.php');
    require_once('menu.php');
    $auth_controller = new Auth\Controller\Auth(new Auth\Model\Auth(), new Auth\Decorator\Auth());
    if(!($auth_controller->checkRights(Auth\Controller\Auth::GROUP_ADMIN)))  {
        echo $auth_controller->getAuthDecorator()->renderNoRightsMsg();
        return;
    }

    $visit_controller = new Visits\Controller\Visits(new Visits\Model\Visits(), new Visits\Decorator\Visits());
    $visit_controller->run();
    ?>
</body>
</html>