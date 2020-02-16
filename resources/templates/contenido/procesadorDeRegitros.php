<?php

$nombre='';
$email='';
$contraseña='';
$contraseña_V='';
$localidad='';
$cp=NULL;
$Telefono=NULL;

$descripcion='';
$nombre_dueno='';
$cif;
$mascota=false;
$empresa=false;
$tipo_cliente='';
$errores=[];

  if (isset($_COOKIE['tipo_cliente'])) {

    if ( $_COOKIE['tipo_cliente']== 'mascota' || $_COOKIE['tipo_cliente']== 'empresa' ) {
      $tipo_cliente=$_COOKIE['tipo_cliente'];
      if ($tipo_cliente =='mascota') {
        $mascota=true;
      }else {
        $empresa=true;
      }
    }else{
      header("location: registro.php");
      die();
    }

  }else{
    header("location: registro.php");
    die();
  }//xiste cookie





if (isset($_POST['enviar'])) {

  // nombree es esto
  if (isset($_POST['nombre']) && $_POST['nombre'] != '') {
    $nombre=clean_input($_POST['nombre']);
  }else{
    $errores['nombre']= 'Debe introducir un nombre';
  }
  // email
  if (isset($_POST['email']) && $_POST['email'] != '') {

    $email=clean_input($_POST['email']);
    if (filter_var($email, FILTER_VALIDATE_EMAIL)== false) {
      $errores['email']='Formato de email no valido';
    }else{
      if (MascotaManager::existeEmail($email) || EmpresaManager::existeEmail($email)) {
        //echo 'entra en el correo ya existe';
        $errores['email']='Este correo electronico ya está registrado';
      }
    }
  }else{
    $errores['email']= 'Debe introducir un Email';
  }
  // Contraseña
  if (isset($_POST['pass']) && $_POST['pass'] != '') {
    $contraseña=clean_input($_POST['pass']);
  }else{
    $errores['pass']= 'Debe introducir una contraseña';
  }
  // validar contraseña
  if (isset($_POST['passVer']) && $_POST['passVer'] != '') {
    $contraseña_V=clean_input($_POST['passVer']);
    if($contraseña!= $contraseña_V){
      $errores['passVer']='Las contraseñas no coinciden';
    }
  }else{
    $errores['passVer']= 'Introduce la verificacion de la contraseña';
  }
  // Localidad
  if (isset($_POST['localidad']) && $_POST['localidad'] != '') {
    $localidad=clean_input($_POST['localidad']);
  }
  if (isset($_POST['cp']) && $_POST['cp'] != '') {
    $cp=clean_input($_POST['cp']);
  }
  if (isset($_POST['telefono']) && $_POST['telefono'] != '') {
    $Telefono=clean_input($_POST['telefono']);
  }


  if(count($_FILES)>0) {
      if($_FILES['imagen']['size'] < $config['MB_2']){
          if($_FILES['imagen']['type'] == "image/png" || $_FILES['imagen']['type'] == "image/jpeg" || $_FILES['imagen']['type'] == "image/jpg"){
              // Gestionamos la información del fichero
              $fichero_tmp = $_FILES["imagen"]["tmp_name"];
              $nombre_real = basename($_FILES["imagen"]["name"]);
              $ruta_destino = $config['img_path']."/".$nombre_real;



              /*
              Si existe lo machacamos. Tener en cuenta
              if (file_exists($ruta_destino)) {
                  // Procesar error
              }
              */

          } else {
              $errores['foto'] = "Fichero no soportado";
          }
      } else {
          $errores['foto'] = "Fichero gigante";
      }
  } else {
      $errores['foto'] = "Sin imagen";
  }


// si es una mascota
  if ($mascota) {
    if (isset($_POST['dueño']) && $_POST['dueño'] != '') {
      $nombre_dueno=clean_input($_POST['dueño']);
    }else {
    $errores['dueño']='Debe rellenar este campo';
    }
    if (isset($_POST['descripcion']) && $_POST['descripcion'] != '') {
      $descripcion=clean_input($_POST['descripcion']);
    }else {
    $errores['descripcion']='Debe rellenar este campo';
    }

  }else {
    // cif
    if (isset($_POST['cif']) && $_POST['cif'] != '') {
      $cif=clean_input($_POST['cif']);
    }else {
    $errores['cif']='Debe rellenar este campo';
    }
  }//else $tipo_cliente

  //errores
  if(count($errores)==0){

    $db= DWESBaseDatos::obtenerInstancia();
    $pass_encriptada= password_hash($contraseña, PASSWORD_DEFAULT);

    if ($mascota) {

      echo 'dentro del if de mascota en registro <br>';
      MascotaManager::insert($nombre,$email,$pass_encriptada,$localidad,$cp,$Telefono,$nombre_real,$descripcion,$nombre_dueno);

      if (move_uploaded_file($fichero_tmp, $ROOT.$ruta_destino)) {
      //  header("location: login.php");
        //exit;
      } else {
          $errores[] = "Error moviendo fichero";
          // Ojo!!!
          $borrado = MascotaManager::delete($id);

          if(!$borrado) {
              // Ha ocurrido un error extraño
              // Debemos reportarlo y que un admin
              // Deje la información correcta
              // Hay un tema sin imagen
              // También podríamos usar transacciones de base de datos
          }
      }
    }

    if ($empresa) {


      EmpresaManager::insert($email,$nombre,$pass_encriptada,$nombre_real,$localidad,$cp,$cif,$Telefono);

      if (move_uploaded_file($fichero_tmp, $ROOT.$ruta_destino)) {
      //  header("location: login.php");
        //exit;
      } else {
          $errores[] = "Error moviendo fichero";
          // Ojo!!!
          $borrado = EmpresaManager::delete($id);

          if(!$borrado) {
              // Ha ocurrido un error extraño
              // Debemos reportarlo y que un admin
              // Deje la información correcta
              // Hay un tema sin imagen
              // También podríamos usar transacciones de base de datos
          }
      }
    }
    header("location: login.php");
    exit;
  }// no hay errores


}
//echo $_SESSION['tipo_cliente'];
 ?>
 <div class="fomulario_registro">

   <form class="registro" action="procesadorDeRegitros.php" method="post" enctype="multipart/form-data">
     <h2>Rellena los campos</h2>
     <!-- NOMBRE-->
     <?php if (isset($errores['nombre'])): ?>
       <span class="error"><?=$errores['nombre'] ?></span> <br>
     <?php endif; ?>
     <label for="">Nombre</label><input type="text" name="nombre" value=" <?= $nombre ?>"><br><br>

     <!-- EMAIL-->
     <?php if (isset($errores['email'])): ?>
       <span class="error"><?= $errores['email']?> </span> <br>
     <?php endif; ?>
     <label for="">Email</label><input type="email" name="email" value="<?= $email ?>"><br><br>

     <?php if (isset($errores['pass'])): ?>
       <span class="error"><?=$errores['pass'] ?></span> <br><br>
     <?php endif; ?>
     <label for="">Contraseña</label><input type="password" name="pass" value="<?=$contraseña?>"><br><br>

     <?php if (isset($errores['passVer'])): ?>
         <span class="error"><?= $errores['passVer']?> </span> <br><br>
     <?php endif; ?>
     <label for="">Repita contraseña</label><input type="password" name="passVer" value="<?=$contraseña_V ?>"><br><br>


     <label for="">Localidad</label><input type="text" name="localidad" value="<?= $localidad ?>"><br><br>
     <label for="">Código Postal </label><input type="number" name="cp" value="<?= $cp ?>"><br><br>
     <label for="">Teléfono</label><input type="tel" name="telefono" value="<?= $Telefono ?>"><br><br>
     <?php if (isset($errores['foto'])): ?>
          <span class="error"><?= $errores['foto']?> </span> <br><br>
     <?php endif; ?>
     <label for="">Foto</label><input type="file" name="imagen" accept="image/png, image/jpeg"><br><br>

     <?php if ($empresa): ?>

       <?php if (isset($errores['cif'])): ?>
         <span class="error"><?=$errores['cif'] ?></span> <br>
       <?php endif; ?>
       <label for=""> CIF</label><input type="text" name="cif" value="<?= $cif ?>"><br>

     <?php endif; ?>

     <?php if ($mascota): ?>
       <?php if (isset($errores['dueño'])): ?>
         <span class="error"> <?= $errores['dueño'] ?></span> <br>
       <?php endif; ?>
       <label for="">Nombre dueño</label> <input type="text" name="dueño" value="<?= $nombre_dueno ?>"> <br><br>

       <?php if (isset($errores['descripcion'])): ?>
         <span class="error"><?=$errores['descripcion'] ?> </span> <br>
       <?php endif; ?>
       <label for=""> Decripción</label> <input type="textarea" name="descripcion" value="<?= $descripcion ?>"> <br>
     <?php endif; ?>

     <br><br> <input type="submit" name="enviar" value="Registrarme">

    </form>
 </div>
