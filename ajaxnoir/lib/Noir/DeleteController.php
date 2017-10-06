<?php

namespace Noir;

/**
 * Controller for the deletemovie page
 */
class DeleteController extends Controller {
	/**
	 * DeleteController constructor.
	 * @param Site $site The Site object
	 * @param $user The User
	 * @param array $_POST
	 */
	public function __construct(Site $site, $user, array $post) {
		parent::__construct($site);

		if(isset($post['ok']) && isset($post['id'])) {
			$id = strip_tags($post['id']);

			$movies = new Movies($this->site);
			$movies->delete($user, $id);
		}

		//
		// And redirect back to home
		//
		$this->redirect = $site->getRoot();
	}
}