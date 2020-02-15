<?php

class MegustaManager implements IDWESEntidadManager{

  public static function verificarMegustas($id_usuario, $id_publicacion){
    $db = DWESBaseDatos::obtenerInstancia();

    $db -> ejecuta("SELECT count(*)
                        FROM megusta WHERE usuario_id = ? and publicacion_id= ?");

    if($db -> executed ){ // Se pudo ejecutar
        $datos = $db -> obtenDatos();
        if (datos===0) {
          return false;
        }else{
          return true;
        }
    }
    return null;
  }
  public static function contadorMegustas($id_publicacion){
    $db = DWESBaseDatos::obtenerInstancia();

    $db -> ejecuta("SELECT count(*)
                        FROM megusta WHERE publicacion_id= ?");

    if($db -> executed ){ // Se pudo ejecutar
        $datos = $db -> obtenDatos();

        return $datos;
    }
    return null;
  }

  public static function insert(...$campos){
    $db= DWESBaseDatos::obtenerInstancia();
    if (count($campos)=== 2) {
        $db-> ejecuta("INSERT INTO megusta(usuario_id,publicacion_id) VALUES (?,?)",$campos);

    }
  }


  public static function update($id, ...$campos){

  }


  public static function delete(...$campos){
      $db= DWESBaseDatos::obtenerInstancia();
      if (count($campos)=== 2) {
        $db-> ejecuta("DELETE FROM megusta WHERE usuario_id = ? AND publicacion_id = ?",$campos);
      }
  }

  public static function getAll(){

  }
  public static function getById($id){
    
  }

}


?>
