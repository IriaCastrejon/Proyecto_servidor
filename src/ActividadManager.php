<?php

class ActividadManager implements IDWESEntidadManager{

  public static function getAll(){
    $db = DWESBaseDatos::obtenerInstancia();

    $db -> ejecuta("SELECT a.id, a.descripcion, a.fecha, a.n_participantes, a.lugar
                        FROM actividad a");

    return array_map(function($fila){
      return new Actividad($fila['id'], $fila['descripcion'], $fila['fecha'], $fila['n_participantes'], $fila['lugar']);
    }, $db -> obtenDatos());
  }


  public static function getById($id){
    $db = DWESBaseDatos::obtenerInstancia();

    $db -> ejecuta("SELECT a.id, a.descripcion, a.fecha, a.n_participantes, a.lugar
                        FROM actividad a WHERE id = ?");

    if($db -> executed ){ // Se pudo ejecutar
        $datos = $db -> obtenDatos($id);
        if(count($datos)>0) { // Hay datos
            $fila = $datos[0];
            return new Actividad($fila['id'], $fila['descripcion'], $fila['fecha'], $fila['n_participantes'], $fila['lugar']);
        }
    }
    return null;
  }





  public static function obtenerActividadPorIdParticipante($id){
    $db = DWESBaseDatos::obtenerInstancia();
    $parametros = [$id];
    $db -> ejecuta("SELECT a.id, a.descripcion, a.fecha, a.n_participantes, a.lugar FROM actividad a WHERE id in
      (SELECT p.actividad_id FROM participa p WHERE usuario_id = ? )",$parametros);

//    if($db -> executed ){ // Se pudo ejecutar
//        $datos = $db -> obtenDatos();
//        if(count($datos)>0) { // Hay datos
            return array_map(function($fila){
                return new Actividad($fila['id'], $fila['descripcion'], $fila['fecha'], $fila['n_participantes'], $fila['lugar']);
              },$db -> obtenDatos());
//        }
//    }
//    return null;
  }


}
 ?>
