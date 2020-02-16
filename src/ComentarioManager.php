<?php

class ComentarioManager implements IDWESEntidadManager{



  public static function getAllComentariosPublicacion(){
    $db = DWESBaseDatos::obtenerInstancia();

    $db -> ejecuta("SELECT *  FROM comentario_publicacion");

    return array_map(function($fila){
      return new Comentario($fila['id'], $fila['usuario_id'],$fila['publicacion_id'], $fila['texto']);
    }, $db -> obtenDatos());
  }

  public static function getAllComentariosActividad(){
    $db = DWESBaseDatos::obtenerInstancia();

    $db -> ejecuta("SELECT *  FROM comentario_actividad");

    return array_map(function($fila){
      return new Comentario($fila['id'], $fila['usuario_id'],$fila['actividad_id'], $fila['texto']);
    }, $db -> obtenDatos());
  }



  public static function getByIdComentarioPublicacion($id){
    $db = DWESBaseDatos::obtenerInstancia();

    $db -> ejecuta("SELECT *  FROM comentario_publicacion  WHERE id = ?", $id);


        $datos = $db -> obtenDatos();
        if(count($datos)>0) { // Hay datos
            $fila = $datos[0];
            return new Comentario($fila['id'], $fila['usuario_id'],$fila['publicacion_id'], $fila['texto']);
        }

    return null;
  }

  public static function getByIdComentariActividad($id){
    $db = DWESBaseDatos::obtenerInstancia();

    $db -> ejecuta("SELECT *  FROM comentario_actividad  WHERE id = ?", $id);


        $datos = $db -> obtenDatos();
        if(count($datos)>0) { // Hay datos
            $fila = $datos[0];
            return new Comentario($fila['id'], $fila['usuario_id'],$fila['actividad_id'], $fila['texto']);
        }

    return null;
  }



  public static function getAll(){}
  public static function getById($id){}
  public static function insert(...$campos){}
  public static function update($id, ...$campos){}
  public static function delete($id){}


}
 ?>
