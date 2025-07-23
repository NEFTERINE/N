<?php
session_start(); // Esto debe ser lo primero, antes de cualquier salida

require_once('menu.php'); // Ahora puedes incluir el menú
require_once('clases/Promovido.php');
require_once('clases/Cliente.php');
require_once('clases/Calendario.php');

$cal = new Calendario;
$cliente = new Cliente();


$respuesta = $cal->mostrarTodo();

$apellido = $_GET['apellido'] ?? '';
$resultados = [];

if (!empty($apellido)) {
    $resultados = $cliente->buscarApellido($apellido);
} else {
    // Puedes cargar todos, o dejar vacío hasta que busque
    $resultados = $cliente->mostrarTodo();
}
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

</style>

<body>
    <br><br><br><br><br><br><br>
        <h2>Registro Datos</h2><br><br>
            <form class="col-10 offset-1" method="GET" enctype="multipart/form-data">

        <!-- Buscar por apellido -->
        <div class="col-12 col-lg-6">
            <label for="apellido">Buscar por apellido:</label>
            <input class="form-control" type="text" name="apellido" value="<?= htmlspecialchars($apellido) ?>" onchange="this.form.submit()">
        </div>
    </form>

    <form class="col-10 offset-1" action="insertar_promovido.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="fk_usuario" value="<?= $_SESSION['pk_usuario'] ?>">

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
<br>
<br>
        <div class="row justify-content-center">
            <div class="col-auto">
                <input class="btn btn-primary" type="submit" value="Guardar"><br><br>
            </div>
            <div class="col-auto">
                <a href="lista_promovido.php" class="btn btn-secondary">Cancelar</a>
                <p class="p">¿La persona ocupa registrarse? <a href="formulario_datos_P.php">registrar</a></p>
            
            </div>
        </div>
    </form>
</body>

</html>