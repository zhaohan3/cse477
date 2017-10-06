<?php
require __DIR__ . "/../../vendor/autoload.php";

/** @file
 * Unit tests for the class CasesController
 * @cond
 */
class CasesControllerTest extends \PHPUnit_Framework_TestCase
{
    public function test_add() {
        $site = new Felis\Site();
        $localize  = require 'localize.inc.php';
        if(is_callable($localize)) {
            $localize($site);
        }

        $post = array('add' => "Add");
        $controller = new Felis\CasesController($site, $post);
        $this->assertInstanceOf('Felis\CasesController', $controller);
        $this->assertContains("step8/newcase.php", $controller->getRedirect());
    }
}

/// @endcond