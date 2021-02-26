<?php
namespace Model;

class User
{
    public function __construct ()
    {
        require("Model.txt");
        $this->link = mysqli_connect($data['host'], $data['user'], $data['pass'], $data['base']);
        mysqli_set_charset($this->link, "utf8");
    }
    public function __destruct()
    {
        mysqli_close($this->link);
    }

    public function logIn ($data) {
        $stmt =  $this->link->stmt_init();
        $stmtString = 'SELECT id, login FROM user WHERE login=? AND password=? LIMIT 1';
        if ( $stmt->prepare($stmtString) ) {
            $stmt->bind_param("ss", $data['login'], $data['password']);
            $stmt->execute();
            $stmt->bind_result($id, $login);
            $result = null;
            while ( $stmt->fetch() ) {
                $result = [
                    'id'     => $id,
                    'login'  => $login,
                ];
            }
            return $result;
        }
    }
}