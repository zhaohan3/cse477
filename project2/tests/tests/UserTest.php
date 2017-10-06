<?php

/** @file
 * Empty unit testing template
 * @cond 
 * Unit tests for the class
 */
require __DIR__ . "/../../vendor/autoload.php";

class UserTest extends \PHPUnit_Framework_TestCase
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
        $row = array(
          "id"=>1,
          "email"=>"test@test.com",
          "name"=>"test tester",
          "joined"=>"2015-01-15 23:50:26"
        );
        $user = new \Nurikabe\User($row);
        $this->assertInstanceOf('Nurikabe\User', $user);
        $this->assertEquals(1, $user->getId());
        $this->assertEquals('test@test.com', $user->getEmail());
        $this->assertEquals('test tester', $user->getName());
        $this->assertEquals(strtotime('2015-01-15 23:50:26'),
            $user->getJoined());
	}
}

/// @endcond
