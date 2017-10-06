<?php
require __DIR__ . "/../../vendor/autoload.php";

/** @file
 * Empty unit testing template
 * @cond 
 * Unit tests for the class
 */
class WumpusControllerTest extends \PHPUnit_Framework_TestCase
{
    const SEED = 1422668587;

    public function test_construct() {
        $wumpus = new Wumpus\Wumpus(self::SEED);
        $controller = new Wumpus\WumpusController($wumpus, array());

        $this->assertInstanceOf('Wumpus\WumpusController', $controller);
        $this->assertFalse($controller->isReset());
        $this->assertEquals('game.php', $controller->getPage());
    }

    public function test_new() {
        $wumpus = new Wumpus\Wumpus(self::SEED);
        $controller = new Wumpus\WumpusController($wumpus, array('n' => ''));

        $this->assertInstanceOf('Wumpus\WumpusController', $controller);
        $this->assertTrue($controller->isReset());
        $this->assertEquals('game.php', $controller->getPage());
    }

    public function test_move() {
        $wumpus = new Wumpus\Wumpus(self::SEED);
        $controller = new Wumpus\WumpusController($wumpus, array('m' => '11'));

        $this->assertFalse($controller->isReset());
        $this->assertEquals('game.php', $controller->getPage());

        $this->assertEquals(11, $wumpus->getCurrent()->getNdx());
    }

    public function test_shoot() {
        $wumpus = new Wumpus\Wumpus(self::SEED);
        $controller = new Wumpus\WumpusController($wumpus, array('s' => '3'));

        $this->assertTrue($controller->isReset());
        $this->assertEquals('win.php', $controller->getPage());
    }
}

/// @endcond
