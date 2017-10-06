<?php

namespace Felis;


class CasesController extends Controller{
    public function __construct(Site $site, $post){
        parent::__construct($site, $post);

        // take appropriate action based on what button was pressed
        if(isset($this->getPost()['add'])){
            $this->setRedirect($site->getRoot() . "/newcase.php");
        }
        else if(isset($this->getPost()['delete'])){
            if(!isset($post['user'])){
                $this->setRedirect($site->getRoot() . "/cases.php");
            }
            else{
                $this->setRedirect($site->getRoot() . "/deletecase.php?id=". $post['user'] ."");
            }
        }
        else{
            $this->setRedirect($site->getRoot() . "/cases.php");
        }
    }

}