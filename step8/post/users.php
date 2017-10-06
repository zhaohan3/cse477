<?php
/**
 * Created by PhpStorm.
 * User: agbaydan
 * Date: 6/16/2017
 * Time: 12:35 AM
 */

require '../lib/site.inc.php';

$controller = new Felis\UsersController($site, $user, $_POST);
//echo "<pre>";
//print_r($_POST);
//echo "</pre>";

header("location: " . $controller->getRedirect());