<?php
session_start();
require_once('menu.php');
require_once('clases/Promovido.php');
require_once('clases/Cliente.php');
require_once('clases/Calendario.php');

$cal = new Calendario;
$cliente = new Cliente;
$pro = new Promovido;

// Obtener datos del promovido
$pk_promovido = $_GET['id'] ?? null;

if ($pk_promovido) {
    $respuesta = $pro->buscar($pk_promovido);
    $datos = mysqli_fetch_assoc($respuesta);

    if (!$datos) {
        $datos = []; // <-- asegúrate de que exista
    }
} else {
    $datos = []; // <-- asegúrate de que exista
}

// Obtener personas
$apellido = $_GET['apellido'] ?? '';
$personas = !empty($apellido) ? $cliente->buscarApellido($apellido) : $cliente->mostrarTodo();

// Obtener promotores activos
$promotores = $cal->mostrarTodo(); // Asegúrate que solo devuelve activos con estatus_pro = 1
?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SIGCE| FormularioCliente</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/estilos.css">
    <link rel="stylesheet" href="css/all.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="owl/owl.carousel.min.css">
    <link rel="stylesheet" href="owl/owl.theme.default.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
        integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200;300;400;500;600;700&display=swap"
        rel="stylesheet">
</head>
<style>
            header {
            /* background-color: #343a40; */
            background: none;
        }
</style>

<body>
    <br><br>
        <h2>Actualizar Datos</h2><br><br>
            <form class="col-10 offset-1" method="GET" enctype="multipart/form-data">

        <!-- Buscar por apellido -->
        <div class="col-12 col-lg-6">
            <label for="apellido">Buscar por apellido:</label>
            <input class="form-control" type="text" name="apellido" value="<?= htmlspecialchars($apellido) ?>" onchange="this.form.submit()">
        </div>
    </form>

    <form class="col-10 offset-1" method="POST" action="actualizar_promovido.php">
        <input type="hidden" name="pk_promovido" value="<?= $datos['pk_promovido'] ?? '' ?>">



            <!-- Buscar persona -->
            <div class="col-12 col-lg-6">
                <label for="fk_persona" class="form-label">Persona</label>
                <select name="fk_persona" id="fk_persona" class="form-control" required>
                    <option value="">Selecciona una persona</option>
                    <?php while ($fila = mysqli_fetch_array($personas)): ?>
                        <option value="<?= $fila['pk_persona'] ?>" <?= isset($datos['fk_persona']) && $fila['pk_persona'] == $datos['fk_persona'] ? 'selected' : '' ?>>
                            <?= $fila['nombres'] . ' ' . $fila['ap_paterno'] . ' ' . $fila['ap_materno'] ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <!-- Promotor -->
            <div class="col-12 col-lg-6">
                <label for="fk_promotor" class="form-label">Promotor</label>
                <select name="fk_promotor" id="fk_promotor" class="form-control" required>
                    <option value="">Selecciona un promotor</option>
                    <?php while ($fila = mysqli_fetch_array($promotores)): ?>
                        <option value="<?= $fila['pk_promotor'] ?>" <?= isset($datos['fk_promotor']) && $fila['pk_promotor'] == $datos['fk_promotor'] ? 'selected' : '' ?>>
                        <?= $fila['nombres'] . ' ' . $fila['ap_paterno'] . ' ' . $fila['ap_materno'] ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
<br>
<br>
        <div class="d-grid gap-2 col-6 mx-auto">
            <input class="btn btn-primary" type="submit" value="Guardar"><br><br>
            
            <a href="lista_promovido.php" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</body>

</html>