<?php

namespace Nurikabe;


class Nurikabe{
    // player board
    private $game = [];
    private $pname;
    private $mode;
    private $nameSet = true;
    private $isRed = false;
    private $solveConfirm = false;
    private $clearConfirm = false;
    CONST SEA = 'sea';
    CONST ISLAND = 'island';
    CONST VACANT = 'vacant';
    CONST RED = 'red';
    CONST RED_ISLAND = 'red_island';

    // solution boards
    private static $solutions = [
        'ultraEasy' => ['desc'=>'3x3 Ultra Easy',
            'game'=>[
                [1, self::SEA, 1],
                [self::SEA, self::SEA, self::SEA],
                [2, self::ISLAND, self::SEA]
            ]
        ],
        'veryEasy' => ['desc'=>'8x8 Very Easy',
            'game'=>[
                [self::SEA, self::SEA, 2, self::ISLAND, self::SEA, self::SEA, self::SEA, self::SEA],
                [self::SEA,  1, self::SEA, self::SEA, self::SEA, 4, self::ISLAND, self::SEA],
                [self::SEA, self::SEA, self::SEA, self::ISLAND, 2, self::SEA, self::ISLAND, self::SEA],
                [self::SEA, 2, self::ISLAND, self::SEA, self::SEA, self::SEA, self::ISLAND, self::SEA],
                [4, self::SEA, self::SEA, self::SEA, self::ISLAND, 2, self::SEA, self::SEA],
                [self::ISLAND, self::SEA, self::ISLAND, self::SEA, self::SEA, self::SEA, self::SEA, self::ISLAND],
                [self::ISLAND, self::SEA, self::ISLAND, 3, self::SEA, self::ISLAND, self::SEA, 3],
                [self::ISLAND, self::SEA, self::SEA, self::SEA, self::ISLAND, 3, self::SEA, self::ISLAND]
            ]
        ],
        'easy' => [ 'desc'=>'10x10 Easy',
            'game'=>[
                [4, self::ISLAND, self::ISLAND, self::ISLAND, self::SEA, self::SEA, self::SEA, self::SEA, self::SEA, 1],
                [self::SEA, self::SEA, self::SEA, self::SEA, self::SEA, self::ISLAND, self::ISLAND, self::SEA, self::ISLAND, self::SEA],
                [self::SEA, self::ISLAND, self::SEA, self::ISLAND, self::ISLAND,self::SEA,3,self::SEA,3,self::SEA],
                [self::SEA, 2, self::SEA, 3, self::SEA, self::SEA, self::SEA, self::SEA, self::ISLAND, self::SEA],
                [1, self::SEA, self::SEA, self::SEA, 4, self::ISLAND, self::SEA, 3, self::SEA, self::SEA],
                [self::SEA, self::SEA, 2, self::ISLAND, self::SEA, self::ISLAND, self::SEA, self::ISLAND, self::SEA, 5],
                [self::SEA,self::ISLAND,self::SEA, self::SEA, self::SEA, self::ISLAND, self::SEA, self::ISLAND, self::SEA,self::ISLAND],
                [self::SEA,self::ISLAND,self::SEA, 1, self::SEA, self::SEA, self::SEA, self::SEA,self::SEA,self::ISLAND],
                [self::SEA,self::ISLAND,4, self::SEA, self::SEA, 3, self::ISLAND,self::ISLAND, self::SEA,self::ISLAND],
                [self::SEA,self::SEA,self::SEA, self::ISLAND, 2, self::SEA, self::SEA, self::SEA, self::SEA, self::ISLAND]
            ]
        ],
        'medium' => ['desc'=>'8x8 Medium',
            'game'=>[
                [self::ISLAND, self::SEA, self::SEA, self::SEA, self::SEA, self::SEA, self::SEA, self::SEA],
                [2, self::SEA, self::ISLAND, self::ISLAND, self::SEA, self::ISLAND, self::ISLAND, self::ISLAND],
                [self::SEA, 4, self::ISLAND, self::SEA, self::SEA, self::SEA, self::SEA, self::ISLAND],
                [self::SEA, self::SEA, self::SEA, self::SEA, 2, self::ISLAND, self::SEA, 6],
                [self::SEA, self::ISLAND, self::SEA, 2, self::SEA, self::SEA, self::SEA, self::ISLAND],
                [self::SEA, 2, self::SEA, self::ISLAND, self::SEA, self::ISLAND, self::SEA, self::SEA],
                [5, self::SEA, self::SEA, self::SEA, 4, self::ISLAND, self::ISLAND, self::SEA],
                [self::ISLAND, self::ISLAND, self::ISLAND, self::ISLAND, self::SEA, self::SEA, self::SEA, self::SEA]
            ]
        ]
    ];

    public function __construct(){
    }
    // get general solutions array
    public function getSolutions(){
        return Nurikabe::$solutions;
    }
    // get current game solution
    public function getSolution(){
        return Nurikabe::$solutions[$this->mode]['game'];
    }
    public function getPname(){
        return $this->pname;
    }
    public function setPname($name){
        $this->pname = $name;
    }
    public function getMode(){
        return $this->mode;
    }
    public function setMode($mode){
        $this->mode = $mode;
    }
    public function getGame(){
        return $this->game;
    }
    public function setGame($game){
        $this->game = $game;
    }
    public function resetGame(){
        $this->game = [];
    }
    public function gameEmpty(){
        if(sizeof($this->game) == 0){
            return true;
        }
        else{
            return false;
        }
    }
    public function setCell($r, $c){
        $cell = $this->game[$r][$c];
        if($cell == self::VACANT){
            $cell = self::SEA;
        }
        else if($cell == self::SEA || $cell == self::RED){
            $cell = self::ISLAND;
        }
        else if($cell == self::ISLAND || $cell == self::RED_ISLAND){
            $cell = self::VACANT;
        }
        $this->game[$r][$c] = $cell;
        $this->clearRed();
    }
    public function setCellVal($r, $c, $val){
        $this->game[$r][$c] = $val;
    }
    public function clearRed(){
        if($this->isRed){
            for($r=0; $r<sizeof($this->game); $r++){
                for($c=0; $c<sizeof($this->game[$r]); $c++){
                    if( $this->game[$r][$c] == self::RED ){
                        $this->game[$r][$c] = self::SEA;
                    }
                    else if($this->game[$r][$c] == self::RED_ISLAND){
                        $this->game[$r][$c] = self::ISLAND;
                    }
                }
            }
        }
    }
    // set up the game board based on difficulty (mode)
    public function setGameBoard(){
        $this->game = Nurikabe::$solutions[$this->mode]['game'];
        for($r=0; $r<sizeof($this->game); $r++){
            for($c=0; $c<sizeof($this->game[$r]); $c++){
                if( $this->game[$r][$c] == self::SEA || $this->game[$r][$c] == self::ISLAND ){
                    $this->game[$r][$c] = self::VACANT;
                }
            }
        }
        $this->setGameBoardCalled = true;
    }

    public function getNameSet(){
        return $this->nameSet;
    }
    public function setNameSet($bool){
        $this->nameSet = $bool;
    }
    public function getIsRed(){
        return $this->isRed;
    }
    public function setIsRed($bool){
        $this->isRed = $bool;
    }
    public function getSolveConfirm(){
        return $this->solveConfirm;
    }
    public function setSolveConfirm($bool){
        $this->solveConfirm = $bool;
    }
    public function getClearConfirm(){
        return $this->clearConfirm;
    }
    public function setClearConfirm($bool){
        $this->clearConfirm = $bool;
    }
}