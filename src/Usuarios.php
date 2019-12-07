<?php

class Usuarios {

  private $id;
  private $nombre;
  private $email;
  private $contraseña;
  private $localidad;
  private $cp;
  private $telefono;
  private $foto;

function __construct($id, $nombre, $email, $contraseña,$localidad = null,$cp = null,$telefono= null,$foto = null){
    $this -> id = $id;
    $this -> nombre = $nombre;
    $this -> email = $email;
    $this -> contraseña = $contraseña;
    $this -> localidad = $localidad;
    $this -> cp = $cp;
    $this -> telefono = $telefono;
    $this -> foto = $foto;
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
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of Descripcion
     *
     * @param mixed $descripcion
     *
     * @return self
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of Fecha
     *
     * @return mixed
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set the value of Fecha
     *
     * @param mixed $fecha
     *
     * @return self
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get the value of n Participantes
     *
     * @return mixed
     */
    public function getContraseña()
    {
        return $this->contraseña;
    }

    /**
     * Set the value of n Participantes
     *
     * @param mixed $n_participantes
     *
     * @return self
     */
    public function setContraseña($contraseña)
    {
        $this->contraseña = $contraseña;

        return $this;
    }

    /**
     * Get the value of Lugar
     *
     * @return mixed
     */
    public function getLocalidad()
    {
        return $this->localidad;
    }

    /**
     * Set the value of Lugar
     *
     * @param mixed $lugar
     *
     * @return self
     */
    public function setLocalidad($localidad)
    {
        $this->localidad = $localidad;

        return $this;
    }
    /**
     * Get the value of Id
     *
     * @return mixed
     */
    public function getCP()
    {
        return $this->cp;
    }

    /**
     * Set the value of Id
     *
     * @param mixed $id
     *
     * @return self
     */
    public function setCP($cp)
    {
        $this->cp = $cp;

        return $this;
    }
    /**
     * Get the value of Id
     *
     * @return mixed
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * Set the value of Id
     *
     * @param mixed $id
     *
     * @return self
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;

        return $this;
    }
    /**
     * Get the value of Id
     *
     * @return mixed
     */
    public function getFoto()
    {
        return $this->foto;
    }

    /**
     * Set the value of Id
     *
     * @param mixed $id
     *
     * @return self
     */
    public function setFoto($foto)
    {
        $this->foto = $foto;

        return $this;
    }
}//clase

 ?>
