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

// se guardará aqui el array con las cordenadas
$coordenadas = '';

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
      $errores['passVer'] = 'Las contraseñas no coinciden';
    }
  }else{
    $errores['passVer'] = 'Introduce la verificación de la contraseña';
  }
  // Localidad
  if (isset($_POST['localidad']) && $_POST['localidad'] != '') {
    $localidad = clean_input($_POST['localidad']);
    if($_COOKIE['tipo_cliente']== 'mascota'){
       $coordenadas = getCoordenadas($localidad);
       if (!$coordenadas) { // si no hay cordenadas  se pinta el error y $ coordenadas se declara vacio
         $coordenadas = '';
         $errores['localidad'] = 'La Dirección debe tener este formato: Calle, edificio y ciudad';
       }
    }

  }
  //codigo postal
  if (isset($_POST['cp']) && $_POST['cp'] != '') {
    $cp=clean_input($_POST['cp']);
  }
  if (isset($_POST['telefono']) && $_POST['telefono'] != '') {
    $Telefono = clean_input($_POST['telefono']);
  }

  // si se ha introducido un fichero
  if(count($_FILES)>0) {
      if($_FILES['imagen']['size'] < $config['MB_2']){
          if($_FILES['imagen']['type'] == "image/png" || $_FILES['imagen']['type'] == "image/jpeg" || $_FILES['imagen']['type'] == "image/jpg"){
              // Gestionamos la información del fichero
              $fichero_tmp = $_FILES["imagen"]["tmp_name"];
              $nombre_real = basename($_FILES["imagen"]["name"]);
              $ruta_destino = $config['img_path']."/".$nombre_real;
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
      $errores['dueño']=' Debe rellenar este campo';
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
  if(count($errores) == 0){
    $pass_encriptada= password_hash($contraseña, PASSWORD_DEFAULT);

    if ($mascota) {
      $insertarMascota = insertarMascota($nombre,$email,$pass_encriptada,$localidad,$cp,$Telefono,$nombre_real,$descripcion,$nombre_dueno);
      $id = '';
      if ($insertarMascota = 1) {
        insertarCoordenadas($email,$coordenadas);
        $mascota = MascotaManager::getByEmail($email);
        $id = $mascota['id'];
        moverArchivo($fichero_tmp, $ROOT.$ruta_destino,$id,$errores,'mascota');
        header("location: login.php");
        exit;
      }

    }

    if ($empresa) {
      $insertEmpresa =insertarEmpresa($email,$nombre,$pass_encriptada,$nombre_real,$localidad,$cp,$cif,$Telefono);
        $id = '';
        if ($insertEmpresa= 1) {
          $empresa= EmpresaManager::getByEmail($email);
          $id = $mascota['id'];
          moverArchivo($fichero_tmp, $ROOT.$ruta_destino,$id,$errores,'empresa');
          header("location: login.php");
          exit;
        }
    }

  }// no hay errores

}
/*******  Funciones    ****/
function moverArchivo($fichero_tmp, $destino,$id,$errores,$usuario){
  // si da error mover el fichero se borra
  if ($usuario == 'mascota') {
    if (!move_uploaded_file($fichero_tmp, $destino)) {
        $errores['moverFichero'] = "Error moviendo fichero";
        $borrado = MascotaManager::delete($id);
    }
  }else if($usuario == 'empresa'){
    if (!move_uploaded_file($fichero_tmp, $destino)) {
        $errores['moverFichero'] = "Error moviendo fichero";
        $borrado = EmpresaManager::delete($id);
    }
  }

}
function insertarMascota($nombre,$email,$pass_encriptada,$localidad,$cp,$Telefono,$nombre_real,$descripcion,$nombre_dueno){
  $insertado = MascotaManager::insert($nombre,$email,$pass_encriptada,$localidad,$cp,$Telefono,$nombre_real,$descripcion,$nombre_dueno);
  return $insertado;
}
function insertarEmpresa($email,$nombre,$pass_encriptada,$nombre_real,$localidad,$cp,$cif,$Telefono){
  $insertado =  EmpresaManager::insert($email,$nombre,$pass_encriptada,$nombre_real,$localidad,$cp,$cif,$Telefono);
  return $insertado;
}
 function insertarCoordenadas($email,$coordenadas){
     $mascota = MascotaManager::getByEmail($email);
     $id = $mascota['id'];
     CoordenadasManager::insert($id,$coordenadas[0],$coordenadas[1],$coordenadas[2]);
 }
?>
 <div class="fomulario_registro">

   <form class="formulario" action="procesadorDeRegitros.php" method="post" enctype="multipart/form-data">
     <h2>Rellena los campos</h2>

     <!-- NOMBRE-->
     <?php if (isset($errores['nombre'])): ?>
       <span class="error"><?=$errores['nombre'] ?></span> <br>
     <?php endif; ?>
     <p>
       <label for="">Nombre *</label>
       <input type="text" name="nombre" value=" <?= $nombre ?>">
     </p>

     <!-- EMAIL-->
     <?php if (isset($errores['email'])): ?>
       <span class="error"><?= $errores['email']?> </span> <br>
     <?php endif; ?>
      <p>
        <label for="">Email *</label>
         <input type="email" name="email" value="<?= $email ?>">
      </p>

      <!-- Password -->
     <?php if (isset($errores['pass'])): ?>
       <span class="error"><?=$errores['pass'] ?></span> <br><br>
     <?php endif; ?>
     <p>
       <label for="">Contraseña *</label>
       <input type="password" name="pass" value="<?=$contraseña?>">
     </p>

     <!-- Password verificacion-->
     <?php if (isset($errores['passVer'])): ?>
         <span class="error"><?= $errores['passVer']?> </span> <br><br>
     <?php endif; ?>
     <p>
        <label for="">Repita contraseña *</label>
        <input type="password" name="passVer" value="<?=$contraseña_V ?>">
     </p>

     <!-- Direccion-->
     <?php if (isset($errores['localidad'])): ?>
       <span class="error"><?=$errores['localidad'] ?></span> <br><br>
     <?php endif; ?>
     <p>
        <label for="">Direccion</label>
        <input type="text" name="localidad" value="<?= $localidad ?>">
     </p>

     <!-- Codigo postal-->
     <p>
       <label for="">Código Postal </label>
       <input type="number" name="cp" value="<?= $cp ?>">
     </p>

     <!-- Teléfono-->
     <p>
       <label for="">Teléfono</label>
       <input type="tel" name="telefono" value="<?= $Telefono ?>">
     </p>

     <!-- Foto-->
     <?php if (isset($errores['foto'])): ?>
          <span class="error"><?= $errores['foto']?> </span> <br><br>
     <?php endif; ?>
     <p>
        <label for="">Foto *</label>
        <input type="file" name="imagen" accept="image/png, image/jpeg">
     </p>


     <?php if ($empresa): ?>
       <!-- Cif-->
       <?php if (isset($errores['cif'])): ?>
         <span class="error"><?=$errores['cif'] ?></span> <br>
       <?php endif; ?>
       <p>
         <label for=""> CIF *</label>
         <input type="text" name="cif" value="<?= $cif ?>">
       </p>

     <?php endif; ?>

     <?php if ($mascota): ?>
       <!-- Dueño-->
       <?php if (isset($errores['dueño'])): ?>
         <span class="error"> <?= $errores['dueño'] ?></span> <br>
       <?php endif; ?>
       <p>
         <label for="">Nombre dueño *</label>
          <input type="text" name="dueño" value="<?= $nombre_dueno ?>">
       </p>

       <!-- descripción-->
       <?php if (isset($errores['descripcion'])): ?>
         <span class="error"><?=$errores['descripcion'] ?> </span> <br>
       <?php endif; ?>
       <p>
         <label for=""> Decripción *</label>
         <input type="textarea" name="descripcion" value="<?= $descripcion ?>">
       </p>

     <?php endif; ?>

      <p><label for=""></label>
        <input type="submit" name="enviar" value="Registrarme"></p>

    </form>
 </div>
