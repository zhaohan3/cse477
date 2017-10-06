<?php

namespace Nurikabe;


class IndexView extends View{
    private $user;
    public function __construct(Nurikabe $Nurikabe, $user){
        parent::__construct($Nurikabe);
        $this->setPage("index");
        $this->getNurikabe()->resetGame();
        $this->user = $user;
    }

    public function presentHeader($page){
        $html = <<<HTML
<header>
    <p><img src="images/nifty800.png" height="140" width="800" alt="Nifty Nurikabe"></p>
    <p id="links">
HTML;
        $html.="<a href=\"instructions.php\">INSTRUCTIONS</a>";

        if($this->user == null) {
            $html .= "&nbsp;<a href=\"login.php\">LOG IN</a>";
            $html .= "&nbsp;<a href=\"newuser.php\">NEW USER</a>";
        }
        else{
            $html .= "&nbsp;<a href=\"post/logout.php\">LOG OUT</a>";
        }

        $html .= "</p>";
        $html .= "<h1>Welcome to Daniel Agbay's Nifty Nurikabe!</h1>";
        $html .="</header>";
        return $html;
    }

    public function presentBody(){
        $html = <<<HTML
<div class="page-body">
    <div class="page-body-content">
        <div class="page-body-inner-content">
            <form action="post/index.php" method="post" name="newGameForm" id="newGameForm">
                <p class="page-body-inner-content-form name">Name</p>
                <p class="page-body-inner-content-form top"><input type="text" name="nameIn" id="nameIn"
HTML;
        if($this->user != null){
            $html .= "value=\"" . $this->user->getName() . "\" readonly";
        }
        else {
            $html .= "value=\"" . $this->getNurikabe()->getPname() . "\"";
        }
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