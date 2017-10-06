<?php
namespace Noir;

/**
 * Base class for all views
 */
class View {
	/**
	 * View constructor.
	 * @param Site $site. The Site object
	 */
	public function __construct(Site $site) {
		$this->site = $site;
	}

    /**
     * Create the HTML for the page header
     * @return string HTML for the standard page header
     */
    public function header() {
        $html = <<<HTML
<header class="main">
    <h1>$this->title</h1>
</header>
HTML;
        return $html;
    }



    /**
     * Create the HTML for the page footer
     * @return string HTML for the standard page footer
     */
    public function footer()
    {
        return <<<HTML
<footer><p>Copyright © 2016 Felis Investigations, Inc. All rights reserved.</p></footer>
HTML;
    }

	/**
	 * Create the HTML for the contents of the head tag
	 * @return string HTML for the page head
	 */
	public function head() {
		return <<<HTML
<meta charset="utf-8">
<title>$this->title</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="noir.css">
<script src="node_modules/jquery/dist/jquery.min.js"></script>
<script src="site.con.js"></script>
HTML;
	}

	/**
	 * Set the page title
	 * @param $title New page title
	 */
	public function setTitle($title) {
		$this->title = $title;
	}

	/**
	 * Get the redirect location link.
	 * @return page to redirect to.
	 */
	public function getRedirect() {
		return $this->redirect;
	}

	protected $site;		///< The Site object
	private $title = "";	///< The page title

	protected $redirect = null;	///< Optional redirect?
}