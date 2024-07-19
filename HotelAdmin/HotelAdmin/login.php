<?php
session_start();

// Datos de conexión a la base de datos
$conn = mysqli_connect('localhost', 'root', '', 'hotel_yaquebeach');

// Verificar conexión
if(!$conn){
    die("Error DB");
}

// Recibir datos del formulario
$email = $_POST['email'];
$clave = $_POST['clave'];

// Consulta SQL para verificar el usuario
$sql = "SELECT cedula, email, clave FROM usuario WHERE email = '$email'";
$resultado = $conn->query($sql);

if ($resultado->num_rows > 0) {
    $row = $resultado->fetch_assoc();
    // Verificar la contraseña en texto plano
    if ($clave == $row['clave']) {
        // Contraseña correcta, iniciar sesión
        $_SESSION['loggedin'] = true;
        $_SESSION['user_id'] = $row['cedula'];
        $_SESSION['user_email'] = $row['email'];
        header("Location: panel.php");
        exit();
    } else {
        // Contraseña incorrecta
        echo "Correo electrónico o contraseña incorrectos.";
    }
} else {
    // Usuario no encontrado
    echo "Usuario no encontrado";
}

$conn->close();
?>

