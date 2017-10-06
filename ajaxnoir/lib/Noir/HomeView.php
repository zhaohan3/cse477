<?php

namespace Noir;

/**
 * View class for the home page
 */
class HomeView extends View {
	/**
	 * DeleteView constructor.
	 * @param Site $site Site object
	 */
	public function __construct(Site $site, $user) {
		parent::__construct($site);

		$this->user = $user;
		$this->setTitle("Ajax Noir Movies");
	}


	/**
	 * Present the page body
	 * @return string HTML for the page body
	 */
	public function present() {
		$html = <<<HTML
<form method="post" action="post/home.php">
    <p class="buttons"><input type="submit" name="new" value="New">
        <input type="submit" name="edit" value="Edit">
        <input type="submit" name="delete" value="Delete">
        <input type="submit" name="info" value="Info">
        <input type="submit" name="logout" value="Logout">
    </p>
    <div class="table">
HTML;

		$html .= $this->presentTable();

		$html .= <<<HTML
	</div>
	<div class="message"></div>
    <div class="instructions">
    <p>New - Add a new movie.</p>
        <p>Edit - Edit the selected movie.</p>
        <p>Delete - Delete the selected movie.</p>
    </div>
</form>
HTML;

		return $html;
	}

	public function presentTable() {
		$html = <<<HTML
    <table>
        <tr><th>&nbsp;</th><th>Title</th><th>Year</th><th>Rating</th></tr>
HTML;

		$movies = new Movies($this->site);
		$all = $movies->getAll($this->user);

		foreach($all as $movie) {
			$title = $movie->getTitle();
			$year = $movie->getYear();
			$rating = $movie->getRating();
			$id = $movie->getId();
			if($rating === null) {
				$stars = "not rated";
			} else {
				$stars = '<span class="stars">' .
					str_repeat('<img src="images/star-green.png">', $rating) .
					str_repeat('<img src="images/star-gray.png">', 10 - $rating) .
					'</span> <span class="num">' .
					$rating . '/10</span>';
			}

			$html .= <<<HTML
<tr><td><input type="radio" value="$id" name="id"></td>
<td>$title</td><td>$year</td><td>$stars</td>
</tr>
HTML;
		}

		$html .= <<<HTML
    </table>
HTML;

		return $html;
	}

    public function head() {
        $html = parent::head();
        $html .= <<<HTML
<script>
$(document).ready(function() {
    new Stars("form");
});
</script>
HTML;
        return $html;
    }

	private $user;
}