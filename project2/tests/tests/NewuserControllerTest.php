<?php

/** @file
 * Empty unit testing template
 * @cond 
 * Unit tests for the class
 */
require __DIR__ . "/../../vendor/autoload.php";

class NewuserControllerTest extends \PHPUnit_Framework_TestCase
{

    //$post = array
    //(
    //  'newUserName' =>'',
    //  'newUserEmail' =>'',
    //  'createAccount' => 'createAccount'
    //  'createAccountCancel' => 'createAccountCancel'
    //);
    private static $site;

    public static function setUpBeforeClass() {
        self::$site = new Nurikabe\Site();
        $localize  = require 'localize.inc.php';
        if(is_callable($localize)) {
            $localize(self::$site);
        }
    }

	public function test_construct(){
        $n = new Nurikabe\Nurikabe();
        $post = array
        (
            'newUserName' =>'',
            'newUserEmail' =>'',
            'createAccountCancel' => 'createAccountCancel'
        );
        $controller = new \Nurikabe\NewuserController($n, $post, self::$site);
        $this->assertInstanceOf('Nurikabe\NewuserController', $controller);
	}

	public function test_invalid_inputs(){
        $n = new Nurikabe\Nurikabe();
	    // test empty name
        $post = array
        (
            'newUserName' =>'',
            'newUserEmail' =>'',
            'createAccount' => 'createAccount'
        );
        $controller = new \Nurikabe\NewuserController($n, $post, self::$site);
        $this->assertContains('/newuser.php?e=1',$controller->getRedirect());

        // test empty email
        $post = array
        (
            'newUserName' =>'Lord Snow',
            'newUserEmail' =>'',
            'createAccount' => 'createAccount'
        );
        $controller = new \Nurikabe\NewuserController($n, $post, self::$site);
        $this->assertContains('/newuser.php?e=2',$controller->getRedirect());

    }
}

/// @endcond
