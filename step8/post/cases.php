<?php
/**
 * Created by PhpStorm.
 * User: agbaydan
 * Date: 6/15/2017
 * Time: 6:35 PM
 */

require '../lib/site.inc.php';

$controller = new Felis\CasesController($site, $_POST);;
header("location: " . $controller->getRedirect());