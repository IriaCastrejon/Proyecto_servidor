<?php

class MegustaManager implements IDWESEntidadManager{

  public static function contadorMegustas($id_publicacion){
    $db = DWESBaseDatos::obtenerInstancia();

    $db -> ejecuta("SELECT count(*) as nMeGusta FROM megusta WHERE publicacion_id = ?", $id_publicacion);

    $resultado = $db -> obtenDatos();

    return $resultado[0]['nMeGusta'];

  }

  public static function verificarMeGusta(...$campos){
    $db = DWESBaseDatos::obtenerInstancia();

    $db -> ejecuta("SELECT count(*) as nMeGusta FROM megusta WHERE usuario_id = ? AND publicacion_id = ?", $campos);

    $resultado = $db -> obtenDatos();


    return $resultado[0]['nMeGusta'];

  }

  public static function insert(...$campos){
    $db= DWESBaseDatos::obtenerInstancia();
    if (count($campos)=== 2) {
        $db-> ejecuta("INSERT INTO megusta (usuario_id,publicacion_id) VALUES (?,?)",$campos);

    }
  }

  public static function delete(...$campos){
    $db= DWESBaseDatos::obtenerInstancia();
    if (count($campos)=== 2) {
      $db-> ejecuta("DELETE FROM megusta WHERE usuario_id = ? AND publicacion_id = ?",$campos);
    }
  }

  public static function update($id, ...$campos){}
  public static function getAll(){}
  public static function getById($id){}


}


?>
