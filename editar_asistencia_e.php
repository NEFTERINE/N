<?php
session_start();

require_once('menu.php');
require_once('clases/Cliente.php');
require_once('clases/Calendario.php');
require_once('clases/Eventos.php');

// *** INSTANCIAMOS LAS CLASES AL PRINCIPIO ***
$eve = new Eventos();
$cliente = new Cliente();
$cal = new Calendario();

$asistencia_data = null; // Para guardar los datos del registro a editar

// --- LÓGICA PARA OBTENER LOS DATOS DE LA ASISTENCIA A EDITAR ---
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_asistencia_a_editar = $_GET['id'];
    // Llamamos al nuevo método que obtiene todos los detalles
    $asistencia_data = $eve->obtenerAsistenciaSimplePorId($id_asistencia_a_editar); 

    if (!$asistencia_data) {
        // Si el ID no existe, redirigir o mostrar un mensaje de error
        header('Location: asistencia_por_evento.php');
        exit();
    }
} else {
    // Si no se proporcionó un ID válido, redirigir
    header('Location: asistencia_por_evento.php');
    exit();
}

// --- LÓGICA PARA EL FORMULARIO DE BÚSQUEDA DE PERSONAS (Si la necesitas) ---
$apellido_buscado = $_GET['apellido'] ?? '';
$resultados_personas = [];
if (!empty($apellido_buscado)) {
    $resultados_personas = $cliente->buscarApellido($apellido_buscado);
    // Convertir el resultado de mysqli_query a un array si no lo hace ya
    // para poder reusar el resultado en el select
    $personas_array = [];
    while ($fila = mysqli_fetch_array($resultados_personas)) {
        $personas_array[] = $fila;
    }
    $resultados_personas = $personas_array; // Guardamos el array para usarlo
} else {
    // Si no se busca por apellido, cargar todas las personas (si es necesario)
    $resultados_personas_obj = $cliente->mostrarTodo();
    $personas_array = [];
    if ($resultados_personas_obj) { // Verificar si la consulta fue exitosa
        while ($fila = mysqli_fetch_array($resultados_personas_obj)) {
            $personas_array[] = $fila;
        }
    }
    $resultados_personas = $personas_array;
}

$tipos_eventos = $cal->mostrarT(); // Obtener todos los tipos de eventos

// --- LÓGICA PARA PROCESAR EL ENVÍO DEL FORMULARIO DE ACTUALIZACIÓN ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Asegúrate de que las validaciones y sanitización sean robustas
    $pk_asistencia_e = $_POST['pk_asistencia_e'] ?? null;
    $fk_persona = $_POST['fk_persona'] ?? null;
    $fk_c_eventos = $_POST['fk_c_eventos'] ?? null;
    $descripcion = $_POST['descripcion'] ?? '';

    // Validar y sanitizar los datos aquí

    if ($pk_asistencia_e && $fk_persona && $fk_c_eventos) {
        $actualizado = $eve->actualizar($pk_asistencia_e, $fk_persona, $fk_c_eventos, $descripcion);
        if ($actualizado) {
            $_SESSION['mensaje'] = "Registro actualizado con éxito.";
            header('Location: asistencia_por_evento.php'); // Redirige a la lista después de actualizar
            exit();
        } else {
            $_SESSION['error'] = "Error al actualizar el registro.";
            // Puedes recargar los datos del formulario si hubo un error para que el usuario no pierda lo que escribió
            $asistencia_data = $eve->obtenerAsistenciaSimplePorId($pk_asistencia_e);
        }
    } else {
        $_SESSION['error'] = "Faltan datos para la actualización.";
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Asistencia</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/estilos.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container mt-4">
        <h2 class="mb-4 text-center">Editar Asistencia</h2>

        <form method="GET" class="col-10 offset-1 mb-4">
            <div class="col-12 col-lg-6">
                <label for="apellido">Buscar por apellido:</label>
                <input type="hidden" name="id" value="<?= htmlspecialchars($id_asistencia_a_editar ?? '') ?>">
                <input type="text" class="form-control" name="apellido" value="<?= htmlspecialchars($apellido_buscado) ?>" onchange="this.form.submit()">
            </div>
        </form>

        <form method="POST" action="actualizar_asistencia_e.php?id=<?= htmlspecialchars($id_asistencia_a_editar ?? '') ?>" class="col-10 offset-1">
            <input type="hidden" name="pk_asistencia_e" value="<?= htmlspecialchars($asistencia_data['pk_asistencia_e'] ?? '') ?>">

            <div class="form-group col-12 col-lg-6">
                <label for="fk_persona">Seleccionar persona:</label>
                <select class="form-control" name="fk_persona" required>
                    <option value="">Selecciona una persona</option>
                    <?php foreach ($resultados_personas as $fila_persona): ?>
                        <option value="<?= htmlspecialchars($fila_persona['pk_persona']) ?>"
                            <?= (isset($asistencia_data['fk_persona']) && $fila_persona['pk_persona'] == $asistencia_data['fk_persona']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($fila_persona['nombres'] . ' ' . $fila_persona['ap_paterno'] . ' ' . $fila_persona['ap_materno']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <br>
            
            <div class="form-group col-12 col-lg-6">
                <label for="fk_c_eventos">Eventos:</label>
                <select class="form-control" name="fk_c_eventos" required>
                    <option value="">Selecciona un Evento</option>
                    <?php foreach ($tipos_eventos as $fila_evento): ?>
                        <option value="<?= htmlspecialchars($fila_evento['pk_c_eventos']) ?>"
                            <?= (isset($asistencia_data['fk_c_eventos']) && $fila_evento['pk_c_eventos'] == $asistencia_data['fk_c_eventos']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($fila_evento['tipo_evento']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <br>

            <div class="form-group col-12 col-lg-6">
                <label for="descripcion">Descripción</label>
                <input value="<?= htmlspecialchars($asistencia_data['descripcion'] ?? '') ?>" type="text" name="descripcion" class="form-control">
                <div style="color: #ffc107;">
                    *Se sugiere poner el tipo de participacion
                </div>
            </div>
            <br>

            <div class="row justify-content-center">
                <div class="col-auto">
                    <input class="btn btn-primary" type="submit" value="Guardar">
                </div>
                <div class="col-auto">
                    <a href="lista_asistencia_e.php" class="btn btn-secondary">Cancelar</a>
                </div>
            </div>
            <p class="p">¿La persona ocupa registrarse? <a href="formulario_persona_e.php">registrar</a></p>
        </form>

    </div>
</body>
</html>