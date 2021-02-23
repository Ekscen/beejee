<?php
namespace Model;

class Task
{
    public function __construct ()
    {
        require("Model.txt");
        $this->link = mysqli_connect($data['host'], $data['user'], $data['pass'], $data['base']);
        if (mysqli_connect_error()) {
            die ('Ошибка подключения ('.mysqli_connect_error().')'.mysqli_connect_error());
        }
        mysqli_set_charset($this->link, "utf8");
    }
    public function __destruct()
    {
        mysqli_close($this->link);
    }
    public function putTask ($data) {
        $stmt =  $this->link->stmt_init();
        $stmtString = 'INSERT INTO task (name, email, task, status) VALUES (?, ?, ?, ?)';
        if ( $stmt->prepare($stmtString) ) {
            $stmt->bind_param("ssss", $data['name'], $data['email'], $data['task'], $data['status']);
            $stmt->execute();
            $stmt->close();
            return true;
        }
    }
    public function getTasks($filter = false) {
        $stmt =  $this->link->stmt_init();
        $stmtString = 'SELECT id, name, email, task, status FROM task';
        if ( $stmt->prepare($stmtString) ) {
            $result = [];
            $stmt->execute();
            $stmt->bind_result($id, $name, $email, $task, $status);
            while ( $stmt->fetch() ) {
                $result[]= [
                    'id'    => $id,
                    'name'  => $name,
                    'email' => $email,
                    'task'  => $task,
                    'status'=> $status
                ];
            }
            return $result;
        } else {
            return "false";
        }
    }
}

