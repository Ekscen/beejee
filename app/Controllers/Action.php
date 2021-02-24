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
                $_SESSION['fast']['formData'] = $data;
                $_SESSION['fast']['errors'] = $errors;
            }
            elseif ( $this->Task->putTask($data) ) {
                $_SESSION['fast']['success'] = "Задача создана успешно";
            }
            header('Location: /');
        }
    }

    public function logIn() {
        $data['login']     = trim(htmlspecialchars($_POST['login']));
        $data['password']  = md5(trim(htmlspecialchars($_POST['password'])));
        if ($user = $this->User->logIn($data)) {
            $_SESSION['user'] = [
                'id'            => $user['id'],
                'login'         => $user['login'],
                'isAdmin'       => true
            ];
        } else {
            $_SESSION['fast']['loginError'] = "Данные авторизации не верны";
        }
        header('Location: /');
    }
    public function logOut() {
        if (isset($_SESSION['user'])) {
            unset($_SESSION['user']);
        }
        header('Location: /');
    }

    private function validate ($data) {
        $errors = [];
        if (isset($data['email']) && !filter_var($data['email'], FILTER_VALIDATE_EMAIL) ){
            $errors['email'] = "Неверно указан эмейл";
        }
        if (isset($data['name']) && !$data['name'] ) {
            $errors['name'] = "Укажите имя";
        }
        if (isset($data['task']) && !$data['task'] ) {
            $errors['task'] = "Напишите задание";
        }
        return $errors;
    }

    private function getDataFromSession ($data) {
        if (isset($_SESSION['fast'])){
            foreach ($_SESSION['fast'] as $key => $value) {
                $data[$key] = $value;
            }
            unset($_SESSION['fast']);
        }
        if (!empty($_SESSION["user"])) {
            $data['user'] = $_SESSION["user"];
        }
        return $data;
    }

    public function __call($name, $arguments) {
        header('Location: /');
    }
}
