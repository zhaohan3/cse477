<?php
/**
 * Created by PhpStorm.
 * User: agbaydan
 * Date: 6/16/2017
 * Time: 9:51 PM
 */

echo "<pre>";
print_r($_POST);
echo "</pre>";

require '../lib/site.inc.php';

$controller = new Felis\DeleteCaseController($site, $_POST);
header("location: " . $controller->getRedirect());
//echo '<p><a href="' . $controller->getRedirect() .'">' . $controller->getRedirect() . '</a></p>';