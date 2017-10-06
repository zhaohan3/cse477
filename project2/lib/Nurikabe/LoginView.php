<?php

namespace Nurikabe;


class LoginView extends View{
    const LOGIN_FAIL = "Invalid Login Credentials";

    private $get;
    private $error;
    public function __construct(\Nurikabe\Nurikabe $Nurikabe, $get){
        parent::__construct($Nurikabe);
        $this->setPage("login");
        $this->get = $get;

        //set errors
        if(isset($get['e'])){
            if($get['e'] == 1){
                $this->error = self::LOGIN_FAIL;
            }
        }
    }

    public function presentBody(){
        $html = <<<HTML
<div class="page-body">
    <div class="page-body-content">
        <div class="page-body-inner-content">
            <form action="post/login.php" method="post" name="newUserForm" id="newUserForm">
                <p class="page-body-inner-content-form name">Email</p>
                <p class="page-body-inner-content-form top"><input type="email" name="loginEmail" id="loginEmail"></p>
                
                <p class="page-body-inner-content-form name">Password</p>
                <p class="page-body-inner-content-form top"><input type="password" name="password" id="password"></p>
                
                <p class="page-body-inner-content-form">
                <button name="login" id="login" value="login">Log In</button></p>
                
                <p class="page-body-inner-content-form">
                <button name="loginCancel" id="loginCancel" value="loginCancel">Cancel</button></p>
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