<?php

class Comentario {

  private $id;
  private $usuario_id;
  private $accion_id;
  private $texto;




  function __construct($id, $usuario_id,$accion_id, $texto){
    $this -> id = $id;
    $this -> usuario_id = $usuario_id;
    $this -> accion_id = $accion_id;
    $this -> texto = $texto;

  }


    /**
     * Get the value of Id
     *
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of Id
     *
     * @param mixed $id
     *
     * @return self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
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
     * Get the value of Accion Id
     *
     * @return mixed
     */
    public function getAccionId()
    {
        return $this->accion_id;
    }

    /**
     * Set the value of Accion Id
     *
     * @param mixed $accion_id
     *
     * @return self
     */
    public function setAccionId($accion_id)
    {
        $this->accion_id = $accion_id;

        return $this;
    }

    /**
     * Get the value of Texto
     *
     * @return mixed
     */
    public function getTexto()
    {
        return $this->texto;
    }

    /**
     * Set the value of Texto
     *
     * @param mixed $texto
     *
     * @return self
     */
    public function setTexto($texto)
    {
        $this->texto = $texto;

        return $this;
    }


    public function getUsuario()
    {
      return MascotaManager::getById($this->usuario_id)[0];

    }
}

 ?>
