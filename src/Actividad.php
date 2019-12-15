<?php

class Actividad {

  private $id;
  private $descripcion;
  private $fecha;
  private $nombre;
  private $lugar;



  function __construct($id, $nombre,$descripcion, $fecha, $lugar){
    $this -> id = $id;
    $this -> nombre = $nombre;
    $this -> descripcion = $descripcion;
    $this -> fecha = $fecha;
//    $this -> n_participantes = $n_participantes;
    $this -> lugar = $lugar;
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
     * Get the value of Descripcion
     *
     * @return mixed
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set the value of Descripcion
     *
     * @param mixed $descripcion
     *
     * @return self
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get the value of Fecha
     *
     * @return mixed
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set the value of Fecha
     *
     * @param mixed $fecha
     *
     * @return self
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }


    /**
     * Get the value of Lugar
     *
     * @return mixed
     */
    public function getLugar()
    {
        return $this->lugar;
    }

    /**
     * Set the value of Lugar
     *
     * @param mixed $lugar
     *
     * @return self
     */
    public function setLugar($lugar)
    {
        $this->lugar = $lugar;

        return $this;
    }


    /**
     * Get the value of Nombre
     *
     * @return mixed
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set the value of Nombre
     *
     * @param mixed $nombre
     *
     * @return self
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

}

 ?>
