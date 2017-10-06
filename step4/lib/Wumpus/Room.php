<?php
/**
 * Created by PhpStorm.
 * User: agbaydan
 * Date: 5/29/2017
 * Time: 11:50 PM
 */

namespace Wumpus;


class Room
{
    private $ndx;       // The room index in the Wumpus game
    private $num;       // The assigned room number
    private $contents = array(); // contents of a room
    private $neighbors = array(); // neighbors of the room

    /**
     * Constructor
     *
     * Every room has an index into the array in the Wumpus class.
     * These are values starting at 1. They also have an assigned
     * room number, which is what the user sees.
     *
     * @param $ndx Index into the array of rooms
     * @param $num The assigned room number
     */
    public function __construct($ndx, $num) {
        $this->ndx = $ndx;
        $this->num = $num;
    }

    /**
     * Get the index into the wumpus cave array of rooms
     * @return Index value starting at 1
     */
    public function getNdx() {
        return $this->ndx;
    }

    /**
     * The assigned room number
     * @return Room number
     */
    public function getNum() {
        return $this->num;
    }
    /** Add a neighboring room
     * @param $room The neighboring room to add */
    public function addNeighbor(Room $room) {
        $this->neighbors[] = $room;
    }


    /**
     * Get a room's neighbors
     * @return Array of room neighbors
     */
    public function getNeighbors() {
        return $this->neighbors;
    }

    /**
     * Add content to this room
     * @param $c Content (integer constant)
     */
    public function addContent($c) {
        $this->contents[] = $c;
    }

    /**
     * Is this room empty (no contents)?
     * @return true if empty
     */
    public function isEmpty() {
        return empty($this->contents);
    }

    /**
     * Test to see if a room contains an item
     * @param $item Item we are testing (integer constant)
     * @param $recurse How many levels away we test
     * @returns true if room or neighbors contain the item
     */
    public function contains($item, $recurse=0) {
        if(in_array($item, $this->contents)){
            return true;
        }
        if($recurse == 1){
            foreach($this->neighbors as $neighbor){
                if($neighbor->contains($item)){
                    return true;
                }
            }
        }
        if($recurse == 2){
            foreach ($this->neighbors as $neighbor1){
                if($neighbor1->contains($item,1)){
                    return true;
                }
//                foreach($neighbor1->neighbors as $neighbor2){
//                    if($neighbor2->contains($item)){
//                        return true;
//                    }
//                }
            }
        }
        return false;
    }
}