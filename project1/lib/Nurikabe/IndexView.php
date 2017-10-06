<?php

namespace Nurikabe;


class IndexView extends View{
    public function __construct(Nurikabe $Nurikabe){
        parent::__construct($Nurikabe);
        $this->setPage("index");
        $this->getNurikabe()->resetGame();
    }

    public function presentBody(){
        $html = <<<HTML
<div class="page-body">
    <div class="page-body-content">
        <div class="page-body-inner-content">
            <form action="index-post.php" method="post" name="newGameForm" id="newGameForm">
                <p class="page-body-inner-content-form" id="name">Name</p>
                <p class="page-body-inner-content-form" id="top"><input type="text" name="nameIn" id="nameIn"
HTML;
        $html .= "value=\"" . $this->getNurikabe()->getPname() . "\"";
        $html .= <<<HTML
                ></p>
                <p class="page-body-inner-content-form"><select name="difficulty" id="difficulty">
                    <option value="ultraEasy">3x3 Ultra Easy</option>
                    <option value="veryEasy">8x8 Very Easy</option>
                    <option value="easy">10x10 Easy</option>
                    <option value="medium">8x8 Medium</option>
                </select></p>
                <p class="page-body-inner-content-form"><button name="startGame" id="startGame">Start Game</button></p>
HTML;
        if(!$this->getNurikabe()->getNameSet()){
            $html .= "<p class=\"message\" id=\"name-error\">You Must Enter a Name!</p>";
        }

        $html .= <<<HTML
            </form>
        </div>
    </div>
</div>
HTML;
        return $html;
    }
}