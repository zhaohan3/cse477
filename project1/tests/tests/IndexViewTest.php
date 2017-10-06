<?php

/** @file
 * Empty unit testing template
 * @cond 
 * Unit tests for the class
 */
require __DIR__ . "/../../vendor/autoload.php";

use Nurikabe\IndexView as IndexView;
use Nurikabe\Nurikabe as Nurikabe;

class IndexViewTest extends \PHPUnit_Framework_TestCase
{
	public function testConstruct() {
        $game = new Nurikabe();
        $view = new IndexView($game);
        $this->assertInstanceOf('Nurikabe\IndexView', $view);
	}
}

/// @endcond
