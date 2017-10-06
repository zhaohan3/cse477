<?php

namespace Nurikabe;


class PasswordValidateView extends View{
    const EMAIL_NULL = "You must supply an email.";     // 1
    const EMAIL_MISMATCH = "Email address does not match validator.";   // 2
    const PASS_MISMATCH = "Passwords did not match.";   //3
    const PASS_SHORT = "Password too short.";           //4
    const EMAIL_DNE = "Email address is not for a valid user."; //5

    private $get;
    private $error;
    private $validator;
    public function __construct(\Nurikabe\Nurikabe $Nurikabe, $get){
        parent::__construct($Nurikabe);
        $this->setPage("pass-validate");
        $this->get = $get;
        $this->validator = strip_tags($get['v']);

        // set error message
        if(isset($get['e'])){
            if($get['e'] == 1){
                $this->error = self::EMAIL_NULL;
            }
            else if($get['e'] == 2){
                $this->error = self::EMAIL_MISMATCH;
            }
            else if($get['e'] == 3){
                $this->error = self::PASS_MISMATCH;
            }
            else if($get['e'] == 4){
                $this->error = self::PASS_SHORT;
            }
        }
    }

    public function presentBody(){
        $html = <<<HTML
<div class="page-body">
    <div class="page-body-content">
        <div class="page-body-inner-content">
            <form action="post/password-validate.php" method="post" name="newUserForm" id="newUserForm">
            
                <input type="hidden" name="validator" value="$this->validator">

                <p class="page-body-inner-content-form name">Email</p>
                <p class="page-body-inner-content-form top"><input type="email" name="newUserEmail" id="newUserEmail"></p>
                
                <p class="page-body-inner-content-form name">Password</p>
                <p class="page-body-inner-content-form top"><input type="password" name="password1" id="password1"></p>
                
                <p class="page-body-inner-content-form name">Password (Again)</p>
                <p class="page-body-inner-content-form top"><input type="password" name="password2" id="password2"></p>
                
                <p class="page-body-inner-content-form">
                <button name="createAccount" id="createAccount" value="createAccount">Create Account</button></p>
                
                <p class="page-body-inner-content-form">
                <button name="createAccountCancel" id="createAccountCancel" value="createAccountCancel">Cancel</button></p>
HTML;
        if(isset($this->get['e'])){
            $html .= '<p class="message">' . $this->error . '</p>';
        }

        $html .= <<<HTML
            </form>
        </div>
    </div>
</div>
HTML;
        return $html;
    }

}