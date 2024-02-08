<?php

require_once "Conexion.php";
require_once "../Modelos/Cuenta.php";

class CuentaController
{
    public static function select($dni)
{
    try {
        $conn = new Conexion();
        $stmt = $conn->prepare("SELECT * FROM cuentas WHERE dni_cuenta = ?");
        $cs = null;
        if ($stmt->execute([$dni])) {
            while ($o = $stmt->fetch())
            $cs[] = new Cuenta($o->iban, $o->saldo, $o->dni_cuenta);
        }
    } catch (PDOException $ex) {
        echo $ex->getTraceAsString();
        echo $ex->getMessage();
        echo $ex->getLine();
    }
    return $cs;
}

public static function updateComision($comision){
    try {
        $conn = new Conexion();
        $fila = $conn->query("UPDATE cuentas SET saldo = saldo + $comision WHERE iban = 'ES2099999999999999999999'");
        if($fila->rowCount() > 0) {
            return true;
        }
        $conn = null;
        
    } catch (PDOException $ex) {
        die("ERROR EN EL UPDATE. " . $ex->getMessage());
    }
    return false;
}

public static function update($iban, $nuevoSaldo){
    try {
        $conn = new Conexion();
        $fila = $conn->query("UPDATE cuentas SET saldo = $nuevoSaldo WHERE iban = '$iban'");
        if($fila->rowCount() > 0) {
            return true;
        }
        $conn = null;
        
    } catch (PDOException $ex) {
        die("ERROR EN EL UPDATE. " . $ex->getMessage());
    }
    return false;
}

public static function cuentaPorIban($iban) {
    try {
        $conn = new Conexion();
        $stmt = $conn->prepare("SELECT * FROM cuentas WHERE iban = ?");
        
        if ($stmt->execute([$iban])) {
            $cuenta = $stmt->fetch();
            
            if ($cuenta) {
                return new Cuenta($cuenta->iban, $cuenta->saldo, $cuenta->dni_cuenta);
            } else {
                return null; // No se encontró la cuenta con el IBAN proporcionado
            }
        } else {
            return null; // Error en la ejecución de la consulta
        }
    } catch (PDOException $ex) {
        echo $ex->getTraceAsString();
        return null; 
    }
}
}