<?php

namespace Noir;

/**
 * Base class for any controllers I use
 *
 * I created this so I would not be repeating work such
 * as the redirect functionality
 */
class Controller {
	/**
	 * Controller constructor.
	 * @param Site $site The Site object
	 */
	public function __construct(Site $site) {
		$this->site = $site;
	}

	/**
	 * Get the redirect location link.
	 * @return page to redirect to.
	 */
	public function getRedirect() {
		return $this->redirect;
	}

	/**
	 * Get any AJAX response
	 * @return JSON result for AJAX
	 */
	public function getResult() {
		return $this->result;
	}

	/**
	 *
	 * @return string HTML for the redirect
	 */
	public function linkRedirect() {
		return '<a href="' . $this->redirect . '">' . $this->redirect . '</a>';
	}

	protected $redirect;		///< Page we will redirect the user to.
	protected $result = null;	///< Result for AJAX operations

	protected $site;			///< The Site object
}