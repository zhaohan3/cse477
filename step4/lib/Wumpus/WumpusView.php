<?php
/**
 * Created by PhpStorm.
 * User: danielagbay
 * Date: 5/30/17
 * Time: 9:59 PM
 */

namespace Wumpus;


class WumpusView
{
    private $wumpus;    // The Wumpus object
    /**
     * Constructor
     * @param Wumpus $wumpus The Wumpus object
     */
    public function __construct(Wumpus $wumpus) {
        $this->wumpus = $wumpus;
    }

    /** Generate the HTML for the number of arrows remaining */
    public function presentArrows() {
        $a = $this->wumpus->numArrows();
        return "<p>You have $a arrows remaining.</p>";
    }

    public function presentStatus(){
        $html = "";
        $html .=   "<p>" . date("g:ia l, F j, Y") . "</p>";
        if($this->wumpus->wasCarried()){
            $html .= "<p>You were carried by the birds to room " . $this->wumpus->getCurrent()->getNum() . "!</p>";
        }

        $html .= "<p>You are in room " . $this->wumpus->getCurrent()->getNum() . "</p>";
        if($this->wumpus->hearBirds()){
            $html .= "<p>You hear birds!</p>";
        }
        if($this->wumpus->feelDraft()){
            $html .= "<p>You  feel a draft!</p>";
        }
        if($this->wumpus->smellWumpus()){
            $html .= "<p>You smell a wumpus!</p>";
        }
        return $html;

    }

    public function presentImages(){
        $html = <<<HTML
<div class="room"><img src="cave2.jpg" width="180" height="135" alt="Cave 2 image"></div>
<div class="room"><img src="cave2.jpg" width="180" height="135" alt="Cave 2 image"></div>
<div class="room"><img src="cave2.jpg" width="180" height="135" alt="Cave 2 image"></div>
HTML;
        return $html;
    }

    public function presentShootArrow($ndx){
        $room = $this->wumpus->getCurrent()->getNeighbors()[$ndx];
        $roomndx = $room->getNdx();
        $shooturl = "game-post.php?s=$roomndx";

        $html = <<<HTML
<div class="label"><a href="$shooturl">Shoot Arrow</a></div>
HTML;

        return $html;
    }

    /** Present the links for a room
     * @param $ndx An index 0 to 2 for the three rooms */
    public function presentRoom($ndx) {
        $room = $this->wumpus->getCurrent()->getNeighbors()[$ndx];
        $roomnum = $room->getNum();
        $roomndx = $room->getNdx();
        $roomurl = "game-post.php?m=$roomndx";

        $html = <<<HTML
<div class="label"><a href="$roomurl">$roomnum</a></div>
HTML;

        return $html;
    }

}