<?php
$conn = mysqli_connect('localhost', 'root', '', 'hotel_yaquebeach');

// Verificar conexión
if (!$conn) {
    die("Error DB");
}

if (isset($_POST['id'])) {
    $id = $_POST['id'];

    // Consulta para eliminar el usuario
    $sql = "DELETE FROM persona WHERE cedula = '$id'";

    if ($conn->query($sql) === TRUE) {
        echo "success";
    } else {
        echo "error";
    }
}

$conn->close();
?>
