<?php

namespace Nurikabe;


class LoginController extends Controller {
    public function __construct(\Nurikabe\Nurikabe $Nurikabe, $post, Site $site, array &$session){
        parent::__construct($Nurikabe, $post, $site);
        $root = $site->getRoot();
        $this->setRedirect( "$root/");
        if(isset($post['loginCancel'])){
            return;
        }

        $users = new Users($site);
        $email = strip_tags($post['loginEmail']);
        $password = strip_tags($post['password']);
        $user = $users->login($email, $password);
        $session[User::SESSION_NAME] = $user;

        if($user === null) {
            // Login failed
            $this->setRedirect("$root/login.php?e=1");
            return;
        }

    }
}