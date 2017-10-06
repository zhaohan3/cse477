<?php

/** @file
 * Empty unit testing template/database version
 * @cond 
 * Unit tests for the class
 */
require __DIR__ . "/../../vendor/autoload.php";

class UsersDBTest extends \PHPUnit_Extensions_Database_TestCase
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
        return $this->createDefaultDBConnection(self::$site->pdo(), 'agbaydan');
    }

    /**
     * @return PHPUnit_Extensions_Database_DataSet_IDataSet
     */
    public function getDataSet()
    {
        return $this->createFlatXMLDataSet(dirname(__FILE__) . '/db/user.xml');
    }

    public function test_construct() {
        $users = new Felis\Users(self::$site);
        $this->assertInstanceOf('Felis\Users', $users);
    }

    public function test_login() {
        $users = new Felis\Users(self::$site);

        // Test a valid login based on email address
        $user = $users->login("dudess@dude.com", "87654321");
        $this->assertInstanceOf('Felis\User', $user);
        $this->assertEquals(7, $user->getId());
        $this->assertEquals('dudess@dude.com', $user->getEmail());
        $this->assertEquals('Dudess, The', $user->getName());
        $this->assertEquals('111-222-3333', $user->getPhone());
        $this->assertEquals('Dudess Address', $user->getAddress());
        $this->assertEquals('Dudess Notes', $user->getNotes());
        $datetime = new DateTime();
        $datetime->setDate(2015, 01, 22);
        $datetime->setTime(23, 50, 26);
        $this->assertEquals($datetime->getTimestamp(), $user->getJoined());
        $this->assertEquals('S', $user->getRole());
        $this->assertEquals(true, $user->isStaff());


        // Test a valid login based on email address
        $user = $users->login("cbowen@cse.msu.edu", "super477");
        $this->assertInstanceOf('Felis\User', $user);

        // Test a failed login
        $user = $users->login("dudess@dude.com", "wrongpw");
        $this->assertNull($user);
    }

    public function test_get(){
        $users = new Felis\Users(self::$site);
        // test get id
        $user = $users->get(7);
        $this->assertInstanceOf('Felis\User', $user);
        $this->assertEquals(7, $user->getId());
        $this->assertEquals('dudess@dude.com', $user->getEmail());
        $this->assertEquals('Dudess, The', $user->getName());
        $this->assertEquals('111-222-3333', $user->getPhone());
        $this->assertEquals('Dudess Address', $user->getAddress());
        $this->assertEquals('Dudess Notes', $user->getNotes());
        $datetime = new DateTime();
        $datetime->setDate(2015, 01, 22);
        $datetime->setTime(23, 50, 26);
        $this->assertEquals($datetime->getTimestamp(), $user->getJoined());
        $this->assertEquals('S', $user->getRole());
        $this->assertEquals(true, $user->isStaff());

    }

    public function test_update(){
        // echo an error message from update:
        //echo "*******MESSAGE***** " . $users->message    . "<br><br><br>";

        $users = new Felis\Users(self::$site);

        // test valid user, Bart Simpson
        $user = $users->get(9);
        $user->setEmail("test2@bart.com");
        $user->setName("Bart the man Simpson");
        $user->setAddress("123 Test lane");
        $user->setNotes("Hello world! Test for Bart");
        $user->setPhone("123-456-7890");
        $user->setRole("U");
        $this->assertTrue($users->update($user));

        // test invalid user, DNE
        $row = array(
            'id'=>999,
            'email'=>"fake@test.com",
            'name'=>"Fake boi",
            'address'=>'',
            'phone'=>"987-654-3210",
            'notes'=>"N/A",
            'joined'=>'',
            'role'=>"F"
        );
        $user = new Felis\User($row);
        $this->assertFalse($users->update($user));

        //test invalid user, break integrity constraint
        $user = $users->get(9);
        $user->setEmail("marge@bartman.com");
        $this->assertFalse($users->update($user));

    }
}

/// @endcond
