<?php

/** @file
 * Empty unit testing template
 * @cond 
 * Unit tests for the class
 */
require __DIR__ . "/../../vendor/autoload.php";

use Nurikabe\InstrView as InstrView;
use Nurikabe\Nurikabe as Nurikabe;
use Nurikabe\User as User;


class InstrViewTest extends \PHPUnit_Framework_TestCase
{
	public function testConstruct() {
        $row = array('id' => 0,
            'email' => 'dude@ranch.com',
            'name' => 'Dude, The',
            'joined' => '2015-01-15 23:50:26',
        );
        $user = new User($row);
        $game = new Nurikabe();
        $view = new InstrView($game);
		$this->assertInstanceOf('Nurikabe\InstrView',$view);
		//$view->setPage("instr");
		$this->assertEquals("instr", $view->getPage());
		$this->assertNotContains("INSTRUCTIONS", $view->presentHeader($view->getPage()));
	}
}

/// @endcond
