<!DOCTYPE html>
<html lang="es">

<head>
    <link rel="stylesheet" href="css/estilos.css?a=1">
    <link rel="stylesheet" href="css/all.css">
    <link rel="stylesheet" href="css/bootstrap.css?a=1">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Líder/Coordinador</title>
</head>
<style>
    header {
        background: none;
    }
</style>
<?php
// Asegúrate de que 'menu.php' y tus clases se incluyan correctamente
// y que tus clases (`Tipo`, `Rol`, `Territorio`, `Estado`, `Lider_coordinador`)
// manejen su conexión a la base de datos de forma autónoma o recibiéndola al instanciarse.
require_once('menu.php');

require_once('clases/Tipo.php');
// require_once('clases/Cliente.php'); // Comentado si no se usa
require_once('clases/Rol.php');
require_once('clases/Territorio.php');
require_once('clases/Estado.php');
require_once('clases/Lider_coordinador.php');

$tipo = new Tipo();
$rol = new Rol();
$territorio = new Territorio();
$estado = new Estado();
$lider = new Lider_coordinador();

$pk_lider_coordinador = $_GET['pk_lider_coordinador'] ?? null;

if (!$pk_lider_coordinador) {
    echo "<script>alert('ID de líder no proporcionado.'); window.location.href = 'lista_lideres.php';</script>";
    exit;
}

// 1. Obtener los datos actuales del líder desde la base de datos
$respuesta_lider = $lider->buscar($pk_lider_coordinador);
$datos_lider_bd = mysqli_fetch_assoc($respuesta_lider);

if (!$datos_lider_bd) {
    echo "<script>alert('Líder no encontrado.'); window.location.href = 'lista_lideres.php';</script>";
    exit;
}

// 2. Determinar qué valores se deben usar para preseleccionar los selects y filtrar

// Inicializa con los valores del líder de la BD, verificando si existen
$estado_actual_seleccionado = isset($datos_lider_bd['fk_estado']) ? $datos_lider_bd['fk_estado'] : null;
$tipo_actual_seleccionado = isset($datos_lider_bd['fk_tipo']) ? $datos_lider_bd['fk_tipo'] : null;

// Si el usuario ya seleccionó un estado/tipo y recargó la página (vía GET),
// sobrescribe los valores predeterminados con los de $_GET.
if (isset($_GET['fk_estado']) && $_GET['fk_estado'] !== '') { // Agregamos !== '' para ignorar selecciones vacías
    $estado_actual_seleccionado = $_GET['fk_estado'];
}
if (isset($_GET['fk_tipo']) && $_GET['fk_tipo'] !== '') { // Agregamos !== '' para ignorar selecciones vacías
    $tipo_actual_seleccionado = $_GET['fk_tipo'];
}

// 3. Obtener todas las opciones disponibles para los selects principales
$tipos_disponibles = $tipo->mostrarTodo();
$estados_disponibles = $estado->mostrarTodo();

// 4. Obtener las opciones para los selects dependientes (municipios y roles)
$municipios_para_mostrar = [];
if (!empty($estado_actual_seleccionado)) {
    $resultado_municipios = $territorio->obtenerPorEstado($estado_actual_seleccionado);
    if ($resultado_municipios && mysqli_num_rows($resultado_municipios) > 0) { // Verifica también si hay filas
        while ($fila = mysqli_fetch_assoc($resultado_municipios)) {
            $municipios_para_mostrar[] = $fila;
        }
    }
}

$roles_para_mostrar = [];
if (!empty($tipo_actual_seleccionado)) {
    $resultado_roles = $rol->mostrarTodo($tipo_actual_seleccionado);
    if ($resultado_roles && mysqli_num_rows($resultado_roles) > 0) { // Verifica también si hay filas
        while ($fila = mysqli_fetch_assoc($resultado_roles)) {
            $roles_para_mostrar[] = $fila;
        }
    }
}
?>

<body>
    <br><br><br>
    <h2>Editar coordinarores</h2><br>

    <form method="POST" action="actualizar_coordinador.php?pk_lider_coordinador=<?= $pk_lider_coordinador ?>" class="col-10 offset-1">
        <input type="hidden" name="pk_lider_coordinador" value="<?= $pk_lider_coordinador ?>">

        <div class="col-12 col-lg-9">
            <label for="nombre_lider">Nombre del Líder:</label>
            <input type="text" class="form-control" id="nombre_lider" name="nombre_lider"
                value="<?= htmlspecialchars($datos_lider_bd['nombre_persona'] . ' ' . $datos_lider_bd['apellido_paterno_persona'] . ' ' . $datos_lider_bd['apellido_materno_persona'] ?? '') ?>" required>
        </div>
        <br>
        <div class="col-12 col-lg-6">
            <label for="fk_estado">Estado</label>
            <select class="form-control" name="fk_estado" onchange="this.form.submit()">
                <option value="">Selecciona un estado</option>
                <?php while ($fila_estado = mysqli_fetch_assoc($estados_disponibles)): ?>
                    <option value="<?= $fila_estado['pk_estado'] ?>" <?= ($estado_actual_seleccionado == $fila_estado['pk_estado']) ? 'selected' : '' ?>>
                        <?= $fila_estado['nombre_estado'] ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <br>
        <div class="col-12 col-lg-6">
            <label for="fk_tipo">Tipo</label>
            <select class="form-control" name="fk_tipo" onchange="this.form.submit()">
                <option value="">Selecciona un tipo</option>
                <?php while ($fila_tipo = mysqli_fetch_assoc($tipos_disponibles)): ?>
                    <option value="<?= $fila_tipo['pk_tipo'] ?>" <?= ($tipo_actual_seleccionado == $fila_tipo['pk_tipo']) ? 'selected' : '' ?>>
                        <?= $fila_tipo['Tipo'] ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <br>
        <div class="col-12 col-lg-6">
            <label for="fk_territorio">Municipio</label>
            <select class="form-control" name="fk_territorio" required>
                <option value="">Selecciona un municipio</option>
                <?php foreach ($municipios_para_mostrar as $fila_municipio): ?>
                    <option value="<?= $fila_municipio['pk_territorio'] ?>" <?= ($datos_lider_bd['fk_territorio'] == $fila_municipio['pk_territorio']) ? 'selected' : '' ?>>
                        <?= $fila_municipio['municipio'] ?> - Dto <?= $fila_municipio['fk_distrito'] ?> - Sec <?= $fila_municipio['fk_secciones'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <br>
        <div class="col-12 col-lg-6">
            <label for="fk_rol">Rol</label>
            <select class="form-control" name="fk_rol" required>
                <option value="">Selecciona un rol</option>
                <?php foreach ($roles_para_mostrar as $fila_rol): ?>
                    <option value="<?= $fila_rol['pk_rol'] ?>" <?= ($datos_lider_bd['fk_rol'] == $fila_rol['pk_rol']) ? 'selected' : '' ?>>
                        <?= $fila_rol['nom_rol'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <br><br>
        <div class="row justify-content-center">
            <div class="col-auto">
                <input class="btn btn-primary" type="submit" value="Actualizar">
            </div>
            <div class="col-auto">
                <a href="lista_coordinador.php" class="btn btn-secondary">Cancelar</a>
            </div>
        </div>
    </form>
</body>

</html>