<?php
/**
 * Created by PhpStorm.
 * User: agbaydan
 * Date: 6/20/2017
 * Time: 8:58 PM
 */

require '../lib/nurikabe.inc.php';
$controller = new \Nurikabe\NewuserController($Nurikabe, $_POST, $site);

//echo "<pre>";
//print_r($_POST);
//echo "</pre>";

header("location: " . $controller->getRedirect());
//echo '<p><a href="' . $controller->getRedirect() .'">' . $controller->getRedirect() . '</a></p>';