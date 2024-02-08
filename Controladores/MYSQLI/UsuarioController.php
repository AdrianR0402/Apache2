<?php
require_once '../controller/Conexion.php';
require_once '../model/Usuario.php'; 
/**
 * Description of UsuarioController
 *
 * @author rafag
 */
class UsuarioController { 
    
    /**
     * 
     * @param type $user
     * @param type $pass
     * @return \Usuario
     */
    public static function comprobarUsuario($user, $pass) {
        $usuario = null; 
        try{
             $conex = new conexion();
             $stmt = $conex->prepare("select * from usuarios where DNI = ?");
             $stmt->bind_param("s", $user);
             $stmt->execute();            
             $resultado = $stmt->get_result()->fetch_object();
             if( $resultado) {
                if (md5($pass) == $resultado->clave){                      
                    $usuario = new Usuario($resultado->Nombre, $resultado->Direccion, $resultado->Telefono, 
                            $resultado->DNI, $resultado->clave, $resultado->intentos, $resultado->bloqueo);
                }
            }
             $stmt->close();
             $conex->close();
         } catch (Exception $ex) {
             echo "Fallo en comprobarUsuario".$ex->getMessage();
         }
         return $usuario;
    }


    public static function findAll() {
        $clientes = [];
        
        try {
            $conex = new Conexion();
            $resultado = $conex->query("SELECT * FROM usuarios");
            while ($fila = $resultado->fetch_object()) {
                $clientes[]= new Usuario($fila->Nombre, $fila->Direccion, $fila->Telefono, $fila->DNI, $fila->clave, $fila->intentos, $fila->bloqueado);
            }
            $conex->close();
        } catch (Exception $ex) {
            echo 'Error en findAll: ' . $ex->getMessage(); 
        }
        return $clientes;
    }
    
        public static function findByDNI($dni){
        $usuario='';
        
        try {
            $conex = new Conexion();
            $resultado = $conex->query("SELECT * FROM usuarios WHERE DNI = '$dni'");
            $fila = $resultado->fetch_object();
            
            if ($fila){
                $usuario = new Usuario($fila->Nombre, $fila->Direccion, $fila->Telefono, $fila->DNI, $fila->clave, $fila->intentos, $fila->bloqueado);
            }
            $conex->close();
        } catch (Exception $ex) {
            echo "Error en findByDNI: ".$ex->getMessage();
        }
        return $usuario;
    }
    
}

