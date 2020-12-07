<?php

class AnuncioManager implements IDWESEntidadManager{

  public static function getAll(){
    $db = DWESBaseDatos::obtenerInstancia();

    $db -> ejecuta("SELECT * FROM anuncio");

    return array_map(function($fila){
      return new Anuncio($fila['id'], $fila['cliente_id'], $fila['imagen'], $fila['fecha_alta'], $fila['fecha_baja'], $fila['url'],$fila['costo']);
    }, $db -> obtenDatos());
  }


  public static function getById($id){
    $db = DWESBaseDatos::obtenerInstancia();

    $db -> ejecuta("SELECT a.id, a.cliente_id, a.imagen, a.fecha_alta, a.fecha_baja, a.url, a.costo
                        FROM anuncio a WHERE id = ?");

    if($db -> executed ){ // Se pudo ejecutar
        $datos = $db -> obtenDatos($id);
        if(count($datos)>0) { // Hay datos
            $fila = $datos[0];
            return new Anuncio($fila['id'], $fila['cliente_id'], $fila['imagen'], $fila['fecha_alta'], $fila['fecha_baja'], $fila['url'],$fila['costo']);
        }
    }
    return null;
  }

  public static function insert(...$campos){
    echo '<br> dentro del insert <br>';

    $insertado=false;

    $db= DWESBaseDatos::obtenerInstancia();

    if (count($campos)=== 6) {
        $db-> ejecuta("INSERT INTO anuncio(cliente_id, imagen,fecha_alta, fecha_baja, url, costo) VALUES (?,?,?,?,?,?)",$campos);
        $insertado=true;
    }
    return $insertado;
  }

  public static function obtenerAnuncioPorIdCliente($id){
    $db = DWESBaseDatos::obtenerInstancia();

    $db -> ejecuta("SELECT a.id, a.imagen, a.fecha_alta, a.fecha_baja, a.url, a.costo
                    FROM anuncio a
                    WHERE cliente_id = ?",$id);

            return array_map(function($fila){
                return new Anuncio($fila['id'],$fila['id_cliente'], $fila['imagen'], $fila['fecha_alta'], $fila['fecha_baja'], $fila['url'],$fila['costo']);
            },$db -> obtenDatos());
  }

  public static function update($id, ...$campos){}
  public static function delete($id){}

}
 ?>
