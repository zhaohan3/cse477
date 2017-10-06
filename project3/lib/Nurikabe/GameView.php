<?php

namespace Nurikabe;


class GameView extends View{
    public function __construct(Nurikabe $Nurikabe){
        parent::__construct($Nurikabe);
        $this->setPage("game");
        if($this->getNurikabe()->gameEmpty()){
            header("location: index.php");
        }
        $gameJson = $this->getNurikabe()->getGameJson();
        $gameSolution = $this->getNurikabe()->getSolutionJson();
        $this->setHeadAdditional("
            <script>
            $(document).ready(function() {
                new Nurikabe(\".game-body-table\", '$gameJson', '$gameSolution');
            });
            </script>");
    }

    public function presentBody(){
        $html = <<<HTML
<div class="game-body">
    <div class="game-body-content">
        <form action="game-post.php" method="post" name="GameForm" id="GameForm">
        <table class="game-body-table">
HTML;

        $game = $this->getNurikabe()->getGame();
        for($r=0; $r<sizeof($game); $r++){
            $html .= "<tr>";
            for($c=0; $c<sizeof($game[$r]); $c++){
                $cell = $game[$r][$c];
                $id = $r . $c;
                $value = $r . "," . $c;
                if(is_int($cell)){
                    $html .= "<td class=\"number\" id=\"{$id}\">" . $cell;
                }
                else if($cell == Nurikabe::VACANT){
                    $html .= "<td class=\"vacant\" id=\"{$id}\"><button name=\"cell\" value=\"{$value}\">&nbsp;</button>";
                }
                else if($cell == Nurikabe::SEA){
                    $html .= "<td class=\"sea\" id=\"{$id}\"><button name=\"cell\" value=\"{$value}\">&nbsp;</button>";
                }
                else if($cell == Nurikabe::ISLAND){
                    $html .= "<td class=\"island\" id=\"{$id}\"><button name=\"cell\" value=\"{$value}\">&#9679;</button>";
                }
                else if($cell == Nurikabe::RED){
                    $html .= "<td class=\"incorrect\" id=\"{$id}\"><button name=\"cell\" value=\"{$value}\">&nbsp;</button>";
                }
                else if($cell == Nurikabe::RED_ISLAND){
                    $html .= "<td class=\"incorrect\" id=\"{$id}\"><button name=\"cell\" value=\"{$value}\">&#9679;</button>";
                }
                $html .= "</td>";
            }
            $html .= "</tr>";
        }

        $html .= <<<HTML
</table>
<div class="page-body-inner-content-game-buttons">
<p class="message" id="winner-message">You're a winner!</p>


<button name="Yes" id="solveYes" value="solveYes">Yes</button>
<button name="No" id="solveNo" value="solveNo">No</button>
<p class="message" id="message-solve">Are you sure you want to solve?</p>

<button name="checkSolution" id="checkSolution">Check Solution</button>
<button name="solve" id="solve">Solve</button>
<button name="clear" id="clear">Clear</button>
</div>

HTML;

//        if($this->getNurikabe()->getSolveConfirm()){
//            $html .= "<button name=\"Yes\" id=\"solveYes\" value=\"solveYes\">Yes</button>
//                      <button name=\"No\" id=\"solveNo\" value=\"solveNo\">No</button></p>
//                      <p class=\"message\" id=\"message-solve\">Are you sure you want to solve?</p>";
//        }
//        else if($this->getNurikabe()->getClearConfirm()){
//            $html .= "<button name=\"Yes\" id=\"clearYes\" value=\"clearYes\">Yes</button>
//                      <button name=\"No\" id=\"clearNo\" value=\"clearNo\">No</button></p>
//                      <p class=\"message\" id=\"message-clear\">Are you sure you want to clear?</p>";
//        }
//        else {
//            $html .= <<<HTML
//                <button name="checkSolution" id="checkSolution">Check Solution</button>
//                <button name="solve" id="solve">Solve</button>
//                <button name="clear" id="clear">Clear</button>
//            </p>
//HTML;
//        }

        $html .= "</form></div></div>";
        //print_r($this->getNurikabe()->getGame());
        return $html;
    }
}