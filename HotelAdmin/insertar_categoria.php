<?php
$conn = mysqli_connect('localhost', 'root', '', 'hotel_yaquebeach');

if (!$conn) {
    die("Error DB");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tipo = $_POST['tipo'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $capacidad = $_POST['capacidad'];

    $query = "INSERT INTO categoria (tipo, descripcion, precio, capacidad) VALUES ('$tipo', '$descripcion', '$precio', '$capacidad')";
    if (mysqli_query($conn, $query)) {
        header("Location: categorias.php");
    } else {
        echo "Error al insertar categoría: " . mysqli_error($conn);
    }
    mysqli_close($conn);
}
?>
