<?php

/** @file
 * Empty unit testing template/database version
 * @cond 
 * Unit tests for the class
 */

require __DIR__ . "/../../vendor/autoload.php";

class EmailMock extends Nurikabe\Email {
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
        $users = new \Nurikabe\Users(self::$site);

        $this->assertInstanceOf('Nurikabe\Users', $users);
        $this->assertEquals('testproj2_user', $users->getTableName());
    }

    public function test_login() {
        $users = new Nurikabe\Users(self::$site);

        // Test a valid login based on email address
        $user = $users->login("dudess@dude.com", "87654321");
        $this->assertInstanceOf('Nurikabe\User', $user);
        $this->assertEquals(7, $user->getId());
        $this->assertEquals('dudess@dude.com', $user->getEmail());
        $this->assertEquals('Dudess, The', $user->getName());
        $datetime = new DateTime();
        $datetime->setDate(2015, 01, 22);
        $datetime->setTime(23, 50, 26);
        $this->assertEquals($datetime->getTimestamp(), $user->getJoined());

        // Test a valid login based on email address
        $user = $users->login("cbowen@cse.msu.edu", "super477");
        $this->assertInstanceOf('Nurikabe\User', $user);

        // Test a failed login
        $user = $users->login("dudess@dude.com", "wrongpw");
        $this->assertNull($user);
    }

    public function test_get(){
        $users = new Nurikabe\Users(self::$site);
        // test get id
        $user = $users->get("dudess@dude.com");
        $this->assertInstanceOf('Nurikabe\User', $user);
        $this->assertEquals(7, $user->getId());
        $this->assertEquals('dudess@dude.com', $user->getEmail());
        $this->assertEquals('Dudess, The', $user->getName());
        $datetime = new DateTime();
        $datetime->setDate(2015, 01, 22);
        $datetime->setTime(23, 50, 26);
        $this->assertEquals($datetime->getTimestamp(), $user->getJoined());
    }

    public function test_exists() {
        $users = new Nurikabe\Users(self::$site);

        $this->assertTrue($users->exists("dudess@dude.com"));
        $this->assertFalse($users->exists("dudess"));
        $this->assertFalse($users->exists("cbowen"));
        $this->assertTrue($users->exists("cbowen@cse.msu.edu"));
        $this->assertFalse($users->exists("nobody"));
        $this->assertFalse($users->exists("7"));
    }

    public function test_add() {
        $users = new Nurikabe\Users(self::$site);
        $validators = new Nurikabe\Validators(self::$site);

        $mailer = new EmailMock();

        $user7 = $users->get("dudess@dude.com");
        $this->assertContains("Email address already exists",
            $users->add($user7, $mailer));

        $row = array('id' => 0,
            'email' => 'dude@ranch.com',
            'name' => 'Dude, The',
            'joined' => '2015-01-15 23:50:26',
        );
        $user = new Nurikabe\User($row);
        $users->add($user, $mailer);

        $this->assertEquals("dude@ranch.com", $mailer->to);
        $this->assertEquals("Confirm your email", $mailer->subject);
        $this->assertContains(self::$site->getEmail(), $mailer->headers);
    }

    public function test_addValidated(){
        $row = array('id' => 123,
            'email' => 'hello@world.com',
            'name' => 'Hello world',
            'joined' => '1970-01-01 23:50:26',
        );
        $user = new Nurikabe\User($row);
        $users = new Nurikabe\Users(self::$site);
        // set pass to hello123world
        $pass = "hello123world";

        $result = $users->addValidated($user, $pass);
        $this->assertTrue($result);

        $login = $users->login($user->getEmail(), $pass);
        $this->assertNotNull($login);
    }

    public function test_setPassword() {
        $users = new Nurikabe\Users(self::$site);

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
        $users = new Nurikabe\Users(self::$site);

        $userList = $users->getUsers();
        //echo '<pre>' . print_r($userList) . '</pre>';
        $this->assertEquals(4, sizeof($userList));

        $u1 = $userList[0];
        $this->assertInstanceOf('Nurikabe\User', $u1);
        $this->assertEquals('Dudess, The', $u1->getName());
        $this->assertEquals(7, $u1->getId());
        $this->assertEquals('dudess@dude.com', $u1->getEmail());

        $u2 = $userList[1];
        $this->assertInstanceOf('Nurikabe\User', $u2);
    }


}

/// @endcond
