<?php
/**
 * Created by PhpStorm.
 * User: agbaydan
 * Date: 6/12/2017
 * Time: 8:19 PM
 */

namespace Felis;

class StaffView extends View{
    public function __construct() {
//		<li><a href="./">Log out</a></li>
        $this->setTitle("Felis Staff");
        $this->addLink("post/logout.php", "Log Out");
    }

}