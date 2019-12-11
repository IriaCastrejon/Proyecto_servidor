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


  public static function getById($id){
    $db = DWESBaseDatos::obtenerInstancia();

    $db -> ejecuta("SELECT m.id, m.nombre, m.email, m.pass, m.localidad,m.cp, m.telefono, m.foto_perfil,m.descripcion, m.nombre_dueno
                        FROM usuario m WHERE id = ?", $id);

    /*if($db -> executed ){ // Se pudo ejecutar
        $datos = $db -> obtenDatos($id);
        if(count($datos)>0) { // Hay datos
            $fila = $datos[0];
            return new Actividad($fila['id'], $fila['descripcion'], $fila['fecha'], $fila['n_participantes'], $fila['lugar']);
        }
    }*/
    return $db->obtenDatos()[0]['id'];
  }

  public static function insert(...$campos){
    echo '<br> dentro del insert ';
    $insertado=false;

    $db= DWESBaseDatos::obtenerInstancia();

    if (count($campos)=== 9) {
        $db-> ejecuta("INSERT INTO usuario(nombre,email,pass,localidad,cp,telefono,foto_perfil,descripcion,nombre_dueno) VALUES (?,?,?,?,?,?,?,?,?)",$campos);
        $insertado=true;
    }
    return $insertado;
  }

  public static function update($id, ...$campos){
    //toDo
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



}
 ?>
