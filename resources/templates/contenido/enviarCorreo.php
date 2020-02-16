<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'vendor/autoload.php';

$tipo_cliente='';
$email='';
$errores=[];
$mensajeEnviado= $_GET['mensajeEnviado'];
if (isset($_POST['enviar'])) {

  if (isset($_POST['cliente']) && ($_POST['cliente']== 'mascota' || $_POST['cliente']== 'empresa')){
    $tipo_cliente=$_POST['cliente'];
    if (isset($_POST['correo']) && $_POST['correo'] != 'correo') {

      $email=clean_input($_POST['correo']);

      if (filter_var($email, FILTER_VALIDATE_EMAIL)== false) {
        $errores['correo']='Formato de email no valido';
      }else{
        if ($tipo_cliente== 'mascota') {

          if (!MascotaManager::existeEmail($email)) {

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
  }


  if (count($errores)==0) {
    $token=bin2hex(random_bytes(10));
    $id = MascotaManager::getByEmail($email)['id'];
    TokenManager::delete($id,$tipo_cliente);
    TokenManager::insert($id,$token,$tipo_cliente);
    // TokenManager::delete($_SESSION['id'],$_SESSION['tipo_cliente']);
    // TokenManager::insert($_SESSION['id'],$token,$_SESSION['tipo_cliente']);
    //borrar token anterior del mismo Usuario/
    //insertar token e id y tipo
    enviarEmail($email,$token,$tipo_cliente);
  }

}

  function enviarEmail($email,$token,$tipo_cliente){
      $email_user="Hipets.enterprise@gmail.com";
      $email_password = "Hipets1234";
      $the_subject = "Recuperar cotraseña";

      $phpmailer = new PHPMailer();

      $url='http://'. $_SERVER["SERVER_NAME"].':9000/cambiarContrasena.php?cliente='.$tipo_cliente.'&token='.$token;
      $body = "<p>Hemos recibido una peticion para restablecer el password de su cuenta.</p>
         <p>Si hiciste esta peticion, haz click en el siguiente enlace: <a href='$url'> Restablecer Password </a></p>";
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
      $phpmailer->setFrom($email_user,'Hipets');
      $phpmailer->AddAddress($email); // recipients email
      $phpmailer->Subject = $the_subject;
      $phpmailer->Body = $body;
      $phpmailer->IsHTML(true);
      if (!$phpmailer->send()) {
       echo "El mail no pudo ser enviado: {$phpmailer->ErrorInfo}";
     }else {
        header('Location: enviarCorreo.php?mensajeEnviado=true');
        die();

     }

  }
 ?>
 <?php if (!$mensajeEnviado){ ?>
   <div class="formularioRecuperarContraseña">
    <h1>Confirma tu correo electrónico </h1>
      <form class="" action="enviarCorreo.php" method="post">
        <label for="">Introduce el correo eletronico</label><input type="email" name="correo" value="<?=$email ?>"><br>
        <span class="error"><?=$errores['correo'] ?></span><br>
        <label for="" class="rad_cliente">Soy mascota <input type="radio" name="cliente" value="mascota" <?=($tipo_cliente== 'mascota')?'checked':'' ?> > </label>
        <label for="" class="rad_cliente">Soy empresa <input type="radio" name="cliente" value="empresa" <?=($tipo_cliente== 'empresa')?'checked':'' ?>> </label><br>
        <span class="error"><?=$errores['tipo_cliente'] ?></span><br>
        <input type="submit" name="enviar" value="Enviar">
      </form>
  </div>
<?php }else{ ?>
  <h1>Se ha enviado un correo para reestablacer su contraseña</h1>
<?php } ?>