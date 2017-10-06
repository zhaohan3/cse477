<?php

namespace Felis;


class UserView extends View{
    private $site;
    private $get;
    public function __construct($site, $get){
        $this->get = $get;
        $this->site = $site;
        $this->setTitle("Felis User");
        $this->addLink("staff.php", "Staff");
        $this->addLink("./", "Log Out");
    }

    public function present(){
        if(isset($this->get['id'])){
            $html = $this->presentEditUser();
        }
        else{
            $html = $this->presentNewUser();
        }
        return $html;
    }

    public function presentEditUser(){
        $users = new Users($this->site);
        $id = $this->get['id'];
        $user = $users->get($id);
        $email = $user->getEmail();
        $name = $user->getName();
        $phone = $user->getPhone();
        $address = $user->getAddress();
        $notes = $user->getNotes();
        $role = $user->getRole();

        $html = <<<HTML
<form action="post/user.php" method="post">
	<fieldset>
		<legend>User</legend>
		
	    <input type="hidden" name="id" value="$id">

		<p>
			<label for="email">Email</label><br>
			<input type="email" id="email" name="email" value="$email" placeholder="Email">
		</p>
		<p>
			<label for="name">Name</label><br>
			<input type="text" id="name" name="name" value="$name" placeholder="Name">
		</p>
		<p>
			<label for="phone">Phone</label><br>
			<input type="text" id="phone" name="phone" value="$phone" placeholder="Phone">
		</p>
		<p>
			<label for="address">Address</label><br>
			<textarea id="address" name="address" placeholder="Address">$address</textarea>
		</p>
		<p>
			<label for="notes">Notes</label><br>
			<textarea id="notes" name="notes" placeholder="Notes">$notes</textarea>
		</p>
		<p>
			<label for="role">Role: </label>
			<select id="role" name="role">
HTML;
        $roles = array( array('role'=>User::ADMIN,'value'=>"admin", 'text'=>"Admin"),
            array('role'=>User::STAFF,'value'=>"staff", 'text'=>"Staff"),
            array('role'=>User::CLIENT,'value'=>"client", 'text'=>"Client") );
        foreach($roles as $r){
            if($r['role'] == $role){
                $html .= '<option selected value="' . $r['value'] . '">' . $r['text'] . '</option>';
            }
            else{
                $html .= '<option value="' . $r['value'] . '">' . $r['text'] . '</option>';
            }
        }

        $html .= <<<HTML
			</select>
		</p>
		<p>
			<input type="submit" name="ok" value="OK"> <input type="submit" name="cancel" value="Cancel">
		</p>

	</fieldset>
</form>

	<p>
		Admin users have complete management of the system. Staff users are able to view and make
		reports for any client, but cannot edit the users. Clients can only view the cases
		they have contracted for.
	</p>
HTML;
        return $html;
    }

    public function presentNewUser(){
        $html = <<<HTML
<form action="post/user.php" method="post">
	<fieldset>
		<legend>User</legend>
		<p>
			<label for="email">Email</label><br>
			<input type="email" id="email" name="email" placeholder="Email">
		</p>
		<p>
			<label for="name">Name</label><br>
			<input type="text" id="name" name="name" placeholder="Name">
		</p>
		<p>
			<label for="phone">Phone</label><br>
			<input type="text" id="phone" name="phone" placeholder="Phone">
		</p>
		<p>
			<label for="address">Address</label><br>
			<textarea id="address" name="address" placeholder="Address"></textarea>
		</p>
		<p>
			<label for="notes">Notes</label><br>
			<textarea id="notes" name="notes" placeholder="Notes"></textarea>
		</p>
		<p>
			<label for="role">Role: </label>
			<select id="role" name="role">
				<option value="admin">Admin</option>
				<option value="staff">Staff</option>
				<option value="client">Client</option>
			</select>
		</p>
		<p>
			<input type="submit" name="ok" value="OK"> <input type="submit" name="cancel" value="Cancel">
		</p>

	</fieldset>
</form>

	<p>
		Admin users have complete management of the system. Staff users are able to view and make
		reports for any client, but cannot edit the users. Clients can only view the cases
		they have contracted for.
	</p>
HTML;
        return $html;
    }
}