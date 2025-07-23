<?php
require_once('menu.php');
require_once('clases/Eventos.php');

$eventos_obj = new Eventos();
// Usamos mostrarT() para obtener la lista de eventos
$lista_eventos = $eventos_obj->mostrarT(); 
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Eventos</title>
    <link rel="stylesheet" href="css/estilos.css?a=16">
    <link rel="stylesheet" href="css/style.css?r=8">
    <link rel="stylesheet" href="css/all.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

    <style>
        /* Estilos para el título (si no está ya en tu CSS externo) */
        .titulo-centrado {
            text-align: center;
            /* Puedes ajustar el margen o tamaño de fuente si es necesario */
            margin-bottom: 30px; 
            font-size: 2.5rem; /* Un poco más grande para el título principal */
            color: #333; /* Color de texto más oscuro */
        }

        /* Estilos para que toda la tarjeta sea clicable */
        .event-card-link {
            text-decoration: none;
            color: inherit;
            display: block; /* Hace que el enlace ocupe toda la tarjeta */
            height: 100%; /* Asegura que la tarjeta sea clicable en toda su altura */
        }
        .event-card {
            border: 1px solid #dee2e6;
            border-radius: 0.25rem;
            margin-bottom: 20px;
            box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,.075);
            transition: transform 0.2s, box-shadow 0.2s;
            background-color: #fff;
            cursor: pointer; /* Indicar que es clicable */
            height: 100%; /* Ajuste para que las tarjetas tengan la misma altura si están en una fila */
        }
        .event-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 0.5rem 1rem rgba(0,0,0,.15);
        }
        .event-card-body {
            padding: 1.25rem;
            text-align: center;
            display: flex; /* Para centrar contenido verticalmente si es necesario */
            flex-direction: column;
            justify-content: center;
            height: 100%;
        }
        .event-card-title {
            font-size: 1.5rem;
            font-weight: bold;
            color: #007bff;
            margin-bottom: 0;
        }

        /* --- CAMBIOS PARA LA CASCADA --- */
        /* Eliminamos las clases de columna responsivas para que siempre ocupe 12 de 12 */
        .col-12.col-sm-6.col-md-4.col-lg-3.mb-4.d-flex {
            /* Mantenemos col-12 para que ocupe todo el ancho */
            /* Eliminamos col-sm-6, col-md-4, col-lg-3 */
            /* Mantenemos mb-4 para el margen inferior */
            /* Mantenemos d-flex para que el enlace ocupe todo el alto */
            flex: 0 0 100%; /* Asegura que ocupe el 100% del ancho de su padre */
            max-width: 100%; /* Asegura que no exceda el 100% */
        }
        /* Para que las tarjetas no se vean demasiado anchas en monitores grandes */
        @media (min-width: 768px) { /* A partir de tabletas */
            .col-md-8-centered { /* Nueva clase para centrar el contenido y limitar su ancho */
                max-width: 700px; /* Ancho máximo para el contenedor de las tarjetas */
                margin-left: auto;
                margin-right: auto;
            }
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <h2 class="titulo-centrado">Selecciona un Evento</h2>

        <div class="row justify-content-center">
            <div class="col-12 col-md-8-centered"> 
                <?php if (empty($lista_eventos)): ?>
                    <div class="alert alert-info text-center" role="alert">
                        No hay eventos registrados.
                    </div>
                <?php else: ?>
                    <?php foreach ($lista_eventos as $evento): ?>
                        <div class="col-12 mb-4 d-flex"> <a href="lista_asistencia_e.php?id_evento=<?= htmlspecialchars($evento['pk_c_eventos']) ?>" class="event-card-link">
                                <div class="card event-card">
                                    <div class="card-body event-card-body">
                                        <h5 class="card-title event-card-title"><?= htmlspecialchars($evento['tipo_evento']) ?></h5>
                                        <p class="card-text text-muted">Haz clic para gestionar asistencia</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <div class="row justify-content-center mt-4">
            <div class="col-auto">
                <a href="index.php" class="btn btn-secondary">Volver al Inicio</a>
            </div>
        </div>
    </div>
</body>
</html>