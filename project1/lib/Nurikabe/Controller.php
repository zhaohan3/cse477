<?php

namespace Nurikabe;
use Nurikabe\Nurikabe as Nurikabe;

class Controller{
    private $redirect;
    private $game;
    private $post;
    private $reset = false;

    public function __construct(Nurikabe $Nurikabe, $post){
        $this->game = $Nurikabe;
        $this->post = $post;
    }

    public function getRedirect(){
        return $this->redirect;
    }

    protected function setRedirect($target){
        $this->redirect = $target;
    }

    public function getGame(){
        return $this->game;
    }
    public function getPost(){
        return $this->post;
    }
    public function setReset($bool){
        $this->reset = $bool;
    }
    public function isReset(){
        return $this->reset;
    }
    //virtual function that depends on each derived class, will dictate the action of a controller
    public function takeAction(){}
}