<?php

namespace Noir;

/**
 * Controller class for the home page
 */
class HomeController extends Controller {
	/**
	 * HomeController constructor.
	 * @param Site $site Site object
	 * @param $user The user ID
	 * @param array $post $_POST
	 * @param array $session $_SESSION
	 */
    public function __construct(Site $site, $user, array $post, array &$session) {
        parent::__construct($site);

        $root = $site->getRoot();
        if(isset($post['new'])) {
            /*
             * New button pressed
             */
            $this->redirect = "$root/movie.php";
        } else if(isset($post['edit'])) {
            /*
             * Edit button pressed
             */
            if(!isset($post['id'])) {
                // Error: You must select a movie to edit.
				$this->redirect = "$root/";
				return;
            }

            $id = strip_tags($post['id']);
            $this->redirect = "$root/movie.php?i=$id";
        } else if(isset($post['delete'])) {
			/*
			 * Delete button pressed
			 */
			if(!isset($post['id'])) {
				// Error: You must select a movie to delete.
				$this->redirect = "$root/";
				return;
			}

			$id = strip_tags($post['id']);
			$this->redirect = "$root/deletemovie.php?i=$id";
		} else if(isset($post['info'])) {
			/*
			 * Info button pressed
			 */
			if(!isset($post['id'])) {
				// Error: You must select a movie to display info for.
				$this->redirect = "$root/";
				return;
			}

			$id = strip_tags($post['id']);
			$this->redirect = "$root/info.php?i=$id";
		} else if(isset($post['logout'])) {
			/*
			 * Logout button pressed
			 */
			unset($session[LOGIN_SESSION]);
			$this->redirect = "$root/login.php";
		} else {
            $this->redirect = "$root/";
        }
    }

}