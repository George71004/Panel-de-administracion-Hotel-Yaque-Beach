<?php

$conn = mysqli_connect('localhost', 'root', '', 'hotel_yaquebeach');

if(!$conn){
    die("Error DB");
}

// Recibir datos del formulario
$cedula = $_POST['cedula'] ?? '';
$nombre = $_POST['nombre'] ?? '';
$apellido = $_POST['apellido'] ?? '';
$email = $_POST['email'] ?? '';
$telefono = $_POST['telefono'] ?? '';
$clave = $_POST['clave'] ?? '';

// Preparar la consulta SQL
mysqli_query($conn, "INSERT INTO usuario (cedula, email, clave) VALUES ('$cedula', '$email', '$clave')");

mysqli_query($conn, "INSERT INTO persona (cedula, nombre, apellido, telefono) VALUES ('$cedula', '$nombre', '$apellido', '$telefono')");


header("Location: usuarios.php");

// Cerrar conexión
$conn->close();
?>
