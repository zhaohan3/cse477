<?php

namespace Noir;

/**
 * Site configuration class
 */
class Site {

    /**
     * Configure the database
     * @param $host
     * @param $user
     * @param $password
     * @param $prefix
     */
    public function dbConfigure($host, $user, $password, $prefix) {
        $this->dbHost = $host;
        $this->dbUser = $user;
        $this->dbPassword = $password;
        $this->tablePrefix = $prefix;
    }

	/**
	 * Database connection function
	 * @returns PDO object that connects to the database
	 */
	public function pdo() {
		// This ensures we only create the PDO object once
		if($this->pdo !== null) {
			return $this->pdo;
		}

		try {
			$this->pdo = new \PDO($this->dbHost, $this->dbUser, $this->dbPassword);
		} catch(\PDOException $e) {
			// If we can't connect we die!
			die("Unable to select database");
		}

		return $this->pdo;
	}

	public function getUser() {
		return $this->dbUser;
	}

	public function getPassword() {
		return $this->dbPassword;
	}

	/**
	 * @return string
	 */
	public function getRoot() {
		return $this->root;
	}

	/**
	 * @param string $root
	 */
	public function setRoot($root) {
		$this->root = $root;
	}

	/**
	 * @return string
	 */
	public function getTablePrefix() {
		return $this->tablePrefix;
	}

	public function startup($user) {
		$movies = new Movies($this);
		$movies->ensureExists($user);
	}

    private $dbHost = null;     ///< Database host name
    private $dbUser = null;     ///< Database user name
    private $dbPassword = null; ///< Database password
    private $tablePrefix = '';  ///< Database table prefix
    private $root = '';         ///< Site root

	private $pdo = null; ///< The PDO object

}