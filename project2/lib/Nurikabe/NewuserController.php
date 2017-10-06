<?php

namespace Nurikabe;


class NewuserController extends Controller {
    public function __construct(\Nurikabe\Nurikabe $Nurikabe, $post, Site $site){
        parent::__construct($Nurikabe, $post, $site);
        //$this->setRedirect("newuser.php");
        $root = $site->getRoot();
        $this->setRedirect( "$root/");
        if(isset($post['createAccountCancel'])){
            return;
        }
        if(isset($post['goHome'])){
            return;
        }

        //
        // 1. Check for valid inputs
        //
        $name = trim(strip_tags($post['newUserName']));
        if($name == null || $name == ""){
            $this->setRedirect("$root/newuser.php?e=1");
            return;
        }
        $email = trim(strip_tags($post['newUserEmail']));
        if($email == null || $email == ""){
            $this->setRedirect("$root/newuser.php?e=2");
            return;
        }

        //
        // 2. Check if email exists
        //
        $users = new Users($site);
        if($users->exists($email)){
           $this->setRedirect("$root/newuser.php?e=3");
           return;
        }

        //
        //  3. If all good, send the email the validation link
        //
        $row = array('id' => '',
            'email' => $email,
            'name' =>$name,
            'joined' => '',
        );
        $newUser = new User($row);
        $mailer = new Email();
        $users->add($newUser, $mailer);
        $this->setRedirect("$root/newuser.php?v=1");
    }
}