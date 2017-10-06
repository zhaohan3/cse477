<?php
require __DIR__ . "/../../vendor/autoload.php";

/** @file
 * Unit tests for the class Cases
 * @cond
 */

class CasesTest extends \PHPUnit_Extensions_Database_TestCase
{
    private static $site;

    public static function setUpBeforeClass() {
        self::$site = new Felis\Site();
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

        return $this->createDefaultDBConnection(self::$site->pdo(),
            'agbaydan');
    }

    /**
     * @return PHPUnit_Extensions_Database_DataSet_IDataSet
     */
    public function getDataSet()
    {
        return $this->createFlatXMLDataSet(dirname(__FILE__) .
            '/db/clientcase.xml');
    }

    /**
     * Test to ensure Cases::get is working.
     */
    public function test_get() {
        $cases = new Felis\Cases(self::$site);

        $case = $cases->get(22);
        $this->assertInstanceOf('Felis\ClientCase', $case);

        $this->assertEquals(22, $case->getId());
        $this->assertEquals(9, $case->getClient());
        $this->assertEquals(8, $case->getAgent());
        $this->assertEquals("Owen, Charles", $case->getAgentName());
        $this->assertEquals("Simpson, Bart", $case->getClientName());
        $this->assertEquals("case summary", $case->getSummary());
        $this->assertEquals(Felis\ClientCase::STATUS_OPEN,
            $case->getStatus());
        $this->assertEquals("16-9876", $case->getNumber());
    }

    public function test_insert() {
        $cases = new Felis\Cases(self::$site);

        $id = $cases->insert(9, 8, "16-5544");
        $case = $cases->get($id);
        $this->assertNotNull($case);
        $this->assertEquals(9, $case->getClient());
        $this->assertEquals(8, $case->getAgent());
        $this->assertEquals("16-5544", $case->getNumber());

        $id = $cases->insert(9, 8, "16-5544");
        $this->assertNull($id);
    }

    public function test_getCases() {
        //echo "<pre> **ALL**  " . print_r($all) ."   " . self::$site->getTablePrefix() . "</pre>";

        $cases = new Felis\Cases(self::$site);

        $all = $cases->getCases();
        $this->assertEquals(3, count($all));
        $c1 = $all[0];
        $this->assertInstanceOf('Felis\ClientCase', $c1);
        $this->assertEquals(23, $c1->getId());
        $this->assertEquals(10, $c1->getClient());
        $this->assertEquals("Simpson, Marge", $c1->getClientName());
        $this->assertEquals(8, $c1->getAgent());
        $this->assertEquals("Owen, Charles", $c1->getAgentName());
        $this->assertEquals("16-1234", $c1->getNumber());
        $this->assertEquals("case summary", $c1->getSummary());
        $this->assertEquals(Felis\ClientCase::STATUS_OPEN, $c1->getStatus());

        $c2 = $all[1];
        $this->assertInstanceOf('Felis\ClientCase', $c2);
        $this->assertEquals(22, $c2->getId());
        $this->assertEquals(9, $c2->getClient());
        $this->assertEquals("Simpson, Bart", $c2->getClientName());
        $this->assertEquals(8, $c2->getAgent());
        $this->assertEquals("Owen, Charles", $c2->getAgentName());
        $this->assertEquals("16-9876", $c2->getNumber());

        $c3 = $all[2];
        $this->assertInstanceOf('Felis\ClientCase', $c3);
        $this->assertEquals(25, $c3->getId());
        $this->assertEquals(9, $c3->getClient());
        $this->assertEquals("Simpson, Bart", $c3->getClientName());
        $this->assertEquals(8, $c3->getAgent());
        $this->assertEquals("Owen, Charles", $c3->getAgentName());
        $this->assertEquals("15-0011", $c3->getNumber());
    }
}

/// @endcond