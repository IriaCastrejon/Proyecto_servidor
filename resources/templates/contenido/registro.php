<?php

  session_start();
  echo '<pre>';
  //print_r($_POST);
  echo '</pre>';
  $nombre='';
  $email='';
  $contraseña='';
  $contraseña_V='';
  $localidad='';
  $cp='';
  $Telefono='';
  $foto='';
  $descripcion='';
  $nombre_dueno='';
  $denominacion='';
  $cif;
  $mascota=false;
  $empresa=false;
  $errores=[];
  if (isset($_POST['tipo_cliente'])) {
    $_SESSION['tipo_cliente']=$_POST['cliente'];

  }
  if (isset($_SESSION['tipo_cliente'])) {
    if ($_SESSION['tipo_cliente']== 'mascota') {
      $mascota=true;
    }else{
      $empresa=true;
    }
  }
// validacion del formulario
  if (isset($_POST['enviar'])) {

    // nombre
    if (isset($_POST['nombre']) && $_POST['nombre'] != '') {
      $nombre=clean_input($_POST['nombre']);
    }else{
      $errores['nombre']= 'introduce un nombre';
    }
    // email
    if (isset($_POST['email']) && $_POST['email'] != '') {
      $email=clean_input($_POST['email']);

      if (filter_var($email, FILTER_VALIDATE_EMAIL)== false) {
        $errores['email']='Formato de email no valido';
      }
    }else{
      $errores['email']= 'introduce un Email';
    }
    // Contraseña
    if (isset($_POST['pass']) && $_POST['pass'] != '') {
      $contraseña=clean_input($_POST['pass']);
    }else{
      $errores['pass']= 'introduce una contraseña';
    }
    // validar contraseña
    if (isset($_POST['passVer']) && $_POST['passVer'] != '') {
      $contraseña_V=clean_input($_POST['passVer']);
      if($contraseña!= $contraseña_V){
        $errores['passVer']='No_COINCIDEN';
      }
    }else{
      $errores['passVer']= 'introduce la verificacion de la contraseña';
    }
    // Localidad
    if (isset($_POST['localidad']) && $_POST['localidad'] != '') {
      $localidad=clean_input($_POST['pass']);
    }
    if (isset($_POST['localidad']) && $_POST['localidad'] != '') {
      $cp=clean_input($_POST['pass']);
    }
    if (isset($_POST['localidad']) && $_POST['localidad'] != '') {
      $Telefono=clean_input($_POST['pass']);
    }
    if (isset($_POST['localidad']) && $_POST['localidad'] != '') {
      $foto=clean_input($_POST['pass']);
    }
// si es una mascota
    if ($_SESSION['tipo_cliente']=='mascota') {
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
      //denominacion
      if (isset($_POST['denominacion']) && $_POST['denominacion'] != '') {
        $denominacion=clean_input($_POST['denominacion']);
      }else {
      $errores['denominacion']='Debe rellenar este campo';
      }
      // descripcion
      if (isset($_POST['cif']) && $_POST['cif'] != '') {
        $cif=clean_input($_POST['cif']);
      }else {
      $errores['cif']='Debe rellenar este campo';
      }
    }//else $_session[tipo_cliente]
    //errores
    if(count($errores)==0){
      $db= DWESBaseDatos::obtenerInstancia();
      $pass_encriptada= password_hash($contraseña, PASSWORD_DEFAULT);

      if ($_SESSION['tipo_cliente']== 'mascota') {
        echo 'dentro del if';
        MascotaManager::insert($nombre,$email,$pass_encriptada,$localidad,$cp,$Telefono,$foto,$descripcion,$nombre_dueno);
      }/*else{
        EmpresaManager::insert($nombre,$email,$pass_encriptada,$localidad,$cp,$Telefono,$foto,$descripcion,$nombre_dueno);
      }*/

      $_SESSION['id']= $db->getLastId();
      echo $_SESSION['id']. ' en registro ultimo id insertado';
      //header("location: login.php");
      //exit;
    }// no hay errores





  }
  //echo $_SESSION['tipo_cliente'];
 ?>

 <div class="fomulario_registro">
   <?php if (!isset($_SESSION['tipo_cliente'])): ?>
  <form class="registro_tipo_cliente" action="registro.php" method="post">
     <label for="" class="rad_cliente">Soy mascota <input type="radio" name="cliente" value="mascota" <?=($_SESSION['tipo_cliente']== 'mascota')?'checked':'' ?> > </label>
     <label for="" class="rad_cliente">Soy empresa <input type="radio" name="cliente" value="empresa" <?=($_SESSION['tipo_cliente']== 'empresa')?'checked':'' ?>> </label>
     <br> <br><input type="submit" name="tipo_cliente" value="Enviar">
  </form>
  <?php endif; ?>
  <?php if (isset($_SESSION['tipo_cliente'])): ?>
 <form class="registro" action="registro.php" method="post">
   <!-- NOMBRE-->
   <?php if (isset($errores['nombre'])): ?>
     <span class="error">Debe introducir un nombre</span> <br>
   <?php endif; ?>
   <label for="">Nombre</label><input type="text" name="nombre" value=" <?= $nombre ?>"><br><br>

   <!-- EMAIL-->
   <?php if (isset($errores['email'])): ?>
     <span class="error">Debe introducir un email</span> <br>
   <?php endif; ?>
   <label for="">Email</label><input type="email" name="email" value="<?= $email ?>"><br><br>

   <?php if (isset($errores['pass'])): ?>
     <span class="error">Debe introducir una contraseña</span> <br><br>
   <?php endif; ?>
   <label for="">Contraseña</label><input type="text" name="pass" value="<?=$contraseña?>"><br><br>

   <?php if (isset($errores['passVer'])): ?>
     <?php if ($errores['passVer']==='No_COINCIDEN'){ ?>
       <span class="error">Las contraseñas no coinciden</span> <br><br>
     <?php} else{?>
        <span class="error">Debe introducir la contraseña nuevamente</span> <br><br>
     <?php } ?>
   <?php endif; ?>
   <label for="">Repite contraseña</label><input type="text" name="passVer" value="<?=$contraseña_V ?>"><br><br>


   <label for="">Localidad</label><input type="text" name="localidad" value="<?= $localidad ?>"><br><br>
   <label for="">Codigo Postal </label><input type="number" name="cp" value="<?= $cp ?>"><br><br>
   <label for="">Telefono</label><input type="tel" name="telefono" value="<?= $Telefono ?>"><br><br>
   <label for="">Foto</label><input type="file" name="foto" value="<?= $foto ?>"><br><br>

   <?php if ($empresa): ?>

     <?php if (isset($errores['denominacion'])): ?>
       <span class="error">Debe introducir una denominacion social</span> <br>
     <?php endif; ?>
     <label for="">Denominacion social</label> <input type="text" name="denominacion" value="<?= $denominacion ?>"><br><br>

     <?php if (isset($errores['cif'])): ?>
       <span class="error">Debe introducir un CIF</span> <br>
     <?php endif; ?>
     <label for=""> CIF</label><input type="text" name="cif" value="<?= $cif ?>"><br>

   <?php endif; ?>

   <?php if ($mascota): ?>
     <?php if (isset($errores['dueño'])): ?>
       <span class="error">Debes introducir un nombre</span> <br>
     <?php endif; ?>
     <label for="">Nombre dueño</label> <input type="text" name="dueño" value="<?= $nombre_dueno ?>"> <br><br>

     <?php if (isset($errores['descripcion'])): ?>
       <span class="error">Debes introducir una descripcion</span> <br><
     <?php endif; ?>
     <label for=""> Decripcion</label> <input type="textarea" name="descripcion" value="<?= $descripcion ?>"> <br>
   <?php endif; ?>

   <br><br> <input type="submit" name="enviar" value="Registrame">

  </form>
  <?php endif; ?>

 </div>

   <!--<div class="cliente">
     <div>
       <p>Soy mascota</p>
       <input type="radio" name="usuario" value="mascota"><br><br>
     </div>
     <div>
       <p>Soy Empresa</p>
       <input type="radio" name="usuario" value="empresa"><br><br>

     </div>
   </div>-->
