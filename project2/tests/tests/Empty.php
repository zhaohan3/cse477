<?php

/** @file
 * Empty unit testing template
 * @cond 
 * Unit tests for the class
 */
require __DIR__ . "/../../vendor/autoload.php";

class EmptyTest extends \PHPUnit_Framework_TestCase
{

    private static $site;

    public static function setUpBeforeClass() {
        self::$site = new Nurikabe\Site();
        $localize  = require 'localize.inc.php';
        if(is_callable($localize)) {
            $localize(self::$site);
        }
    }

	public function test1() {
		//$this->assertEquals($expected, $actual);
	}
}

/// @endcond
