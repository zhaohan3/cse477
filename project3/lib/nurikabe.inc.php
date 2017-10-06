<?php
/**
 * Created by PhpStorm.
 * User: agbaydan
 * Date: 6/7/2017
 * Time: 9:37 PM
 */

require __DIR__ . "/../vendor/autoload.php";

session_start();

define("NURIKABE_SESSION", 'Nurikabe');

if(!isset($_SESSION[NURIKABE_SESSION])) {
    $_SESSION[NURIKABE_SESSION] = new Nurikabe\Nurikabe();
}

$Nurikabe = $_SESSION[NURIKABE_SESSION];
