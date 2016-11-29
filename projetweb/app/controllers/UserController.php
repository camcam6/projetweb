<?php
namespace app\controllers;

use core\AppController;

class UserController extends AppController {

    public function login()
    {
        if (isset($_POST['username']) && isset($_POST['password']))
            {
            $this->loadModel();
                $login = $_POST['username'] ;
                $password = $_POST['password'] ;
            $exist = $this->User->find([
                'where' => [
                    'login' => "$login",
                    'password' =>"$password"
                ]
            ]);

            if ($exist)
            {
                $_SESSION['Auth'] = $_POST;
                $_SESSION['Auth']['mail']=$exist[0]->email;
                header("Location: ?controller=article");
            }
        }

        $this->render('login', 'user');
    }

    public function logout()
    {
        session_destroy();
        header('Location: ?controller=article');
    }

    public function subscribe(){
        $this->render('subscribe', 'user');
        if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['mail']))
        {
            $this->loadModel();
            $login = $_POST['username'] ;
            $password = $_POST['password'] ;
            $email = $_POST['mail'];
            $exist = $this->User->save([
                    'login' => "$login",
                    'password' =>"$password",
                    'email'=>"$email"
            ]);

            if ($exist)
            {
                $_SESSION['Auth'] = $_POST;

                header("Location: ?controller=article");

            }
        }
    }

}