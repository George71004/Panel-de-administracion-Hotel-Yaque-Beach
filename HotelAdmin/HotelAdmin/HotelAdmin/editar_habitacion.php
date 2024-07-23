<?php
$conn = mysqli_connect('localhost', 'root', '', 'hotel_yaquebeach');

// Verificar conexión
if(!$conn){
    die("Error DB: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $numero_habitacion = $_POST['numero_habitacion'];
    $categoria = $_POST['categoria'];

    // Depuración: mostrar los valores recibidos
    error_log("ID: $id, Numero: $numero_habitacion, Categoria: $categoria");

    // Actualizar habitación en la base de datos
    $sql = "UPDATE habitacion SET numero_habitacion='$numero_habitacion', categoria='$categoria' WHERE id_habitacion='$id'";

    if (mysqli_query($conn, $sql)) {
        echo 'success';
    } else {
        error_log("Error: " . mysqli_error($conn));  // Registro de error detallado
        echo "Error: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>







