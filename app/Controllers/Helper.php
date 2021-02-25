<?php

class Helper
{
    static function validate ($data) {
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

    static function getDataFromSession () {
        $data = [];
        if (isset($_SESSION['fast'])){
            foreach ($_SESSION['fast'] as $key => $value) {
                $data[$key] = $value;
            }
            unset($_SESSION['fast']);
        }
        if (!empty($_SESSION["user"])) {
            $data['user'] = $_SESSION["user"];
        }
        if (!empty($_SESSION['filter'])) {
            foreach ($_SESSION['filter'] as $key => $value) {
                $data['filter'][$key] = $value;
            }
        }
        return $data;
    }

    static function getFilterData () {
        $limit = 5;
        $data['filter']['page']  = $_SESSION['filter']['page'] ?? 1;
        $order = $_SESSION['filter']['order'] ?? false;
        $offset = ($data['filter']['page'] - 1)*$limit;
        return [
            'limit'  => $limit,
            'offset' => $offset,
            'order'  => $order
        ];
    }

    static function prepareData ($data) {
        foreach ($data as $key => $value) {
            $data[$key] = trim(htmlspecialchars($value));
        }
        return $data;
    }
}