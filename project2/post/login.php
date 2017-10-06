<?php
/**
 * Created by PhpStorm.
 * User: agbaydan
 * Date: 6/20/2017
 * Time: 11:27 PM
 */

require '../lib/nurikabe.inc.php';
$controller = new \Nurikabe\LoginController($Nurikabe, $_POST, $site, $_SESSION);

//echo "<pre>";
//print_r($_POST);
//echo "</pre>";

header("location: " . $controller->getRedirect());
//echo '<p><a href="' . $controller->getRedirect() .'">' . $controller->getRedirect() . '</a></p>';