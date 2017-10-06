<?php
/**
 * Created by PhpStorm.
 * User: agbaydan
 * Date: 6/13/2017
 * Time: 7:16 PM
 */

$open = true;		// Can be accessed when not logged in
require '../lib/site.inc.php';

$controller = new Felis\LoginController($site, $_SESSION, $_POST);
header("location: " . $controller->getRedirect());