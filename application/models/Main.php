<?php

namespace application\models;

use application\core\Model;

class Main extends Model
{
    public $error;

    public function contactValidate($post)
    {
        $nameLen = iconv_strlen($post['name']);
        $textLen = iconv_strlen($post['text']);
        if ($nameLen < 3 or $nameLen > 25) {
            $this->error = 'Имя должно содержать от 3 до 25 символов';
            return false;
        } elseif (!filter_var($post['email'], FILTER_VALIDATE_EMAIL)) {
            $this->error = 'E-mail указан не верно';
            return false;
        } elseif ($textLen < 10 or $textLen > 700) {
            $this->error = 'Сообщение должно быть от 10 до 700 символов';
            return false;
        }
        return true;
    }

    public function postsCount()
    {
        return $this->db->column("SELECT COUNT(id) FROM posts");
    }

    public function postsList($route) {
        $max = 10;
        $params = [
            'max' => $max,
            'start' => ((($route['page'] ?? 1) - 1) * $max),
        ];
        return $this->db->row('SELECT * FROM posts ORDER BY id DESC LIMIT :start, :max', $params);
    }
}