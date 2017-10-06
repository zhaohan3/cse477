<?php

namespace Felis;


class PasswordValidateController extends Controller {
    /**
     * PasswordValidateController constructor.
     * @param Site $site The Site object
     * @param array $post $_POST
     */
    public function __construct(Site $site, array $post) {
        parent::__construct($site, $post);
        $root = $site->getRoot();
        $this->setRedirect( "$root/");
        if(isset($post['cancelChangePassword'])){
            return;
        }

        //
        // 1. Ensure the validator is correct! Use it to get the user ID.
        //
        $validators = new Validators($site);
        $validator = strip_tags($post['validator']);
        $userid = $validators->get($validator);
        if($userid === null) {
            $this->setRedirect("$root/password-validate.php?v=$validator&e=1");
            return;
        }

        //
        // 2. Ensure the email matches the user.
        //
        $users = new Users($site);
        $editUser = $users->get($userid);
        if($editUser === null) {
            // User does not exist!
            $this->setRedirect("$root/password-validate.php?v=$validator&e=2");
            return;
        }
        $email = trim(strip_tags($post['email']));
        if($email !== $editUser->getEmail()) {
            // Email entered is invalid
            $this->setRedirect("$root/password-validate.php?v=$validator&e=3");
            return;
        }

        //
        // 3. Ensure the passwords match each other
        //
        $password1 = trim(strip_tags($post['password']));
        $password2 = trim(strip_tags($post['password2']));
        if($password1 !== $password2) {
            // Passwords do not match
            $this->setRedirect("$root/password-validate.php?v=$validator&e=4");
            return;
        }

        if(strlen($password1) < 8) {
            // Password too short
            $this->setRedirect("$root/password-validate.php?v=$validator&e=5");
            return;
        }

        //
        // 4. Create a salted password and save it for the user.
        //
        $users->setPassword($userid, $password1);

        //
        // 5. Destroy the validator record so it can't be used again!
        //
        $validators->remove($userid);

    }
}