-<?php

/** @file
 * Empty unit testing template
 * @cond 
 * Unit tests for the class
 */
require __DIR__ . "/../../vendor/autoload.php";

use Nurikabe\View as View;
use Nurikabe\Nurikabe as Nurikabe;

class ViewTest extends \PHPUnit_Framework_TestCase
{
	public function testConstruct() {
	    $game = new Nurikabe();
		$view = new View($game);
		$this->assertInstanceOf('Nurikabe\View',$view);
	}
	public function testHeader(){
        $game = new Nurikabe();
        $view = new View($game);
	    $this->assertContains('<p id="links"><a href="instructions.php">INSTRUCTIONS</a>',$view->presentHeader("index"));
        $this->assertContains('<p id="links"><a href="./">NEW GAME</a>&nbsp;<a href="instructions.php">INSTRUCTIONS</a>',$view->presentHeader("game"));
        $this->assertContains('<p id="links"><a href="./">NEW GAME</a>',$view->presentHeader("instr"));
	}
}

/// @endcond
