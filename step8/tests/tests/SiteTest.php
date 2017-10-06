<?php

/** @file
 * Empty unit testing template
 * @cond 
 * Unit tests for the class
 */
require __DIR__ . "/../../vendor/autoload.php";

class SiteTest extends \PHPUnit_Framework_TestCase
{
    public function testGettersSetters() {
        $site = new \Felis\Site();
        $site->setEmail("test@test.com");
        $this->assertEquals("test@test.com", $site->getEmail());
        $site->setRoot("/root");
        $this->assertEquals("/root", $site->getRoot());
        $site->dbConfigure("host", "user", "pass","pre");
        $this->assertEquals("pre", $site->getTablePrefix());
    }

    public function test_localize() {
        $site = new Felis\Site();
        $localize = require 'localize.inc.php';
        if(is_callable($localize)) {
            $localize($site);
        }
        $this->assertEquals('test8_', $site->getTablePrefix());
    }
}

/// @endcond
