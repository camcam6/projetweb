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
                $password = $_POST['password'];
                $pass = sha1($password);
            $exist = $this->User->find([
                'where' => [
                    'login' => "$login",
                    'password' =>"$pass"
                ]
            ]);

            //si utilisateur existe on crée une session
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
            $pass = sha1($password);
            //insertion dans la base de données du nouvel utilisateur
            $exist = $this->User->save([
                    'login' => "$login",
                    'password' =>"$pass",
                    'email'=>"$email"
            ]);

            //si insertion réussi, on stocke les données en session
            if ($exist)
            {
                $_SESSION['Auth'] = $_POST;

                header("Location: ?controller=article");

            }
        }
    }

}