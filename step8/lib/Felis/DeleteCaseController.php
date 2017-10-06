<?php

namespace Felis;


class DeleteCaseController extends Controller {
    public function __construct(Site $site, $post){
        parent::__construct($site, $post);

        if(isset($post['yes'])){
            $this->setRedirect($site->getRoot() . "/cases.php");
            //delete the case
            $id = $post['id'];
            $cases = new Cases($site);
            $cases->delete($id);
        }
        else if(isset($post['no'])){
            $this->setRedirect($site->getRoot() . "/cases.php");
        }
        else{
            $this->setRedirect($site->getRoot() . "/cases.php");
        }
    }
}