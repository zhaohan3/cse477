<?php

/** @file
 * Empty unit testing template
 * @cond 
 * Unit tests for the class
 */
require __DIR__ . "/../../vendor/autoload.php";

class ControllerTest extends \PHPUnit_Framework_TestCase
{
    public function test_construct(){
        $site = new Felis\Site();
        $post = array('test'=>"test post");
        $cont = new \Felis\Controller($site, $post);
        $this->assertInstanceOf("Felis\Controller", $cont);
    }
}

/// @endcond
