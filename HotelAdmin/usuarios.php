<?php
//LOGEADO??
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: index.html");
    exit;
}
//ESTE ARCHIVO SERA UTILIZADO COMO LA TABLA DE PERSONAS
$conn = mysqli_connect('localhost', 'root', '', 'hotel_yaquebeach');

// Verificar conexión
if(!$conn){
    die("Error DB");
}

// Consulta SQL para obtener todos los usuarios
$consulta = "SELECT cedula, nombre, apellido, email, telefono FROM persona";
$resultado = $conn->query($consulta);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Usuarios</title>
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
        .table-actions {
            width: 100px; /* Ajusta el ancho según sea necesario */
            text-align: center;
        }
        .btn-action {
            margin-bottom: 5px; /* Ajusta el margen derecho según sea necesario */
        }
        .search-bar {
            float: right;
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
        <div class="container mt-5">
            <h1>Administrar Personas</h1>
            <div class="search-bar">
                <input type="text" id="searchInput" class="form-control" placeholder="Buscar...">
            </div>
            <button class="btn btn-primary my-3" data-toggle="modal" data-target="#createUserModal">Crear Persona</button>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Cédula</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Teléfono</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="personasTableBody">
                <?php
                //Mostrar usuarios
                    if ($resultado->num_rows > 0) {
                        // Mostrar datos de cada fila
                        while($row = $resultado->fetch_assoc()) {
                            echo "<tr>
                                    <td>" . $row["cedula"] . "</td>
                                    <td>" . $row["nombre"] . "</td>
                                    <td>" . $row["apellido"] . "</td>
                                    <td>" . $row["telefono"] . "</td>
                                    <td class='table-actions'>
                                        <button class='btn btn-primary btn-sm btn-action edit-btn' data-toggle='modal' data-target='#editPersonModal' data-cedula='" . $row['cedula'] . "' data-nombre='" . $row['nombre'] . "'>Editar</button>
                                        <button class='btn btn-danger btn-sm delete-btn' data-id='" . $row['cedula'] . "'>Eliminar</button>
                                    </td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>No hay personas registradas</td></tr>";
                    }
                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Crear Usuario -->
    <div class="modal fade" id="createUserModal" tabindex="-1" aria-labelledby="createUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createUserModalLabel">Crear Usuario</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="createUserForm" action="insertar_usuario.php" method="post">
                        <div class="form-group">
                            <label for="cedula">Cédula</label>
                            <input type="text" class="form-control" id="cedula" name="cedula" required>
                        </div>
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>
                        <div class="form-group">
                            <label for="apellido">Apellido</label>
                            <input type="text" class="form-control" id="apellido" name="apellido" required>
                        </div>
                        <div class="form-group">
                            <label for="telefono">Teléfono</label>
                            <input type="text" class="form-control" id="telefono" name="telefono" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Crear</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Editar Usuario -->
    <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editUserModalLabel">Editar Usuario</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editUserForm">
                        <input type="hidden" id="editUserId">
                        <div class="form-group">
                            <label for="editCedula">Cédula</label>
                            <input type="text" class="form-control" id="editCedula" required>
                        </div>
                        <div class="form-group">
                            <label for="editNombre">Nombre</label>
                            <input type="text" class="form-control" id="editNombre" required>
                        </div>
                        <div class="form-group">
                            <label for="editApellido">Apellido</label>
                            <input type="text" class="form-control" id="editApellido" required>
                        </div>
                        <div class="form-group">
                            <label for="editTelefono">Teléfono</label>
                            <input type="text" class="form-control" id="editTelefono" required>
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
                var nombre = $(this).data('nombre');
                var apellido = $(this).data('apellido');
                var telefono = $(this).data('telefono');

                $('#editUserId').val(id);
                $('#editCedula').val(id);
                $('#editNombre').val(nombre);
                $('#editApellido').val(apellido);
                $('#editTelefono').val(telefono);
            });

            // Evento para manejar la eliminación de usuario
            $('.delete-btn').click(function() {
                var id = $(this).data('id');
                if (confirm('¿Estás seguro de que deseas eliminar este usuario?')) {
                    $.post('eliminar_usuario.php', { id: id }, function(response) {
                        if (response == 'success') {
                            location.reload();
                        } else {
                            alert('Error al eliminar usuario.');
                        }
                    });
                }
            });

            // Evento para enviar el formulario de edición
            $('#editUserForm').submit(function(e) {
                e.preventDefault();
                var formData = {
                    id: $('#editUserId').val(),
                    cedula: $('#editCedula').val(),
                    nombre: $('#editNombre').val(),
                    apellido: $('#editApellido').val(),
                    telefono: $('#editTelefono').val()
                };

                $.post('editar_usuario.php', formData, function(response) {
                    if (response == 'success') {
                        location.reload();
                    } else {
                        alert('Error al editar usuario.');
                    }
                });
            });
        });
         // Evento para buscar en la tabla
         $('#searchInput').on('keyup', function() {
                var value = $(this).val().toLowerCase();
                $('#personasTableBody tr').filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                });
            });
    </script>
</body>
</html>
