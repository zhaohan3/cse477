<?php
/**
 * Created by PhpStorm.
 * User: agbaydan
 * Date: 6/20/2017
 * Time: 8:32 PM
 */

namespace Nurikabe;


class NewuserView extends View{
    const NAME_ERROR = "You must supply a name.";       // 1
    const EMAIL_ERROR = "You must supply an email.";    // 2
    const EMAIL_EXISTS = "Email already exists.";       // 3

    private $get;
    private $error;

    public function __construct(\Nurikabe\Nurikabe $Nurikabe, $get){
        parent::__construct($Nurikabe);
        $this->setPage("newuser");
        $this->get = $get;

        // set error message
        if(isset($get['e'])){
            if($get['e'] == 1){
                $this->error = self::NAME_ERROR;
            }
            else if($get['e'] == 2){
                $this->error = self::EMAIL_ERROR;
            }
            else if($get['e'] == 3){
                $this->error = self::EMAIL_EXISTS;
            }
        }
    }

    public function presentBody(){
        if(isset($this->get['v'])){
            return $this->presentDone();
        }
        else{
            return $this->presentForm();
        }

    }

    public function presentDone(){
        $html = <<<HTML
<div class="page-body">
    <div class="page-body-content">
        <div class="page-body-inner-content">
        <p id="newUserMessage">An email message has been sent to your address. When it arrives, select the validate link in the email to validate your account.</p>
            <form action="post/newuser.php" method="post" name="newUserForm" id="newUserForm">
                <p class="page-body-inner-content-form">
                <button name="goHome" id="goHome" value="goHome">Home</button></p>
            </form>
        </div>
    </div>
</div>
HTML;
        return $html;
    }

    public function presentForm(){
        $html = <<<HTML
<div class="page-body">
    <div class="page-body-content">
        <div class="page-body-inner-content">
        <p id="newUserMessage">If you create an account on Nifty Nurikabe, you can save and load games as you play.</p>
            <form action="post/newuser.php" method="post" name="newUserForm" id="newUserForm">
                <p class="page-body-inner-content-form name">Name</p>
                <p class="page-body-inner-content-form top"><input type="text" name="newUserName" id="newUserName"></p>
                
                <p class="page-body-inner-content-form name">Email</p>
                <p class="page-body-inner-content-form top"><input type="email" name="newUserEmail" id="newUserEmail"></p>
                
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