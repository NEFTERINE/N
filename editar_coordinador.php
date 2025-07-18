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

require_once('menu.php');
require_once('clases/Tipo.php');
require_once('clases/Cliente.php');
require_once('clases/Rol.php');
require_once('clases/Territorio.php');
require_once('clases/Estado.php');
require_once('clases/Lider_coordinador.php');

$tipo = new Tipo();
$cliente = new Cliente();
$rol = new Rol();
$territorio = new Territorio();
$estado = new Estado();
$lider = new Lider_coordinador();

$pk_lider_coordinador = $_GET['pk_lider_coordinador'] ?? null;
if (!$pk_lider_coordinador) {
    echo "<script>alert('ID no proporcionado'); window.location.href = 'lista_lideres.php';</script>";
    exit;
}

$respuesta = $lider->buscar($pk_lider_coordinador);
$datos = mysqli_fetch_assoc($respuesta);

$fk_estado = isset($_GET['fk_estado']) ? $_GET['fk_estado'] : ($datos['fk_estado'] ?? '');
$fk_tipo = isset($_GET['fk_tipo']) ? $_GET['fk_tipo'] : ($datos['fk_tipo'] ?? '');


$municipios = !empty($fk_estado) ? $territorio->obtenerPorEstado($fk_estado) : [];
$roles = !empty($fk_tipo) ? $rol->mostrarTodo($fk_tipo) : [];
$tipos = $tipo->mostrarTodo();
$estados = $estado->mostrarTodo();

?>

<body>
    <br><br><br>
    <h2Coordinadores</h2><br>
    <!--editar formulario de lideres y coordinadores-->

    <form method="GET" class="col-10 offset-1">
        <input type="hidden" name="pk_lider_coordinador" value="<?= $pk_lider_coordinador ?>">
        <div class="col-12 col-lg-6">
            <label for="fk_estado">Estado</label>
            <select class="form-control" name="fk_estado" onchange="this.form.submit()">
                <option value="">Selecciona un estado</option>
                <?php while ($fila = mysqli_fetch_assoc($estados)): ?>
                    <option value="<?= $fila['pk_estado'] ?>" <?= ($fk_estado == $fila['pk_estado']) ? 'selected' : '' ?>>
                        <?= $fila['nombre_estado'] ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <br>
        <div class="col-12 col-lg-6">
            <label for="fk_tipo">Tipo</label>
            <select class="form-control" name="fk_tipo" onchange="this.form.submit()">
                <option value="">Selecciona un tipo</option>
                <?php while ($fila = mysqli_fetch_assoc($tipos)): ?>
                    <option value="<?= $fila['pk_tipo'] ?>" <?= ($fk_tipo == $fila['pk_tipo']) ? 'selected' : '' ?>>
                        <?= $fila['Tipo'] ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

    </form>

    <!-- Formulario de edición -->
    <form method="POST" action="actualizar_coordinador.php?pk_lider_coordinador=<?= $pk_lider_coordinador ?>" class="col-10 offset-1">
        <input type="hidden" name="fk_tipo" value="<?= $fk_tipo ?>">
        <br>
        <div class="col-12 col-lg-6">
            <label for="fk_territorio">Municipio</label>
            <select class="form-control" name="fk_territorio" required>
                <option value="">Selecciona un municipio</option>
                <?php foreach ($municipios as $fila): ?>
                    <option value="<?= $fila['pk_territorio'] ?>" <?= ($datos['fk_territorio'] == $fila['pk_territorio']) ? 'selected' : '' ?>>
                        <?= $fila['municipio'] ?> - Dto <?= $fila['fk_distrito'] ?> - Sec <?= $fila['fk_secciones'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <br>
        <!-- <div class="col-md-6"> -->
        <div class="col-12 col-lg-6">
            <label for="fk_rol">Rol</label>
            <select class="form-control" name="fk_rol" required>
                <option value="">Selecciona un rol</option>
                <?php foreach ($roles as $fila): ?>
                    <option value="<?= $fila['pk_rol'] ?>" <?= ($datos['fk_rol'] == $fila['pk_rol']) ? 'selected' : '' ?>>
                        <?= $fila['nom_rol'] ?>
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
                <a href="lista_lideres.php" class="btn btn-secondary">Cancelar</a>
            </div>
        </div>

    </form>
</body>