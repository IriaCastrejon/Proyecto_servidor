<?php

/**
 *
 */
class Anuncio extends Usuarios{

  private $id;
  private $id_cliente;
  private $foto;
  private $fecha_alta;
  private $fecha_baja;
  private $url;
  private $costo;
  //PRECIO??

  function __construct($id,$id_cliente, $foto = null, $fecha_alta, $fecha_baja=null, $url,$costo) {
    $this -> id = $id;
    $this -> id_cliente = $id_cliente;
    $this -> foto = $foto;
    $this -> fecha_alta = $fecha_alta;
    $this -> fecha_baja = $fecha_baja;
    $this -> url = $url;
    $this-> costo = $costo;
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
      global $config;
      return $config['img_in_url'] . "/". $this->foto;
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


    /**
     * Get the value of Id Cliente
     *
     * @return mixed
     */
    public function getIdCliente()
    {
        return $this->id_cliente;
    }

    /**
     * Set the value of Id Cliente
     *
     * @param mixed $id_cliente
     *
     * @return self
     */
    public function setIdCliente($id_cliente)
    {
        $this->id_cliente = $id_cliente;

        return $this;
    }

    /**
     * Get the value of Costo
     *
     * @return mixed
     */
    public function getCosto()
    {
      return $this->costo;
    }

    /**
     * Set the value of Costo
     *
     * @param mixed $costo
     *
     * @return self
     */
    public function setCosto($costo)
    {
        $this->costo = $costo;

        return $this;
    }


}













?>
