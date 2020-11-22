<?php session_start(); ?>
<h3>Acceso no autorizado</h3>
<?php
if($_SESSION['tipo_cliente'] == 'mascota'){ ?>

  <a href="perfil.php">Volver a mi perfil</a>
<?php }else{ ?>

  <a href="inicioEmpresario.php">Volver a mi perfil</a>

<?php } ?>
