<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'vendor/autoload.php';

$tipo_cliente='';
$email='';
$errores=[];
if (isset($_POST['enviar'])) {

  if (isset($_POST['cliente']) && ($_POST['cliente']== 'mascota' || $_POST['cliente']== 'empresa')){
    $tipo_cliente=$_POST['cliente'];
    if (isset($_POST['correo']) && $_POST['email'] != 'correo') {

      $email=clean_input($_POST['correo']);

      if (filter_var($email, FILTER_VALIDATE_EMAIL)== false) {
        $errores['correo']='Formato de email no valido';
      }else{
        if ($tipo_cliente== 'mascota') {

          if (!MascotaManager::existeEmail($email)) {
            echo 'MascotaManager::existeEmail($email)';
            $errores['correo']='Este correo electronico no está registrado';
          }
        }
        if ($tipo_cliente== 'empresa') {
          if (!EmpresaManager::existeEmail($email)) {
            echo 'MascotaManager::existeEmail($email)';
            $errores['correo']='Este correo electronico no está registrado';
          }
        }
      }
    }else{
      $errores['correo']= 'Debe introducir un Email';
    }
  }else {
    $errores['tipo_cliente']='No es una opción válida';
  }


  if (count($errores)==0) {
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
           <a href="login.php"> Restablecer contrase&ntildea </a>
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
 ?>
 <div class="formularioRecuperarContraseña">
   <form class="" action="enviarCorreo.php" method="post">
     <label for="">Introduce el correo eletronico</label><input type="email" name="correo" value="<?=$email ?>"><br>
     <span class="error"><?=$errores['correo'] ?></span><br>
     <label for="" class="rad_cliente">Soy mascota <input type="radio" name="cliente" value="mascota" <?=($tipo_cliente== 'mascota')?'checked':'' ?> > </label>
     <label for="" class="rad_cliente">Soy empresa <input type="radio" name="cliente" value="empresa" <?=($tipo_cliente== 'empresa')?'checked':'' ?>> </label><br>
     <span class="error"><?=$errores['tipo_cliente'] ?></span><br>
     <input type="submit" name="enviar" value="Enviar">
   </form>
 </div>
