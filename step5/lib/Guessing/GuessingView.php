<?php

namespace Guessing;

/**
 * View class for the guessing game.
 */
class GuessingView {
    /** Constructor
     * @param $guessing Guessing game object */
    public function __construct(Guessing $guessing) {
        $this->guessing = $guessing;
    }

    /**
     * Create the HTML we present
     * @return string HTML to present
     */
    public function present() {
        // All begins with this...
        $html = '<form method="post" action="guessing-post.php">' .
            '<h1>Guessing Game</h1>';

        // Save in handy variables
        $check = $this->guessing->check();
        $num = $this->guessing->getNumGuesses();

        if($check == Guessing::INVALID) {
            //
            // An invalid guess
            //
            $guess = $this->guessing->getGuess();
            $html .= <<<HTML
<p class="message">Your guess of $guess is invalid!</p>
<p><label for="value">Guess:</label> <input type="text" name="value" id="value"></p>
<p><input type="submit"></p>
HTML;

        } else if($num == 0) {
            //
            // New game, no guesses, yet.
            //
            $html .= <<<HTML
<p class="message">Try to guess the number.</p>
<p><label for="value">Guess:</label> <input type="text" name="value" id="value"></p>
<p><input type="submit"></p>
HTML;

        } else if($check == Guessing::CORRECT) {
            //
            // The guess was correct
            //
            $html .= <<<HTML
<p class="message">After $num guesses you are correct!</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
HTML;

        } else {
            //
            // Too high or low
            //
            $msg = $check == Guessing::TOOLOW ? "too low" : "too high";
            $html .= <<<HTML
    <p class="message">After $num guesses you are $msg!</p>
    <p><label for="value">Guess:</label> <input type="text" name="value" id="value"></p>
    <p><input type="submit"></p>
HTML;

        }

        // All ends with this
        $html .= '<p><input type="submit" name="clear" value="New Game"></p></form>';

        return $html;
    }

    private $guessing;	// Guessing object
}