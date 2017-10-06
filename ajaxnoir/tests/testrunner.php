<?php
$testingDirectory = __DIR__;
$host = $_SERVER['HTTP_HOST'];
if(strpos($host, 'localhost') !== false) {
	require __DIR__ . "/../../../webdev/student/test/testrunner.php";
} else {
	require "/user/cse477/classweb/student/test/testrunner.php";
}
