<?php

namespace Felis;


class CaseController extends Controller {
    public function __construct(Site $site, $post){
        parent::__construct($site, $post);
        $cases = new Cases($site);
        $client = $cases->get($post['id']);

        //update the client
        $client->setNumber($post['number']);
        $client->setSummary($post['summary']);
        $client->setStatus($post['status']);
        $client->setAgent($post['agent']);

        //update in database
        if($cases->update($client)) {
            $this->setRedirect($site->getRoot() . "/cases.php");
        }
        else{
            $this->setRedirect($site->getRoot() . "/case.php?id=" . $post['id']);
        }
    }
}