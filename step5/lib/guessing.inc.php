<?php
/**
 * Created by PhpStorm.
 * User: danielagbay
 * Date: 6/2/17
 * Time: 8:19 PM
 */
require __DIR__ . "/../vendor/autoload.php";

session_start();

define("GUESSING_SESSION", 'Guessing');

if(!isset($_SESSION[GUESSING_SESSION])) {
    $_SESSION[GUESSING_SESSION] = new Guessing\Guessing();
}

if(isset($_GET['seed'])) {
  $_SESSION[GUESSING_SESSION] = new Guessing\Guessing(strip_tags($_GET['seed']));
}

$guessing = $_SESSION[GUESSING_SESSION];