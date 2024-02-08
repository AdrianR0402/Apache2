<?php

require_once '../controller/Conexion.php';
require_once '../model/Cuenta.php';


/**
 * Description of CuentaController
 *
 * @author rafag
 */
class CuentaController {
    
    /**
     * 
     * @param type $dni
     * @return \Cuenta
     */
    public static function findAlldByDNI($dni) {
        $cuentas = [];
        
        try {
            $conex = new Conexion();
            $resultado = $conex->query("SELECT * FROM cuentas WHERE dni_cuenta = '$dni'");
            
            while ($fila = $resultado->fetch_object()) {
                $cuentas[]= new Cuenta($fila->iban, $fila->saldo, $fila->dni_cuenta);
            }
            $conex->close();
        } catch (Exception $ex) {
            echo 'Error en findAllByDNI: ' . $ex->getMessage(); 
        }
        return $cuentas;
    }
    
    
    public static function findAll() {
        $cuentas = [];
        
        try {
            $conex = new Conexion();
            $resultado = $conex->query("SELECT * FROM cuentas");
            
            while ($fila = $resultado->fetch_object()) {
                $cuentas[]= new Cuenta($fila->iban, $fila->saldo, $fila->dni_cuenta);
            }
            $conex->close();
        } catch (Exception $ex) {
            echo 'Error en findAll: ' . $ex->getMessage(); 
        }
        return $cuentas;
    }
    
    
    public static function findByIban($iban){
        $cuenta='';
        
        try {
            $conex = new Conexion();
            $resultado = $conex->query("SELECT * FROM cuentas WHERE iban = '$iban'");
            $fila = $resultado->fetch_object();
            
            if ($fila){
                $cuenta = new Cuenta($fila->iban, $fila->saldo, $fila->dni_cuenta);
            }
            $conex->close();
        } catch (Exception $ex) {
            echo "Error en findByIban: ".$ex->getMessage();
        }
        return $cuenta;
    }
    
    public static function update($iban, $nuevoSaldo){
        try {
            $conex = new Conexion();
            $fila = $conex->query("UPDATE cuentas SET saldo = '$nuevoSaldo' WHERE iban = '$iban'");
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
