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
                        FROM amigos a WHERE usuario_id = ?");

    if($db -> executed ){ // Se pudo ejecutar
        $datos = $db -> obtenDatos($id);
        if(count($datos)>0) { // Hay datos
            $fila = $datos[0];
            return new Amigo($fila['usuario_id'], $fila['usuario_id2']);
        }
    }
    return null;
  }

  //SELECT * from usuario WHERE id=(SELECT id_usuaio)


}


 ?>
