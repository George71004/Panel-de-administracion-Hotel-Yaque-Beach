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

    // Actualizar habitación en la base de datos
    $sql = "UPDATE habitacion SET numero_habitacion='$numero_habitacion', categoria='$categoria' WHERE id_habitacion='$id'";

    if (mysqli_query($conn, $sql)) {
        echo 'success';
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>




