<?php

class Router
{
    function __construct() {
        $this->request = explode("/", $_SERVER["REQUEST_URI"]);
        $this->action = new Action;
    }

    public function redirectToContent () {
        $method = $this->request[1];
        if ($method === "") {
            $this->action->index();
        } else {
            if (!empty($_POST)) {
                $this->action->$method();
            }
            header('Location: /');
        }
    }
}
