<?php
/**
 *
 */
class Empresa extends Usuarios{
     private $denominacion_social;
     private $cif;

  function __construct($id, $nombre, $email, $contraseña,$localidad = null,$cp = null,$telefono= null,$foto = null,$denominacion_social,$cif) {

    parent:: __construct($id, $nombre, $email, $contraseña,$localidad = null,$cp = null,$telefono= null,$foto = null);
    $this->denominacion_social=$denominacion_social;
    $this->cif=$cif;

  }



  public function getDenominacion_social()
  {
      return $this->denominacion_social;
  }


  public function setDenominacion_social($denominacion_social)
  {
      $this->denominacion_social = $denominacion_social;

      return $this;
  }


  public function getCif()
  {
      return $this->cif;
  }


  public function setCif($cif)
  {
      $this->cif = $cif;

      return $this;
  }



}// clase
