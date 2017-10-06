<?php

/** @file
 * Empty unit testing template/database version
 * @cond 
 * Unit tests for the class
 */

require __DIR__ . "/../../vendor/autoload.php";


class EmptyDBTest extends \PHPUnit_Extensions_Database_TestCase
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
        return $this->createFlatXMLDataSet(dirname(__FILE__) . '/db/validators.xml');
    }


    public function test_construct() {
        $users = new Nurikabe\Validators(self::$site);
        $this->assertInstanceOf('Nurikabe\Validators', $users);
    }
    public function test_newValidator() {
        $validators = new Nurikabe\Validators(self::$site);

        $row = array('id' => 99,
            'email' => 'homeboi@test.com',
            'name' => 'Home slice',
            'joined' => '2015-05-15 23:50:26',
        );
        $user = new Nurikabe\User($row);

        $validator = $validators->newValidator($user);
        $this->assertEquals(32, strlen($validator));

        $table = $validators->getTableName();
        $sql = <<<SQL
select * from $table
where email=? and validator=?
SQL;

        $stmt = $validators->pdo()->prepare($sql);
        $stmt->execute(array($user->getEmail(), $validator));
        $this->assertEquals(1, $stmt->rowCount());
    }

    public function test_get() {
        $validators = new Nurikabe\Validators(self::$site);
        $row = array('id' => 55,
            'email' => 'sadbois@test.com',
            'name' => 'Darkness, Old friend',
            'joined' => '2012-12-24 23:50:26',
        );
        $user = new Nurikabe\User($row);

        // Test a not-found condition
        $this->assertNull($validators->get(""));

        // Create a validator
        $validator = $validators->newValidator($user);

        $this->assertEquals("sadbois@test.com", $validators->get($validator));

        // Remove the validator for this user
        $validators->remove("sadbois@test.com");
        $this->assertNull($validators->get($validator));


        $row = array('id' => 33,
            'email' => 'batman@gotham.com',
            'name' => 'Not Bruce Wayne',
            'joined' => '1939-03-27 23:50:26',
        );
        $bats = new \Nurikabe\User($row);
        // Create two validators
        // Either can work.
        $validator1 = $validators->newValidator($bats);
        $validator2 = $validators->newValidator($bats);

        $this->assertEquals("batman@gotham.com", $validators->get($validator1));
        $this->assertEquals("batman@gotham.com", $validators->get($validator2));

        // Remove the validator for this user
        $validators->remove("batman@gotham.com");

        $this->assertNull($validators->get($validator1));
        $this->assertNull($validators->get($validator2));
    }

    public function test_getName(){
        $validators = new Nurikabe\Validators(self::$site);
        $row = array('id' =>43,
            'email' => 'getname@test.com',
            'name' => 'sad boi',
            'joined' => '2012-12-24 23:50:26',
        );
        $user = new Nurikabe\User($row);

        // Test a not-found condition
        $this->assertNull($validators->get(""));

        // Create a validator
        $validator = $validators->newValidator($user);

        $this->assertEquals("sad boi", $validators->getName($validator));

        // Remove the validator for this user
        $validators->remove("getname@test.com");
        $this->assertNull($validators->getName($validator));


        $row = array('id' => 333,
            'email' => 'supes@metropolis.com',
            'name' => 'Not Clark Kent',
            'joined' => '1938-03-27 23:50:26',
        );
        $supes = new \Nurikabe\User($row);
        // Create two validators
        // Either can work.
        $validator1 = $validators->newValidator($supes);
        $validator2 = $validators->newValidator($supes);

        $this->assertEquals("Not Clark Kent", $validators->getName($validator1));
        $this->assertEquals("Not Clark Kent", $validators->getName($validator2));

        // Remove the validator for this user
        $validators->remove("supes@metropolis.com");

        $this->assertNull($validators->getName($validator1));
        $this->assertNull($validators->getName($validator2));
    }

}

/// @endcond
