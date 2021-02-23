<?php

class Router
{
    function __construct() {
        $this->request = explode("/", $_SERVER["REQUEST_URI"]);
        $this->action = new Action;
    }

    public function redirectToContent () {
        if ($this->request[1] === "") {
            $this->action->index();
        } else {
            $method = $this->request[1];
            $this->action->$method();
        }
    }
}
