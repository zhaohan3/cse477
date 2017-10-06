<?php

namespace Felis;


class PasswordValidateView extends View{
    // validation error messages
    const INVALID_VALIDATOR = "Invalid or unavailable validator.";           // 1
    const EMAIL_USER_DNE = "Email address is not for a valid user.";         // 2
    const EMAIL_VALIDATOR_DNE = "Email address does not match validator.";   // 3
    const PASSWORDS_NOT_EQUAL = "Passwords did not match.";                 // 4
    const PASSWORDS_SHORT = "Password too short.";                           // 5

    private $get;
    private $site;
    private $validator;
    private $error='';
    public function __construct($site, $get){
        $this->setTitle("Felis Password Entry");
        $this->site = $site;
        $this->get = $get;
        $this->validator = strip_tags($get['v']);

        // set error messages
        if(isset($get['e'])){
            if($get['e'] == 1){
                $this->error = self::INVALID_VALIDATOR;
            } else if($get['e'] == 2){
                $this->error = self::EMAIL_USER_DNE;
            } else if($get['e'] == 3){
                $this->error = self::EMAIL_VALIDATOR_DNE;
            } else if($get['e'] == 4){
                $this->error = self::PASSWORDS_NOT_EQUAL;
            } else if($get['e'] == 5){
                $this->error = self::PASSWORDS_SHORT;
            }
        }
    }

    public function present(){
        $html = <<<HTML
<form action="post/password-validate.php" method="post">
<fieldset>
    <legend>Change Password</legend>    
    
    <input type="hidden" name="validator" value="$this->validator">

    
    <p><label for="email">Email</label><br>
    <input type="email" name="email" id="email" placeholder="Email"></p>
    
    <p><label for="password">Password:</label><br>
    <input type="password" name="password" id="password" placeholder="password"></p>
    
    <p><label for="password2">Password (again):</label><br>
    <input type="password" name="password2" id="password2" placeholder="password"></p>
HTML;

    if(isset($this->get['e'])){
        $html .= '<p class="msg">' . $this->error . '</p>';
    }

    $html .= <<<HTML
    <p>
    <button name="changePassword" value="ok">OK</button>
    <button name="cancelChangePassword" value="cancel">Cancel</button>
    </p>
</fieldset>

</form>
HTML;
        return $html;
    }
}