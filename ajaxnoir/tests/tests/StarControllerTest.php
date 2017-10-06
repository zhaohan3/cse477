<?php
require_once __DIR__ . "/DatabaseBase.php";

/**
 * Unit tests for the class StarController
 */
class StarControllerTest extends DatabaseBase {
    /**
     * @return PHPUnit_Extensions_Database_DataSet_IDataSet
     */
    public function getDataSet() {
        return $this->createFlatXMLDataSet(dirname(__FILE__) .
            '/db/movie.xml');
    }

    public function test_construct() {
        $movies = new Noir\Movies(self::$site);

        // Successful update
        $post = array('id' => "12", 'rating' => 7);
        $controller = new \Noir\StarController(self::$site, "test", $post);
        $ret = json_decode($controller->getResult(), true);
        $this->assertTrue($ret['ok']);

        $movie = $movies->get("test", 12);
        $this->assertEquals(7, $movie->getRating());

        // Unsuccessful update
        $post = array('id' => "99", 'rating' => 7);
        $controller = new \Noir\StarController(self::$site, "test", $post);
        $ret = json_decode($controller->getResult(), true);
        $this->assertFalse($ret['ok']);
        $this->assertEquals("Failed to update database!", $ret['message']);
    }

}