<?php
class Transferencia {
    private $ibanOrigen;
    private $ibanDestino;
    private $fecha;
    private $cantidad;

    // Constructor, getters y setters

    public function __construct($ibanOrigen, $ibanDestino, $fecha, $cantidad) {
        $this->ibanOrigen = $ibanOrigen;
        $this->ibanDestino = $ibanDestino;
        $this->fecha = $fecha;
        $this->cantidad = $cantidad;
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