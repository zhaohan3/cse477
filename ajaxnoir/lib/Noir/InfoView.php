<?php
namespace Noir;

/**
 * View class for the movie info page
 */
class InfoView extends View {

	/**
	 * DeleteView constructor.
	 * @param Site $site Site object
	 * @param $user User
	 * @param array $get $_GET
	 * @param array $session $_SESSION
	 */
	public function __construct(Site $site, $user, array $get) {
		parent::__construct($site);
		$this->user = $user;
		$this->get = $get;
		$this->setTitle("Ajax Noir Movie");
	}

	/**
	 * Present the page body
	 * @return string HTML for the page body
	 */
	public function present() {
		$title = '';
		$year = '';
		$rating = null;

		$html = <<<HTML
	<form method="post" action="post/home.php">
    <p class="buttons">
        <input type="submit" name="home" value="Home">
        <input type="submit" name="logout" value="Logout">
    </p>
    </form>
HTML;

		// Editing an existing movie
		$movies = new Movies($this->site);
		$movie = isset($this->get['i']) ?
			$movies->get($this->user, $this->get['i']) : null;
		if($movie !== null) {
            $title = addslashes($movie->getTitle());
            $year = addslashes($movie->getYear());
            /*
             * This is an example of a simple message
             */
			$content = <<<CONTENT
<p>Loading...</p>
<script>
$(document).ready(function() {
	new MovieInfo(".paper", "$title", "$year");
});
</script>

CONTENT;

			/*
			 * This is an example of three tabs.
			 * I have added class show to one to show it, but
			 * you should implement the show yourself in
			 * JavaScript
			 */
//			$content = <<<CONTENT
//<ul>
//
//<li><a href=""><img src="images/info.png"></a>
//<div class="show">
//<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
//incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
//exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute
//irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat
//nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa
//qui officia deserunt mollit anim id est laborum.</p>
//<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
//incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
//exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute
//irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat
//nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa
//qui officia deserunt mollit anim id est laborum.</p>
//</div>
//</li>
//
//<li><a href=""><img src="images/plot.png"></a>
//<div>
//<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
//incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
//exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute
//irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat
//nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa
//qui officia deserunt mollit anim id est laborum.</p></div>
//</li>
//
//<li><a href=""><img src="images/poster.png"></a>
//<div>
//<p class="poster"><img src="images/maltese.jpg">
//</p></div>
//</li>
//
//</ul>
//CONTENT;
		} else {
			$content = "<p>No movie selected.</p>";
		}

		$html .= <<<HTML
<div class="paper-wrapper">
<div class="paper">
$content;
</div>
</div>
<p class="attrib"><img src="images/moviedb.png"></p>
HTML;

		return $html;
	}

	private $user;
	private $get;
}
