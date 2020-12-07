<?php
/*

Template base del proyecto para no repetir código
Son necesarias las variables
  $titulo
  $ruta_contenido

*/
?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title><?=$titulo?></title>
    <link rel="stylesheet" href="/css/master.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400&display=swap" rel="stylesheet">
  </head>
  <body>
    <?php
      require("$ROOT/resources/templates/header.php");
      require("$ROOT/resources/templates/navegacion.php");
     ?>
    <main class="contenedor">
      <?php      
          require("$ROOT/resources/templates/contenido$ruta_contenido");
       ?>
    </main>
    <?php
      require("$ROOT/resources/templates/pie.php");
    ?>
  </body>
</html>
