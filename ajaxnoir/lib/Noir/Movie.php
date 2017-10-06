<?php

namespace Noir;

/**
 * Represents a single movie in our system.
 */
class Movie {
	public function __construct($row) {
		$this->id = $row['id'];
		$this->title = $row['title'];
		$this->year = $row['year'];
		$this->rating = $row['rating'];
	}

	/**
	 * Get the internal movie ID
	 * @return mixed
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * Get the movie title
	 * @return mixed
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * Get the movie year
	 * @return mixed
	 */
	public function getYear() {
		return $this->year;
	}

	/**
	 * Get the movie rating
	 * @return mixed null if none or 1-10.
	 */
	public function getRating() {
		return $this->rating;
	}


	private $id;
	private $title;
	private $year;
	private $rating;
}