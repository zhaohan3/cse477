<?php
require __DIR__ . '/lib/guessing.inc.php';
$controller = new Guessing\GuessingController($guessing, $_POST);
if($controller->isReset()) {
//    echo "new game!!!!!!!!";
    unset($_SESSION[GUESSING_SESSION]);
}
header("location: guessing.php");
exit;