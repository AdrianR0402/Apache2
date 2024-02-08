<?php
class Usuario {
    private $nombre;
    private $direccion;
    private $telefono;
    private $dni;
    private $clave;
    private $intentos;
    private $bloqueado;

    // Constructor, getters y setters
    public function __construct($nombre, $direccion, $telefono, $dni, $clave, $intentos = 3, $bloqueado = 0) {
        $this->nombre = $nombre;
        $this->direccion = $direccion;
        $this->telefono = $telefono;
        $this->dni = $dni;
        $this->clave = $clave;
        $this->intentos = $intentos;
        $this->bloqueado = $bloqueado;
    }

    public function __get($name)
    {
        return $this->$name;
    }

    public function __set($name, $value)
    {
        $this->$name = $value;
    }
}
?>