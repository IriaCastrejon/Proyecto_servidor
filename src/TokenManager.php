<?php

class TokenManager implements IDWESEntidadManager{

  public static function getAll(){}
  public static function getById($id){}
  public static function update($id, ...$campos){}


  public static function getIdyTipo($token){
    $db = DWESBaseDatos::obtenerInstancia();

    $db -> ejecuta("SELECT usuario_id, tipo FROM usuario_token WHERE token = ?", $token);
    $fila = $db -> obtenDatos();
    return $fila[0];
  }
  public static function insert(...$campos){
    echo "dentro de insert";
    $db = DWESBaseDatos::obtenerInstancia();
    if (count($campos)=== 3) {

      echo "dentro de campos";
        $db-> ejecuta("INSERT INTO usuario_token (usuario_id, token, tipo) VALUES (?,?,?)",$campos);
    }
  }
  public static function delete(...$campos){
    echo "dentro de delete";
    $db = DWESBaseDatos::obtenerInstancia();
    if (count($campos)=== 2) {
      echo "dentro de campos";
      $db-> ejecuta("DELETE FROM usuario_token WHERE usuario_id = ? AND tipo = ?",$campos);
    }

  }
}