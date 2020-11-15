<?php
  class Coordenadas{
    private $id;
    private $usuario_id;
    private $longitud;
    private $latitud;
    private $direccion;


    function __construct($id, $usuario_id, $longitud, $latitud, $direccion){
      $this -> id = $id;
      $this -> usuario_id = $usuario_id;
      $this -> longitud = $longitud;
      $this -> latitud = $latitud;
      $this -> direccion = $direccion;
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
     * Get the value of Longitud
     *
     * @return mixed
     */
    public function getLongitud()
    {
        return $this->longitud;
    }

    /**
     * Set the value of Longitud
     *
     * @param mixed $longitud
     *
     * @return self
     */
    public function setLongitud($longitud)
    {
        $this->longitud = $longitud;

        return $this;
    }

    /**
     * Get the value of Latitud
     *
     * @return mixed
     */
    public function getLatitud()
    {
        return $this->latitud;
    }

    /**
     * Set the value of Latitud
     *
     * @param mixed $latitud
     *
     * @return self
     */
    public function setLatitud($latitud)
    {
        $this->latitud = $latitud;

        return $this;
    }

    /**
     * Get the value of Direccion
     *
     * @return mixed
     */
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * Set the value of Direccion
     *
     * @param mixed $direccion
     *
     * @return self
     */
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;

        return $this;
    }

}

 ?>
