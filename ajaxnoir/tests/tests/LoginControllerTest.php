<?php
require_once __DIR__ . "/DatabaseBase.php";

define("LOGIN_SESSION", "ajaxnoir_login");

/** @file
 * @brief Unit tests for the class LoginController
 * @cond 
 */
class LoginControllerTest extends DatabaseBase {
	/**
	 * @return PHPUnit_Extensions_Database_DataSet_IDataSet
	 */
	public function getDataSet() {
		return $this->createFlatXMLDataSet(dirname(__FILE__) . '/db/movie.xml');
	}


	public function test_construct() {
		$login_session = LOGIN_SESSION;

		/*
		 * This is an extra login record we'll use for
		 * testing purposes. Creating this makes it easier
		 * to distribute the code without everyone getting
		 * a login that anyone can use.
		 *
		 * User: test
		 * Password: zXAajLf9
		 */
		$extra = array('user' => 'test', 'salt' => '40wQld%&LYNp4ZBC',
			'hash' => 'df4c872a265f94094e3e28ff3c7259889e9eedbee4109eaa060bfe3280540974');


		// Valid login
        $post = array('user' => "test",
            'password' => "zXAajLf9");
        $session = array();

        $login = new Noir\LoginController(self::$site, $post, $session, $extra);
        $ret = json_decode($login->getResult(), true);
        $this->assertTrue($ret['ok']);
        $this->assertTrue(isset($session[$login_session]));

        // Bad user ID
        $post = array('user' => "doofus",
            'password' => "zXAajLf9");
        $session = array();

        $login = new Noir\LoginController(self::$site, $post, $session, $extra);
        $ret = json_decode($login->getResult(), true);
        $this->assertFalse($ret['ok']);
        $this->assertFalse(isset($session[$login_session]));
        $this->assertEquals("Invalid user ID", $ret['message']);

        // Bad password
        $post = array('user' => "test",
            'password' => "12345678");
        $session = array();

        $login = new Noir\LoginController(self::$site, $post, $session, $extra);
        $ret = json_decode($login->getResult(), true);
        $this->assertFalse($ret['ok']);
        $this->assertFalse(isset($session[$login_session]));
        $this->assertEquals("Invalid password", $ret['message']);
	}

}

/// @endcond
?>
