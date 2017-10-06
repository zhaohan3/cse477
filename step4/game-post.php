<?php
/**
 * Created by PhpStorm.
 * User: danielagbay
 * Date: 5/30/17
 * Time: 10:41 PM
 */

require 'lib/game.inc.php';
$controller = new Wumpus\WumpusController($wumpus, $_REQUEST);
if($controller->isReset()) {
    unset($_SESSION[WUMPUS_SESSION]);
}

header('Location: ' . $controller->getPage());