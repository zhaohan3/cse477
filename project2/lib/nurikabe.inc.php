<?php
/**
 * Created by PhpStorm.
 * User: agbaydan
 * Date: 6/7/2017
 * Time: 9:37 PM
 */

require __DIR__ . "/../vendor/autoload.php";

$site = new Nurikabe\Site();
$localize = require 'localize.inc.php';
if(is_callable($localize)) {
    $localize($site);
}


session_start();

define("NURIKABE_SESSION", 'Nurikabe');

if(!isset($_SESSION[NURIKABE_SESSION])) {
    $_SESSION[NURIKABE_SESSION] = new Nurikabe\Nurikabe();
}
$Nurikabe = $_SESSION[NURIKABE_SESSION];

$user = null;
if(isset($_SESSION[Nurikabe\User::SESSION_NAME])) {
    $user = $_SESSION[Nurikabe\User::SESSION_NAME];
}

//// redirect if user is not logged in
//if(!isset($open) && $user === null) {
//    $root = $site->getRoot();
//    header("location: $root/");
//    exit;
//}