<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

class CorreoManager
{
  public static function enviarEmail(){
    $email_user="Hipets.enterprise@gmail.com";
    $email_password = "Hipets1234";
    $the_subject = "Recuperar cotraseña";
    $phpmailer = new PHPMailer();
    $body = '<html>
      <head>
        <title>Restablece tu contraseña</title>
      </head>
      <body>
       <p>Hemos recibido una petici&oacuten para restablecer la contrase&ntildea de tu cuenta.</p>
       <p>Si hiciste esta petici&oacuten, haz clic en el siguiente enlace, si no hiciste esta petici&oacuten puedes ignorar este correo.</p>
       <p>
         <strong>Enlace para restablecer tu contrase&ntildea</strong><br>
         <a href=""> Restablecer contrase&ntildea </a>
       </p>
     </body>
    </html>';
    // ---------- datos de la cuenta de Gmail -------------------------------
    $phpmailer->Username = $email_user;
    $phpmailer->Password = $email_password;
    //-----------------------------------------------------------------------
    // $phpmailer->SMTPDebug = 1;
    $phpmailer->CharSet = 'UTF-8';
    $phpmailer->SMTPSecure = 'ssl';
    $phpmailer->Host = "smtp.gmail.com"; // GMail
    $phpmailer->Port = 465;
    $phpmailer->IsSMTP(); // use SMTP
    $phpmailer->SMTPAuth = true;
    $phpmailer->setFrom($email_user,'prueba');
    $phpmailer->AddAddress('marbeucv@gmail.com'); // recipients email
    $phpmailer->Subject = $the_subject;
    $phpmailer->Body = $body;
    $phpmailer->isHTML(true);
    if (!$phpmailer->send()) {
     echo "Message could not be sent. Mailer Error: {$phpmailer->ErrorInfo}";
   }else {
      echo 'Message has been sent';
   }
  }

}

 ?>
