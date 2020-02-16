<?php

class ComentarioManager implements IDWESEntidadManager{



  public static function getAllComentariosPublicacion($id){
    $db = DWESBaseDatos::obtenerInstancia();

    $db -> ejecuta("SELECT * FROM comentario_publicacion WHERE publicacion_id = ?",$id);

    return array_map(function($fila){
      return new Comentario($fila['id'], $fila['usuario_id'],$fila['publicacion_id'], $fila['texto']);
    }, $db -> obtenDatos());
  }

  public static function getAllComentariosActividad(){
    $db = DWESBaseDatos::obtenerInstancia();

    $db -> ejecuta("SELECT *  FROM comentario_actividad  WHERE actividad_id = ?",$id);

    return array_map(function($fila){
      return new Comentario($fila['id'], $fila['usuario_id'],$fila['actividad_id'], $fila['texto']);
    }, $db -> obtenDatos());
  }



  public static function getByIdComentarioPublicacion($id){
    $db = DWESBaseDatos::obtenerInstancia();

    $db -> ejecuta("SELECT *  FROM comentario_publicacion  WHERE publicacion_id = ?", $id);


        $datos = $db -> obtenDatos();
        if(count($datos)>0) { // Hay datos
            $fila = $datos[0];
            return new Comentario($fila['id'], $fila['usuario_id'],$fila['publicacion_id'], $fila['texto']);
        }

    return null;
  }

  public static function getByIdComentariActividad($id){
    $db = DWESBaseDatos::obtenerInstancia();

    $db -> ejecuta("SELECT *  FROM comentario_actividad  WHERE actividad_id = ?", $id);


        $datos = $db -> obtenDatos();
        if(count($datos)>0) { // Hay datos
            $fila = $datos[0];
            return new Comentario($fila['id'], $fila['usuario_id'],$fila['actividad_id'], $fila['texto']);
        }

    return null;
  }

public static function insertComentariosPublicacion(...$campos){
  $db= DWESBaseDatos::obtenerInstancia();

  if (count($campos)=== 3 ) {
      $db-> ejecuta("INSERT INTO comentario_publicacion(usuario_id,publicacion_id,texto) VALUES (?,?,?)",$campos);

  }
}
public static function insertComentariosActividad(...$campos){
  $db= DWESBaseDatos::obtenerInstancia();

  if (count($campos)=== 3 ) {
      $db-> ejecuta("INSERT INTO comentario_actividad(usuario_id,actividad_id,texto) VALUES (?,?,?)",$campos);

  }
}
public static function deleteComentariosPublicacion($id){
  $db= DWESBaseDatos::obtenerInstancia();

  $db->ejecuta("DELETE FROM comentario_publicacion WHERE id =?",$id);

}
public static function deleteComentariosActividad($id){
  $db= DWESBaseDatos::obtenerInstancia();

  $db->ejecuta("DELETE FROM comentario_actividad WHERE id =?",$id);
}


  public static function getAll(){}
  public static function getById($id){}
  public static function insert(...$campos){}
  public static function update($id, ...$campos){}
  public static function delete($id){}


}
 ?>
