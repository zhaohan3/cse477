<?php

namespace Nurikabe;
use Nurikabe\Nurikabe as Nurikabe;

class Controller{
    private $redirect;
    private $game;
    private $post;
    private $site;
    private $reset = false;

    public function __construct(Nurikabe $Nurikabe, $post, Site $site){
        $this->game = $Nurikabe;
        $this->post = $post;
        $this->site = $site;
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

    /**
     * @return Site
     */
    public function getSite()
    {
        return $this->site;
    }

    /**
     * @param Site $site
     */
    public function setSite($site)
    {
        $this->site = $site;
    }


    //virtual function that depends on each derived class, will dictate the action of a controller
    public function takeAction(){}
}