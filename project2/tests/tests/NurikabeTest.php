<?php

/** @file
 * Empty unit testing template
 * @cond 
 * Unit tests for the class
 */
require __DIR__ . "/../../vendor/autoload.php";

use Nurikabe\Nurikabe as Nurikabe;


class NurikabeTest extends \PHPUnit_Framework_TestCase
{
	public function testConstruct() {
        $game = new Nurikabe();
        $this->assertInstanceOf('Nurikabe\Nurikabe',$game);
        $game->setPname("daniel");
        $this->assertEquals("daniel", $game->getPname());
        $game->setPname("foo");
        $this->assertEquals("foo", $game->getPname());
        $game->setMode("hard");
        $this->assertEquals("hard", $game->getMode());
	}
}

/// @endcond
