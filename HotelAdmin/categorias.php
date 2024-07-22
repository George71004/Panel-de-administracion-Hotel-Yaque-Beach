<?php
//LOGEADO??
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: index.html");
    exit;
}
$conn = mysqli_connect('localhost', 'root', '', 'hotel_yaquebeach');

// Verificar conexión
if (!$conn) {
    die("Error de conexión a la base de datos: " . mysqli_connect_error());
}

// Consulta SQL para obtener todas las categorías
$consulta = "SELECT * FROM categoria";
$resultado = $conn->query($consulta);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Categorías</title>
    <!-- Enlace a Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Enlace a Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Enlace a jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
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
        .table-actions {
            width: 100px; /* Ajusta el ancho según sea necesario */
            text-align: center;
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

    <div class="container mt-5">
        <h1>Administrar Categorías</h1>
        <button class="btn btn-primary my-3" data-toggle="modal" data-target="#createCategoryModal">Crear Categoría</button>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tipo</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th>Capacidad</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($resultado->num_rows > 0) {
                    while ($row = $resultado->fetch_assoc()) {
                        echo "<tr>
                                <td>" . $row["id_categoria"] . "</td>
                                <td>" . $row["tipo"] . "</td>
                                <td>" . $row["descripcion"] . "</td>
                                <td>" . $row["precio"] . "</td>
                                <td>" . $row["capacidad"] . "</td>
                                <td>
                                    <button class='btn btn-primary btn-sm edit-btn' data-toggle='modal' data-target='#editCategoryModal' data-id='" . $row['id_categoria'] . "' data-tipo='" . $row['tipo'] . "' data-descripcion='" . $row['descripcion'] . "' data-precio='" . $row['precio'] . "' data-capacidad='" . $row['capacidad'] . "'>Editar</button>
                                    <button class='btn btn-danger btn-sm delete-btn' data-id='" . $row['id_categoria'] . "'>Eliminar</button>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No hay categorías registradas</td></tr>";
                }
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>

    <!-- Modal Crear Categoría -->
    <div class="modal fade" id="createCategoryModal" tabindex="-1" aria-labelledby="createCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createCategoryModalLabel">Crear Categoría</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="createCategoryForm" action="insertar_categoria.php" method="post">
                        <div class="form-group">
                            <label for="tipo">Tipo</label>
                            <input type="text" class="form-control" id="tipo" name="tipo" required>
                        </div>
                        <div class="form-group">
                            <label for="descripcion">Descripción</label>
                            <input type="text" class="form-control" id="descripcion" name="descripcion" required>
                        </div>
                        <div class="form-group">
                            <label for="precio">Precio</label>
                            <input type="text" class="form-control" id="precio" name="precio" required>
                        </div>
                        <div class="form-group">
                            <label for="capacidad">Capacidad</label>
                            <input type="text" class="form-control" id="capacidad" name="capacidad" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Crear</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Editar Categoría -->
    <div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCategoryModalLabel">Editar Categoría</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editCategoryForm">
                        <input type="hidden" id="editCategoryId">
                        <div class="form-group">
                            <label for="editTipo">Tipo</label>
                            <input type="text" class="form-control" id="editTipo" required>
                        </div>
                        <div class="form-group">
                            <label for="editDescripcion">Descripción</label>
                            <input type="text" class="form-control" id="editDescripcion" required>
                        </div>
                        <div class="form-group">
                            <label for="editPrecio">Precio</label>
                            <input type="text" class="form-control" id="editPrecio" required>
                        </div>
                        <div class="form-group">
                            <label for="editCapacidad">Capacidad</label>
                            <input type="text" class="form-control" id="editCapacidad" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Enlace a Bootstrap JS y dependencias -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        $(document).ready(function() {
    // Evento para mostrar datos en el modal de edición
    $('.edit-btn').click(function() {
        var id = $(this).data('id');
        var tipo = $(this).data('tipo');
        var descripcion = $(this).data('descripcion');
        var precio = $(this).data('precio');
        var capacidad = $(this).data('capacidad');

        $('#editCategoryId').val(id);
        $('#editTipo').val(tipo);
        $('#editDescripcion').val(descripcion);
        $('#editPrecio').val(precio);
        $('#editCapacidad').val(capacidad);
    });

    // Evento para manejar la eliminación de categoría
    $('.delete-btn').click(function() {
        var id = $(this).data('id');
        if (confirm('¿Estás seguro de que deseas eliminar esta categoría?')) {
            $.post('eliminar_categoria.php', { id: id }, function(response) {
                if (response == 'success') {
                    location.reload();
                } else {
                    alert('Error al eliminar categoría.');
                }
            });
        }
    });

    // Evento para enviar el formulario de edición
    $('#editCategoryForm').submit(function(e) {
        e.preventDefault();
        var formData = {
            id: $('#editCategoryId').val(),
            tipo: $('#editTipo').val(),
            descripcion: $('#editDescripcion').val(),
            precio: $('#editPrecio').val(),
            capacidad: $('#editCapacidad').val()
        };

        $.post('editar_categoria.php', formData, function(response) {
            if (response == 'success') {
                location.reload();
            } else {
                alert(response); // Mostrar el mensaje de error exacto
            }
        });
    });
});

    </script>
</body>
</html>
