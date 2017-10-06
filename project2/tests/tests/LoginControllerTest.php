<?php

/** @file
 * Empty unit testing template/database version
 * @cond 
 * Unit tests for the class
 */

require __DIR__ . "/../../vendor/autoload.php";


class LoginControllerTest extends \PHPUnit_Extensions_Database_TestCase
{

    private static $site;

    public static function setUpBeforeClass() {
        self::$site = new Nurikabe\Site();
        $localize  = require 'localize.inc.php';
        if(is_callable($localize)) {
            $localize(self::$site);
        }
    }
	/**
     * @return PHPUnit_Extensions_Database_DB_IDatabaseConnection
     */
    public function getConnection()
    {
        return $this->createDefaultDBConnection(self::$site->pdo(), 'agbaydan');
    }

    /**
     * @return PHPUnit_Extensions_Database_DataSet_IDataSet
     */
    public function getDataSet()
    {
        return $this->createFlatXMLDataSet(dirname(__FILE__) . '/db/users.xml');
    }

    public function test_construct(){
        $n = new \Nurikabe\Nurikabe();
        $session = array();	// Fake session
        $root = self::$site->getRoot();

        // Valid staff login
        $controller = new Nurikabe\LoginController($n,array("loginEmail" => "cbowen@cse.msu.edu", "password" => "super477"),
            self::$site, $session);

        $this->assertNotContains("e=1", $controller->getRedirect());
        $this->assertNotNull($session[Nurikabe\User::SESSION_NAME]);
        $this->assertEquals("Owen, Charles", $session[Nurikabe\User::SESSION_NAME]->getName());
        $this->assertEquals("$root/", $controller->getRedirect());

        // Invalid login
        $controller = new Nurikabe\LoginController($n,array("loginEmail" => "cbowen@cse.msu.edu", "password" => "wrong477"),
            self::$site, $session);

        $this->assertNull($session[Nurikabe\User::SESSION_NAME]);
        $this->assertEquals("$root/login.php?e=1", $controller->getRedirect());
    }
}

/// @endcond
