-<?php

/** @file
 * Empty unit testing template
 * @cond 
 * Unit tests for the class
 */
require __DIR__ . "/../../vendor/autoload.php";

use Nurikabe\View as View;
use Nurikabe\Nurikabe as Nurikabe;
use Nurikabe\User as User;

class ViewTest extends \PHPUnit_Framework_TestCase
{
	public function testConstruct() {
        $row = array('id' => 0,
            'email' => 'dude@ranch.com',
            'name' => 'Dude, The',
            'joined' => '2015-01-15 23:50:26',
        );
        $user = new User($row);
	    $game = new Nurikabe();
		$view = new View($game);
		$this->assertInstanceOf('Nurikabe\View',$view);
	}
	public function testHeader(){
        $row = array('id' => 0,
            'email' => 'dude@ranch.com',
            'name' => 'Dude, The',
            'joined' => '2015-01-15 23:50:26',
        );
        $user = new User($row);
        $game = new Nurikabe();
        $view = new View($game);
	    //$this->assertContains('<p id="links"><a href="instructions.php">INSTRUCTIONS</a>',$view->presentHeader("index"));
        //$this->assertContains('<p id="links"><a href="./">NEW GAME</a>&nbsp;<a href="instructions.php">INSTRUCTIONS</a>',$view->presentHeader("game"));
        //$this->assertContains('<p id="links"><a href="./">NEW GAME</a>',$view->presentHeader("instr"));
	}
}

/// @endcond
