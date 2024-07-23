<?php
$conn = mysqli_connect('localhost', 'root', '', 'hotel_yaquebeach');

if (!$conn) {
    die("Error de conexión a la base de datos: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];

    $query = "DELETE FROM categoria WHERE id_categoria='$id'";
    
    if (mysqli_query($conn, $query)) {
        echo 'success';
    } else {
        echo "Error al eliminar categoría: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>
