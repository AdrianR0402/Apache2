<?php

require_once "Conexion.php";
require_once "../Modelos/Usuario.php";

// Al crear el INSERT no importa si el campo se escribe en mayúscula o minúscula.
// AL crear el SELECT debemos escribirlos tal y como estén en la base de datos.
// Al crear el UPDATE debemos de escribir los campos como los tengamos en el modelo.
class UsuarioController
{
    public static function insert($o) //Metodo para crear usuarios
    {
        try {
            $conn = new Conexion();
            $stmt = $conn->prepare("INSERT INTO usuarios VALUES (?,?,?,?,?,?,?)");
            $stmt->execute([$o->nombre, $o->direccion, $o->telefono, $o->dni, $o->clave, $o->intentos, $o->bloqueado]);
            if ($stmt->rowCount() > 0) {
                $conn = null;

                return true;
            }
        } catch (Exception $ex) {
            echo $ex->getTraceAsString();
        }
        return false;
    }

//  Select con passhash  
//   public static function select($dni, $clave)
//     {
//         try {
//             $conn = new Conexion();
//             $stmt = $conn->prepare("SELECT * FROM usuario WHERE dni = ?");
//             if ($stmt->execute([$dni])) {
//                 if ($o = $stmt->fetch())
//                     if (password_verify($clave, $o->clave)) {
//                         return new Usuario($o->nombre, $o->direccion, $o->telefono, $o->dni, $o->clave, $o->intentos, $o->bloqueado);
//                     }
//             }
//         } catch (PDOException $ex) {
//             echo $ex->getTraceAsString();
//             echo $ex->getMessage();
//             echo $ex->getLine();
//         }
//         return null;
//     }


//Select con MD5
public static function select($dni, $clave)
    {
        try {
            $conn = new Conexion();
            $hash_md5 = md5($clave);
            $stmt = $conn->prepare("SELECT * FROM usuarios WHERE DNI = ?");
            
            if ($stmt->execute([$dni])) {
                if ($o = $stmt->fetch()) {
                    if($o->bloqueado != 1){
                        if ($hash_md5 == $o->clave) {
                            return new Usuario($o->Nombre, $o->Direccion, $o->Telefono, $o->DNI, $o->clave, $o->intentos, $o->bloqueado);
                        } else {
                            return self::updateIntentos($dni);
                        }
                    } else {
                        return 0;
                    }
                } else {
                    return -1;
                } 
            }
        } catch (PDOException $ex) {
            echo $ex->getTraceAsString();
            echo $ex->getMessage();
            echo $ex->getLine();
        }
        return null;
    }

public static function resetIntentos($dni)
{
    try {
        $conn = new Conexion();
        $stmt = $conn->prepare("UPDATE usuarios SET intentos = 3, bloqueado = 0 WHERE DNI = ?");
        $stmt->execute([$dni]);
    } catch (PDOException $ex) {
        echo $ex->getTraceAsString();
        echo $ex->getMessage();
        echo $ex->getLine();
    }
}

public static function updateIntentos($dni)
{
    try {
        $conn = new Conexion();
        $stmt = $conn->prepare("SELECT * FROM usuarios WHERE DNI = ?");
        $stmt->execute([$dni]);

        if ($o = $stmt->fetch()) {
            if($o->bloqueado == 1) {
                return 0;
            } else {
                $stmt = $conn->prepare("UPDATE usuarios SET intentos = intentos - 1 WHERE DNI = ?");
                $stmt->execute([$dni]);

                if ($stmt->rowCount() > 0) {
                    if($o->intentos - 1 == 0) {
                        $stmt = $conn->prepare("UPDATE usuarios SET bloqueado = 1 WHERE DNI = ?");
                        $stmt->execute([$dni]);
                        if ($stmt->rowCount() > 0) {
                            return 0;
                        }
                    } else {
                        return $o->intentos - 1;
                    }
                }
            }
        }
    } catch (PDOException $ex) {
        echo $ex->getTraceAsString();
        echo $ex->getMessage();
        echo $ex->getLine();
    }
}
}