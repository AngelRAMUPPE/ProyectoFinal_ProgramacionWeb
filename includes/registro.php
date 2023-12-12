<?php 
    session_start();
    include_once("dbcon.php");

    if (isset($_POST['registro'])) {
        $database = new conexion();
        $db = $database->open();
        $correo = $_POST["correo"];
        $contra = $_POST["contra"];
        $codigo = $_POST["codigo"];
        try {
        $stmt = $db->prepare("INSERT INTO usuarios (correo,contrasena,codigo_medidor) VALUES ('$correo','$contra','$codigo')");
            $_SESSION['message']=($stmt ->execute() ?'Registro guardado exitosamente':'Algo salio mal');
        }
        catch (PDOException $e) {
        $_SESSION['message'] = $e-> getMessage();
        echo $_SESSION['message'];
        }
        $database->close();
    }
    else {
        $_SESSION['message'] == 'Por favor escribe algun nombre del equipo';
    }
    header('location: ../login.html');

?>