<?php

/** @file
 * Empty unit testing template
 * @cond 
 * Unit tests for the class
 */
require __DIR__ . "/../../vendor/autoload.php";

use Nurikabe\Nurikabe as Nurikabe;
use Nurikabe\GameController as GameController;

class GameControllerTest extends \PHPUnit_Framework_TestCase
{
	public function testConstruct() {
        $game = new Nurikabe();
        $_P = [1,2,3];
        $control = new GameController($game, $_P);
        $this->assertInstanceOf('Nurikabe\GameController',$control);
	}
}

/// @endcond
