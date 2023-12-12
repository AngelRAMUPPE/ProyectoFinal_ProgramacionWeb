<?php
session_start();
$db = new mysqli('localhost', 'root', 'SQL100_', 'pagina_web');

$email = $_POST["correo"];
$password = $_POST["contra"];

if($_SERVER['REQUEST_METHOD'] == 'POST') {

  $sql = "SELECT verify_user('$email', '$password') AS user_id";
  $result = $db->query($sql);
  $row = $result->fetch_assoc();    
  if($row['user_id'] > 0) {
    // Successful login
    $_SESSION['user_id'] = $row['user_id'];
    $userId = $_SESSION['user_id'];
    header('Location: ../medidor.php'); 
  } else {
    // Invalid login
    $error = "Invalid login credentials";
    echo $error;
  }

}
?>