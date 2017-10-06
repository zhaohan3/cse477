<?php

/** @file
 * Empty unit testing template
 * @cond 
 * Unit tests for the class
 */
require __DIR__ . "/../../vendor/autoload.php";

class TableTest extends \PHPUnit_Framework_TestCase
{

    private static $site;

    public static function setUpBeforeClass() {
        self::$site = new Nurikabe\Site();
        $localize  = require 'localize.inc.php';
        if(is_callable($localize)) {
            $localize(self::$site);
        }
    }

	public function test_construct() {
		$table = new \Nurikabe\Table(self::$site, '');
        $this->assertInstanceOf('Nurikabe\Table', $table);
        $this->assertEquals('testproj2_', $table->getTableName());
	}
}

/// @endcond
