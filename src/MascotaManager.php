<?php

class MascotaManager implements IDWESEntidadManager{

  public static function getAll(){
    $db = DWESBaseDatos::obtenerInstancia();

    $db -> ejecuta("SELECT m.id, m.nombre, m.email, m.pass, m.localidad, m.cp, m.telefono, m.foto_perfil, m.descripcion, m.nombre_dueno
                        FROM usuario m");

    return array_map(function($fila){
      return new Mascota($fila['id'], $fila['nombre'], $fila['email'], $fila['pass'], $fila['localidad'],$fila['cp'],$fila['telefono'],$fila['foto_perfil'],$fila['descripcion'],$fila['nombre_dueno']);
    }, $db -> obtenDatos());
  }



  public static function insert(...$campos){
    $insertado = false;
    $db= DWESBaseDatos::obtenerInstancia();

    if (count($campos)=== 9) {
        $db-> ejecuta("INSERT INTO usuario(nombre,email,pass,localidad,cp,telefono,foto_perfil,descripcion,nombre_dueno) VALUES (?,?,?,?,?,?,?,?,?)",$campos);
        $insertado = true;
    }
    return $insertado;
  }

  public static function update($id, ...$campos){
    $db = DWESBaseDatos::obtenerInstancia();

    $db -> ejecuta("UPDATE usuario SET foto_perfil=?
                    WHERE id= $id", $campos);

  }
  public static function updatePass($id, ...$campos){
    $db = DWESBaseDatos::obtenerInstancia();

    $db -> ejecuta("UPDATE usuario SET pass=?
                    WHERE id= $id", $campos);

  }
  public static function delete($id){
    // toDo
  }
  public static function getByEmail($email){
    $db = DWESBaseDatos::obtenerInstancia();

    $db -> ejecuta("SELECT m.id, m.nombre, m.email, m.pass, m.localidad,m.cp, m.telefono, m.foto_perfil,m.descripcion, m.nombre_dueno
                        FROM usuario m WHERE email= ?", $email);
    return $db->obtenDatos()[0];
  }

  public static function existeEmail($email){
  //  echo 'dentro de existe email mascota  ' ;
    $db = DWESBaseDatos::obtenerInstancia();

    $db -> ejecuta("SELECT count(*) as cantidad
                        FROM usuario  WHERE email = ?", $email);
    $datos=  $db->obtenDatos();
    if ($datos[0]['cantidad'] > 0) {
      //echo 'true' .' es verdad';
      return true;
    }else{
      //echo 'false' .' no existe';
      return false;
    }

  }
  public static function buscar($dato){
    //echo 'dentro de buscar en mascota manager';
    $dato= "%".$dato."%";
    $db = DWESBaseDatos::obtenerInstancia();

    $db -> ejecuta("SELECT *
                        FROM usuario m WHERE m.nombre like ?", $dato);


    return array_map(function($fila){
      return new Usuarios($fila['id'], $fila['email'], $fila['pass'],$fila['nombre'], $fila['foto_perfil'], $fila['localidad'], $fila['cp'], $fila['telefono']);
    },$db -> obtenDatos());


  }
  public static function getById($id){
    $db = DWESBaseDatos::obtenerInstancia();

    $db -> ejecuta("SELECT m.id, m.email, m.pass, m.nombre,m.foto_perfil, m.localidad,m.cp, m.telefono,m.descripcion, m.nombre_dueno
                        FROM usuario m WHERE id = ?", $id);

    return array_map(function($fila){
      return new Mascota($fila['id'], $fila['email'], $fila['pass'], $fila['nombre'],$fila['foto_perfil'],$fila['localidad'],$fila['cp'],$fila['telefono'],$fila['descripcion'],$fila['nombre_dueno']);
    }, $db -> obtenDatos());
  }

}
 ?>
