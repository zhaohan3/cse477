<?php

namespace Felis;


class NewCaseView extends View{
    private $site;	///< The Site object

    public function __construct(Site $site){
        $this->site = $site;
        $this->setTitle("Felis New Case");
        $this->addLink("staff.php", "Staff");
        $this->addLink("cases.php", "Cases");
        $this->addLink("post/logout.php", "Log out");
    }

    public function present() {
        $html = <<<HTML
<form action="post/newcase.php" method="post">
	<fieldset>
		<legend>New Case</legend>
		<p>Client:
			<select name="client">
HTML;
        $users = new Users($this->site);
        foreach($users->getClients() as $client) {
            $id = $client['id'];
            $name = $client['name'];
            $html .= '<option value="' . $id . '">' . $name . '</option>';
        }

        $html .= <<<HTML
			</select>
		</p>

		<p>
			<label for="number">Case Number: </label>
			<input type="text" id="number" name="number" placeholder="Case Number">
		</p>

		<p><input type="submit" name="ok" value="OK"> <input type="submit" name="cancel" value="Cancel"></p>

	</fieldset>
</form>
HTML;

        return $html;
    }
}