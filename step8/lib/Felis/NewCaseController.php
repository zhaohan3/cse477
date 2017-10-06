<?php

namespace Felis;


class NewCaseController extends Controller {
    public function __construct(Site $site, User $user, $post){
        parent::__construct($site, $post);

        $root = $site->getRoot();
        if(isset($post['ok'])){
            $cases = new Cases($site);
            $id = $cases->insert(strip_tags($post['client']),
                $user->getId(),
                strip_tags($post['number']));

            if($id === null) {
                $this->setRedirect("$root/newcase.php?e=".$_SESSION['e']."");
            } else {
                $this->setRedirect("$root/case.php?id=$id") ;
            }
        }
        else if(isset($post['cancel'])){
            $this->setRedirect($site->getRoot() . "/cases.php");
        }
        else{
            $this->setRedirect($site->getRoot() . "/cases.php");
        }
    }
}