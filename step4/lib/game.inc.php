<?php
/**
 * Created by PhpStorm.
 * User: danielagbay
 * Date: 5/30/17
 * Time: 9:50 PM
 */

require __DIR__ . "/../vendor/autoload.php";

// Start the PHP session system
session_start();

define("WUMPUS_SESSION", 'wumpus');

// If there is a Wumpus session, use that. Otherwise, create one
if(!isset($_SESSION[WUMPUS_SESSION])) {
    if(isset($_REQUEST["c"])){
        $_SESSION[WUMPUS_SESSION] = new Wumpus\Wumpus(1422668587);
    }
    else {
        $_SESSION[WUMPUS_SESSION] = new Wumpus\Wumpus();
    }
}

$wumpus = $_SESSION[WUMPUS_SESSION];