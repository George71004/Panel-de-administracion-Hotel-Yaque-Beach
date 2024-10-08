<?php
//LOGEADO??
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: index.html");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración</title>
    <!-- Enlace a Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Enlace a Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            display: flex;
            height: 100vh;
            margin: 0;
        }
        #sidebar {
            width: 80px;
            background: #343a40;
            transition: all 0.3s;
            overflow: hidden;
            height: 100%;
        }
        #sidebar:hover {
            width: 250px;
        }
        #sidebar .list-unstyled {
            padding: 0;
            margin: 0;
        }
        #sidebar .list-unstyled li {
            text-align: center;
        }
        #sidebar .list-unstyled li a {
            color: #ffffff;
            padding: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            white-space: nowrap;
        }
        #sidebar .list-unstyled li a i {
            margin-right: 0;
            transition: margin-right 0.3s;
        }
        #sidebar:hover .list-unstyled li a i {
            margin-right: 10px;
        }
        #sidebar .list-unstyled li a span {
            display: none;
            transition: display 0.3s;
        }
        #sidebar:hover .list-unstyled li a span {
            display: inline;
        }
        #sidebar h3 {
            color: #ffffff;
            padding: 10px;
            text-align: center;
            display: none;
        }
        #sidebar:hover h3 {
            display: block;
        }
        #content {
            width: 100%;
            padding: 20px;
        }
    </style>
</head>
<body>
    <div id="sidebar">
        <h3>Menú</h3>
        <ul class="list-unstyled">
            <li><a href="usuarios.php"><i class="fas fa-users"></i> <span>Personas</span></a></li>
            <li><a href="habitaciones.php"><i class="fas fa-bed"></i> <span>Habitaciones</span></a></li>
            <li><a href="personas.php"><i class="fas fa-user"></i> <span>Usuarios</span></a></li>
            <li><a href="categorias.php"><i class="fas fa-list"></i> <span>Categorías</span></a></li>
            <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> <span>Cerrar sesión</span></a></li>
        </ul>
    </div>

    <div id="content">
        <div class="user-info">
            <i class="fas fa-user"></i>
            <span><?php echo "Administrador"; ?> (<?php echo $_SESSION['user_email']; ?>)</span>
        </div>

    <div id="content">
        <h1>Panel de Administración del Yaque Beach Hotel</h1>
        <p>Selecciona una opción del menú lateral para comenzar.</p>
    </div>

    <!-- Enlace a Bootstrap JS y dependencias -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>