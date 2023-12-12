<?php
session_start();
include_once("dbcon.php");
if (isset($_POST["id"])) {
    $id = $_POST["id"];
    $database = new conexion();
    $db = $database->open();
    try {
        $stmt = $db->prepare("DELETE FROM registros_humedad WHERE id_registro = $id");
        $_SESSION['message']=($stmt ->execute() ?'Valor Eliminado exitosamente':'Algo salio mal');
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