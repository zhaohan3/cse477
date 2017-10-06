<?php
require '../lib/site.inc.php';

$controller = new Noir\MovieController($site, $user, $_POST);
header("location: " . $controller->getRedirect());
//echo $controller->linkRedirect();
