<?php

$agregar = isset($_SESSION['type']) && in_array($_SESSION['type'], [2, 3, 5]);

require_once('menu.php');
require_once('clases/Calendario.php');
require_once('clases/Promotor.php'); // Asegúrate de incluir la clase Promotor

// -------- Lógica para el Calendario --------
$cal = new Calendario;
$respuesta_calendario = $cal->mostrarTodo(); // Renombré para evitar conflicto si 'respuesta' se usa en la clase Promotor

// -------- Lógica para la Gráfica de Promovidos --------
$promotor_obj = new Promotor();
// Asegúrate de que el método en tu clase Promotor se llama 'contarPromovidosPorPromotor'
// como lo definimos en la respuesta anterior. Si le pusiste 'cPPromotor', úsalo.
$datos_promovidos_para_grafica = $promotor_obj->cPPromotor();

// Prepara los datos para JavaScript de la gráfica
$labels_promovidos = [];
$data_promovidos = [];
if ($datos_promovidos_para_grafica) {
    foreach ($datos_promovidos_para_grafica as $item) {
        $labels_promovidos[] = $item['promotor_nombre_completo'];
        $data_promovidos[] = $item['cantidad'];
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Calendario y Gráfica</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/adminlte.min.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="fontawesome-free/all.min.css">
    <link rel="stylesheet" href="fullcalendar/main.css">
    <style>
        .titulo {
            text-align: center;
            font-size: 30px;
            margin-bottom: 20px;
            color: black;
        }
        header {
            background: none;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="moment/moment.min.js"></script>
    <script src="fullcalendar/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> </head>

<body class="hold-transition sidebar-mini">
<div class="wrapper">

    <?php if ($agregar): ?>
        <div class="modal fade" id="modalAgregarEvento" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form id="formEvento">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Nuevo Evento</h5>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" id="fecha">
                            <div class="form-group">
                                <label for="title">Título del evento</label>
                                <input type="text" id="title" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="descripcion">Descripción</label>
                                <textarea id="descripcion" class="form-control"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="hora_inicio">Hora de inicio</label>
                                <input type="time" id="hora_inicio" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="hora_fin">Hora de fin</label>
                                <input type="time" id="hora_fin" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="ubicacion">Ubicación</label>
                                <input type="text" id="ubicacion" class="form-control" required>
                            </div>
                            <?php if (!empty($respuesta_calendario) && is_object($respuesta_calendario) && mysqli_num_rows($respuesta_calendario) > 0): ?>
                                <div class="col-12 col-lg-6">
                                    <label for="fk_promotor">Promotor:</label>
                                    <select id="fk_promotor" class="form-control" name="fk_promotor" required>
                                        <option value="">Selecciona un promotor</option>
                                        <?php // Volver a "resetear" el puntero de resultados para el select si ya se usó antes
                                        mysqli_data_seek($respuesta_calendario, 0);
                                        while ($fila = mysqli_fetch_array($respuesta_calendario)): ?>
                                            <option value="<?= htmlspecialchars($fila['pk_promotor']) ?>">
                                                <?= htmlspecialchars($fila['nombres'] . ' ' . $fila['ap_paterno'] . ' ' . $fila['ap_materno']) ?>
                                            </option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    <?php endif; ?>

    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid pt-4">

                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Calendario de Eventos</h3>
                    </div>
                    <div class="card-body">
                        <div id="calendar"></div>
                    </div>
                </div>

                <?php if (isset($_SESSION['pk_usuario'])): // Puedes ajustar esta condición según quién deba ver la gráfica ?>
                    <div class="card card-info mt-4"> <div class="card-header">
                            <h3 class="card-title">Gráfica de Promovidos por Promotor</h3>
                        </div>
                        <div class="card-body">
                            <canvas id="promovidosChart"></canvas>
                        </div>
                    </div>
                <?php endif; ?>

            </div>
        </section>
    </div>
</div>

<script>
    // FullCalendar JS
    document.addEventListener('DOMContentLoaded', function () {
        let calendarEl = document.getElementById('calendar');
        let calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            locale: 'es',
            selectable: <?= $agregar ? 'true' : 'false' ?>,
            editable: false,
            events: 'eventos.php',

            eventClick: function(info) {
                const eventoId = info.event.id;
                if (eventoId) {
                    window.location.href = `detalle_evento.php?id=${eventoId}`;
                }
            },

            select: function(info) {
                document.getElementById('fecha').value = info.startStr;
                document.getElementById('title').value = '';
                document.getElementById('descripcion').value = '';
                document.getElementById('hora_inicio').value = '';
                document.getElementById('hora_fin').value = '';
                document.getElementById('ubicacion').value = '';
                document.getElementById('fk_promotor').value = '';
                $('#modalAgregarEvento').modal('show');
            }
        });
        calendar.render();

        // Manejador de envío del formulario de evento
        document.getElementById('formEvento').addEventListener('submit', function(e) {
            e.preventDefault();

            let fecha = document.getElementById('fecha').value;
            let title = document.getElementById('title').value;
            let descripcion = document.getElementById('descripcion').value;
            let hora_inicio = document.getElementById('hora_inicio').value;
            let hora_fin = document.getElementById('hora_fin').value;
            let ubicacion = document.getElementById('ubicacion').value;
            let fk_promotor = document.getElementById('fk_promotor').value;

            let fecha_inicio = `${fecha} ${hora_inicio}`;
            let fecha_fin = `${fecha} ${hora_fin}`;

            fetch('guardar_eventos.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: new URLSearchParams({
                    title: title,
                    descripcion: descripcion,
                    hora_inicio: hora_inicio,
                    hora_fin: hora_fin,
                    fecha_inicio: fecha_inicio,
                    fecha_fin: fecha_fin,
                    ubicacion: ubicacion,
                    fk_promotor: fk_promotor
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'ok') {
                    $('#modalAgregarEvento').modal('hide');
                    calendar.refetchEvents();
                } else {
                    alert('Error al guardar el evento: ' + data.message);
                }
            })
            .catch(error => console.error('Error:', error)); // Agrega manejo de errores
        });
    });

    // Chart.js para la gráfica de promovidos
    <?php if (isset($_SESSION['pk_usuario'])): // Solo si el usuario tiene permiso para ver la gráfica ?>
        document.addEventListener('DOMContentLoaded', function () {
            const labelsPromovidos = <?php echo json_encode($labels_promovidos); ?>;
            const dataPromovidos = <?php echo json_encode($data_promovidos); ?>;

            if (labelsPromovidos.length > 0 && dataPromovidos.length > 0) { // Solo si hay datos
                const ctxPromovidos = document.getElementById('promovidosChart').getContext('2d');
                new Chart(ctxPromovidos, {
                    type: 'bar',
                    data: {
                        labels: labelsPromovidos,
                        datasets: [{
                            label: 'Cantidad de Promovidos por Promotor',
                            data: dataPromovidos,
                            backgroundColor: 'rgba(75, 192, 192, 0.5)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Número de Promovidos'
                                }
                            },
                            x: {
                                title: {
                                    display: true,
                                    text: 'Nombre del Promotor'
                                }
                            }
                        },
                        plugins: {
                            title: {
                                display: true,
                                text: 'Total de Promovidos Asignados por Cada Promotor'
                            }
                        }
                    }
                });
            } else {
                // Si no hay datos, puedes mostrar un mensaje en lugar de la gráfica vacía
                const chartContainer = document.getElementById('promovidosChart').parentNode;
                chartContainer.innerHTML = '<p class="text-center">No hay datos de promovidos por promotor para mostrar la gráfica.</p>';
            }
        });
    <?php endif; ?>
</script>
</body>
</html>