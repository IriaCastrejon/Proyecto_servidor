<?php
/**
 *
 */
class Publicaciones{
     private $id;
     private $id_usuario;
     private $imagen;
     private $texto;
     private $fecha;
     private $comentarios;

    function __construct($id, $id_usuario, $imagen, $texto,$fecha) {
      $this->id= $id;
      $this->id_usuario= $id_usuario;
      $this->imagen= $imagen;
      $this->texto= $texto;
      $this->fecha= $fecha;

    }
    public function getFecha() {
        return $this->fecha;
    }

    public function setFecha($fecha){
        $this->fecha = $fecha;
        return $this;
    }
    public function getTexto() {
        return $this->texto;
    }

    public function setTexto($texto){
        $this->texto = $texto;
        return $this;
    }

    public function getImagen() {
        global $config;
        return $config['img_in_url'] . "/". $this->imagen;

    }


    public function setImagen($imagen){
        $this->imagen = $imagen;
        return $this;
    }


  public function getId(){
      return $this->id;
  }


  public function setId($id){
      $this->id = $id;
      return $this;
  }


  public function getId_usuario(){
      return $this->id_usuario;
  }


  public function setId_usuario($id_usuario){
      $this->id_usuario = $id_usuario;
      return $this;
  }

  public function getComentarios(){
      return ComentarioManager::getAllComentariosPublicacion($this->id);
  }


}// clase



 ?>
