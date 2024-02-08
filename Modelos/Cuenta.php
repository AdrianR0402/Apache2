<?php
class Cuenta {
    private $iban;
    private $saldo;
    private $dniCuenta;

    // Constructor, getters y setters

    public function __construct($iban, $saldo, $dniCuenta) {
        $this->iban = $iban;
        $this->saldo = $saldo;
        $this->dniCuenta = $dniCuenta;
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