<?php

/** @file
 * Empty unit testing template
 * @cond 
 * Unit tests for the class
 */
require __DIR__ . "/../../vendor/autoload.php";

use Nurikabe\Nurikabe as Nurikabe;
use Nurikabe\IndexController as IndexController;

class IndexControllerTest extends \PHPUnit_Framework_TestCase
{
	public function testConstruct() {
	    $game = new Nurikabe();
	    $_P = [1,2,3];
        $control = new IndexController($game, $_P);
        $this->assertInstanceOf('Nurikabe\IndexController',$control);
        //$this->assertEquals('game.php',$control->getRedirect());
        $this->assertInstanceOf('Nurikabe\Nurikabe',$control->getGame());
	}
}

/// @endcond
