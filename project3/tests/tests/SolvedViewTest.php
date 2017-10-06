<?php

/** @file
 * Empty unit testing template
 * @cond 
 * Unit tests for the class
 */
require __DIR__ . "/../../vendor/autoload.php";

use Nurikabe\SolvedView as SolvedView;
use Nurikabe\Nurikabe as Nurikabe;


class SolvedViewTest extends \PHPUnit_Framework_TestCase
{
	public function testConstruct() {
        $game = new Nurikabe();
        $view = new SolvedView($game);
        $this->assertInstanceOf('Nurikabe\SolvedView',$view);
    }
}

/// @endcond
