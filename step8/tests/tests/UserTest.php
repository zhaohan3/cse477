<?php

/** @file
 * Empty unit testing template
 * @cond 
 * Unit tests for the class
 */
require __DIR__ . "/../../vendor/autoload.php";

class UserTest extends \PHPUnit_Framework_TestCase
{
    public function test_construct() {
        $row = array('id' => 12,
            'email' => 'dude@ranch.com',
            'name' => 'Dude, The',
            'phone' => '123-456-7890',
            'address' => 'Some Address',
            'notes' => 'Some Notes',
            'password' => '12345678',
            'joined' => '2015-01-15 23:50:26',
            'role' => 'S'
        );
        $user = new Felis\User($row);
        $this->assertEquals(12, $user->getId());
        $this->assertEquals('dude@ranch.com', $user->getEmail());
        $this->assertEquals('123-456-7890', $user->getPhone());
        $this->assertEquals('Some Address', $user->getAddress());
        $this->assertEquals('Some Notes', $user->getNotes());
        $this->assertEquals(strtotime('2015-01-15 23:50:26'),
            $user->getJoined());
        $this->assertEquals('S', $user->getRole());
    }
}

/// @endcond
