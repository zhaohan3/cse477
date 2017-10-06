<?php

namespace Nurikabe;


class PasswordValidateController extends Controller{
    public function __construct(\Nurikabe\Nurikabe $Nurikabe, $post, Site $site){
        parent::__construct($Nurikabe, $post, $site);
        $root = $site->getRoot();
        $this->setRedirect( "$root/");
        if(isset($post['createAccountCancel'])){
            return;
        }

        //
        // 1. Check for valid email, must match user
        //
        $validators = new Validators($site);
        $validator = strip_tags($post['validator']);
        $email = trim(strip_tags($post['newUserEmail']));
        if($email === null || $email === ""){
            $this->setRedirect("$root/password-validate.php?v=$validator&e=1");
            return;
        }
        if($validators->get($validator) != $email){
            $this->setRedirect("$root/password-validate.php?v=$validator&e=2");
            return;
        }

        //
        // 2. Check passwords match and length
        //
        $password1 = strip_tags($post['password1']);
        $password2 = strip_tags($post['password2']);
        if($password1 != $password2){
            $this->setRedirect("$root/password-validate.php?v=$validator&e=3");
            return;
        }
        if(strlen($password1) < 8){
            $this->setRedirect("$root/password-validate.php?v=$validator&e=4");
            return;
        }

        //
        // 3. If all good, add the user!
        //
        $name = $validators->getName($validator);
        $row = array('id'=>'',
            'email' => $email,
            'name' => $name,
            'joined'=>''
        );
        $newUser = new User($row);
        $users = new Users($site);
        $users->addValidated($newUser, $password1);
        $validators->remove($email);
    }
}