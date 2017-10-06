<?php
require __DIR__ . "/../../vendor/autoload.php";

/** @file
 * Empty unit testing template
 * @cond 
 * Unit tests for the class
 */
class WumpusViewTest extends \PHPUnit_Framework_TestCase
{
    const SEED = 1422668587;

    public function test_construct() {
        $wumpus = new Wumpus\Wumpus(self::SEED);
        $view = new Wumpus\WumpusView($wumpus);

        $this->assertInstanceOf('Wumpus\WumpusView', $view);
    }

    public function test_presentArrows() {
        $wumpus = new Wumpus\Wumpus(self::SEED);
        $view = new Wumpus\WumpusView($wumpus);

        $arrows = $view->presentArrows();
        $this->assertContains('<p>You have 3 arrows remaining.</p>', $arrows);
    }

    public function test_presentStatus() {
        $wumpus = new Wumpus\Wumpus(self::SEED);
        $view = new Wumpus\WumpusView($wumpus);

        $status = $view->presentStatus();
        $this->assertContains('You are in room 11', $status);
        $this->assertContains("smell a wumpus", $status);
        $this->assertNotContains("carried by the birds", $status);
        $this->assertNotContains("feel a draft", $status);
        $this->assertNotContains("hear birds", $status);

        $wumpus->move(20);
        $status = $view->presentStatus();
        $this->assertNotContains("smell a wumpus", $status);
        $this->assertNotContains("carried by the birds", $status);
        $this->assertContains("feel a draft", $status);
        $this->assertContains("hear birds", $status);

        $wumpus->move(19);
        $status = $view->presentStatus();
        $this->assertContains("carried by the birds", $status);
    }

    public function test_presentRoom() {
        $wumpus = new Wumpus\Wumpus(self::SEED);
        $view = new Wumpus\WumpusView($wumpus);

        $room = $view->presentRoom(0);
        $this->assertContains('?m=3">6', $room);
        $this->assertContains('?s=3">Shoot', $room);

        $room = $view->presentRoom(1);
        $this->assertContains('?m=9">1', $room);
        $this->assertContains('?s=9">Shoot', $room);

        $room = $view->presentRoom(2);
        $this->assertContains('?m=11">5', $room);
        $this->assertContains('?s=11">Shoot', $room);
    }
}

/// @endcond
