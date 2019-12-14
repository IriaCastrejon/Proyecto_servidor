<?php
/**
 *
 */
class Empresa extends Usuarios{
  private $cif;

  function __construct($id,$email, $contraseña,$foto = null,$localidad = null,$cp = null,$cif,$telefono= null) {

    parent:: __construct($id,$email, $contraseña,$foto = null,$localidad = null,$cp = null,$telefono= null);

    $this->cif=$cif;

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
