<?php
/**
 * Created by PhpStorm.
 * User: agbaydan
 * Date: 6/16/2017
 * Time: 4:20 PM
 */

//echo "<pre>";
//print_r($_POST);
//echo "</pre>";

$open = true;
require '../lib/site.inc.php';

$controller = new Felis\PasswordValidateController($site, $_POST);
header("location: " . $controller->getRedirect());
//echo '<p><a href="' . $controller->getRedirect() .'">' . $controller->getRedirect() . '</a></p>';