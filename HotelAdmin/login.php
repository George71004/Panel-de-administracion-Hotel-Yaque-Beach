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
$nivel = '1';

// Consulta SQL para verificar el usuario
$sql = "SELECT cedula, email, clave, nivel FROM usuario WHERE email = '$email'";
$resultado = $conn->query($sql);

if ($resultado->num_rows > 0) {
    $row = $resultado->fetch_assoc();
    // Verificar la contraseña en texto plano
    if ($clave == $row['clave'] && $nivel == $row['nivel']) {
        // Contraseña correcta, iniciar sesión
        $_SESSION['loggedin'] = true;
        $_SESSION['user_id'] = $row['cedula'];
        $_SESSION['user_email'] = $row['email'];

        header("Location: panel.php");
        exit();
    
    } else {
        // Contraseña incorrecta
        echo "Clave incorrecta o nivel no permitido.";
    }
} else {
    // Usuario no encontrado
    echo "Su usuario no ha sido encontrado. Verifique si el correo esta escrito correctamente.";
}

$conn->close();
?>

