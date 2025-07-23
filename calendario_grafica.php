<?php 
 // Asegúrate de iniciar la sesión si no lo haces en 'menu.php'
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard de Eventos</title>
    <link rel="stylesheet" href="css/estilos.css?a=16">
    <link rel="stylesheet" href="css/style.css?r=8">
    <link rel="stylesheet" href="css/all.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css' rel='stylesheet' />
    <style>
        /* Estilos generales para centrar el contenido principal */
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh; /* Asegura que el body ocupe al menos el 100% del alto de la ventana */
        }
        .main-content-container {
            flex-grow: 1; /* Permite que este contenedor se expanda para llenar el espacio disponible */
            display: flex;
            align-items: center; /* Centra verticalmente el contenido dentro de .main-content-container */
            justify-content: center; /* Centra horizontalmente el contenido dentro de .main-content-container */
            padding: 20px 0; /* Espaciado superior e inferior */
        }

        /* Estilos para el título */
        .dashboard-title {
            text-align: center;
            font-size: 2.5rem; /* Ajusta el tamaño del título */
            color: #333;
            margin-top: 50px; /* Espacio superior para el título después del menú */
            margin-bottom: 30px;
        }

        /* Estilos para los contenedores del calendario y la gráfica */
        .widget-container {
            background-color: #fff;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px; /* Espacio entre los widgets si se apilan en móvil */
            height: 100%; /* Asegura que ambos widgets ocupen el mismo alto en la fila */
            display: flex; /* Para flexibilidad interna del widget si es necesario */
            flex-direction: column;
            /* justify-content: center;  Eliminado para permitir que el contenido del widget determine su verticalidad */
            /* align-items: center; */ /* Eliminado para permitir que el contenido del widget determine su horizontalidad */
        }
        
        /* Asegurarse que el calendario y la gráfica se muestren bien dentro de su widget */
        #calendar {
            width: 100%;
            /* Puedes ajustar la altura mínima si lo necesitas, pero FullCalendar es responsive */
            /* min-height: 300px; */ 
        }
        #promovidosChart {
            width: 100% !important; /* Asegura que la gráfica ocupe el ancho completo */
            height: 300px !important; /* Altura fija para la gráfica, ajústala si es necesario */
        }


        /* Responsive adjustments for columns */
        @media (min-width: 992px) { /* Para pantallas grandes (lg y xl) */
            .col-lg-6 {
                flex: 0 0 50%;
                max-width: 50%;
            }
        }
    </style>
</head>
<body>
    <?php require_once('menu.php'); ?>

    <div class="container main-content-container">
        <div class="row justify-content-center w-100">
            <div class="col-12">
            <div class="row mt-4 justify-content-end">
            <div class="col-auto">
                <a href="Lista_eventos.php" class="btn btn-secondary">Lista de eventos</a>
            </div>
                        <div class="col-auto">
                <a href="index.php" class="btn btn-secondary">Volver al Inicio</a>
            </div>
        </div>               
            </div>
            
            <div class="col-12 col-md-10 col-lg-6 mb-4 d-flex">
                <div class="widget-container w-100">
                    <h3>Calendario de Eventos</h3>
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
                                                    <div class="col-12"> <label for="fk_promotor">Promotor:</label>
                                                        <select id="fk_promotor" class="form-control" name="fk_promotor" required>
                                                            <option value="">Selecciona un promotor</option>
                                                            <?php 
                                                            mysqli_data_seek($respuesta_calendario, 0); // Reestablece el puntero
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
                                        <div class="card-body">
                                            <div id="calendar"></div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/locales/es.js'></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // FullCalendar JS Initialization
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
                editable: false, // Los eventos no son arrastrables/redimensionables por defecto
                events: 'eventos.php', // URL donde FullCalendar buscará los eventos

                eventClick: function(info) {
                    const eventoId = info.event.id;
                    if (eventoId) {
                        // Redirige a la página de detalles del evento cuando se hace clic
                        window.location.href = `detalle_evento.php?id=${eventoId}`;
                    }
                },

                select: function(info) {
                    // Abre el modal para agregar un evento cuando se selecciona una fecha
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

            // Handle form submission for adding event
            const formEvento = document.getElementById('formEvento');
            if (formEvento) { // Asegúrate de que el formulario exista si el usuario tiene permisos para agregar
                formEvento.addEventListener('submit', function(e) {
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
                            calendar.refetchEvents(); // Vuelve a cargar los eventos en el calendario
                        } else {
                            alert('Error al guardar el evento: ' + data.message);
                        }
                    })
                    .catch(error => console.error('Error al guardar evento:', error));
                });
            }
        });
    </script> 
</body>
</html>