<?php
// $puede_pintar=false;
$id='';
$tipo_cliente='';
$contraseña='';
$contraseña_V='';
$errores=[];
//get
if (isset($_GET['token']) && isset($_GET['cliente'])) {

    $token=clean_input($_GET['token']);
    $cliente=clean_input($_GET['cliente']);

    $resultado_token = TokenManager::getIdyTipo($token);
    $id=$resultado_token['usuario_id'];
    $tipo_cliente=$resultado_token['tipo'];

    if($tipo_cliente===$cliente){
      // $puede_pintar=true;
    }else{
      header("location: enviarCorreo.php");
      die();
    }
}
if ($_POST['enviar']==='Cambiar') {

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
    $errores['passVer']= 'Introduce la verificación de la contraseña';
  }
  if (count($errores)==0) {
    $id=$_POST['id'];
    $tipo_cliente=$_POST['cliente'];
    $pass_encriptada= password_hash($contraseña, PASSWORD_DEFAULT);
    if ($tipo_cliente=='mascota') {
      MascotaManager::updatePass($id,$pass_encriptada);
    }
    if ($tipo_cliente=='empresa') {
      EmpresaManager::updatePass($id,$pass_encriptada);
    }
    header("location: login.php");
    die();
  }
}
 ?>


  <div class="formCambiarPass">
    <h1>Introduce la nueva contraseña </h1>
    <form class="recuperarPass" action="cambiarContrasena.php" method="post">
      <!-- ocultos -->
      <input type="hidden" name="id" value="<?=$id?>">
      <input type="hidden" name="cliente" value="<?=$tipo_cliente?>">

      <?php if (isset($errores['pass'])): ?>
        <span class="error"><?=$errores['pass'] ?></span> <br><br>
      <?php endif; ?>
      <label for="">Contraseña</label><input type="password" name="pass" value="<?=$contraseña ?>"><br><br>

      <?php if (isset($errores['passVer'])): ?>
          <span class="error"><?= $errores['passVer']?> </span> <br><br>
      <?php endif; ?>
      <label for="">Repita contraseña</label><input type="password" name="passVer" value="<?=$contraseña_V ?>"><br><br>
      <input type="submit" name="enviar" value="Cambiar">
    </form>
  </div>
