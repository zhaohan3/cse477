<?php

namespace Nurikabe;

use Nurikabe\Nurikabe as Nurikabe;

class View{
    private $page;
    private $nurikabe;
    private $headAdditional = '';

    public function __construct(Nurikabe $Nurikabe){
        $this->nurikabe = $Nurikabe;
    }

    public function getNurikabe(){
        return $this->nurikabe;
    }

    public function setPage($page){
        $this->page = $page;
    }

    public function getPage(){
        return $this->page;
    }

    public function getHeadAdditional(){
        return $this->headAdditional;
    }
    public function setHeadAdditional($h){
        $this->headAdditional = $h;
    }

    public function presentHeader($page){
        $html = <<<HTML
<header>
    <p><img src="images/nifty800.png" height="140" width="800" alt="Nifty Nurikabe"></p>
    <p id="links">
HTML;
        if($page == "index") {
            $html.="<a href=\"instructions.php\">INSTRUCTIONS</a>";
        }
        else if($page == "game" || $page == "solved"){
            $html.="<a href=\"./\">NEW GAME</a>&nbsp;<a href=\"instructions.php\" target='_blank'>INSTRUCTIONS</a>";
        }
        else if($page == "instr"){
            $html.="<a href=\"./\">NEW GAME</a>";
        }

        $html .= "</p>";
        if($page == "game"){
            $html .= "<h1>Greetings, ". $this->getNurikabe()->getPname() .", and welcome to Nifty Nurikabe!</h1>";
        }
        else if($page == "solved"){
            $html .= "<h1>Congratulations, ". $this->getNurikabe()->getPname() .", you solved Nifty Nurikabe!</h1>";
        }
        else if( $page == "instr" ){
            $html .= "<h1>Nifty Nurikabe Instructions</h1>";
        }
        else{
            $html .= "<h1>Welcome to Daniel Agbay's Nifty Nurikabe!</h1>";
        }
        $html .="</header>";
        return $html;
    }

    public function presentFooter(){
        $html = <<<HTML
<footer>
    <p><img src="images/nifty1-800.png" height="140" width="800" alt="Nifty Nurikabe1"></p>
</footer>
HTML;
        return $html;
    }

    public function presentBody(){}

    public function presentHead(){
        $html = <<<HTML
<meta charset="UTF-8">
<title>Nifty Nurikabe</title>
<link href="lib/CSS/styles.css" rel="stylesheet" type="text/css">
<script src="node_modules/jquery/dist/jquery.min.js"></script>
<script src="site.con.js"></script>
HTML;
        $html .= $this->getHeadAdditional();
        return $html;
    }

    public function present(){
        return $this->presentHeader($this->page).
            $this->presentBody().
            $this->presentFooter();
    }
}