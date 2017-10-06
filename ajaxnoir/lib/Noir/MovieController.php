<?php

namespace Noir;

/**
 * Controller class for the movie editing page
 */
class MovieController extends Controller {

    /**
     * HomeController constructor.
     * @param Site $site Site object
	 * @param $user User
     * @param array $post $_POST
     */
    public function __construct(Site $site, $user, $post) {
        parent::__construct($site);

        $root = $site->getRoot();
        if(isset($post['ok'])) {
            // Edit or add?
            if(isset($post['id'])) {
                $id = strip_tags($post['id']);
            } else {
                $id = null;
            }

			$this->id = $id;

            // The OK button was pressed
            // Get the values and do some error checking
            $title = trim(strip_tags($post['title']));
            if($title === '') {
                // No title entered
                $this->error("movie.php", "No title entered");
                return;
            }

            $year = trim(strip_tags($post['year']));
            if($year === '') {
                $this->error("movie.php", "No year entered");
                return;
            }

            if(!is_numeric($year)) {
                $this->error("movie.php", "Invalid year entered");
                return;
            }

            $year = intval($year);
            if($year < 1800 || $year > 2100) {
                $this->error("movie.php", "Invalid year entered");
                return;
            }

            $rating = isset($post['rating']) ? strip_tags($post['rating']) : null;
            //
            // Create the movie object
            //
            $row = array("id" => $id, "title" => $title, "year" => $year, "rating" => $rating);
            $movie = new Movie($row);

            $movies = new Movies($this->site);

            if($id === null) {
                //
                // Try to insert
                //
                $id = $movies->add($user, $movie);
                if($id === false) {
                    $this->error("movie.php", "Unable to add movie, name already exists");
                    return;
                }
            } else {
                //
                // Try to edit
                //
                if(!$movies->update($user, $movie)) {
                    $this->error("movie.php?i=$id", "Unable to edit movie, name already exists");
                    return;
                }
            }

            //
            // And redirect back to home
            //
            $this->redirect = "$root/";
        } else {
            // Cancel was pressed, just return to the home page
            $this->redirect = "$root/";
        }

    }

	private function error($msg) {
		$root = $this->site->getRoot();
		if($this->id !== null) {
			$this->redirect = "$root/movie.php?id=" . $this->id;
		} else {
			$this->redirect = "$root/movie.php";
		}
	}

	private $id;
}