<?php
$open = true;
require '../lib/site.inc.php';

$controller = new Noir\LoginController($site, $_POST, $_SESSION);
echo $controller->getResult();
