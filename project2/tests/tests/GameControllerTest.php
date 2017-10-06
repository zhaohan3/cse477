<?php

/** @file
 * Empty unit testing template
 * @cond 
 * Unit tests for the class
 */
require __DIR__ . "/../../vendor/autoload.php";

use Nurikabe\Nurikabe as Nurikabe;
use Nurikabe\GameController as GameController;
use Nurikabe\Site as Site;
use Nurikabe\User as User;

class GameControllerTest extends \PHPUnit_Framework_TestCase
{

    private static $site;

    public static function setUpBeforeClass() {
        self::$site = new Site();
        $localize  = require 'localize.inc.php';
        if(is_callable($localize)) {
            $localize(self::$site);
        }
    }
	public function testConstruct() {
        $game = new Nurikabe();
        $_P = [1,2,3];
        $row = array('id' => 0,
            'email' => 'dude@ranch.com',
            'name' => 'Dude, The',
            'joined' => '2015-01-15 23:50:26',
        );
        $user = new User($row);
        $control = new GameController($game, $_P, self::$site, $user);
        $this->assertInstanceOf('Nurikabe\GameController',$control);
	}
}

/// @endcond
