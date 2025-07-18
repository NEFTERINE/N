<?php
session_start(); // Esto debe ser lo primero, antes de cualquier salida

require_once('menu.php');
require_once('clases/Tipo.php');
require_once('clases/Cliente.php');
require_once('clases/Rol.php');
require_once('clases/Lider_coordinador.php');
require_once('clases/Promotor.php');

$promotor = new Promotor();
$tipo = new Tipo();
$cliente = new Cliente();
$rol = new Rol();
$lider = new Lider_coordinador();

$pk_promotor = $_GET['id'] ?? null;
$datos = []; // Array para almacenar los datos del promotor actual

// 1. Obtener los datos del promotor si se proporciona un ID
if ($pk_promotor) {
    $respuesta_promotor = $promotor->buscar($pk_promotor);
    $datos = mysqli_fetch_assoc($respuesta_promotor) ?: [];
    // Opcional: Redirigir si el promotor no se encuentra
    if (!$datos) {
        header('Location: lista_promotor.php?error=notfound'); // Redirige si el ID no es válido
        exit();
    }
} else {
    // Si no hay ID, puedes redirigir o preparar un formulario vacío para "nuevo" (aunque este es para "editar")
    header('Location: lista_promotor.php?error=noid');
    exit();
}

// 2. Variables para la pre-selección de los dropdowns, priorizando GET sobre los datos actuales
$fk_lider_coordinador = $_GET['fk_lider_coordinador'] ?? ($datos['fk_lider_coordinador'] ?? '');
$fk_tipo = $_GET['fk_tipo'] ?? ($datos['fk_tipo'] ?? '');

// 3. Obtener datos para poblar los dropdowns
// Convertir mysqli_result a array para los bucles foreach
$personas_result = $cliente->mostrarTodo();
$personas = [];
if ($personas_result) {
    while ($row = mysqli_fetch_assoc($personas_result)) {
        $personas[] = $row;
    }
}

$lideres_result = $lider->mostrar(); // Asumiendo que 'mostrar()' de Lider_coordinador devuelve un mysqli_result
$lideres = [];
if ($lideres_result) {
    while ($row = mysqli_fetch_assoc($lideres_result)) {
        $lideres[] = $row;
    }
}

// Los roles dependen del fk_tipo. Si fk_tipo no está presente, $roles será un array vacío.
$roles = [];
if (!empty($fk_tipo)) {
    $roles_result = $rol->mostrarTodo($fk_tipo);
    if ($roles_result) {
        while ($row = mysqli_fetch_assoc($roles_result)) {
            $roles[] = $row;
        }
    }
}

// Los tipos se siguen usando con mysqli_fetch_assoc() directamente en el HTML
$tipos_result = $tipo->mostrarTodo(); // Renombrado para claridad

