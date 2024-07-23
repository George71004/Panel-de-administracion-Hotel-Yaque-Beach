<?php
$conn = mysqli_connect('localhost', 'root', '', 'hotel_yaquebeach');

if (!$conn) {
    die("Error de conexión a la base de datos: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $tipo = $_POST['tipo'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $capacidad = $_POST['capacidad'];

    // Depuración: Imprimir los datos recibidos
    error_log("Datos recibidos: id=$id, tipo=$tipo, descripcion=$descripcion, precio=$precio, capacidad=$capacidad");

    $query = "UPDATE categoria SET tipo='$tipo', descripcion='$descripcion', precio='$precio', capacidad='$capacidad' WHERE id_categoria='$id'";

    if (mysqli_query($conn, $query)) {
        echo 'success';
    } else {
        // Depuración: Mostrar el error específico de MySQL
        echo "Error al editar categoría: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>