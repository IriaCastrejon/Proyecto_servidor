<?php
session_start();

$_SESSION['buscar']='';
  if($_SESSION['tipo_cliente'] == 'mascota'){ ?>

    <nav class="menu">
      <a href="inicio.php">Inicio</a>
      <a href="actividades.php">Mis actividades</a>
      <a href="amigos.php">Mis Amigos</a>
      <!-- <a href="cercaDeMi.php">Cerca de mi</a> -->
      <form action="cercaDeMi.php" name="enviarDistancias" method="get">
        <select class="distancias" id="distancia" name="distancias">
          <option value="1">Buscar a 1Km</option>
          <option value="2">Buscar a  2Km</option>
          <option value="5">Buscar a 5Km</option>
          <option value="10">Buscar a 10Km</option>
          <option value="20">Buscar a 20Km</option>
          <option value="50">Buscar a 50Km</option>
        </select>
        <input type="hidden" id="kmsInput" name="kilometros" value="">
      </form>
      <a href="perfil.php?idUsuario=<?=$_SESSION['id']?>">Mi perfil</a>
      <form class="" action="buscarAmigos.php" method="get" >
        <input type="text" name="busca" value="<?= $_SESSION['buscar']?>" placeholder="Buscar nuevos amigos">
        <input type="submit" name="enviar" value="Buscar">
      </form>
      <a href="logout.php">Logout</a>
    </nav>
    <script src="/js/distancia.js"></script>
  <?php }else if ($_SESSION['tipo_cliente'] == 'empresa'){ ?>

    <nav class="menu">
      <a href="anuncio.php">Mis anuncios</a>
      <a href="anuncioNuevo.php">Nuevo anuncio</a>
      <a href="inicioEmpresario.php">Perfil</a>
      <a href="logout.php">Logout</a>
    </nav>

  <?php }else{ ?>
    <nav class="menu">
    </nav>
  <?php } ?>
