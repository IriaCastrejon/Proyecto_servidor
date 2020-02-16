<?php

  // require ("/vendor/phpmailer/phpmailer/src/PHPMailer.php");
  // require ("/vendor/phpmailer/phpmailer/src/SMTP.php");
  // // require 'path/to/PHPMailer/src/Exception.php';
  // // ("/resources/templates/header.php");
  // // Load Composer's autoloader
  // require 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'vendor/autoload.php';

$tipo_cliente='';
$email='';
$errores=[];
echo '<pre>';
print_r($_POST);
echo '</pre>';
if (isset($_POST['enviar'])) {

  if (isset($_POST['cliente']) && ($_POST['cliente']== 'mascota' || $_POST['cliente']== 'empresa')){
    $tipo_cliente=$_POST['cliente'];
    if (isset($_POST['email']) && $_POST['email'] != '') {

      $email=clean_input($_POST['email']);

      if (filter_var($email, FILTER_VALIDATE_EMAIL)== false) {
        $errores['correo']='Formato de email no valido';
      }else{
        if ($tipo_cliente== 'mascota') {
          echo 'es una mascota';
          echo MascotaManager::existeEmail($email);
          if (!MascotaManager::existeEmail($email)) {
            echo $tipo_cliente;
            $errores['correo']='Este correo electronico no está registrado';
          }
        }
        if ($tipo_cliente== 'empresa') {
          if (!EmpresaManager::existeEmail($email)) {
            $errores['correo']='Este correo electronico no está registrado';
          }
        }
      }
    }else{
      $errores['correo']= 'Debe introducir un Email';
    }
  }else {
    $errores['tipo_cliente']='No es una opción válida';
    echo 'dentro del else de cl'.$errores['tipo_cliente'];
  }


  if (count($errores)>0) {
    echo $email;
    $token=generaToken();
  //  enviarEmail();
  }

}
  function generaToken(){
    return bin2hex(random_bytes(10));
  }
  function enviarEmail($token,$email){
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
   echo $tipo_cliente;
 ?>
 <div class="formularioRecuperarContraseña">
   <form class="" action="enviarCorreo.php" method="post">
     <input type="text" name="correo" value="<?=$email?>"><label for="">Introduce el correo eletronico</label><br>
     <span class="error"><?=$errores['correo'] ?></span><br>
     <label for="" class="rad_cliente">Soy mascota <input type="radio" name="cliente" value="mascota" <?=($tipo_cliente== 'mascota')?'checked':'' ?> > </label>
     <label for="" class="rad_cliente">Soy empresa <input type="radio" name="cliente" value="empresa" <?=($tipo_cliente== 'empresa')?'checked':'' ?>> </label><br>
     <span class="error"><?=$errores['tipo_cliente'] ?></span><br>
     <input type="submit" name="enviar" value="Enviar">
   </form>
 </div>
