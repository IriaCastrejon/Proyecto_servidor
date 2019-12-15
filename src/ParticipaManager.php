<?php

class ParticipaManager implements IDWESEntidadManager{

  public static function getAll(){
    $db = DWESBaseDatos::obtenerInstancia();

    $db -> ejecuta("SELECT usuario_id, actividad_id
                        FROM participa");

    return array_map(function($fila){
      return new Participa($fila['usuario_id'], $fila['actividad_id']);
    }, $db -> obtenDatos());
  }


  public static function getById($id){
    $db = DWESBaseDatos::obtenerInstancia();

    $db -> ejecuta("SELECT usuario_id, actividad_id
                        FROM participa a WHERE usuario_id = ?");

    if($db -> executed ){ // Se pudo ejecutar
        $datos = $db -> obtenDatos($id);
        if(count($datos)>0) { // Hay datos
            $fila = $datos[0];
            return new Participa($fila['usuario_id'], $fila['actividad_id']);
        }
    }
    return null;
  }


  public static function insert(...$campos){
    $db= DWESBaseDatos::obtenerInstancia();
    if (count($campos)=== 2) {
        $db-> ejecuta("INSERT INTO participa(usuario_id,actividad_id) VALUES (?,?)",$campos);

    }
  }


  public static function update($id, ...$campos){

  }


  public static function delete(...$campos){
      $db= DWESBaseDatos::obtenerInstancia();
      if (count($campos)=== 2) {
        $db-> ejecuta("DELETE FROM participa WHERE usuario_id = ? AND actividad_id = ?",$campos);
      }
  }



}


?>