// Búsqueda por apellido
$apellido = $_GET['apellido'] ?? '';
// Si el usuario busca por apellido, $personas ya se ha llenado con mostrarTodo(), no buscarApellido()
// Si quieres que el filtro de apellido restrinja las opciones, deberías aplicar el filtro aquí:
if (!empty($apellido)) {
    // Si Cliente tiene un método buscarApellido($apellido) que devuelve mysqli_result, úsalo:
    // $personas_filtradas_result = $cliente->buscarApellido($apellido);
    // $personas = [];
    // if ($personas_filtradas_result) {
    //     while ($row = mysqli_fetch_assoc($personas_filtradas_result)) {
    //         $personas[] = $row;
    //     }
    // }
    // De lo contrario, si 'mostrarTodo' ya carga todo, deberías filtrar el array $personas
    $personas_filtradas = [];
    foreach ($personas as $persona_item) {
        $full_name = strtolower($persona_item['nombres'] . ' ' . $persona_item['ap_paterno'] . ' ' . $persona_item['ap_materno']);
        if (strpos($full_name, strtolower($apellido)) !== false) {
            $personas_filtradas[] = $persona_item;
        }
    }
    $personas = $personas_filtradas;
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Promotor</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/estilos.css">
    <link rel="stylesheet" href="css/all.css">
    </head>
<body>
    <br><br><br>
    <div class="container">
        <h2>Editar Promotor</h2>

        <form method="GET" class="col-10 offset-1">
            <input type="hidden" name="id" value="<?= htmlspecialchars($pk_promotor) ?>">

            <div class="col-12 col-lg-6">
                <label for="apellido">Buscar por apellido:</label>
                <input type="text" class="form-control" name="apellido" value="<?= htmlspecialchars($apellido) ?>" onchange="this.form.submit()">
            </div>
            <br>
            <div class="col-12 col-lg-6">
                <label for="fk_lider_coordinador">Seleccionar Líder/Coordinador:</label>
                <select class="form-control" name="fk_lider_coordinador" onchange="this.form.submit()">
                    <option value="">Selecciona uno</option>
                    <?php foreach ($lideres as $fila): ?>
                        <option value="<?= htmlspecialchars($fila['pk_lider_coordinador']) ?>"
                            <?= ($fila['pk_lider_coordinador'] == $fk_lider_coordinador) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($fila['nombres'] . ' ' . $fila['ap_paterno'] . ' ,' . ($fila['Tipo'] ?? '') . ' ,' . ($fila['nom_rol'] ?? '')) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <br>
            <div class="col-12 col-lg-6">
                <label for="fk_tipo">Tipo:</label>
                <select class="form-control" name="fk_tipo" onchange="this.form.submit()" required>
                    <option value="">Selecciona un tipo</option>
                    <?php
                    // Rebobinar el puntero del resultado si ya se ha recorrido
                    if (is_object($tipos_result)) {
                        mysqli_data_seek($tipos_result, 0);
                    }
                    while ($fila_tipo = mysqli_fetch_assoc($tipos_result)) {
                        // Si tienes una razón para solo mostrar el tipo 4, mantén esta condición
                        // De lo contrario, quítala para mostrar todos los tipos disponibles
                        if (in_array($fila_tipo['pk_tipo'], [4])) {
                            $selected = ($fila_tipo['pk_tipo'] == $fk_tipo) ? 'selected' : '';
                            echo "<option value='" . htmlspecialchars($fila_tipo['pk_tipo']) . "' $selected>" . htmlspecialchars($fila_tipo['Tipo']) . "</option>";
                        }
                    }
                    ?>
                </select>
            </div>
            <br>
        </form>

        <form method="POST" action="actualizar_promotor.php" class="col-10 offset-1">

            <input type="hidden" name="pk_promotor" value="<?= htmlspecialchars($pk_promotor) ?>">
            <input type="hidden" name="fk_lider_coordinador" value="<?= $fk_lider_coordinador ?>">
            
            
            <?php if (!empty($personas)): ?>
            <div class="col-12 col-lg-6">
                <label for="fk_persona">Seleccionar persona:</label>
                <select class="form-control" name="fk_persona" required>
                    <option value="">Selecciona una persona</option>
                    <?php foreach ($personas as $fila_persona): ?>
                        <option value="<?= htmlspecialchars($fila_persona['pk_persona']) ?>"
                            <?= (isset($datos['fk_persona']) && $fila_persona['pk_persona'] == $datos['fk_persona']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($fila_persona['nombres'] . ' ' . $fila_persona['ap_paterno'] . ' ' . $fila_persona['ap_materno']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <?php endif; ?>
            <br>

            <?php if (!empty($fk_tipo)): // Mostrar Rol solo si un Tipo está seleccionado/presente ?>
            <div class="col-12 col-lg-6">
                <label for="fk_rol">Seleccionar Rol:</label>
                <select class="form-control" name="fk_rol" required>
                    <option value="">Selecciona un rol</option>
                    <?php foreach ($roles as $fila_rol): ?>
                        <option value="<?= htmlspecialchars($fila_rol['pk_rol']) ?>"
                            <?= (isset($datos['fk_rol']) && $fila_rol['pk_rol'] == $datos['fk_rol']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($fila_rol['nom_rol']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <?php endif; ?>
            <br><br>

            <div class="col-12">
                <input class="btn btn-primary" type="submit" value="Guardar"><br><br>
                <a href="lista_promotor.php" class="btn btn-secondary">Cancelar</a>
                <p class="p">¿La persona ocupa registrarse? <a href="formulario_datos_P.php">registrar</a></p>
            </div>
        </form>
    </div>
</body>
</html>