<?php
session_start();


  if($_SESSION['tipo_cliente'] == 'mascota'){ ?>

    <nav class="menu">
      <a href="actividades.php">actividades</a>
      <a href="nuevaActividad.php">Nueva Actividad</a>
      <a href="amigos.php">amigos</a>
      <a href="perfil.php">Mi perfil</a>
      <a href="logout.php">Logout</a>
    </nav>

  <?php }else{ ?>

    <nav class="menu">
      <a href="anuncio.php">anuncio</a>
      <a href="anuncioNuevo.php">Anuncio NUEVO</a>
      <a href="inicioEmpresario.php">Perfil empresario</a>
      <a href="logout.php">Logout</a>
    </nav>

  <?php } ?>
