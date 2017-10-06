<?php
require "/user/cse477/classweb/student/student.inc.php";
$view = new Student\PortalView(__DIR__);
echo $view->present();
