<?php

namespace Guessing;


class Guessing{
    const MIN = 1;
    const MAX = 100;
    const INVALID = -1; // invalid guess, return -1
    const TOOLOW = -2;
    const TOOHIGH = -3;
    const CORRECT = -4;
    const VACANT = -5;

    private $number;
    private $numGuesses = 0;
    private $guess = self::VACANT;

    public function __construct($seed = null) {
        if($seed === null) {
            $seed = time();
        }

        srand($seed);
        $this->number = rand(self::MIN, self::MAX);

    }


    public function getNumber(){
        return $this->number;
    }
    public function getNumGuesses(){
        return $this->numGuesses;
    }
    public function getGuess(){
        return $this->guess;
    }
    public function guess($num){
        $this->guess = $num;
    }

    public function check(){
        if(($this->guess<self::MIN || $this->guess>self::MAX || !is_numeric($this->guess)) && $this->guess!=self::VACANT) {
            return self::INVALID;
        }
        else if($this->guess == self::VACANT){
            return self::VACANT;
        }
        else{
            $this->numGuesses++;
            if($this->guess < $this->number){
                return self::TOOLOW;
            }
            else if($this->guess > $this->number){
                return self::TOOHIGH;
            }
            else if($this->guess == $this->number){
                return self::CORRECT;
            }
        }
    }


}