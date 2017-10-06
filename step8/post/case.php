<?php
/**
 * Created by PhpStorm.
 * User: agbaydan
 * Date: 6/15/2017
 * Time: 10:54 PM
 */
require '../lib/site.inc.php';

echo "<pre>";
print_r($_POST);
echo "</pre>";

$controller = new Felis\CaseController($site, $_POST);
header("location: " . $controller->getRedirect());