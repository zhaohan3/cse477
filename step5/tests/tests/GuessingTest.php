<?php

/** @file
 * Empty unit testing template
 * @cond 
 * Unit tests for the class
 */

require __DIR__ . "/../../vendor/autoload.php";
use Guessing\Guessing as Guessing;


class GuessingTest extends \PHPUnit_Framework_TestCase{
    const SEED = 1234;

    public function test_construct() {
        $guessing = new Guessing(self::SEED);
        $this->assertEquals(23, $guessing->getNumber());

        // Should work with no arguments as well.
        $guessing = new Guessing();
    }


    /**
     * Test ways you can get an INVALID return value from check.
     */
    public function test_invalids() {
        $guessing = new Guessing(self::SEED);
        $this->assertEquals(0, $guessing->getNumGuesses());
        $this->assertNotEquals(Guessing::INVALID, $guessing->check());

        // Try invalid guess
        $guessing->guess(0);    // Below minimum
        $this->assertEquals(Guessing::INVALID, $guessing->check());
        $this->assertEquals(0, $guessing->getGuess());

        // Invalid guesses do not add to the count of guesses
        $this->assertEquals(0, $guessing->getNumGuesses());

        // Try invalid guess
        $guessing->guess(101);    // Above maximum
        $this->assertEquals(Guessing::INVALID, $guessing->check());
        $this->assertEquals(101, $guessing->getGuess());

        // Invalid guesses do not add to the count of guesses
        $this->assertEquals(0, $guessing->getNumGuesses());

        // Try invalid guesses - not a number
        $guessing->guess("garbage");    // Garbage
        $this->assertEquals(Guessing::INVALID, $guessing->check());
        $this->assertEquals("garbage", $guessing->getGuess());

        // Invalid guesses do not add to the count of guesses
        $this->assertEquals(0, $guessing->getNumGuesses());
    }

    /**
     * Simulates a basic game
     */
    public function test_game() {
        $guessing = new Guessing(self::SEED);

        $guessing->guess(18);
        $this->assertEquals(Guessing::TOOLOW, $guessing->check());
        $this->assertEquals(18, $guessing->getGuess());
        $this->assertEquals(1, $guessing->getNumGuesses());

        $guessing->guess(55);
        $this->assertEquals(Guessing::TOOHIGH, $guessing->check());
        $this->assertEquals(55, $guessing->getGuess());
        $this->assertEquals(2, $guessing->getNumGuesses());

        $guessing->guess(23);
        $this->assertEquals(Guessing::CORRECT, $guessing->check());
        $this->assertEquals(23, $guessing->getGuess());
        $this->assertEquals(3, $guessing->getNumGuesses());
    }

}

/// @endcond
