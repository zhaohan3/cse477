<?php

namespace Felis;


class UsersController extends Controller {
    public function __construct(Site $site, User $user, array $post){
        parent::__construct($site, $post);

        if(isset($post['add'])){
            $this->setRedirect($site->getRoot(). "/user.php");
        }
        else if(isset($post['edit'])){
            if(!isset($post['user'])){
                $this->setRedirect($site->getRoot(). "/users.php");
            }
            else {
                $this->setRedirect($site->getRoot() . "/user.php?id=" . $post['user'] . "");
            }
        }
        else if(isset($post['delete'])){

        }
        else{
            $this->setRedirect($site->getRoot(). "/users.php");
        }
    }
}