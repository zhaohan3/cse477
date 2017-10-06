<?php

/** @file
 * Empty unit testing template
 * @cond 
 * Unit tests for the class
 */
require __DIR__ . "/../../vendor/autoload.php";

use Nurikabe\Nurikabe as Nurikabe;
use Nurikabe\Controller as Controller;

class ControllerTest extends \PHPUnit_Framework_TestCase
{
	public function testConstruct() {
        $game = new Nurikabe();
        $_P = [1,2,3];
		$cnt = new Controller($game, $_P);
		$this->assertInstanceOf('Nurikabe\Controller', $cnt);
        $this->assertEquals(null,$cnt->getRedirect());
        $this->assertInstanceOf('Nurikabe\Nurikabe',$cnt->getGame());

    }
}

/// @endcond
