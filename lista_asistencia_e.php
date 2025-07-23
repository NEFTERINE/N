<?php
require_once('menu.php');
require_once('clases/Eventos.php'); // Tu clase Eventos

$eventos_obj = new Eventos();
$asistentes_del_evento = [];
$nombre_del_evento = "Evento Desconocido"; // Valor por defecto
$id_evento_seleccionado = null; // Para almacenar el ID del evento actual

if (isset($_GET['id_evento']) && is_numeric($_GET['id_evento'])) {
    $id_evento_seleccionado = $_GET['id_evento'];
    
    // Obtener la lista de asistentes para este evento
    $asistentes_del_evento = $eventos_obj->obtenerAsistentesPorIdEvento($id_evento_seleccionado);

    // Intentar obtener el nombre del evento para el título de la página
    if (!empty($asistentes_del_evento)) {
        $nombre_del_evento = $asistentes_del_evento[0]['tipo_evento']; // Obtenemos el nombre del primer asistente
    } else {
        // Si no hay asistentes, buscamos el nombre del evento directamente por su ID
        // Esto es útil si un evento existe pero aún no tiene asistentes registrados
        $todos_los_eventos = $eventos_obj->mostrarT(); // Este método debe devolver pk_c_eventos y tipo_evento
        foreach ($todos_los_eventos as $evento_item) {
            if ($evento_item['pk_c_eventos'] == $id_evento_seleccionado) {
                $nombre_del_evento = $evento_item['tipo_evento'];
                break;
            }
        }
    }
} else {
    // Si no se proporcionó un ID de evento válido, redirigir a la lista de eventos
    header('Location: lista_eventos.php'); // Redirige a la página que lista los eventos
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/estilos.css">
    <link rel="stylesheet" href="css/all.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <title>Asistentes del Evento: <?= htmlspecialchars($nombre_del_evento) ?></title>

    <style>
        .titulo {
            text-align: center;
            font-size: 30px;
            margin-bottom: 20px;
            color: black;
        }
        header {
            background: none; /* Si tu menú tiene un fondo, esto lo quita para este body */
        }
        /* Ajustes para la tabla, similar a tu ejemplo de coordinadores */
        .table th, .table td {
            vertical-align: middle; /* Centra el contenido verticalmente en las celdas */
        }
        .table thead th {
            background-color: #f8f9fa; /* Un ligero fondo para la cabecera */
            border-bottom: 2px solid #dee2e6;
        }
        .table tbody tr:hover {
            background-color: #f2f2f2; /* Ligero cambio de color al pasar el mouse */
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="col-12"> <br><br><br><br><br><br><br>
            <h2 class="titulo">Asistentes del Evento: <?= htmlspecialchars($nombre_del_evento) ?></h2><br><br>
            
            <?php if (empty($asistentes_del_evento)): ?>
                <div class="alert alert-info text-center mt-3" role="alert">
                    No hay asistencia registrada para este evento.
                </div>
            <?php else: ?>
                <table class="table table-hover table-bordered"> <thead>
                        <tr>
                            <th>Nombre Completo</th>
                            <th>Descripción</th>
                            <th>Fecha de Registro</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($asistentes_del_evento as $asistencia_item) {
                        ?>
                            <tr>
                                <td><?= htmlspecialchars($asistencia_item['nombres'] . " " . $asistencia_item['ap_paterno'] . " " . $asistencia_item['ap_materno']) ?></td>
                                <td><?= htmlspecialchars($asistencia_item['descripcion']) ?></td>
                                <td><?= htmlspecialchars($asistencia_item['fecha_Registro']) ?></td>
                                <td>
                                    <a href="editar_asistencia_e.php?id=<?= htmlspecialchars($asistencia_item['id_asistencia']) ?>" class="btn btn-warning btn-sm">Editar</a>
                                    </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            <?php endif; ?>
            
            <br><br><br>
            <div class="row justify-content-center">
                <div class="col-auto">
                    <a class="btn btn-info" href="formulario_asistencia_e.php?id_evento=<?= htmlspecialchars($id_evento_seleccionado) ?>">Agregar Nuevo Asistente a este Evento</a>
                </div>
                <div class="col-auto">
                    <a class="btn btn-secondary" href="lista_eventos.php">Volver a Eventos</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>