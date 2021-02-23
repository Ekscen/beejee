<?php

class View
{
    private $templateDir = "../resources/views/"; 

    public function showIndex ($data) {
        require_once "{$this->templateDir}index.php";
    }
}
