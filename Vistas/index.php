<html>
<?php
require_once("../Controladores/PDO/UsuarioController.php");

if (isset($_POST["entrar"])) {
    $o = UsuarioController::select($_POST["DNI"], $_POST["Contraseña"]);

    if (is_object($o)) {
        session_start();
        $_SESSION["usuario"] = $o;
        UsuarioController::resetIntentos($_POST["DNI"]);
        header("location: inicio_cliente.php");
    } else {
        if ($o == -1) {
            echo "<font color=red>NO HAY NINGUN USUARIO CON ESOS DATOS.</font>";
        } 
        if ($o == 0) {
            echo "<font color=red>USUARIO BLOQUEADO.</font>";
        }
        if ($o != 0 && $o != -1) {
            echo "<font color=red>TE QUEDAN " . $o . " INTENTOS</font>";
        }
    }

}
?>
<h1>LOGIN</h1>

<form action="" method="POST">
    <input type="text" name="DNI" placeholder="DNI">
    <br>
    <input type="password" name="Contraseña" placeholder="Contraseña">
    <br><br>
    <input type="submit" name="entrar" value="Entrar">
    
</form>

</html>