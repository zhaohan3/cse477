<?php

/** @file
 * Empty unit testing template
 * @cond 
 * Unit tests for the class
 */
require __DIR__ . "/../../vendor/autoload.php";

use Nurikabe\Nurikabe as Nurikabe;
use Nurikabe\IndexController as IndexController;
use Nurikabe\Site as Site;

class IndexControllerTest extends \PHPUnit_Framework_TestCase
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
        $control = new IndexController($game, $_P, self::$site);
        $this->assertInstanceOf('Nurikabe\IndexController',$control);
        $this->assertInstanceOf('Nurikabe\Nurikabe',$control->getGame());
	}
}

/// @endcond
