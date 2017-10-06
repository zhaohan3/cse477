<?php
require __DIR__ . "/../../vendor/autoload.php";

/** @file
 * Empty unit testing template
 * @cond 
 * Unit tests for the class Room
 */
class RoomTest extends \PHPUnit_Framework_TestCase
{
    public function test_construct(){
        $room = new Wumpus\Room(0,1);
        $this->assertInstanceOf('Wumpus\Room', $room);
    }

    public function test_getNum() {
        $room = new Wumpus\Room(55, 23);
        $this->assertEquals(23, $room->getNum());
    }

    public function test_getNdx() {
        $room = new Wumpus\Room(55, 23);
        $this->assertEquals(55, $room->getNdx());
    }
    public function test_addNeighbor() {
        $room = new Wumpus\Room(0, 23);
        $room0 = new Wumpus\Room(1, 7);
        $room1 = new Wumpus\Room(2, 3);
        $room2 = new Wumpus\Room(3, 9);

        $room->addNeighbor($room0);
        $room->addNeighbor($room1);
        $room->addNeighbor($room2);

        $neighbors = $room->getNeighbors();
        $this->assertEquals($room0, $neighbors[0]);
        $this->assertEquals($room1, $neighbors[1]);
        $this->assertEquals($room2, $neighbors[2]);
    }

    public function test_content() {
        $room = new Wumpus\Room(0, 23);

        // Ensure does not contain anything, yet
        $this->assertTrue($room->isEmpty());
        $this->assertFalse($room->contains(1));

        $room->addContent(2);
        $this->assertFalse($room->contains(1));
        $this->assertTrue($room->contains(2));

        // Test one room away
        $room0 = new Wumpus\Room(1, 7);
        $room->addNeighbor($room0);
        $room0->addContent(3);
        $this->assertFalse($room->contains(3));
        $this->assertTrue($room->contains(3, 1));

        // Test one room away, but where the item
        // is in the second room in the list.
        $room2 = new Wumpus\Room(3, 19);
        $room->addNeighbor($room2);
        $room2->addContent(5);
        $this->assertFalse($room->contains(5));
        $this->assertTrue($room->contains(5, 1));

        // Test two rooms away
        $room1 = new Wumpus\Room(2, 8);
        $room0->addNeighbor($room1);
        $room1->addContent(4);
        $this->assertFalse($room->contains(4));
        $this->assertFalse($room->contains(4, 1));
        $this->assertTrue($room->contains(4, 2));
    }
}

/// @endcond
