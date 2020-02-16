<?php

class PublicacionesManager implements IDWESEntidadManager{

  public static function getAll(){
    $db = DWESBaseDatos::obtenerInstancia();

    $db -> ejecuta("SELECT id, usuario_id, imagen, texto, fecha
                        FROM publicacion");

    /*if($db -> executed ){ // Se pudo ejecutar
        $datos = $db -> obtenDatos($id);
        if(count($datos)>0) { // Hay datos
            $fila = $datos[0];
            return new Actividad($fila['id'], $fila['descripcion'], $fila['fecha'], $fila['n_participantes'], $fila['lugar']);
        }
    }*/
    return array_map(function($fila){
      return new Publicaciones($fila['id'], $fila['usuario_id'], $fila['imagen'],$fila['texto'],$fila['fecha']);
    }, $db -> obtenDatos());
  }


  public static function insert(...$campos){

    $insertado=false;

    $db= DWESBaseDatos::obtenerInstancia();

    if (count($campos)=== 3) {
        $db-> ejecuta("INSERT INTO publicacion(usuario_id,imagen,texto) VALUES (?,?,?)",$campos);
        $insertado=true;
    }
    return $insertado;
  }

  public static function update($id, ...$campos){
    //toDo
  }
  public static function delete($id){
    $db= DWESBaseDatos::obtenerInstancia();

    $db->ejecuta("DELETE FROM publicacion WHERE id =?",$id);

  }

  public static function getByIdDeMascota($id){
    $db = DWESBaseDatos::obtenerInstancia();

    $db -> ejecuta("SELECT id, usuario_id, imagen, texto, fecha
                        FROM publicacion  WHERE usuario_id = ?", $id);

    /*if($db -> executed ){ // Se pudo ejecutar
        $datos = $db -> obtenDatos($id);
        if(count($datos)>0) { // Hay datos
            $fila = $datos[0];
            return new Actividad($fila['id'], $fila['descripcion'], $fila['fecha'], $fila['n_participantes'], $fila['lugar']);
        }
    }*/
    return array_map(function($fila){
      return new Publicaciones($fila['id'], $fila['usuario_id'], $fila['imagen'], $fila['texto'],$fila['fecha']);
    }, $db -> obtenDatos());
  }

  public static function getById($id){
    $db = DWESBaseDatos::obtenerInstancia();

    $db -> ejecuta("SELECT id, usuario_id, imagen, texto, fecha
                        FROM publicacion  WHERE id = ?", $id);

    /*if($db -> executed ){ // Se pudo ejecutar
        $datos = $db -> obtenDatos($id);
        if(count($datos)>0) { // Hay datos
            $fila = $datos[0];
            return new Actividad($fila['id'], $fila['descripcion'], $fila['fecha'], $fila['n_participantes'], $fila['lugar']);
        }
    }*/
    return array_map(function($fila){
      return new Publicaciones($fila['id'], $fila['usuario_id'], $fila['imagen'], $fila['texto'],$fila['fecha']);
    }, $db -> obtenDatos());
  }

  public static function getAllPublicaciones($id)
  {
    $db = DWESBaseDatos::obtenerInstancia();

    $db -> ejecuta( "SELECT * FROM publicacion WHERE usuario_id = ? OR usuario_id IN(SELECT usuario_id2 FROM amigos WHERE usuario_id = ? ) ORDER BY fecha DESC", $id, $id);

    return array_map(function($fila){
      return new Publicaciones($fila['id'], $fila['usuario_id'], $fila['imagen'], $fila['texto'],$fila['fecha']);
    }, $db -> obtenDatos());
  }
}
 ?>
