<?php

namespace Noir;

/**
 * Class that represents the collection of movies and the movie table.
 *
 * Most of these functions require a user. That's a security precaution
 * the ensures users can only change their own movies.
 */
class Movies extends Table {
	/**
	 * Constructor
	 * @param $site The Site object
	 */
	public function __construct(Site $site) {
		parent::__construct($site, "movie");
	}

	/**
	 * Ensure the movie table exists. If it  does not,
	 * create it.
	 */
	public function ensureExists($user) {
		$sql = <<<SQL
CREATE TABLE IF NOT EXISTS $this->tableName (
  id     int(10) NOT NULL AUTO_INCREMENT,
  `user` varchar(20) NOT NULL,
  title  varchar(200) NOT NULL,
  year   int(4) NOT NULL,
  rating int(2),
  PRIMARY KEY (id),
  CONSTRAINT unique_movie
    UNIQUE (`user`, title, year));
SQL;

		$this->site->pdo()->query($sql);

		// Some initial records if the table is empty
		if(count($this->getAll($user)) == 0 ) {
			$sql = <<<SQL
  insert into $this->tableName(user, title, year, rating)
  values(?, "The Maltese Falcon", 1941, 10),
     (?, "Felis Noir", 2016, 8)
SQL;

			$stmt = $this->pdo()->prepare($sql);
			$stmt->execute(array($user, $user));
		}
	}

	/**
	 * Get all movies in the system.
	 * @param $user User to get movies for
	 * @return array of all movies in the system for a user
	 */
	public function getAll($user) {
		$sql = <<<SQL
select * from $this->tableName
where user=?
order by rating desc, title asc
SQL;

		$stmt = $this->pdo()->prepare($sql);
		$stmt->execute(array($user));

		$movies = array();
		foreach($stmt as $row) {
			$movies[] = new Movie($row);
		}

		return $movies;
	}

	/**
	 * Add a movie to the table.
	 *
	 * The main reason for failure is a duplicate movie title,
	 * which causes a constraint violation.
	 * @param $user User ID
	 * @param Movie $movie Movie to add
	 * @return bool True if successful
	 */
	public function add($user, Movie $movie) {
		$sql = <<<SQL
insert into $this->tableName(user, title, year, rating)
values(?, ?, ?, ?)
SQL;

		$stmt = $this->pdo()->prepare($sql);
		$ret = $stmt->execute(array($user, $movie->getTitle(), $movie->getYear(), $movie->getRating()));

		if($ret === FALSE) {
			return false;
		}

		return $this->pdo()->lastInsertId();
	}

	/**
	 * Get a single movie by ID
	 * @param $user User to get the movie for
	 * @param $id ID to look up
	 * @return Movie|null
	 */
	public function get($user, $id) {
		$sql = <<<SQL
select * from $this->tableName
where user=? and id=?
SQL;

		$stmt = $this->pdo()->prepare($sql);
		$stmt->execute(array($user, $id));

		$row = $stmt->fetch(\PDO::FETCH_ASSOC);
		if($row === false) {
			return null;
		}

		return new Movie($row);
	}

	/**
	 * Update a movie record
	 * @param $user User to get the movie for
	 * @param Movie $movie Modified movie
	 * @return false on failure
	 */
	public function update($user, Movie $movie) {
		$sql = <<<SQL
update $this->tableName
set title=?, year=?, rating=?
where user=? and id=?
SQL;

		$stmt = $this->pdo()->prepare($sql);
		$ret = $stmt->execute(array($movie->getTitle(), $movie->getYear(), $movie->getRating(), $user, $movie->getId()));

		return $ret;
	}

	/**
	 * Update a movie record
	 * @param $user User to update
	 * @param $id ID for the movie to change
	 * @param $rating New rating to set
	 * @return false on failure
	 */
	public function updateRating($user, $id, $rating) {
		$sql = <<<SQL
update $this->tableName
set rating=?
where user=? and id=?
SQL;

		$stmt = $this->pdo()->prepare($sql);
		$ret = $stmt->execute(array($rating, $user, $id));

		return $ret && $stmt->rowCount() == 1;
	}

	/**
	 * Delete a movie
	 * @param $user User to delete for
	 * @param $id Id for the movie to delete
	 * @return false on failure
	 */
	public function delete($user, $id) {
		$sql = <<<SQL
delete from $this->tableName
where user=? and id=?
SQL;

		$stmt = $this->pdo()->prepare($sql);
		$ret = $stmt->execute(array($user, $id));

		return $ret && $stmt->rowCount() == 1;
	}
}