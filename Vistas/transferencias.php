<html>

<?php
require_once "../Modelos/Usuario.php";
require_once "../Controladores/PDO/CuentaController.php";
require_once "../Controladores/PDO/TransferenciaController.php";

session_start();

if (isset($_SESSION["usuario"])) {
    echo "Hola " . $_SESSION["usuario"]->nombre . "<br>";
    echo "<a href='cerrar.php'>Cerrar sesión</a>";
    ?>

    <div style="text-align: start">
        <?php
        echo "<h1>Tramitar Transferencia</h1>";
        echo "Origen: " . $_POST["iban"] . "<br>";
        echo "Saldo: " . $_POST["saldo"] . "<br>";
        echo "Cuentas:<br>";
        $ps = TransferenciaController::selectCuentas($_POST["iban"]);

        // var_dump($ps);
    
        echo "<form action='validar_transferencia.php' method='POST'>";
        echo "<input type='hidden' name='origen' value='$_POST[iban]'>";
        echo "<input type='hidden' name='saldo' value='$_POST[saldo]'>";
        echo "<select name='cuentasDestino'>";
        foreach ($ps as $p) {
            // var_dump($p);
            echo $p->iban;
            echo "<option value='$p->iban'>$p->iban --- $p->Nombre</option>";
        }
        echo "</select>";
        ?>
        <br>Cantidad: <input type="number" name="cantidad"><br><br>
        <input type="submit" name="transferir" value="Transferir">
        </form>
        <form action='inicio_cliente.php' method='POST'>
            <input type='submit' name='inicio' value='Volver'>
        </form>
        <?php
} ?>

</div>

</html>