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

    if($db -> executed ){ // Se pudo ejecutar
        $datos = $db -> obtenDatos();
        if(count($datos)>0) { // Hay datos
            $fila = $datos[0];
            return new Amigo($fila['usuario_id'], $fila['usuario_id2']);
        }
    }
    return null;
  }

  //SELECT * from usuario WHERE id=(SELECT id_usuaio)



  public static function obtenerAmigos($id){
    $db = DWESBaseDatos::obtenerInstancia();

    $db -> ejecuta("SELECT u.id, u.email, u.pass, u.nombre, u.foto_perfil, u.localidad, u.cp, u.telefono FROM usuario u WHERE id IN
      (SELECT a.usuario_id2 FROM amigos a WHERE a.usuario_id = ?) ", $id);



        return array_map(function($fila){
          return new Usuarios($fila['id'], $fila['email'], $fila['pass'],$fila['nombre'], $fila['foto_perfil'], $fila['localidad'], $fila['cp'], $fila['telefono']);
        },$db -> obtenDatos());




  }
}


 ?>
