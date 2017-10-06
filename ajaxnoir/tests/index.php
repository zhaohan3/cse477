<?php
$host = $_SERVER['HTTP_HOST'];
if(strpos($host, 'localhost') !== false) {
	require __DIR__ . "/../../../webdev/student/student.inc.php";
} else {
	require "/user/cse477/classweb/student/student.inc.php";
}
$view = new Testing\IndexView(__DIR__, $_GET);
echo $view->present();
