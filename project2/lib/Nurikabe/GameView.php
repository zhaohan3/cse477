<?php

namespace Nurikabe;


class GameView extends View{
    private $user;
    public function __construct(Nurikabe $Nurikabe, $user){
        parent::__construct($Nurikabe);
        $this->setPage("game");
        $this->user = $user;
        if($this->getNurikabe()->gameEmpty()){
            header("location: index.php");
        }
    }

    public function presentBody(){
        $html = <<<HTML
<div class="game-body">
    <div class="game-body-content">
        <form action="post/game.php" method="post" name="GameForm" id="GameForm">
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

        $html .= "</table><p class=\"page-body-inner-content-game-buttons\">";
        if($this->getNurikabe()->getSolveConfirm()){
            $html .= "<button name=\"Yes\" id=\"solveYes\" value=\"solveYes\">Yes</button>
                      <button name=\"No\" id=\"solveNo\" value=\"solveNo\">No</button></p>
                      <p class=\"message\" id=\"message-solve\">Are you sure you want to solve?</p></p>";
        }
        else if($this->getNurikabe()->getClearConfirm()){
            $html .= "<button name=\"Yes\" id=\"clearYes\" value=\"clearYes\">Yes</button>
                      <button name=\"No\" id=\"clearNo\" value=\"clearNo\">No</button></p>
                      <p class=\"message\" id=\"message-clear\">Are you sure you want to clear?</p></p>";
        }
        else {
            $html .= <<<HTML
                <button name="checkSolution" id="checkSolution">Check Solution</button>
                <button name="solve" id="solve">Solve</button>
                <button name="clear" id="clear">Clear</button></p>
HTML;

            if($this->user != null){
                $html .= <<<HTML
                <p class="page-body-inner-content-game-buttons">
                <button name="save" id="save">Save Game</button>
                <button name="load" id="load">Load Game</button>
                </p>
HTML;
            }
        }

        $html .= "</form></div></div>";
        //print_r($this->getNurikabe()->getGame());
        return $html;
    }
}