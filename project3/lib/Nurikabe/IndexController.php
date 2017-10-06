<?php

namespace Nurikabe;

class IndexController extends Controller{
    public function __construct(Nurikabe $Nurikabe, $post){
        parent::__construct($Nurikabe, $post);
    }
    // function checks name, if not set it redirects back to index and displays error message
    public function checkName(){
        if(empty($this->getPost()["nameIn"])){
            $this->getGame()->setNameSet(false);
            $this->setRedirect("index.php");
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
        $this->getGame()->setPname($post["nameIn"]);
        $this->getGame()->setMode($post["difficulty"]);
        $this->getGame()->setGameBoard();
        $this->setRedirect("game.php");
    }

    public function takeAction(){
        if($this->checkName()){
            $this->setupGame();
        }
    }
}