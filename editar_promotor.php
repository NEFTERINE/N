<?php
session_start();
require_once('menu.php');
require_once('clases/Promotor.php'); 
require_once('clases/Cliente.php');
require_once('clases/Rol.php');
require_once('clases/Lider_coordinador.php');

$prom = new Promotor(); 
$cliente = new Cliente();
$rol = new Rol();
$lider = new Lider_coordinador();

$pk_promotor = $_GET['id'] ?? null;
if (!$pk_promotor) {
    echo "<script>alert('ID no proporcionado.'); window.location.href = 'lista_promotor.php';</script>";
    exit;
}

$datos_promotor = $prom->buscarPromotorPorId($pk_promotor);
if (!$datos_promotor) {
    echo "<script>alert('Promotor no encontrado.'); window.location.href = 'lista_promotor.php';</script>";
    exit;
}

// Datos para selects
$personas = $cliente->mostrarTodo();
$lideres = $lider->mostrar();
$roles = $rol->mostrarTodo(null); // todos los roles activos
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Promotor</title>
    <link rel="stylesheet" href="css/bootstrap.css">
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">Editar Promotor</h2>


    <form method="POST" action="actualizar_promotor.php" class="col-10 offset-1">
        <input type="hidden" name="pk_promotor" value="<?= htmlspecialchars($pk_promotor) ?>">

        <!-- Persona -->
        <div class="col-12 col-lg-9">
            <label for="fk_persona" class="form-label">Persona:</label>
            <select class="form-control" name="fk_persona" required>
                <option value="">Selecciona una persona</option>
                <?php while ($fila = mysqli_fetch_array($personas)): ?>
                    <option value="<?= $fila['pk_persona'] ?>" 
                        <?= $fila['pk_persona'] == $datos_promotor['fk_persona'] ? 'selected' : '' ?>>
                        <?= $fila['nombres'] . ' ' . $fila['ap_paterno'] . ' ' . $fila['ap_materno'] ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <!-- Líder/Coordinador -->
        <div class="col-12 col-lg-9">
            <label for="fk_lider_coordinador" class="form-label">Líder o Coordinador a cargo:</label>
            <select class="form-control" name="fk_lider_coordinador" required>
                <option value="">Selecciona uno</option>
                <?php
                if ($lideres instanceof mysqli_result) {
                    while ($fila = $lideres->fetch_assoc()):
                ?>
                    <option value="<?= $fila['pk_lider_coordinador'] ?>" 
                        <?= $fila['pk_lider_coordinador'] == $datos_promotor['fk_lider_coordinador'] ? 'selected' : '' ?>>
                        <?= $fila['nombres'] . ' ' . $fila['ap_paterno'] . ' - ' . $fila['Tipo'] . ' / ' . $fila['nom_rol'] ?>
                    </option>
                <?php
                    endwhile;
                }
                ?>
            </select>
        </div>

        <!-- Rol -->
        <div class="col-12 col-lg-9">
            <label for="fk_rol" class="form-label">Rol:</label>
            <select class="form-control" name="fk_rol" required>
                <option value="">Selecciona un rol</option>
                <?php foreach ($roles as $fila_rol): ?>
                    <option value="<?= $fila_rol['pk_rol'] ?>" 
                        <?= $fila_rol['pk_rol'] == $datos_promotor['fk_rol'] ? 'selected' : '' ?>>
                        <?= $fila_rol['nom_rol'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Botones -->
        <div class="row justify-content-left mt-4">
            <div class="col-auto">
            <button type="submit" class="btn btn-primary">Actualizar</button> <br>
            </div>
            <div class="col-auto">
            <a href="lista_promotor.php" class="btn btn-secondary">Cancelar</a>
            </div>
        </div>
    </form>
</div>
</body>
</html>
