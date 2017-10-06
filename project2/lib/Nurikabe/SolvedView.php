<?php

namespace Nurikabe;


class SolvedView extends View{
    public function __construct(Nurikabe $Nurikabe){
        parent::__construct($Nurikabe);
        $this->setPage("solved");
    }
    public function presentBody(){
        $html = <<<HTML
<div class="game-body">
    <div class="game-body-content">
        <table class="game-body-table">
HTML;

        $solution = $this->getNurikabe()->getGame();
        for($r=0; $r<sizeof($solution); $r++){
            $html .= "<tr>";
            for($c=0; $c<sizeof($solution[$r]); $c++){
                $cell = $solution[$r][$c];
                $id = $r . $c;
                if(is_int($cell)){
                    $html .= "<td class=\"number\" id=\"{$id}\">" . $cell;
                }
                else if($cell == Nurikabe::VACANT){
                    $html .= "<td class=\"vacant\" id=\"{$id}\">&nbsp;";
                }
                else if($cell == Nurikabe::SEA){
                    $html .= "<td class=\"sea\" id=\"{$id}\">&nbsp;";
                }
                else if($cell == Nurikabe::ISLAND){
                    $html .= "<td class=\"island\" id=\"{$id}\">&#9679;";
                }
                $html .= "</td>";
            }
            $html .= "</tr>";
        }

        $html .= <<<HTML
        </table>
        <p>You're a winner!</p>
    </div>
</div>
HTML;
        //print_r($this->getNurikabe()->getGame());
        return $html;
    }
}