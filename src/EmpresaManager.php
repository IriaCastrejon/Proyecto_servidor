<?php

class EmpresaManager implements IDWESEntidadManager{

  public static function getAll(){
    $db = DWESBaseDatos::obtenerInstancia();

    $db -> ejecuta("SELECT c.id, c.nombre, c.email, c.pass, c.foto, c.localidad, c.cp, c.cif, c.telefono
                        FROM cliente c");

    return array_map(function($fila){
      return new Empresa($fila['id'], $fila['nombre'], $fila['email'], $fila['pass'], $fila['foto'], $fila['localidad'],$fila['cp'],$fila['cif'],$fila['telefono']);
    }, $db -> obtenDatos());
  }


  public static function getById($id){
    $db = DWESBaseDatos::obtenerInstancia();

    $db -> ejecuta("SELECT c.id, c.nombre, c.email, c.pass, c.foto, c.localidad, c.cp, c.cif, c.telefono
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
    echo "<pre>";
    echo print_r($campos);
    echo "</pre>";
    if (count($campos)=== 8) {
        $db-> ejecuta("INSERT INTO cliente(email,nombre,pass,foto,localidad,cp,cif,telefono) VALUES (?,?,?,?,?,?,?,?)",$campos);
        $insertado=true;
    }
    return $insertado;
  }

  public static function update($id, ...$campos){
    $db = DWESBaseDatos::obtenerInstancia();

    $db -> ejecuta("UPDATE cliente SET foto=?
                    WHERE id= $id", $campos);
  }
  public static function updatePass($id, ...$campos){
    $db = DWESBaseDatos::obtenerInstancia();

    $db -> ejecuta("UPDATE cliente SET pass=?
                    WHERE id= $id", $campos);

  }
  public static function delete($id){
    // toDo
  }
  public static function getByEmail($email){
    $db = DWESBaseDatos::obtenerInstancia();

    $db -> ejecuta("SELECT c.id, c.nombre, c.email, c.pass, c.foto, c.localidad, c.cp, c.cif, c.telefono
                        FROM cliente c WHERE email = ?", $email);
    return $db->obtenDatos()[0];
  }

  public static function existeEmail($email){
    //echo 'dentro de existe email empresa   ';
    $db = DWESBaseDatos::obtenerInstancia();

    $db -> ejecuta("SELECT count(*) as cantidad
                        FROM cliente c WHERE email = ?", $email);

    $datos=  $db->obtenDatos();
    if ($datos[0]['cantidad'] > 0) {
      //  echo 'true' .' es verdad';
      return true;
    }else{
      //  echo 'false' .' no existe';
      return false;
    }
  }//existeEmail

  public static function getAllById($id){
    $db = DWESBaseDatos::obtenerInstancia();

    $db -> ejecuta("SELECT c.id, c.nombre,c.email, c.pass, c.foto, c.localidad, c.cp, c.cif, c.telefono
                        FROM cliente c WHERE id = ?", $id);

    /*if($db -> executed ){ // Se pudo ejecutar
        $datos = $db -> obtenDatos($id);
        if(count($datos)>0) { // Hay datos
            $fila = $datos[0];
            return new Actividad($fila['id'], $fila['descripcion'], $fila['fecha'], $fila['n_participantes'], $fila['lugar']);
        }
    }*/
    return array_map(function($fila){
      return new Usuarios($fila['id'], $fila['email'], $fila['pass'],$fila['nombre'],$fila['foto'],$fila['localidad'],$fila['cp'],$fila['telefono']);
    }, $db -> obtenDatos());
    return $db->obtenDatos();
  }

}
 ?>
