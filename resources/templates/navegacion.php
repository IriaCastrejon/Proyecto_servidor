<?php
session_start();

$_SESSION['buscar']='';
  if($_SESSION['tipo_cliente'] == 'mascota'){ ?>

    <nav class="menu">
      <ul>
        <li> <a href="inicio.php">Inicio</a></li>
        <li> <a href="actividades.php">Mis actividades</a></li>
        <li> <a href="amigos.php">Mis Amigos</a></li>
        <li>
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
        </li>
        <li>  <a href="perfil.php?idUsuario=<?=$_SESSION['id']?>">Mi perfil</a></li>
        <li>
          <form class="" action="buscarAmigos.php" method="get" >
            <input type="text" name="busca" value="<?= $_SESSION['buscar']?>" placeholder="Buscar nuevos amigos">
            <input type="submit" name="enviar" value="Buscar">
          </form>
        </li>
        <li class="logout">  <a href="logout.php">Logout</a></li>
      </ul>
    </nav>
    <script src="/js/distancia.js"></script>
  <?php }else if ($_SESSION['tipo_cliente'] == 'empresa'){ ?>

    <nav class="menu">
      <ul>
        <li>  <a href="anuncio.php">Mis anuncios</a></li>
        <li>  <a href="anuncioNuevo.php">Nuevo anuncio</a></li>
        <li>  <a href="inicioEmpresario.php">Perfil</a></li>
        <li class="logout">  <a href="logout.php">Logout</a></li>
      </ul>
    </nav>

  <?php }else{ ?>
    <nav class="menu">
    </nav>
  <?php } ?>
