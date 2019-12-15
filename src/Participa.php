<?php

class Participa {

  private $usuario_id;
  private $actividad_id;


  function __construct($usuario_id, $actividad_id){
    $this -> usuario_id = $usuario_id;
    $this -> actividad_id = $actividad_id;

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
     * Get the value of Actividad Id
     *
     * @return mixed
     */
    public function getActividadId()
    {
        return $this->actividad_id;
    }

    /**
     * Set the value of Actividad Id
     *
     * @param mixed $actividad_id
     *
     * @return self
     */
    public function setActividadId($actividad_id)
    {
        $this->actividad_id = $actividad_id;

        return $this;
    }

}

 ?>
