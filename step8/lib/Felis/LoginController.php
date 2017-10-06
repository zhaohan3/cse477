<?php

namespace Felis;


class LoginController extends Controller{
    /**
     * LoginController constructor.
     * @param Site $site The Site object
     * @param array $session $_SESSION
     * @param array $post $_POST
     */
    public function __construct(Site $site, array &$session, array $post) {
        parent::__construct($site, $post);
        // Create a Users object to access the table
        $users = new Users($site);

        $email = strip_tags($post['email']);
        $password = strip_tags($post['password']);
        $user = $users->login($email, $password);
        $session[User::SESSION_NAME] = $user;

        $root = $site->getRoot();
        if($user === null) {
            // Login failed
            $this->setRedirect("$root/login.php?e");
            $session['ERROR'] = "Invalid Login Credentials";
        } else {
            if($user->isStaff()) {
                $this->setRedirect("$root/staff.php");
            } else {
                $this->setRedirect("$root/client.php");
            }
        }
    }
}