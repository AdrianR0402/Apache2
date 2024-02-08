<?php
require_once "../Modelos/Usuario.php";
require_once "../Controladores/PDO/CuentaController.php";
require_once "../Controladores/PDO/TransferenciaController.php";

session_start();

if (isset($_SESSION["usuario"])) {
    // var_dump($_SESSION);
    //var_dump($_POST);
    echo "Hola " . $_SESSION["usuario"]->nombre . "<br>";

    echo "<a href='cerrar.php'>Cerrar sesión</a>";
    if (isset($_POST["confirmar"])) {
        if ($_POST["saldoPosterior"] < 0) {
            echo "<br><font color=red>Tu saldo sería negativo con esa transferencia</font>";
        } else {
        TransferenciaController::insert($_POST["origen"],$_POST["destino"],$_POST["cantidad"]);
        CuentaController::update($_POST["origen"],$_POST["saldoPosterior"]);
        $pasta = CuentaController::cuentaPorIban($_POST["destino"]);
        CuentaController::update($_POST["destino"], $pasta->saldo + $_POST["cantidad"]);
        CuentaController::updateComision($_POST["comision"]);
        header("Location:inicio_cliente.php");
        }
    } else {
        ?>
        <form action='' method='POST'>
            <label for="origen">Origen:</label>
            <input readonly value="<?php echo $_POST["origen"] ?>" type="text" id="origen" name="origen"><br>

            <label for="destino">Destino:</label>
            <input readonly value="<?php echo $_POST["cuentasDestino"] ?>" type="text" id="destino" name="destino"><br>

            <label for="cantidad">Cantidad:</label>
            <input readonly value="<?php echo $_POST["cantidad"] ?>" type="number" id="cantidad" name="cantidad"><br>

            <label for="comision">Comisión:</label>
            <input readonly value="<?php echo $_POST["cantidad"] * 0.01 ?>" type="number" id="comision" name="comision"><br>

            <label for="saldoAnterior">Saldo Anterior:</label>
            <input readonly value="<?php echo $_POST["saldo"] ?>" type="number" id="saldoAnterior" name="saldoAnterior"><br>
            
            <label for="saldoPosterior">Saldo Posterior:</label>
            <?php
if (($_POST["saldo"] - ($_POST["cantidad"] + $_POST["cantidad"] * 0.01)) < 0) {
    echo "<input readonly value='" . ($_POST["saldo"] - ($_POST["cantidad"] + $_POST["cantidad"] * 0.01)) . "'
        type='number' id='saldoPosterior' name='saldoPosterior'  style='color: red;'><br><br>";
} else {
    ?>
    <input readonly value="<?php echo $_POST["saldo"] - ($_POST["cantidad"] + $_POST["cantidad"] * 0.01) ?>"
        type="number" id="saldoPosterior" name="saldoPosterior"><br>
<?php } ?>
<input type='submit' name='confirmar' value='Confirmar' <?php if (($_POST["saldo"] - ($_POST["cantidad"] + $_POST["cantidad"] * 0.01)) < 0) echo 'disabled'; ?>>
</form></form>
<?php
}
?>
    <form action='inicio_cliente.php' method='POST'>
        <input type='submit' name='inicio' value='Volver'>
    </form>
    <?php
}
?>