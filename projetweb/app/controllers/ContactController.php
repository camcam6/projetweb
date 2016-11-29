<?php
/**
 * Created by PhpStorm.
 * User: Camille
 * Date: 22/10/2016
 * Time: 16:48
 */

namespace app\controllers;

use core\AppController;

class ContactController extends AppController
{
    public function contact(){
            $this->loadModel();
        $this->render('contact');
    }

    public function sendMail(){
        require_once dirname(__DIR__) . '/lib/PHPMailer/class.phpmailer.php';
        require_once dirname(__DIR__) . '/lib/PHPMailer/class.smtp.php';

        if (isset($_SESSION['Auth'])){
            $from = $_SESSION['Auth']['mail'];
        }else{
            $from = $_POST['mail'];
        }
        $message = $_POST['message'];
        $topic = $_POST['topic'];
        $objet = $topic;
        $mail_contenu = $message;



        $mail = new \PHPmailer();

        // Pas utile en local, à adapter en ligne
        /*$mail->isSMTP();
        $mail->Host = $smtp_server; // SMTP servers àlocalhost pour toi
        $mail->Port = 465;
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = "ssl";
        $mail->Username = $compte_smtp;
        $mail->Password = $mdp_smtp;*/

        $mail->IsHTML(true);
        $mail->From = "neveu.devs@gmail.com";
        $mail->FromName = "Neveu Devs";

        $mail->AddAddress("camilleneveu12@gmail.com");
        /*$mail->AddCC($email_copie); // copie du mail
        $mail->AddBCC($email_copie_cache);*/ // copie du mail en caché

        $mail->Subject = $objet;
        $mail->Body = $mail_contenu;


        if($mail->Send())
            header('Location: ?controller=main&ok=1');
        else
            header('Location: ?controller=contact&action=contact&ok=0');


    }
}