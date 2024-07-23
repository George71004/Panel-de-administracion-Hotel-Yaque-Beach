<?php
$conn = mysqli_connect('localhost', 'root', '', 'hotel_yaquebeach');

if (!$conn) {
    die("Error de conexión: " . mysqli_connect_error());
}

$cedula = $_POST['cedula'];
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$telefono = $_POST['telefono'];

$sql = "UPDATE persona SET nombre='$nombre', apellido='$apellido', telefono='$telefono' WHERE cedula='$cedula'";

if (mysqli_query($conn, $sql)) {
    echo 'success';
} else {
    echo 'error';
}

mysqli_close($conn);
?>


