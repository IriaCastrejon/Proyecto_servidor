<?php

/**
 *
 */
class Anuncio extends Usuarios{

  private $id;
  private $foto;
  private $fecha_alta;
  private $fecha_baja;
  private $url;
  //PRECIO??

  function __construct($id, $foto = null, $fecha_alta, $fecha_baja=null, $url) {
    $this -> id = $id;
    $this -> foto = $foto;
    $this -> fecha_alta = $fecha_alta;
    $this -> fecha_baja = $fecha_baja;
    $this -> url = $url;
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
     * Get the value of Foto
     *
     * @return mixed
     */
    public function getFoto()
    {
        return $this->foto;
    }

    /**
     * Set the value of Foto
     *
     * @param mixed $foto
     *
     * @return self
     */
    public function setFoto($foto)
    {
        $this->foto = $foto;

        return $this;
    }

    /**
     * Get the value of Fecha Alta
     *
     * @return mixed
     */
    public function getFechaAlta()
    {
        return $this->fecha_alta;
    }

    /**
     * Set the value of Fecha Alta
     *
     * @param mixed $fecha_alta
     *
     * @return self
     */
    public function setFechaAlta($fecha_alta)
    {
        $this->fecha_alta = $fecha_alta;

        return $this;
    }

    /**
     * Get the value of Fecha Baja
     *
     * @return mixed
     */
    public function getFechaBaja()
    {
        return $this->fecha_baja;
    }

    /**
     * Set the value of Fecha Baja
     *
     * @param mixed $fecha_baja
     *
     * @return self
     */
    public function setFechaBaja($fecha_baja)
    {
        $this->fecha_baja = $fecha_baja;

        return $this;
    }

    /**
     * Get the value of Url
     *
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set the value of Url
     *
     * @param mixed $url
     *
     * @return self
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

}













?>
