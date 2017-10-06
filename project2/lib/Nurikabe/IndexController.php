<?php

namespace Nurikabe;

class IndexController extends Controller{
    public function __construct(Nurikabe $Nurikabe, $post, Site $site){
        parent::__construct($Nurikabe, $post, $site);
    }
    // function checks name, if not set it redirects back to index and displays error message
    public function checkName(){
        if(empty(strip_tags($this->getPost()["nameIn"]))){
            $this->getGame()->setNameSet(false);
            $this->setRedirect($this->getSite()->getRoot() . "/index.php");
            return false;
        }
        else{
            $this->getGame()->setNameSet(true);
            return true;
        }
    }
    public function setupGame(){
        $post = $this->getPost();
        // store post variables in nurikabe object
        $this->getGame()->setPname(strip_tags($post["nameIn"]));
        $this->getGame()->setMode($post["difficulty"]);
        $this->getGame()->setGameBoard();
        $this->setRedirect($this->getSite()->getRoot() . "/game.php");
    }

    public function takeAction(){
        if($this->checkName()){
            $this->setupGame();
        }
    }
}