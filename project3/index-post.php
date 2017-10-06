<?php
require __DIR__ . '/lib/nurikabe.inc.php';
$indexController = new \Nurikabe\IndexController($Nurikabe, $_POST);
//print_r($_POST);
//print_r($indexController->getPost());

$indexController->takeAction();

//echo "<p><a href=\"" . $indexController->getRedirect() . "\">" . $indexController->getRedirect() . "</a>";
header("location: " . $indexController->getRedirect());
exit;

