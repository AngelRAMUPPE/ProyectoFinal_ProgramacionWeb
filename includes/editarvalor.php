<?php
session_start();
include_once("dbcon.php");
if (isset($_POST["editar"])) {
    $id = $_POST["id2"];
    $nombre = $_POST["nombres"];
    $database = new conexion();
    $db = $database->open();
    try {
        $stmt = $db->prepare("UPDATE registros_humedad SET valor_leido = '$nombre' WHERE id_registro = $id");
        $_SESSION['message']=($stmt ->execute() ?'Valor guardado exitosamente':'Algo salio mal');
    } catch (PDOException $e) {
        $_SESSION['message'] = $e-> getMessage();
    }
    $database->close();
}
else {
    $_SESSION['message'] == 'Error';
}
header('location: ../medidor.php');
?>