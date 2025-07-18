<?php

$agregar = isset($_SESSION['type']) && in_array($_SESSION['type'], [2, 3, 5]);

require_once('menu.php');
require_once('clases/Calendario.php');
$cal = new Calendario;

$respuesta = $cal->mostrarTodo();


?>

<?php if ($agregar): ?>
  <!-- Mostrar botón de agregar evento, el modal y la función select del calendario -->

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Calendario</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/adminlte.min.css">
  <link rel="stylesheet" href="css/bootstrap.css">
  <link rel="stylesheet" href="fontawesome-free/all.min.css">
  <link rel="stylesheet" href="fullcalendar/main.css">
</head>

<body class="hold-transition sidebar-mini">
<div class="wrapper">

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
          
          <?php if (!empty($respuesta)): ?>
            <div class="col-12 col-lg-6">
                <label for="fk_promotor">promotor:</label>
                <select id="fk_promotor" class="form-control" name="fk_promotor" required>
                    <option value="">Selecciona un promotor</option>
                    <?php while ($fila = mysqli_fetch_array($respuesta)): ?>
                        <option value="<?= $fila['pk_promotor'] ?>">
                            <?= $fila['nombres'] . ' ' . $fila['ap_paterno'] . ' ' . $fila['ap_materno'] ?>
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

<!-- Contenido principal para todos -->
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

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="moment/moment.min.js"></script>
<script src="fullcalendar/main.js"></script>

<script>
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
    });
  });
});
</script>
</body>
</html>
<?php else: ?>
  <script>
    console.log("No tienes permisos para agregar eventos.");
  </script>
<?php endif; ?>