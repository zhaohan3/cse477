<?php
/**
 * Created by PhpStorm.
 * User: agbaydan
 * Date: 6/16/2017
 * Time: 12:39 AM
 */

require '../lib/site.inc.php';

$controller = new Felis\UserController($site, $user, $_POST);
header("location: " . $controller->getRedirect());