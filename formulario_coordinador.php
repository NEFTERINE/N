<!DOCTYPE html>
<html lang="es">

<head>
    <link rel="stylesheet" href="css/estilos.css?a=1">
    <link rel="stylesheet" href="css/all.css">
    <link rel="stylesheet" href="css/bootstrap.css?a=1">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Nuevo Usuario</title>
</head>
<style>
    header {
        /* background-color: #343a40; */
        background: none;
    }
</style>
<?php
require_once('menu.php');

require_once('clases/Tipo.php');
require_once('clases/Cliente.php');
require_once('clases/Rol.php');
require_once('clases/Territorio.php');
require_once('clases/Estado.php');
// require_once('clases/Categoria.php');

$tipo = new Tipo();
$cliente = new Cliente();
$rol = new Rol();
$territorio = new Territorio();
$estado = new Estado();
// $categoria=new Categoria();


$resul = $tipo->mostrarTodo();

$apellido = $_GET['apellido'] ?? '';
$resultados = [];

if (!empty($apellido)) {
    $resultados = $cliente->buscarApellido($apellido);
} else {
    // Puedes cargar todos, o dejar vacío hasta que busque
    $resultados = $cliente->mostrarTodo();
}

$fk_estado = $_GET['fk_estado'] ?? '';
$municipios = [];

if (!empty($fk_estado)) {
    $municipios = $territorio->obtenerPorEstado($fk_estado);
} else {
    $municipios = []; // vacío hasta que seleccionen estado
}


$fk_tipo = $_GET['fk_tipo'] ?? '';
$roles = [];

if (!empty($fk_tipo)) {
    $roles = $rol->mostrarTodo($fk_tipo);
}

?>

<body>
    <br><br><br>
    <h2>Coordinadores</h2><br>
    <form class="col-10 offset-1" method="GET" enctype="multipart/form-data">

        <!-- Buscar por apellido -->
        <div class="col-12 col-lg-6">
            <label for="apellido">Buscar por apellido:</label>
            <input class="form-control" type="text" name="apellido" value="<?= htmlspecialchars($apellido) ?>" onchange="this.form.submit()">
        </div>

        <!-- estado -->
        <div class="col-12 col-lg-6">
            <label for="fk_estado">Estado:</label>
            <select class="form-control" name="fk_estado" onchange="this.form.submit()">
                <option value="">Selecciona un estado</option>
                <?php
                $estados = $estado->mostrarTodo();
                while ($fila = mysqli_fetch_assoc($estados)) {
                    $selected = ($fk_estado == $fila['pk_estado']) ? 'selected' : '';
                    echo "<option value='{$fila['pk_estado']}' $selected>{$fila['nombre_estado']}</option>";
                }
                ?>
            </select>
        </div>
        <br>
        <!-- Tipo -->
        <div class="col-12 col-lg-6">
            <label for="fk_tipo">Tipo:</label>
            <select class="form-control" name="fk_tipo" onchange="this.form.submit()" required>
                <option value="">Selecciona un tipo</option>
                <?php
                $tipos = $tipo->mostrarTodo();
                while ($fila = mysqli_fetch_assoc($tipos)) {
                    if (in_array($fila['pk_tipo'], [2])) {
                        $selected = ($fk_tipo == $fila['pk_tipo']) ? 'selected' : '';
                        echo "<option value='{$fila['pk_tipo']}' $selected>{$fila['Tipo']}</option>";
                    }
                }
                ?>
            </select>
        </div>
    </form>

    <form class="col-5 offset-1" method="POST" action="insertar_coordinador.php">
        <br>
        <!-- Seleccionar persona -->
        <br>
        <?php if (!empty($apellido)): ?>
            <div class="col-12 col-lg-6">
                <label for="fk_persona">Seleccionar persona:</label>
                <select class="form-control" name="fk_persona" required>
                    <option value="">Selecciona una persona</option>
                    <?php while ($fila = mysqli_fetch_array($resultados)): ?>
                        <option value="<?= $fila['pk_persona'] ?>" <?= ($_GET['fk_persona'] ?? '') == $fila['pk_persona'] ? 'selected' : '' ?>>
                            <?= $fila['nombres'] . ' ' . $fila['ap_paterno'] . ' ' . $fila['ap_materno'] ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
        <?php endif; ?>
        <br>

        <!-- Municipio -->
        <?php if (!empty($fk_estado)): ?>
            <div class="col-12 col-lg-6">
                <label for="fk_territorio">Municipio:</label>
                <select class="form-control" name="fk_territorio" required>
                    <option value="">Selecciona un municipio</option>
                    <?php
                    foreach ($municipios as $fila) {
                        $selected = ($_GET['fk_territorio'] ?? '') == $fila['pk_territorio'] ? 'selected' : '';
                        echo "<option value='{$fila['pk_territorio']}' $selected>
                            {$fila['municipio']} - Dto {$fila['fk_distrito']} - Sec {$fila['fk_secciones']}
                          </option>";
                    }
                    ?>
                </select>
            </div>
        <?php endif; ?>
        <br>

        <input type="hidden" name="fk_tipo" value="<?= htmlspecialchars($fk_tipo) ?>">
        <!-- Rol -->
        <?php if (!empty($fk_tipo)): ?>
            <div class="col-12 col-lg-6">
                <label for="fk_rol">Rol:</label>
                <select class="form-control" name="fk_rol" required>
                    <option value="">Selecciona un rol</option>
                    <?php
                    foreach ($roles as $fila) {
                        $selected = ($_GET['fk_rol'] ?? '') == $fila['pk_rol'] ? 'selected' : '';
                        echo "<option value='{$fila['pk_rol']}' $selected>{$fila['nom_rol']}</option>";
                    }
                    ?>
                </select>
            </div>
        <?php endif; ?>
        
        <br><br>
        <div class="d-grid gap-2 col-6 mx-auto">
            <input class="btn btn-primary" type="submit" value="Guardar">
            
            <p class="p">¿La persona ocupa registrarse? <a href="formulario_datos_P.php">registrar</a></p>
        </div>
    </form>
</body>