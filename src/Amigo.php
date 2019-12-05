<?php

class Amigo{

private $usuario_id;
private $usuario_id2;


function __construct($usuario_id, $usuario_id2){
  $this -> usuario_id = $usuario_id;
  $this -> usuario_id2 = $usuario_id2;
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
     * Get the value of Usuario Id
     *
     * @return mixed
     */
    public function getUsuarioId2()
    {
        return $this->usuario_id2;
    }

    /**
     * Set the value of Usuario Id
     *
     * @param mixed $usuario_id2
     *
     * @return self
     */
    public function setUsuarioId2($usuario_id2)
    {
        $this->usuario_id2 = $usuario_id2;

        return $this;
    }

}


 ?>
