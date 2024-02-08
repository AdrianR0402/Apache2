<?php
require_once "../Modelos/Usuario.php";
require_once "../Controladores/PDO/CuentaController.php";
require_once "../Controladores/PDO/TransferenciaController.php";

session_start();

if (isset($_SESSION["usuario"])) {
    echo "Hola " . $_SESSION["usuario"]->nombre . "<br>";
    echo "<a href='cerrar.php'>Cerrar sesión</a>";
    $os = CuentaController::select($_SESSION["usuario"]->dni);

    ?>

    <div style="text-align: start">
        <h2>Mis Cuentas</h2>
        <table border=1>
        <tr>
            <th>Cuentas</th>
            <th>Saldo</th>
            <th>Historial</th>
            <th>Transferencia</th>
        </tr>
        <tbody>
                    <?php
                    foreach ($os as $o) {
                        echo "<tr>";
                        echo "<td> $o->iban </td>";
                        echo "<td> $o->saldo €</td>";
                        echo "<td><form action='' method='POST'><input type='hidden' name='iban' value='$o->iban'><input type='submit' name='historial' value='Historal'></form></td>";
                        echo "<td><form action='transferencias.php' method='POST'><input type='hidden' name='iban' value='$o->iban'><input type='hidden' name='saldo' value='$o->saldo'><input type='submit' name='transferencia' value='Transferencia'></form></td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
        
        </table>

        <?php
if (isset($_POST["historial"])) {   
    echo "<h2>Historial</h2>";

$ts=TransferenciaController::select($_POST["iban"]);
?>
<table border=1>
        <tr>
            <th>Origen</th>
            <th>Destino</th>
            <th>Fecha</th>
            <th>Cantidad</th>
        </tr>
        <tbody>
                    <?php
                    foreach ($ts as $t) {
                        echo "<tr>";
                        echo "<td>$t->ibanOrigen</td>";
                        echo "<td>$t->ibanDestino</td>";
                        $fechaReal = date('d-m-Y H:i', $t->fecha);
                        echo "<td>$fechaReal</td>";
                        echo "<td>$t->cantidad</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
        
        </table>

<?php
}
if (isset($_POST["transferencia"])) {   

}    

} 
else {
    header("Location: index.php");
}
?>