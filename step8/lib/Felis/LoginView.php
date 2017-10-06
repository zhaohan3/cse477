<?php

namespace Felis;


class LoginView extends View {
    private $session;
    private $get;
    public function __construct($session, $get){
        $this->session = $session;
        $this->get = $get;
    }

    public function presentForm(){
        $html = <<<HTML
<form action="post/login.php" method="post">
	<fieldset>
		<legend>Login</legend>
		<p>
			<label for="email">Email</label><br>
			<input type="email" id="email" name="email" placeholder="Email">
		</p>
		<p>
			<label for="password">Password</label><br>
			<input type="password" id="password" name="password" placeholder="Password">
		</p>
HTML;
        $html .= $this->displayLoginError();
        $html .= <<<HTML
		<p>
			<input type="submit" value="Log in"> <a href="">Lost Password</a>
		</p>
		<p><a href="./">Felis Agency Home</a></p>

	</fieldset>
</form>
HTML;
        return $html;
    }
    public function displayLoginError(){
        $html = '';
        if(isset($this->get['e'])){
            $html = "<p class=\"msg\"> " . $this->session['ERROR'] . "</p>";
            //print_r($this->session);
        }

        return $html;
    }

}