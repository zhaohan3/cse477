<?php

/** @file
 * Empty unit testing template
 * @cond 
 * Unit tests for the class
 */
require __DIR__ . "/../../vendor/autoload.php";

use Nurikabe\GameView as GameView;
use Nurikabe\Nurikabe as Nurikabe;
use Nurikabe\User as User;

class GameViewTest extends \PHPUnit_Framework_TestCase
{
	public function testConstruct() {
        $row = array('id' => 0,
            'email' => 'dude@ranch.com',
            'name' => 'Dude, The',
            'joined' => '2015-01-15 23:50:26',
        );
        $user = new User($row);
        $game = new Nurikabe();
        $game->setGame(array('test'=>['test array']));
        $view = new GameView($game, $user);
        $this->assertInstanceOf('Nurikabe\GameView',$view);
    }
}

/// @endcond
