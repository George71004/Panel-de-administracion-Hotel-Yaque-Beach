<?php
$conn = mysqli_connect('localhost', 'root', '', 'hotel_yaquebeach');

// Verificar conexión
if(!$conn){
    die("Error DB");
}

// Consulta SQL para obtener todas las habitaciones
$consulta = "SELECT h.id_habitacion, h.numero_habitacion, c.tipo, c.descripcion, c.precio, c.capacidad 
             FROM habitacion h 
             JOIN categoria c ON h.categoria = c.id_categoria";
$resultado = $conn->query($consulta);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Habitaciones</title>
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
        </ul>
    </div>

    <div id="content">
        <div class="container mt-5">
            <h1>Administrar Habitaciones</h1>
            <button class="btn btn-primary my-3" data-toggle="modal" data-target="#createRoomModal">Crear Habitación</button>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Número de Habitación</th>
                        <th>Tipo de Habitación</th>
                        <th>Descripción</th>
                        <th>Precio</th>
                        <th>Capacidad</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                // Mostrar habitaciones
                    if ($resultado->num_rows > 0) {
                        // Mostrar datos de cada fila
                        while($row = $resultado->fetch_assoc()) {
                            echo "<tr>
                                    <td>" . $row["id_habitacion"] . "</td>
                                    <td>" . $row["numero_habitacion"] . "</td>
                                    <td>" . $row["tipo"] . "</td>
                                    <td>" . $row["descripcion"] . "</td>
                                    <td>" . $row["precio"] . "</td>
                                    <td>" . $row["capacidad"] . "</td>
                                    <td class='table-actions'>
                                        <button class='btn btn-primary btn-action btn-sm edit-btn' data-toggle='modal' data-target='#editRoomModal' data-id='" . $row['id_habitacion'] . "' data-numero='" . $row['numero_habitacion'] . "' data-tipo='" . $row['tipo'] . "' data-descripcion='" . $row['descripcion'] . "' data-precio='" . $row['precio'] . "' data-capacidad='" . $row['capacidad'] . "'>Editar</button>
                                        <button class='btn btn-danger btn-sm delete-btn' data-id='" . $row['id_habitacion'] . "'>Eliminar</button>
                                    </td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>No hay habitaciones registradas</td></tr>";
                    }
                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Crear Habitación -->
    <div class="modal fade" id="createRoomModal" tabindex="-1" aria-labelledby="createRoomModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createRoomModalLabel">Crear Habitación</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="createRoomForm" action="insertar_habitacion.php" method="post">
                        <div class="form-group">
                            <label for="numero_habitacion">Número de Habitación</label>
                            <input type="text" class="form-control" id="numero_habitacion" name="numero_habitacion" required>
                        </div>
                        <div class="form-group">
                            <label for="categoria">Categoría</label>
                            <select class="form-control" id="categoria" name="categoria" required>
                                <?php
                                // Conectar de nuevo para obtener las categorías
                                $conn = mysqli_connect('localhost', 'root', '', 'hotel_yaquebeach');
                                $consulta_categoria = "SELECT id_categoria, tipo FROM categoria";
                                $resultado_categoria = $conn->query($consulta_categoria);
                                if ($resultado_categoria->num_rows > 0) {
                                    while($row_categoria = $resultado_categoria->fetch_assoc()) {
                                        echo "<option value='" . $row_categoria['id_categoria'] . "'>" . $row_categoria['tipo'] . "</option>";
                                    }
                                }
                                $conn->close();
                                ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Crear</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Editar Habitación -->
    <div class="modal fade" id="editRoomModal" tabindex="-1" aria-labelledby="editRoomModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editRoomModalLabel">Editar Habitación</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editRoomForm">
                        <input type="hidden" id="editRoomId">
                        <div class="form-group">
                            <label for="editNumeroHabitacion">Número de Habitación</label>
                            <input type="text" class="form-control" id="editNumeroHabitacion" required>
                        </div>
                        <div class="form-group">
                            <label for="editCategoria">Categoría</label>
                            <select class="form-control" id="editCategoria" required>
                                <?php
                                // Conectar de nuevo para obtener las categorías
                                $conn = mysqli_connect('localhost', 'root', '', 'hotel_yaquebeach');
                                $consulta_categoria = "SELECT id_categoria, tipo FROM categoria";
                                $resultado_categoria = $conn->query($consulta_categoria);
                                if ($resultado_categoria->num_rows > 0) {
                                    while($row_categoria = $resultado_categoria->fetch_assoc()) {
                                        echo "<option value='" . $row_categoria['id_categoria'] . "'>" . $row_categoria['tipo'] . "</option>";
                                    }
                                }
                                $conn->close();
                                ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Enlace a Bootstrap JS y dependencias -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        $(document).ready(function() {
            // Evento para mostrar datos en el modal de edición
            $('.edit-btn').click(function() {
                var id = $(this).data('id');
                var numero = $(this).data('numero');
                var tipo = $(this).data('tipo');
                var descripcion = $(this).data('descripcion');
                var precio = $(this).data('precio');
                var capacidad = $(this).data('capacidad');

                $('#editRoomId').val(id);
                $('#editNumeroHabitacion').val(numero);
                $('#editCategoria').val(tipo);
                $('#editDescripcion').val(descripcion);
                $('#editPrecio').val(precio);
                $('#editCapacidad').val(capacidad);
            });

            // Evento para manejar la eliminación de habitación
            $('.delete-btn').click(function() {
                var id = $(this).data('id');
                if (confirm('¿Estás seguro de que deseas eliminar esta habitación?')) {
                    $.post('eliminar_habitacion.php', { id: id }, function(response) {
                        if (response == 'success') {
                            location.reload();
                        } else {
                            alert('Error al eliminar habitación.');
                        }
                    });
                }
            });

            // Evento para enviar el formulario de edición
            $('#editRoomForm').submit(function(e) {
                e.preventDefault();
                var formData = {
                    id: $('#editRoomId').val(),
                    numero_habitacion: $('#editNumeroHabitacion').val(),
                    categoria: $('#editCategoria').val()
                };

                $.post('editar_habitacion.php', formData, function(response) {
                    if (response == 'success') {
                        location.reload();
                    } else {
                        alert('Error al editar habitación.');
                    }
                });
            });
        });
    </script>
</body>
</html>




