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
    die("Error DB");
}

// Consulta SQL para obtener todos los usuarios
$consulta = "SELECT cedula, email, clave, nivel FROM usuario";
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
        .search-bar {
            float: right;
            margin-bottom: 10px;
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
        <h1>Administrar Usuarios</h1>
        <p>La eliminacion de usuarios se lleva a cabo en la opcion "Personas".</p>
        <p>Para otorgar el nivel de Administrador se coloca el nivel en "1", para revocar "00".</p>

        <div class="search-bar">
            <input type="text" id="searchInput" class="form-control" placeholder="Buscar...">
        </div>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Cédula</th>
                    <th>Email</th>
                    <th>Clave</th>
                    <th>Nivel</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="usuariosTableBody">
            <?php
            // Mostrar usuarios
            if ($resultado->num_rows > 0) {
                // Mostrar datos de cada fila
                while ($row = $resultado->fetch_assoc()) {
                    echo "<tr>
                            <td>" . $row["cedula"] . "</td>
                            <td>" . $row["email"] . "</td>
                            <td>" . $row["clave"] . "</td>
                            <td>" . $row["nivel"] . "</td>
                            <td class='table-actions'>
                                <button class='btn btn-primary btn-sm edit-btn' data-toggle='modal' data-target='#editUserModal' data-cedula='" . $row['cedula'] . "' data-email='" . $row['email'] . "' data-clave='" . $row['clave'] . "'>Editar</button>
                            </td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No hay usuarios registrados</td></tr>";
            }
            $conn->close();
            ?>
            </tbody>
        </table>
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
                        <input type="hidden" id="editCedula" name="cedula">
                        <div class="form-group">
                            <label for="editEmail">Email</label>
                            <input type="email" class="form-control" id="editEmail" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="editClave">Clave</label>
                            <input type="password" class="form-control" id="editClave" name="clave" required>
                        </div>
                        <div class="form-group">
                            <label for="editNivel">Nivel</label>
                            <input type="level" class="form-control" id="editNivel" name="nivel" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Enlace a jQuery y Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        // Script para rellenar el modal de edición con datos del usuario seleccionado
        $('#editUserModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Botón que activó el modal
            var cedula = button.data('cedula');
            var email = button.data('email');
            var clave = button.data('clave');
            var nivel = button.data('nivel');

            var modal = $(this);
            modal.find('#editCedula').val(cedula);
            modal.find('#editEmail').val(email);
            modal.find('#editClave').val(clave);
            modal.find('#editNivel').val(nivel);
        });

        // Script para manejar el formulario de edición y enviar datos al servidor
        $('#editUserForm').on('submit', function (event) {
            event.preventDefault();
            var formData = {
                cedula: $('#editCedula').val(),
                email: $('#editEmail').val(),
                clave: $('#editClave').val(),
                nivel: $('#editNivel').val()
            };

            $.ajax({
                url: 'editar_persona.php',
                type: 'POST',
                data: formData,
                success: function (response) {
                    // Ocultar el modal
                    $('#editUserModal').modal('hide');
                    // Recargar la página para ver los cambios
                    location.reload();
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });
            // Evento para buscar en la tabla
            $('#searchInput').on('keyup', function() {
                    var value = $(this).val().toLowerCase();
                    $('#usuariosTableBody tr').filter(function() {
                        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                    });
                });
    </script>
</body>
</html>
