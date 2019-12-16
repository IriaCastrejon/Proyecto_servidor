<?php


  /*echo '<pre>';
  print_r($_POST);
  print_r($_COOKIE);
  echo '</pre>';*/

$tipo_cliente='';
$errores=[];
   // Esto se puede y debe sacar al config

  if (isset($_POST['tipo_cliente']) && ($_POST['cliente']== 'mascota' || $_POST['cliente']== 'empresa')) {
    setcookie('tipo_cliente',$_POST['cliente']);
    $tipo_cliente=$_POST['cliente'];
    header("location: procesadorDeRegitros.php");
    die();
  }else {
    $errores['cliente']='No es ua opción válida';
  }
 ?>

 <div class="fomulario_registro">

  <form class="registro_tipo_cliente" action="registro.php" method="post">
     <label for="" class="rad_cliente">Soy mascota <input type="radio" name="cliente" value="mascota" <?=($tipo_cliente== 'mascota')?'checked':'' ?> > </label>
     <label for="" class="rad_cliente">Soy empresa <input type="radio" name="cliente" value="empresa" <?=($tipo_cliente== 'empresa')?'checked':'' ?>> </label>
     <br> <br><input type="submit" name="tipo_cliente" value="Enviar">
    <?php if (isset($errores['cliente'])): ?>
      <span><?=$errores['cliente'] ?></span>
    <?php endif; ?>
  </form>
  <br><br>
  
</div>
