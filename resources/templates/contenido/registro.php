<?php


$tipo_cliente='';
$errores=[];
   // Esto se puede y debe sacar al config

  if (isset($_POST['tipo_cliente']) ) {
    if ( $_POST['cliente'] == 'mascota' || $_POST['cliente'] == 'empresa') {
      setcookie('tipo_cliente',$_POST['cliente']);
      $tipo_cliente=$_POST['cliente'];
      header("location: procesadorDeRegitros.php");
      die();
    }
  }
 ?>

 <div class="fomulario_registro">

  <form class="registro_tipo_cliente" action="registro.php" method="post">
    <p>
      <label for="soyMascota" class="rad_cliente"><input id="soyMascota" type="radio" name="cliente" value="mascota" <?=($tipo_cliente== 'mascota')?'checked':'' ?> > Soy mascota </label>
      <label for="soyCliente" class="rad_cliente"><input id="soyCliente" type="radio" name="cliente" value="empresa" <?=($tipo_cliente== 'empresa')?'checked':'' ?>>  Soy empresa </label>
    </p>

     <p>
       <label for=""></label>
       <input type="submit" name="tipo_cliente" value="Enviar">
     </p>
    <?php if (isset($errores['cliente'])): ?>
      <span><?=$errores['cliente'] ?></span>
    <?php endif; ?>
  </form>
  <br><br>

</div>
