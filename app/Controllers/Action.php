<?php
use Model\Task;

class Action
{
    public function __construct() {
        $this->view = new View();
        $this->modelTask = new Task();
        session_start();
    }
    public function index () {
        $tasks = $this->modelTask->getTasks();
        $data['tasks'] = $tasks;
        $data = $this->getDataFromSession($data);
        $this->view->showIndex($data);
    }

    public function putTask() {
        if (!empty($_POST)) {
            $data['name']       = trim(htmlspecialchars($_POST['name']));
            $data['email']      = trim(htmlspecialchars($_POST['email']));
            $data['task']       = trim(htmlspecialchars($_POST['task']));
            $data['status']     = 0;

            $errors = $this->validate($data);
            
            if (!empty($errors)) {
                $_SESSION['formData'] = $data;
                $_SESSION['errors'] = $errors;
            }
            elseif ( $this->modelTask->putTask($data) ) {
                $_SESSION['success'] = "Задача создана успешно";
            }
            header('Location: /');
        }
    }

    public function validate ($data) {
        $errors = [];
        if ( !filter_var($data['email'], FILTER_VALIDATE_EMAIL) ){
            $errors['email'] = "Неверно указан эмейл";
        }
        if ( !$data['name'] ) {
            $errors['name'] = "Укажите имя";
        }
        if ( !$data['task'] ) {
            $errors['task'] = "Напишите задание";
        }
        return $errors;
    }

    public function getDataFromSession ($data) {
        if (!empty($_SESSION["errors"])) {
            $data['errors'] = $_SESSION["errors"];
            unset( $_SESSION["errors"] );
        }
        if (!empty($_SESSION["success"])) {
            $data['success'] = $_SESSION["success"];
            unset( $_SESSION["success"] );
        }
        if (!empty($_SESSION["formData"])) {
            $data['formData'] = $_SESSION["formData"];
            unset( $_SESSION["formData"] );
        }
        return $data;
    }
}
