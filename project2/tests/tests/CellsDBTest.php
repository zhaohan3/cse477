<?php

/** @file
 * Empty unit testing template/database version
 * @cond 
 * Unit tests for the class
 */

require __DIR__ . "/../../vendor/autoload.php";


class CellsDBTest extends \PHPUnit_Extensions_Database_TestCase
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
        return $this->createFlatXMLDataSet(dirname(__FILE__) . '/db/cell.xml');
    }

    public function test_construct(){
        $cells = new \Nurikabe\Cells(self::$site);
        $this->assertInstanceOf('Nurikabe\Cells', $cells);
        $this->assertEquals('testproj2_cell', $cells->getTableName());


        /*
         * In test cell: 3x3 board w Nurikabeid: 9
         * Nurikabeid 9: ultraEasy, userid: 10
         * userid 10: id="10" email="marge@bartman.com" name="Simpson, Marge"         *
         */
    }

    public function test_exists(){
        $cells = new \Nurikabe\Cells(self::$site);

        $this->assertTrue($cells->exists(0,0,9));
        $this->assertTrue($cells->exists(1,2,9));
        $this->assertTrue($cells->exists(2,1,9));

        $this->assertFalse($cells->exists(0,0,8));
        $this->assertFalse($cells->exists(5,2,9));
        $this->assertFalse($cells->exists(2,8,9));
        $this->assertFalse($cells->exists(7,8,9));
    }

    public function test_get(){
        $cells = new \Nurikabe\Cells(self::$site);

        $cell = $cells->get(1,2,9);
        $this->assertEquals(1, $cell->getCRow());
        $this->assertEquals(2, $cell->getCCol());
        $this->assertEquals(9, $cell->getNurikabeid());
        $this->assertEquals(6, $cell->getId());
        $this->assertEquals('Blue', $cell->getCVal());

        // cell dne
        $cell = $cells->get(8,8, 9);
        $this->assertNull($cell);
    }

    public function test_add(){
        $cells = new \Nurikabe\Cells(self::$site);

        $cells->add(0,0, 'sea', 2);
        $this->assertTrue($cells->exists(0,0,2));

        $cells->add(0,1,4,2);
        $this->assertTrue($cells->exists(0,1,2));
    }

    public function test_update(){
        $cells = new \Nurikabe\Cells(self::$site);

        $u = $cells->update('red', 2,0, 9);
        $this->assertTrue($u);
        $this->assertEquals('red', $cells->get(2,0,9)->getCVal());

        $u = $cells->update(5, 2,0, 9);
        $this->assertTrue($u);
        $this->assertEquals(5, $cells->get(2,0,9)->getCVal());
    }

    public function test_save(){
        $cells = new \Nurikabe\Cells(self::$site);

        $this->assertContains('Updated', $cells->save(1,0, 'island',9));
        $this->assertEquals('island', $cells->get(1,0,9)->getCVal());

        $this->assertContains('Added', $cells->save(5,8, 'yeet', 9));
        $this->assertEquals('yeet', $cells->get(5,8,9)->getCVal());

//        $val = "4";
//        $val = (int) $val;
//        $this->assertEquals(4, $val);
    }


	
}

/// @endcond
