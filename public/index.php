<?php
require_once "../app/autoload.php";
Init\classLoader();

$router = new Router;

$router->redirectToContent();
