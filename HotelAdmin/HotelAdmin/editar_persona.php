<?php
// Conexión a la base de datos
$conn = mysqli_connect('localhost', 'root', '', 'hotel_yaquebeach');

// Verificar conexión
if (!$conn) {
    die("Error DB: " . mysqli_connect_error());
}

// Obtener datos del formulario
$cedula = $_POST['cedula'];
$email = $_POST['email'];
$clave = $_POST['clave'];

// Validar que todos los campos estén presentes
if (empty($cedula) || empty($email) || empty($clave)) {
    echo "Error: Todos los campos son obligatorios.";
    exit;
}

// Consulta SQL para actualizar el usuario
$sql = "UPDATE usuario SET email='$email', clave='$clave' WHERE cedula='$cedula'";

if (mysqli_query($conn, $sql)) {
    echo "success";
} else {
    echo "Error al actualizar el usuario: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
