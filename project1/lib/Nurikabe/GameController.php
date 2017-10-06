<?php

namespace Nurikabe;

class GameController extends Controller{
    public function __construct(Nurikabe $Nurikabe, $post){
        parent::__construct($Nurikabe, $post);
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
                    $this->setRedirect("game.php");
                    return;
                }
            }
        }
        $this->setRedirect("solved.php");
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
        $this->setRedirect("game.php");
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
        $this->setRedirect("game.php");
    }

    public function solveGame(){
        $this->setRedirect("solved.php");
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
            $this->setRedirect("game.php");
        }
        $this->getGame()->setSolveConfirm(false);
        $this->getGame()->setClearConfirm(false);
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
            $this->setRedirect("game.php");
        }
        else if(isset($post['clear'])){
            $this->getGame()->setClearConfirm(true);
            $this->setRedirect("game.php");
        }
        else if( isset($post['Yes']) || isset($post['No']) ){
            $this->handleSolveClear();
        }
    }
}