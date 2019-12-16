<?php
/**
 *
 */
class Mascota extends Usuarios{
     private $descripcion;
     private $nombre_dueno;

  function __construct($id, $nombre, $email, $contraseña,$localidad = null,$cp = null,$telefono= null,$foto = null,$descripcion,$nombre_dueno) {

    parent:: __construct($id, $nombre, $email, $contraseña,$localidad,$cp,$telefono,$foto);
    $this->descripcion=$descripcion;
    $this->nombre_dueno=$nombre_dueno;

  }



  public function getDescripcion()
  {
      return $this->descripcion;
  }


  public function setDescripcion($descripcion)
  {
      $this->descripcion = $descripcion;

      return $this;
  }


  public function getNombre_dueno()
  {
      return $this->nombre_dueno;
  }


  public function setNombre_dueno($nombre_dueno)
  {
      $this->nombre_dueno = $nombre_dueno;

      return $this;
  }



}// clase



 ?>
