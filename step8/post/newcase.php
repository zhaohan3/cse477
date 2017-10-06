<?php
/**
 * Created by PhpStorm.
 * User: agbaydan
 * Date: 6/15/2017
 * Time: 7:57 PM
 */

//echo "<pre>";
//print_r($_POST);
//echo "</pre>";

require '../lib/site.inc.php';

$controller = new Felis\NewCaseController($site, $user, $_POST);
header("location: " . $controller->getRedirect());
//echo '<p><a href="' . $controller->getRedirect() .'">next page</a></p>';