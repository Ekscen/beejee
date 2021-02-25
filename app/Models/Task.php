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
            $result = $stmt->affected_rows;
            $stmt->close();
            return $result;
        }
    }
    public function editTask ($data) {
        $stmt =  $this->link->stmt_init();
        $stmtString = 'UPDATE task SET task=?, is_edit=1 WHERE id=?';
        if ( $stmt->prepare($stmtString) ) {
            $stmt->bind_param("si", $data['task'], $data['id']);
            $stmt->execute();
            $result = $stmt->affected_rows;
            $stmt->close();
            return $result;
        }
    }
    public function setTaskAsComplete ($id) {
        $stmt =  $this->link->stmt_init();
        $stmtString = 'UPDATE task SET status = 1 WHERE id=?';
        if ( $stmt->prepare($stmtString) ) {
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $result = $stmt->affected_rows;
            $stmt->close();
            return $result;
        }
    }
    public function getTasks($filter) {
        $stmt =  $this->link->stmt_init();
        $stmtString = "SELECT SQL_CALC_FOUND_ROWS id, name, email, task, status, is_edit FROM task";
        if ($filter['order']){
            $stmtString .= " ORDER BY {$filter['order']['by']} {$filter['order']['sortOrder']}";
        }
        $stmtString .= " LIMIT ? OFFSET ?";
        if ( $stmt->prepare($stmtString) ) {
            $result = [];
            $stmt->bind_param('ii', $filter['limit'], $filter['offset']);
            $stmt->execute();
            $stmt->bind_result($id, $name, $email, $task, $status, $isEdit);
            while ( $stmt->fetch() ) {
                $tasks[]= [
                    'id'     => $id,
                    'name'   => $name,
                    'email'  => $email,
                    'task'   => $task,
                    'status' => $status,
                    'isEdit' => $isEdit,
                ];
            }
            $stmtString = 'SELECT FOUND_ROWS()';
            $stmt->prepare($stmtString);
            $stmt->execute();
            $stmt->bind_result($count);
            $stmt->fetch();
            $stmt->close();
            return [
                'fields' => $tasks,
                'count' => $count
            ];
        }
    }
}

