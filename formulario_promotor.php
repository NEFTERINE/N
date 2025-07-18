<?php
require_once('menu.php');
require_once('clases/Tipo.php');
require_once('clases/Cliente.php');
require_once('clases/Rol.php');
require_once('clases/Lider_coordinador.php');

$tipo = new Tipo();
$cliente = new Cliente();
$rol = new Rol();
$lider = new Lider_coordinador();

$apellido = $_GET['apellido'] ?? '';
$fk_lider_coordinador = $_GET['fk_lider_coordinador'] ?? '';
$fk_tipo = $_GET['fk_tipo'] ?? '';

$resultados = !empty($apellido) ? $cliente->buscarApellido($apellido) : $cliente->mostrarTodo();
$lideres = $lider->mostrar();
$roles = !empty($fk_tipo) ? $rol->mostrarTodo($fk_tipo) : [];
$tipos = $tipo->mostrarTodo();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Promotor</title>
    <link rel="stylesheet" href="css/bootstrap.css">
</head>
<body>
        <h2>Registrar Promotor</h2>
        <form method="GET" class="col-10 offset-1">
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
                        <option value="<?= $fila['pk_lider_coordinador'] ?>" <?= ($fk_lider_coordinador == $fila['pk_lider_coordinador']) ? 'selected' : '' ?>>
                            <?= $fila['nombres'] . ' ' . $fila['ap_paterno'] . ' ,' . $fila['Tipo']. ' ,' . $fila['nom_rol']?>
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
                $tipos = $tipo->mostrarTodo();
                while ($fila = mysqli_fetch_assoc($tipos)) {
                    if (in_array($fila['pk_tipo'], [4])) {
                        $selected = ($fk_tipo == $fila['pk_tipo']) ? 'selected' : '';
                        echo "<option value='{$fila['pk_tipo']}' $selected>{$fila['Tipo']}</option>";
                    }
                }
                ?>
            </select>
        </div>
            <br>

        </form>

        <form method="POST" action="insertar_promotor.php" class="col-10 offset-1">
        <input type="hidden" name="fk_lider_coordinador" value="<?= htmlspecialchars($fk_lider_coordinador) ?>">


            <?php if (!empty($apellido)): ?>
            <div class="col-12 col-lg-6">
                <label for="fk_persona">Seleccionar persona:</label>
                <select class="form-control" name="fk_persona" required>
                    <option value="">Selecciona una persona</option>
                    <?php while ($fila = mysqli_fetch_array($resultados)): ?>
                        <option value="<?= $fila['pk_persona'] ?>">
                            <?= $fila['nombres'] . ' ' . $fila['ap_paterno'] . ' ' . $fila['ap_materno'] ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <?php endif; ?>
            <br>

            <?php if (!empty($fk_tipo)): ?>
            <div class="col-12 col-lg-6">
                <label for="fk_rol">Seleccionar Rol:</label>
                <select class="form-control" name="fk_rol" required>
                    <option value="">Selecciona un rol</option>
                    <?php foreach ($roles as $fila): ?>
                        <option value="<?= $fila['pk_rol'] ?>"><?= $fila['nom_rol'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <?php endif; ?>
            <br><br>

        <div class="col-12">
            <input class="btn btn-primary" type="submit" value="Guardar">
            <br><br>
            <a href="lista_promotor.php" class="btn btn-secondary">Cancelar</a>

            <p class="p">¿La persona ocupa registrarse? <a href="formulario_datos_P.php">registrar</a></p>
        </div>
        </form>

</body>
</html>
