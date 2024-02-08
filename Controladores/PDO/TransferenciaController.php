<?php

require_once "Conexion.php";
require_once "../Modelos/Transferencia.php";

class TransferenciaController
{
        public static function select($iban)
    {
        try {
            $conn = new Conexion();
            $stmt = $conn->prepare("SELECT * FROM transferencias WHERE iban_origen = ? or iban_destino = ?");
            $ts = null;
            if ($stmt->execute([$iban, $iban])) {
                while ($o = $stmt->fetch()) {
                $ts[] = new Transferencia($o->iban_origen, $o->iban_destino, $o->fecha,$o->cantidad);
                }
            }
        } catch (PDOException $ex) {
            echo $ex->getTraceAsString();
            echo $ex->getMessage();
            echo $ex->getLine();
        }
        return $ts;;
    }

    public static function selectCuentas($iban)
    {
        try {
            $conn = new Conexion();
            $stmt = $conn->prepare("SELECT cuentas.*, usuarios.* FROM cuentas JOIN usuarios ON cuentas.dni_cuenta = usuarios.DNI WHERE cuentas.iban != ? and usuarios.Nombre != 'Comisiones'");
            $P = null;
            if ($stmt->execute([$iban])) {
                while ($o = $stmt->fetch()) {
                    $p[] = $o;
                }
            }
        } catch (PDOException $ex) {
            echo $ex->getTraceAsString();
        }
        return $p;
    }

    public static function insert($iban_origen, $iban_destino, $cantidad){
        try {
            $fecha = time();
            $conn = new Conexion();
            $fila = $conn->query("INSERT INTO transferencias values('$iban_origen', '$iban_destino', '$fecha', '$cantidad')");
            if($fila->rowCount() > 0) {
                return true;
            }
            $conn=null;
            
        } catch (PDOException $ex) {
            die("ERROR EN EL UPDATE. " . $ex->getMessage());
        }
        return false;
    }
}
