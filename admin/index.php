<?php
session_start();
header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title>ЭСКС Администрирование</title>
	<link rel="stylesheet" href="../style/ui.css">
	<link rel="stylesheet" href="style/css.css">
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
</head>
<body>

</body>

<script>
	$(document).ready(function() {
		$('.datepicker').datepicker();
	});
</script>


<?php
require_once('../classes/autoload.php');
$auth_controller = new \Auth\Controller\Auth(new \Auth\Model\Auth(), new \Auth\Decorator\Auth());
if(isset($_GET['action']) && $_GET['action'] == 'exit') {
    $auth_controller->actionExit();
}
if (empty($_SESSION['login']) or empty($_SESSION['id'])) { // Проверяем, пусты ли переменные логина и id пользователя
    $msg_result = isset($_GET['msg_result']) ? $_GET['msg_result'] : '';
    $auth_controller->actionAuth($msg_result);
}
else {
    $msg_result = isset($_GET['msg_result']) ? $_GET['msg_result'] : '';
    $auth_controller->actionAuthComplete($msg_result);
}

?>
</html>
