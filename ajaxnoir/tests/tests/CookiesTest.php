<?php
require_once __DIR__ . "/DatabaseBase.php";

/**
 * Unit tests for the class Cookies
 */
class CookiesTest extends DatabaseBase {
    /**
     * @return PHPUnit_Extensions_Database_DataSet_IDataSet
     */
    public function getDataSet() {
        return $this->createFlatXMLDataSet(dirname(__FILE__) . '/db/cookie.xml');
    }

    /*
     * Simple test that we can create a token
     */
    public function test_create() {
        $cookies = new Noir\Cookies(self::$site);

        $token = $cookies->create("test");
        $this->assertNotNull($token);
        $this->assertEquals(32, strlen($token));
    }

    /*
     * Test that we can create and validate a token
     */
    public function test_validate() {
        $cookies = new Noir\Cookies(self::$site);

        $token = $cookies->create("test");

        $this->assertNotNull($cookies->validate("test", $token));
    }

    /*
     * Test that we can delete a token
     */
    public function test_delete() {
        $cookies = new Noir\Cookies(self::$site);

        $token = $cookies->create("test");
        $hash = $cookies->validate("test", $token);
        $this->assertNotNull($hash);

        $cookies->delete($hash);
        $this->assertNull($cookies->validate("test", $token));
    }

    /*
     * Ensure you can have multiple tokens active for a given user
     */
    public function test_multiples() {
        $cookies = new Noir\Cookies(self::$site);

        $token1 = $cookies->create("test");
        $token2 = $cookies->create("test");
        $token3 = $cookies->create("test");

        $hash1 = $cookies->validate("test", $token1);
        $this->assertNotNull($hash1);
        $hash2 = $cookies->validate("test", $token2);
        $this->assertNotNull($hash2);
        $hash3 = $cookies->validate("test", $token3);
        $this->assertNotNull($hash3);

        $cookies->delete($hash2);
        $this->assertNull($cookies->validate("test", $token2));
        $this->assertNotNull($cookies->validate("test", $token1));
        $this->assertNotNull($cookies->validate("test", $token3));

        $cookies->delete($hash1);
        $this->assertNull($cookies->validate("test", $token1));
        $this->assertNotNull($cookies->validate("test", $token3));

        $cookies->delete($hash3);
        $this->assertNull($cookies->validate("test", $token3));
    }

}