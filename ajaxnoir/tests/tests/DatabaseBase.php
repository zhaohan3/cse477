<?php
require_once __DIR__ . "/../../vendor/autoload.php";

/** @file
 * @brief Base class for tests that involve the database.
 * @cond 
 */

abstract class DatabaseBase extends \PHPUnit_Extensions_Database_TestCase {
	/**
	 * @return PHPUnit_Extensions_Database_DB_IDatabaseConnection
	 */
	public function getConnection() {
		return $this->createDefaultDBConnection(self::$site->pdo(), self::$site->getUser());
	}

	protected static $site;

	/**
	 * This code is executed before any tests. I am
	 * creating a Site object to use and also
	 * ensuring the tables exist.
	 */
	public static function setUpBeforeClass() {
		self::$site = new Noir\Site();
		$localize  = require 'localize.inc.php';
		if(is_callable($localize)) {
			$localize(self::$site);
		}

		/*
		 * This code automatically creates the tables
		 * if they do not already exist.
		 */
		$movies = new Noir\Movies(self::$site);
		$movies->ensureExists("test");
	}
}

/// @endcond
?>
