<?php

namespace Felis;


class DeleteCaseView extends View{
    private $site;
    private $get;
    public function __construct(Site $site, array $get){
        $this->site = $site;
        $this->get = $get;

        $this->setTitle("Felis Delete?");
        $this->addLink("staff.php", "Staff");
        $this->addLink("cases.php", "Cases");
        $this->addLink("post/logout.php", "Log out");
    }

    public function present(){
        $id = $this->get['id'];

        $cases = new Cases($this->site);
        $case = $cases->get($id);
        $number = $case->getNumber();

        $html = <<<HTML
<form action="post/deletecase.php" method="post">
	<fieldset>
		<legend>Delete?</legend>
		
	    <input type="hidden" name="id" value="$id">
		
		<p>Are you sure absolutely certain beyond a shadow of
			a doubt that you want to delete case $number?</p>

		<p>Speak now or forever hold your peace.</p>

		<p><input type="submit" name="yes" value="Yes"> <input type="submit" name="no" value="No"></p>

	</fieldset>
</form>
HTML;
        return $html;
    }
}