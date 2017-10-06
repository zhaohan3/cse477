<?php

namespace Nurikabe;

class GameController extends Controller{
    private $user;

    public function __construct(Nurikabe $Nurikabe, $post, Site $site, $user){
        parent::__construct($Nurikabe, $post, $site);
        $this->user = $user;
    }

    public function getUser(){
        return $this->user;
    }

    public function updateCell(){
        $post = $this->getPost();
        $split = explode(',', strip_tags($post['cell']));
        $r = intval($split[0]);
        $c = intval($split[1]);
        $this->getGame()->setCell($r, $c);
    }
    public function isSolved(){
        $solution = $this->getGame()->getSolution();
        $game = $this->getGame()->getGame();

        for($r=0; $r<sizeof($game); $r++){
            for($c=0; $c<sizeof($game[$r]); $c++){
                $gameCell = $game[$r][$c];
                $solutionCell = $solution[$r][$c];
                if($gameCell != $solutionCell){
                    $this->setRedirect($this->getSite()->getRoot() . "/game.php");
                    return;
                }
            }
        }
        $this->setRedirect($this->getSite()->getRoot() . "/solved.php");
        $this->setReset(true);
    }

    public function checkSolution(){
        $solution = $this->getGame()->getSolution();
        $game = $this->getGame()->getGame();
        for($r=0; $r<sizeof($game); $r++){
            for($c=0; $c<sizeof($game[$r]); $c++){
                $gameCell = $game[$r][$c];
                $solutionCell = $solution[$r][$c];
                if($gameCell == Nurikabe::SEA && $gameCell != $solutionCell){
                    $this->getGame()->setCellVal($r, $c, Nurikabe::RED);
                    $this->getGame()->setIsRed(true);
                }
                else if($gameCell == Nurikabe::ISLAND && $gameCell != $solutionCell){
                    $this->getGame()->setCellVal($r, $c, Nurikabe::RED_ISLAND);
                    $this->getGame()->setIsRed(true);
                }
            }
        }
        $this->setRedirect($this->getSite()->getRoot() . "/game.php");
    }

    public function clearGame(){
        $game = $this->getGame()->getGame();
        for($r=0; $r<sizeof($game); $r++){
            for($c=0; $c<sizeof($game[$r]); $c++){
                $gameCell = $game[$r][$c];
                if(!is_int($gameCell)){
                    $this->getGame()->setCellVal($r, $c, Nurikabe::VACANT);
                }
            }
        }
        $this->setRedirect($this->getSite()->getRoot() . "/game.php");
    }

    public function solveGame(){
        $this->setRedirect($this->getSite()->getRoot() . "/solved.php");
        // set game array equal to solution array so in instructions we can check if solved
        $this->getGame()->setGame($this->getGame()->getSolution());
    }

    public function handleSolveClear(){
        $post = $this->getPost();
        if(isset($post['Yes'])){
            $value = $post['Yes'];
            if($value == "solveYes"){
                $this->solveGame();
            }
            else if($value == "clearYes"){
                $this->clearGame();
            }
        }
        else if(isset($post['No'])){
            $this->setRedirect($this->getSite()->getRoot() . "/game.php");
        }
        $this->getGame()->setSolveConfirm(false);
        $this->getGame()->setClearConfirm(false);
    }


    public function saveGame(){
        $nurikabes = new Nurikabes($this->getSite());
        //
        // 1. Get the id from nurikabe table
        //      If one exists, get it. Else, add a new one
        //
        $Nurikabeid=null;
        if($nurikabes->exists($this->getGame()->getMode(), $this->user->getId()) ){
            $Nurikabeid = $nurikabes->get($this->getGame()->getMode(), $this->user->getId())->getId();
        }
        else{
            $nurikabes->add($this->getGame()->getMode(), $this->user->getId());
            $Nurikabeid = $nurikabes->get($this->getGame()->getMode(), $this->user->getId())->getId();
        }

        //
        // 2. Insert current game board into cell table
        //
        $cells = new Cells($this->getSite());
        $this->getGame()->clearRed();
        $game = $this->getGame()->getGame();
        for($r=0; $r<sizeof($game); $r++){
            for($c=0; $c<sizeof($game[$r]); $c++){
                $gameCell = $game[$r][$c];

                $cells->save($r, $c, $gameCell, $Nurikabeid);
            }
        }
        $this->setRedirect($this->getSite()->getRoot() . "/game.php");
    }

    public function loadGame(){
        $nurikabes = new Nurikabes($this->getSite());
        //
        // 1. Get the id from nurikabe table
        //      If one exists, get it. Else, no game has been saved for this user, cancel load
        //
        $Nurikabeid=null;
        if($nurikabes->exists($this->getGame()->getMode(), $this->user->getId()) ){
            $Nurikabeid = $nurikabes->get($this->getGame()->getMode(), $this->user->getId())->getId();
        }
        else{
            $this->clearGame();
            return;
        }

        //
        // 2. Load saved game board into current game board
        //
        $cells = new Cells($this->getSite());
        $game = $this->getGame()->getGame();
        for($r=0; $r<sizeof($game); $r++){
            for($c=0; $c<sizeof($game[$r]); $c++){
                $val = $cells->get($r, $c, $Nurikabeid)->getCVal();
                $this->getGame()->setCellVal($r, $c, $val);
            }
        }
        $this->setRedirect($this->getSite()->getRoot() . "/game.php");
    }


    public function takeAction(){
        $post = $this->getPost();
        if(isset($post['cell'])) {
            // update the cell that was clicked
            $this->updateCell();
            $this->isSolved();
        }
        else if(isset($post['checkSolution'])){
            $this->checkSolution();
        }
        else if(isset($post['solve'])){
            $this->getGame()->setSolveConfirm(true);
            $this->setRedirect($this->getSite()->getRoot() . "/game.php");
        }
        else if(isset($post['clear'])){
            $this->getGame()->setClearConfirm(true);
            $this->setRedirect($this->getSite()->getRoot() . "/game.php");
        }
        else if( isset($post['Yes']) || isset($post['No']) ){
            $this->handleSolveClear();
        }

        // save and load
        else if( isset($post['save']) ){
            $this->saveGame();
        }
        else if( isset($post['load']) ){
            $this->loadGame();
        }
    }
}