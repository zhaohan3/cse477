<?php

/** @file
 * Empty unit testing template
 * @cond 
 * Unit tests for the class
 */
require __DIR__ . "/../../vendor/autoload.php";

use Nurikabe\GameView as GameView;
use Nurikabe\Nurikabe as Nurikabe;

class GameViewTest extends \PHPUnit_Framework_TestCase
{
	public function testConstruct() {
        $game = new Nurikabe();
        $game->setGame(array('test'=>['test array']));
        $view = new GameView($game);
        $this->assertInstanceOf('Nurikabe\GameView',$view);
    }
}

/// @endcond
