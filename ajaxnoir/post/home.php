<?php
require '../lib/site.inc.php';

$controller = new Noir\HomeController($site, $user, $_POST, $_SESSION);
header("location: " . $controller->getRedirect());
//echo $controller->linkRedirect();
