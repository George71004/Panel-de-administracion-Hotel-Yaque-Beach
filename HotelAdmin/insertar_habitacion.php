<?php
$conn = mysqli_connect('localhost', 'root', '', 'hotel_yaquebeach');

// Verificar conexión
if(!$conn){
    die("Error DB: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $numero_habitacion = $_POST['numero_habitacion'];
    $categoria = $_POST['categoria'];

    // Insertar habitación en la base de datos
    $sql = "INSERT INTO habitacion (numero_habitacion, categoria) VALUES ('$numero_habitacion', '$categoria')";

    if (mysqli_query($conn, $sql)) {
        header("Location: habitaciones.php");
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>










