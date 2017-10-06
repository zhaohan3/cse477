<?php

/** @file
 * Empty unit testing template/database version
 * @cond 
 * Unit tests for the class
 */

require __DIR__ . "/../../vendor/autoload.php";


class NurikabesDBTest extends \PHPUnit_Extensions_Database_TestCase
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
        return $this->createFlatXMLDataSet(dirname(__FILE__) . '/db/nurikabes.xml');
    }

    public function test_construct(){
        $nurikabes = new \Nurikabe\Nurikabes(self::$site);
        $this->assertInstanceOf('Nurikabe\Nurikabes', $nurikabes);
        $this->assertEquals('testproj2_nurikabe', $nurikabes->getTableName());
    }

    public function test_exists(){
        $nurikabes = new \Nurikabe\Nurikabes(self::$site);

        $this->assertTrue($nurikabes->exists('ultraEasy', 7));
        $this->assertTrue($nurikabes->exists('easy', 8));
        $this->assertFalse($nurikabes->exists('medium', 10));
        $this->assertTrue($nurikabes->exists('ultraEasy', 10));

    }

    public function test_get(){
        $nurikabes = new \Nurikabe\Nurikabes(self::$site);

        $game = $nurikabes->get('easy', 8);
        $this->assertEquals(5, $game->getId());
        $this->assertEquals('easy', $game->getDifficulty());
        $this->assertEquals(8, $game->getUserid());

        $game = $nurikabes->get('ultraEasy', 8);
        $this->assertNull($game);
    }

    public function test_add(){
        $nurikabes = new \Nurikabe\Nurikabes(self::$site);

        $add = $nurikabes->add('ultraEasy', 7);
        $this->assertContains('User and game mode already exist.', $add);

        $add = $nurikabes->add('medium', 10);
        $this->assertTrue($add);

        $this->assertTrue($nurikabes->exists('medium', 10));
    }

    public function test_delete(){
        $nurikabes = new \Nurikabe\Nurikabes(self::$site);

        $delete = $nurikabes->delete('medium', 9);
        $this->assertContains('User and game mode DO NOT exist.', $delete);

        $nurikabes->delete('ultraEasy', 7);
        $this->assertFalse($nurikabes->exists('ultraEasy', 7));
    }
}

/// @endcond
