<?php

/** @file
 * Empty unit testing template/database version
 * @cond 
 * Unit tests for the class
 */
require __DIR__ . "/../../vendor/autoload.php";

class EmailMock extends Felis\Email {
    public function mail($to, $subject, $message, $headers)
    {
        $this->to = $to;
        $this->subject = $subject;
        $this->message = $message;
        $this->headers = $headers;
    }

    public $to;
    public $subject;
    public $message;
    public $headers;
}

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

//        // test valid user, Bart Simpson
//        $user = $users->get(9);
//        $user->setEmail("test2@bart.com");
//        $user->setName("Bart the man Simpson");
//        $user->setAddress("123 Test lane");
//        $user->setNotes("Hello world! Test for Bart");
//        $user->setPhone("123-456-7890");
//        $user->setRole("C");
//        $this->assertTrue($users->update($user));

        // test valid user, Bart Simpson
        $user = $users->get(9);
        $user->setEmail("bart@bartman.com");
        $user->setName("Simpson, Bart");
        $user->setAddress("");
        $user->setNotes("");
        $user->setPhone("");
        $user->setRole("C");
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

    public function test_getAgents(){
        $users = new Felis\Users(self::$site);

        $clients = $users->getAgents();

        $this->assertEquals(2, count($clients));
        $c0 = $clients[0];
        $this->assertEquals(2, count($c0));
        $this->assertEquals(7, $c0['id']);
        $this->assertEquals("Dudess, The", $c0['name']);
        $c1 = $clients[1];
        $this->assertEquals(8, $c1['id']);
        $this->assertEquals("Owen, Charles", $c1['name']);
    }

    public function test_exists() {
        $users = new Felis\Users(self::$site);

        $this->assertTrue($users->exists("dudess@dude.com"));
        $this->assertFalse($users->exists("dudess"));
        $this->assertFalse($users->exists("cbowen"));
        $this->assertTrue($users->exists("cbowen@cse.msu.edu"));
        $this->assertFalse($users->exists("nobody"));
        $this->assertFalse($users->exists("7"));
    }

    public function test_add() {
        $users = new Felis\Users(self::$site);

        $mailer = new EmailMock();

        $user7 = $users->get(7);
        $this->assertContains("Email address already exists",
            $users->add($user7, $mailer));

        $row = array('id' => 0,
            'email' => 'dude@ranch.com',
            'name' => 'Dude, The',
            'phone' => '123-456-7890',
            'address' => 'Some Address',
            'notes' => 'Some Notes',
            'password' => '12345678',
            'joined' => '2015-01-15 23:50:26',
            'role' => 'S'
        );
        $user = new Felis\User($row);
        $users->add($user, $mailer);

        $table = $users->getTableName();
        $sql = <<<SQL
select * from $table where email='dude@ranch.com'
SQL;

        $stmt = $users->pdo()->prepare($sql);
        $stmt->execute();
        $this->assertEquals(1, $stmt->rowCount());

        $this->assertEquals("dude@ranch.com", $mailer->to);
        $this->assertEquals("Confirm your email", $mailer->subject);
    }

    public function test_setPassword() {
        $users = new Felis\Users(self::$site);

        // Test a valid login based on user ID
        $user = $users->login("dudess@dude.com", "87654321");
        $this->assertNotNull($user);
        $this->assertEquals("Dudess, The", $user->getName());

        // Change the password
        $users->setPassword(7, "dFcCkJ6t");

        // Old password should not work
        $user = $users->login("dudess@dude.com", "87654321");
        $this->assertNull($user);

        // New password does work!
        $user = $users->login("dudess@dude.com", "dFcCkJ6t");
        $this->assertNotNull($user);
        $this->assertEquals("Dudess, The", $user->getName());
    }

    public function test_getUsers(){
        $users = new Felis\Users(self::$site);

        $userList = $users->getUsers();
        //echo '<pre>' . print_r($userList) . '</pre>';
        $this->assertEquals(4, sizeof($userList));

        $u1 = $userList[0];
        $this->assertInstanceOf('Felis\User', $u1);
        $this->assertEquals('Dudess, The', $u1->getName());
        $this->assertEquals(7, $u1->getId());
        $this->assertEquals('dudess@dude.com', $u1->getEmail());
        $this->assertEquals('S', $u1->getRole());

        $u2 = $userList[1];
        $this->assertInstanceOf('Felis\User', $u2);
    }
}

/// @endcond
