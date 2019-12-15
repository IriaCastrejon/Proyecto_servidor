<?php

class ActividadManager implements IDWESEntidadManager{

  public static function getAll(){
    $db = DWESBaseDatos::obtenerInstancia();

    $db -> ejecuta("SELECT id, descripcion, fecha, lugar, nombre
                        FROM actividad ");

    return array_map(function($fila){
      return new Actividad($fila['id'], $fila['nombre'],$fila['descripcion'], $fila['fecha'], $fila['lugar']);
    }, $db -> obtenDatos());
  }


  public static function getById($id){
    $db = DWESBaseDatos::obtenerInstancia();

    $db -> ejecuta("SELECT id, nombre,descripcion, fecha, lugar
                        FROM actividad  WHERE id = ?", $id);


        $datos = $db -> obtenDatos();
        if(count($datos)>0) { // Hay datos
            $fila = $datos[0];
            return new Actividad($fila['id'], $fila['nombre'], $fila['descripcion'], $fila['fecha'],$fila['lugar']);
        }

    return null;
  }

  public static function insert(...$campos){
    echo '<br> dentro del insert ';
    $insertado=false;

    $db= DWESBaseDatos::obtenerInstancia();

    if (count($campos)=== 4 ) {
        $db-> ejecuta("INSERT INTO actividad(nombre,descripcion,fecha,lugar) VALUES (?,?,?,?)",$campos);
        $insertado=true;
    }
    return $insertado;
  }



  public static function obtenerActividadPorIdParticipante($id){
    $db = DWESBaseDatos::obtenerInstancia();

    $db -> ejecuta("SELECT a.id,a.nombre, a.descripcion, a.fecha, a.lugar FROM actividad a WHERE id in
      (SELECT p.actividad_id FROM participa p WHERE usuario_id = ? )",$id);


            return array_map(function($fila){
                return new Actividad($fila['id'], $fila['nombre'], $fila['descripcion'], $fila['fecha'], $fila['lugar']);
              },$db -> obtenDatos());

  }

  public static function numeroParticipantes($id){
    $db = DWESBaseDatos::obtenerInstancia();

    $db -> ejecuta("SELECT count(*) as nParticipantes FROM participa WHERE actividad_id = ? GROUP BY actividad_id",$id);
    $resultado = $db -> obtenDatos();
    return $resultado[0]['nParticipantes'];

  }


  public static function obtenerActividadNoParticipa($id){
    $db = DWESBaseDatos::obtenerInstancia();

    $db -> ejecuta("SELECT a.id,a.nombre, a.descripcion, a.fecha, a.lugar FROM actividad a WHERE id not in
      (SELECT p.actividad_id FROM participa p WHERE usuario_id = ? )",$id);


            return array_map(function($fila){
                return new Actividad($fila['id'], $fila['nombre'], $fila['descripcion'], $fila['fecha'], $fila['lugar']);
              },$db -> obtenDatos());

  }


  public static function update($id, ...$campos){}
  public static function delete($id){}


}
 ?>
