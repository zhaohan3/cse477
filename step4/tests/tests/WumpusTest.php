<?php
require __DIR__ . "/../../vendor/autoload.php";

/** @file
 * Empty unit testing template
 * @cond 
 * Unit tests for the class Wumpus
 */
class WumpusTest extends \PHPUnit_Framework_TestCase
{
    const SEED = 1422668587;
    public function test_construct() {
        $wumpus = new Wumpus\Wumpus(self::SEED);
        $this->assertInstanceOf('Wumpus\Wumpus', $wumpus);

        // Ensure we have the 20 rooms
        for($r=1; $r<=Wumpus\Wumpus::NUM_ROOMS;  $r++) {
            $this->assertInstanceOf("Wumpus\Room", $wumpus->getRoom($r));
        }

        // Ensure rooms are connected correctly
        $this->connect_test($wumpus, 1, 5, 2, 6);
        $this->connect_test($wumpus, 2, 3, 8, 1);
        $this->connect_test($wumpus, 3, 10, 2, 4);
        $this->connect_test($wumpus, 4, 12, 3, 5);
        $this->connect_test($wumpus, 5, 1, 14, 4);
        $this->connect_test($wumpus, 6, 1, 15, 7);
        $this->connect_test($wumpus, 7, 6, 16, 8);
        $this->connect_test($wumpus, 8, 7, 9, 2);
        $this->connect_test($wumpus, 9, 8, 17, 10);
        $this->connect_test($wumpus, 10, 9, 11, 3);
        $this->connect_test($wumpus, 11, 10, 18, 12);
        $this->connect_test($wumpus, 12, 11, 13, 4);
        $this->connect_test($wumpus, 13, 12, 19, 14);
        $this->connect_test($wumpus, 14, 5, 15, 13);
        $this->connect_test($wumpus, 15, 14, 20, 6);
        $this->connect_test($wumpus, 16, 7, 20, 17);
        $this->connect_test($wumpus, 17, 16, 18, 9);
        $this->connect_test($wumpus, 18, 17, 19, 11);
        $this->connect_test($wumpus, 19, 13, 18, 20);
        $this->connect_test($wumpus, 20, 15, 16, 19);
    }

    private function connect_test(Wumpus\Wumpus $wumpus, $r, $n1, $n2, $n3) {
        $room = $wumpus->getRoom($r);
        $neighbors = $room->getNeighbors();
        $this->assertEquals(3, count($neighbors));
        $this->assertTrue(in_array($wumpus->getRoom($n1), $neighbors, true));
        $this->assertTrue(in_array($wumpus->getRoom($n2), $neighbors, true));
        $this->assertTrue(in_array($wumpus->getRoom($n3), $neighbors, true));
    }

    public function test_move() {
        $wumpus = new Wumpus\Wumpus(self::SEED);

        // Move to Wumpus
        $this->assertEquals(Wumpus\Wumpus::HAPPY, $wumpus->move(9));
        $this->assertEquals(Wumpus\Wumpus::HAPPY, $wumpus->move(8));
        $this->assertEquals(Wumpus\Wumpus::HAPPY, $wumpus->move(2));
        $this->assertEquals(Wumpus\Wumpus::EATEN, $wumpus->move(3));
        $this->assertFalse($wumpus->wasCarried());

        // Move to birds, will be picked up and moved to a pit in room ndx 15
        $wumpus = new Wumpus\Wumpus(self::SEED);
        $this->assertEquals(Wumpus\Wumpus::HAPPY, $wumpus->move(11));
        $this->assertEquals(Wumpus\Wumpus::HAPPY, $wumpus->move(18));
        $this->assertEquals(Wumpus\Wumpus::FELL, $wumpus->move(19));
        $this->assertTrue($wumpus->wasCarried());

        // Move to pit
        $wumpus = new Wumpus\Wumpus(self::SEED);
        $this->assertEquals(Wumpus\Wumpus::HAPPY, $wumpus->move(11));
        $this->assertEquals(Wumpus\Wumpus::HAPPY, $wumpus->move(12));
        $this->assertEquals(Wumpus\Wumpus::HAPPY, $wumpus->move(4));
        $this->assertEquals(Wumpus\Wumpus::FELL, $wumpus->move(5));
        $this->assertFalse($wumpus->wasCarried());
    }

    public function test_shoot() {
        $wumpus = new Wumpus\Wumpus(self::SEED);

        // Single shot right on the money
        $this->assertEquals(3, $wumpus->numArrows());
        $this->assertTrue($wumpus->shoot(3));

        $wumpus = new Wumpus\Wumpus(self::SEED);
        $wumpus->move(8);	// Two rooms away
        $this->assertFalse($wumpus->shoot(2));
        $this->assertEquals(2, $wumpus->numArrows());
        $this->assertTrue($wumpus->shoot(2));
        $this->assertEquals(1, $wumpus->numArrows());
    }

    public function test_smellWumpus() {
        $wumpus = new Wumpus\Wumpus(self::SEED);

        // Based on this seed, we are in room 10, wumpus is in room 3
        $this->assertTrue($wumpus->smellWumpus());

        // Move two away, should still smell the wumpus
        $wumpus->move(9);
        $this->assertTrue($wumpus->smellWumpus());

        // Move three away, no longer smell wumpus
        $wumpus->move(17);
        $this->assertFalse($wumpus->smellWumpus());
    }

    public function test_feelDraft() {
        $wumpus = new Wumpus\Wumpus(self::SEED);

        $this->assertFalse($wumpus->feelDraft());

        $wumpus->move(4);
        $this->assertTrue($wumpus->feelDraft());

        $wumpus->move(6);
        $this->assertTrue($wumpus->feelDraft());
    }

    public function test_hearBirds() {
        $wumpus = new Wumpus\Wumpus(self::SEED);

        $this->assertFalse($wumpus->hearBirds());

        $wumpus->move(18);
        $this->assertTrue($wumpus->hearBirds());
    }

    public function test_getCurrent() {
        $wumpus = new Wumpus\Wumpus(self::SEED);
        $this->assertEquals(10, $wumpus->getCurrent()->getNdx());

    }
}

/// @endcond
