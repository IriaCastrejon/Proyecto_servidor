<?php
 session_start();

$_SESSION['buscar']='';
  if($_SESSION['tipo_cliente'] == 'mascota'){ ?>

    <nav class="menu">
      <a href="inicio.php">Inicio</a>
      <a href="actividades.php">Mis actividades</a>
      <a href="amigos.php">Mis Amigos</a>
      <a href="perfil.php?idUsuario=<?=$_SESSION['id']?>">Mi perfil</a>

      <form class="" action="buscarAmigos.php" method="get" >
        <input type="text" name="busca" value="<?= $_SESSION['buscar']?>" placeholder="Buscar nuevos amigos">
        <input type="submit" name="enviar" value="Buscar">
      </form>
      <a href="logout.php">Logout</a>

    </nav>

  <?php }else if ($_SESSION['tipo_cliente'] == 'empresa'){ ?>

    <nav class="menu">
      <a href="anuncio.php">Mis anuncios</a>
      <a href="anuncioNuevo.php">Anuncio NUEVO</a>
      <a href="inicioEmpresario.php">Perfil empresario</a>
      <a href="logout.php">Logout</a>
    </nav>

  <?php }else{ ?>

    <nav class="menu">
    </nav>

  <?php } ?>
