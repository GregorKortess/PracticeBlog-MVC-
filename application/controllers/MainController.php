<?php

namespace application\controllers;

use application\core\Controller;
use application\lib\Pagination;
use application\models\Admin;


class MainController extends Controller
{
    public function indexAction()
    {
        $pagination = new Pagination($this->route,$this->model->postsCount(),10);
        $vars = [
          'pagination' => $pagination->get(),
            'list' => $this->model->postsList($this->route),
        ];
        $this->view->render("Главная страница",$vars);
    }

    public function aboutAction()
    {
        $this->view->render("Обо мне");
    }

    public function contactAction()
    {
        if(!empty($_POST)) {
            if (!$this->model->contactValidate($_POST)) {
                $this->view->message('ОШИБКА', $this->model->error);
            }
            //mail('CortessHack@gmail.com','Сообщение из блога ',$_POST['name'].'|'.$_POST['email'].'|'.$_POST['text']);
            $this->view->message('УСПЕХ', 'На локалке сообщения не работают , если надо что бы работали на Хосте, раскоментируй функцию mail в MainController');
        }
        $this->view->render("Контакты");
    }

    public function PostAction()
    {
        $adminModel = new Admin;
        if (!$adminModel->isPostExists($this->route['id'])) {
            $this->view->errorCode(404);
    }
        $vars = [
            'data' => $adminModel->postData($this->route['id'])[0],
        ];
        $this->view->render("Пост",$vars);
    }
}