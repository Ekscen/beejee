<?php
use Model\Task;
use Model\User;

class Action
{
    public function __construct() {
        $this->view = new View();
        $this->Task = new Task();
        $this->User = new User();
        session_start();
    }

    public function index () {
        $tasks = $this->Task->getTasks();
        $data['tasks'] = $tasks;
        $data = Helper::getDataFromSession($data);
        $this->view->showIndex($data);
    }
    public function putTask() {
            $data = Helper::prepareData($_POST);
            $data['status'] = 0;

            $errors = Helper::validate($data);
            if (!empty($errors)) {
                $_SESSION['fast']['formData'] = $data;
                $_SESSION['fast']['errors'] = $errors;
            }
            elseif ( $this->Task->putTask($data) ) {
                $_SESSION['fast']['success'] = "Задача создана успешно";
            }
    }
    public function completeTask() {
        if (isset($_SESSION['user']) && $_SESSION['user']['isAdmin']) {
            $data = Helper::prepareData($_POST);
            if ($this->Task->setTaskAsComplete($data['id'])) {
                $_SESSION['fast']['success'] = "Задача отмечена выполненной";
            }
        } 
        else {
            $_SESSION['fast']['loginError'] = "Необходимо войти";
        }
    }
    public function editTask() {
        if (isset($_SESSION['user']) && $_SESSION['user']['isAdmin']) {
            $data = Helper::prepareData($_POST);
            if ($this->Task->editTask($data)) {
                $_SESSION['fast']['success'] = "Задача отредактирована";
            }
        }
        else {
            $_SESSION['fast']['loginError'] = "Необходимо войти";
        }
    }

    public function logIn() {
        $data = Helper::prepareData($_POST);
        $data['password']  = md5($data['password']);

        if ($user = $this->User->logIn($data)) {
            $_SESSION['user'] = [
                'id'            => $user['id'],
                'login'         => $user['login'],
                'isAdmin'       => true
            ];
        } 
        else {
            $_SESSION['fast']['loginError'] = "Данные авторизации не верны";
        }
    }
    public function logOut() {
        if (isset($_SESSION['user'])) {
            unset($_SESSION['user']);
        }
        header('Location: /');
    }

    public function __call($name, $arguments) {
        header('Location: /');
    }
}
