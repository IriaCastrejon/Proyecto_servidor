<?php

class EmpresaManager implements IDWESEntidadManager{

  public static function getAll(){
    $db = DWESBaseDatos::obtenerInstancia();

    $db -> ejecuta("SELECT c.id, c.email, c.pass, c.foto, c.localidad, c.cp, c.cif, c.telefono
                        FROM cliente c");

    return array_map(function($fila){
      return new Empresa($fila['id'], $fila['email'], $fila['pass'], $fila['foto'], $fila['localidad'],$fila['cp'],$fila['cif'],$fila['telefono']);
    }, $db -> obtenDatos());
  }


  public static function getById($id){
    $db = DWESBaseDatos::obtenerInstancia();

    $db -> ejecuta("SELECT c.id, c.email, c.pass, c.foto, c.localidad, c.cp, c.cif, c.telefono
                        FROM cliente c WHERE id = ?", $id);

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
    echo '<br> dentro del insert de cliente';
    $insertado=false;

    $db= DWESBaseDatos::obtenerInstancia();

    if (count($campos)=== 7) {
        $db-> ejecuta("INSERT INTO cliente(email,pass,foto,localidad,cp,cif,telefono) VALUES (?,?,?,?,?,?,?)",$campos);
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

    $db -> ejecuta("SELECT c.id, c.email, c.pass, c.foto, c.localidad, c.cp, c.cif, c.telefono
                        FROM cliente c WHERE email = ?", $email);
    return $db->obtenDatos()[0];
  }

  public static function existeEmail($email){
    $db = DWESBaseDatos::obtenerInstancia();

    $db -> ejecuta("SELECT count(*)
                        FROM cliente c WHERE email = ?", $email);
    if ($db->obtenDatos()[0] ==0) {
      return true;
    }else{
      return false;
    }

  }

}
 ?>
