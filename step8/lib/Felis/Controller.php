<?php

namespace Felis;


class Controller{
    private $redirect;
    private $site;
    private $post;

    public function __construct(Site $site, $post){
        $this->site = $site;
        $this->post = $post;
    }

    /**
     * @return mixed
     */
    public function getRedirect(){
        return $this->redirect;
    }

    /**
     * @param mixed $redirect
     */
    public function setRedirect($redirect)
    {
        $this->redirect = $redirect;
    }

    /**
     * @return mixed
     */
    public function getSite()
    {
        return $this->site;
    }

    /**
     * @param mixed $site
     */
    public function setSite($site)
    {
        $this->site = $site;
    }

    /**
     * @return mixed
     */
    public function getPost()
    {
        return $this->post;
    }

    /**
     * @param mixed $post
     */
    public function setPost($post)
    {
        $this->post = $post;
    }	///< Page we will redirect the user to.
    ///
}