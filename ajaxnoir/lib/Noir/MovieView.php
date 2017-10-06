<?php
namespace Noir;

/**
 * View class for the movie editing page
 */
class MovieView extends View {

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
		/*
		 * We may be editing an existing movie or
		 * adding a new movie. We determine that
		 * by checking to see if $get['i'] exists
		 */
		$title = '';
		$year = '';
		$rating = null;
		$hidden = '';

        if(isset($this->get['i'])) {
            // Editing an existing movie
            $movies = new Movies($this->site);
            $movie = $movies->get($this->user, $this->get['i']);
            if($movie !== null) {
                $title = $movie->getTitle();
                $id = $movie->getId();
                $rating = $movie->getRating();
                $year = $movie->getYear();

                // When editing we add a hidden field with the id of
                // the movie we are editing.
                $hidden = '<input type="hidden" name="id" value="' . $id . '">';
            }
        } else {
			// Adding a new movie
			// Just use empty values
		}

        $html = <<<HTML
<form class="movie" method="post" action="post/movie.php">
$hidden
    <fieldset>
        <p><label for="title">Title: </label>
        <input type="text" id="title" name="title" value="$title"></p>
        <p><label for="year">Year: </label>
            <input type="text" id="year" name="year" value="$year"></p>
        <p class="rating">
HTML;

		for($i=1; $i<=10; $i++) {
			$checked = ($i == $rating) ? " checked" : "";
			$html .= <<<HTML
<input type="radio" name="rating" value="$i"$checked>
HTML;

		}
		$html .= <<<HTML

		</p>
		<p class="buttons"><input type="submit" name="ok" value="OK">
			<input type="submit" name="cancel" value="Cancel">
		</p>

	</fieldset>
</form>
HTML;

		return $html;
	}

	private $user;
	private $get;
}