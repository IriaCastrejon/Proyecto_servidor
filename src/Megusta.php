<?php

class Megusta {

  private $usuario_id;
  private $publicacion_id;


  function __construct($usuario_id, $publicacion_id){
    $this -> usuario_id = $usuario_id;
    $this -> publicacion_id = $publicacion_id;

  }




    /**
     * Get the value of Usuario Id
     *
     * @return mixed
     */
    public function getUsuarioId()
    {
        return $this->usuario_id;
    }

    /**
     * Set the value of Usuario Id
     *
     * @param mixed $usuario_id
     *
     * @return self
     */
    public function setUsuarioId($usuario_id)
    {
        $this->usuario_id = $usuario_id;

        return $this;
    }

    /**
     * Get the value of Publicacion Id
     *
     * @return mixed
     */
    public function getPublicacionId()
    {
        return $this->publicacion_id;
    }

    /**
     * Set the value of Publicacion Id
     *
     * @param mixed $publicacion_id
     *
     * @return self
     */
    public function setPublicacionId($publicacion_id)
    {
        $this->publicacion_id = $publicacion_id;

        return $this;
    }

}

 ?>
