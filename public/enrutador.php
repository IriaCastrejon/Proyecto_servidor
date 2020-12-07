<?php

$ROOT = realpath(__DIR__."/..");
require_once("$ROOT/config/configuracion.php");

if (preg_match('/\.(?:css|js|ico|png|jpg|jpeg|gif)$/', $_SERVER["REQUEST_URI"])){

  if(startsWith($_SERVER["REQUEST_URI"], $config['img_in_url'])) {
      // Imagen subida por el usuario

      // Solo aceptamos PNG
      header('Content-Type: image/png');

      // Quitamos subir de directorio
      $file_path = str_replace("..","",$_SERVER["REQUEST_URI"]);
      // Quitamos el prefijo de la petición
      $file_path = str_replace($config['img_in_url'],"",$_SERVER["REQUEST_URI"]);
      // Cargamos el fichero y lo enviamos

      $file_path = $ROOT.$config['img_path'].urldecode($file_path);
      $mime_type = mime_content_type($file_path);
      header("Content-Type: $mime_type");
      readfile($file_path);

  } else {
      return false;    // servir la petición tal cual es.
  }

}else {

    // Requerir los ficheros necesarios
    require_once("$ROOT/src/db.php");

    // Enruto la petción
    $uri = $_SERVER['REQUEST_URI'];
    $partes = explode("?", $uri);

    $titulo = $config['title'];

    $fichero = $partes[0];


    if($fichero == "/"){
      header("Location: " . $config['pagina_inicio']);
      die();
    }

    // Aquí es dónde la magia ocurre
    // ver también resources/templates/template.php
    $ruta_contenido = str_replace("..", "", $fichero);

    require_once("$ROOT/resources/templates/template.php");

}

?>
