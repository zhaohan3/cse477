<?php

/** @file
 * Empty unit testing template
 * @cond 
 * Unit tests for the class
 */
require __DIR__ . "/../../vendor/autoload.php";

use Nurikabe\IndexView as IndexView;
use Nurikabe\Nurikabe as Nurikabe;
use Nurikabe\User as User;

class IndexViewTest extends \PHPUnit_Framework_TestCase
{
	public function testConstruct() {
        $row = array('id' => 0,
            'email' => 'dude@ranch.com',
            'name' => 'Dude, The',
            'joined' => '2015-01-15 23:50:26',
        );
        $user = new User($row);
        $game = new Nurikabe();
        $view = new IndexView($game, $user);
        $this->assertInstanceOf('Nurikabe\IndexView', $view);
	}
}

/// @endcond
