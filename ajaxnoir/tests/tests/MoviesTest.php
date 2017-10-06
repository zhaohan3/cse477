<?php
require_once __DIR__ . "/DatabaseBase.php";

/** @file
 * @brief Unit tests for the class Movies
 * @cond 
 */
class MoviesTest extends DatabaseBase {
    /**
     * @return PHPUnit_Extensions_Database_DataSet_IDataSet
     */
    public function getDataSet() {
		return $this->createFlatXMLDataSet(dirname(__FILE__) . '/db/movie.xml');
    }

	public function test_getAll() {
		$movies = new Noir\Movies(self::$site);

		$all = $movies->getAll("test");
		$this->assertEquals(2, count($all));
	}

	public function test_get() {
		$movies = new Noir\Movies(self::$site);

		// <test_ajaxnoir_movie id="14" user="test" title="Felis Noir" year="2016" rating="8" />
		$movie = $movies->get("test", 14);
		$this->assertEquals("Felis Noir", $movie->getTitle());

		$movie = $movies->get("test", 999);
		$this->assertNull($movie);
	}

	public function test_updateRating() {
		$movies = new Noir\Movies(self::$site);

		$movie = $movies->get("test", 12);
		$this->assertEquals(10, $movie->getRating());

		$this->assertTrue($movies->updateRating("test", 12, 7));
		$movie = $movies->get("test", 12);
		$this->assertEquals(7, $movie->getRating());

		// Invalid ID
		$this->assertFalse($movies->updateRating("test", 22, 9));

		// Invalid user
		$this->assertFalse($movies->updateRating("test", 15, 9));
	}
}

/// @endcond
?>
