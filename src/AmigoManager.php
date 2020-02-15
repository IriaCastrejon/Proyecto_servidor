<?php

class AmigoManager implements IDWESEntidadManager{

  public static function getAll(){
    $db = DWESBaseDatos::obtenerInstancia();

    $db -> ejecuta("SELECT a.usuario_id, a.usuario_id2 FROM amigos a");

    return array_map(function($fila){
      return new Amigo($fila['usuario_id'], $fila['usuario_id2']);
    }, $db -> obtenDatos());
  }


  public static function getById($id){
    $db = DWESBaseDatos::obtenerInstancia();

    $db -> ejecuta("SELECT a.usuario_id, a.usuario_id2
                        FROM amigos a WHERE usuario_id = ? ");

    if($db -> executed ()){ // Se pudo ejecutar
        $datos = $db -> obtenDatos();
        if(count($datos)>0) { // Hay datos
            $fila = $datos[0];
            return new Amigo($fila['usuario_id'], $fila['usuario_id2']);
        }
    }
    return null;
  }


  public static function compruebaAmistad(...$campos){
    $db = DWESBaseDatos::obtenerInstancia();

    $db -> ejecuta("SELECT count(*) as n FROM amigos a WHERE a.usuario_id = ? and a.usuario_id2= ?", $campos);
    $resultado = $db -> obtenDatos();
    return $resultado[0]['n'];
  }


  public static function obtenerAmigos($id){
    $db = DWESBaseDatos::obtenerInstancia();

    $db -> ejecuta("SELECT u.id, u.email, u.pass, u.nombre, u.foto_perfil, u.localidad, u.cp, u.telefono FROM usuario u WHERE id IN
      (SELECT a.usuario_id2 FROM amigos a WHERE a.usuario_id = ?) ", $id);

        return array_map(function($fila){
          return new Usuarios($fila['id'], $fila['email'], $fila['pass'],$fila['nombre'], $fila['foto_perfil'], $fila['localidad'], $fila['cp'], $fila['telefono']);
        },$db -> obtenDatos());

  }



  public static function obtenerSeguidores($id){
    $db = DWESBaseDatos::obtenerInstancia();

    $db -> ejecuta("SELECT u.id, u.email, u.pass, u.nombre, u.foto_perfil, u.localidad, u.cp, u.telefono FROM usuario u WHERE id IN
      (SELECT a.usuario_id FROM amigos a WHERE a.usuario_id2 = ?) ", $id);

        return array_map(function($fila){
          return new Usuarios($fila['id'], $fila['email'], $fila['pass'],$fila['nombre'], $fila['foto_perfil'], $fila['localidad'], $fila['cp'], $fila['telefono']);
        },$db -> obtenDatos());

  }


  public static function obtenerNoAmigos($id){
    $db = DWESBaseDatos::obtenerInstancia();

    $db -> ejecuta("SELECT u.id, u.email, u.pass, u.nombre, u.foto_perfil, u.localidad, u.cp, u.telefono FROM usuario u WHERE id NOT IN
      (SELECT a.usuario_id2 FROM amigos a WHERE a.usuario_id = ?) ", $id);

        return array_map(function($fila){
          return new Usuarios($fila['id'], $fila['email'], $fila['pass'],$fila['nombre'], $fila['foto_perfil'], $fila['localidad'], $fila['cp'], $fila['telefono']);
        },$db -> obtenDatos());

  }

  public static function insert(...$campos){
    $db= DWESBaseDatos::obtenerInstancia();
    if (count($campos)=== 2) {
        $db-> ejecuta("INSERT INTO amigos (usuario_id,usuario_id2) VALUES (?,?)",$campos);

    }
  }

  public static function delete(...$campos){
      $db= DWESBaseDatos::obtenerInstancia();
      if (count($campos)=== 2) {
        $db-> ejecuta("DELETE FROM amigos WHERE usuario_id = ? AND usuario_id2 = ?",$campos);
      }
  }



  public static function update($id, ...$campos){}


}


 ?>
