<?php
 class CoordenadasManager implements IDWESEntidadManager{

   public static function getAll(){
     $db = DWESBaseDatos::obtenerInstancia();

     $db -> ejecuta("SELECT c.id, c.usuario_id, c.longitud, c.latitud, c.direccion FROM coordenadas c");

     return array_map(function($fila){
       return new Coordenadas($fila['id'],$fila['usuario_id'], $fila['longitud'],$fila['latitud'],$fila['direccion']);
     }, $db -> obtenDatos());
   }

   public static function insert(...$campos){
     echo '<br> dentro del insert coordenadas';
     $insertado=false;

     $db= DWESBaseDatos::obtenerInstancia();

     if (count($campos)=== 4) {
         $db-> ejecuta("INSERT INTO coordenadas(usuario_id,longitud,latitud,direccion) VALUES (?,?,?,?)",$campos);
         $insertado=true;
     }
     echo $insertado;
     return $insertado;
   }

   public static function getCordenadasByUsuarioID($usuarioId){
     $db = DWESBaseDatos::obtenerInstancia();

     $db -> ejecuta("SELECT c.id, c.usuario_id, c.longitud, c.latitud, c.direccion
                    FROM coordenadas c WHERE usuario_id= ?", $usuarioId);
                    return array_map(function($fila){
      return new Coordenadas($fila['id'],$fila['usuario_id'], $fila['longitud'],$fila['latitud'],$fila['direccion']);
      }, $db -> obtenDatos());
   }

   public static function getCercanos($lat, $long,$id){
     $db = DWESBaseDatos::obtenerInstancia();

     $db -> ejecuta("SELECT c.usuario_id, (acos(sin(radians($lat)) * sin(radians(c.latitud)) +
                 cos(radians($lat)) * cos(radians(c.latitud)) *
                 cos(radians($long) - radians(c.longitud))) * 6378) as
                 distanciaKilometros , c.direccion from coordenadas c where c.id != $id;" );
      return $db -> obtenDatos();
   }
   public static function getById($id){}
   public static function update($id, ...$campos){}

 }
 ?>
