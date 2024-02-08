<?php

require_once '../controller/Conexion.php';
require_once '../model/Transferencia.php';

/**
 * Description of TransferenciaController
 *
 * @author rafag
 */
class TransferenciaController {
    
    /**
     * 
     * @param type $dni
     * @return \Cuenta
     */
    public static function findAlldByIban($iban) {
        $transferencias = [];
        
        try {
            $conex = new Conexion();
            $resultado = $conex->query("SELECT * FROM transferencias WHERE iban_origen = '$iban' OR iban_destino = '$iban'");
            
            while ($fila = $resultado->fetch_object()) {
                $transferencias[]= new Transferencia($fila->iban_origen, $fila->iban_destino, $fila->fecha, $fila->cantidad);
            }
            $conex->close();
        } catch (Exception $ex) {
            echo 'Error en findAllByIban: ' . $ex->getMessage(); 
        }
        return $transferencias;
    }
    
    public static function insertar($iban_origen, $iban_destino, $fecha, $cantidad) {
        try {
            $conex = new Conexion();
            $fila = $conex->query("INSERT INTO transferencias VALUES ('$iban_origen', '$iban_destino', '$fecha', '$cantidad')");
            if($conex->affected_rows > 0) {    
                return true;
            }
            return false;
            $conex->close();
        } catch (Exception $ex) {
            die("ERROR EN EL UPDATE. " . $ex->getMessage());
        }
        return false;
    }
    
}
