<?php
session_start();
require_once('clases/Usuario.php');
require_once('menu.php');
$usuario = new Usuario();
?>


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
<body>
    <br><br><br><br><br><br>
    <form class="col-10 offset-1" action="insertar_usuario_c.php" method="POST">
        <h2>Crear Usuario Vinculado</h2><br>

        <label>Correo:</label><br>
        <input class="form-control" type="email" name="correo" required><br>

        <label>Contraseña:</label><br>
        <input class="form-control" type="password" name="contraseña" required><br>

        <label>Tipo de Usuario:</label><br>
        <select name="type" class="form-control" required>
            <option value="">Selecciona una opción</option>
            <option value="2">Líder</option>
            <option value="3">Coordinador</option>
            <option value="5">Promotor</option>
            <option value="4">Representante de Casilla</option>
        </select><br><br>

        <input type="hidden" name="pk_persona" value="<?= $_SESSION['pk_persona'] ?>">

        <div class="d-grid gap-2 col-6 mx-auto">
            <input class="btn btn-primary" type="submit" value="Crear Usuario"><br><br>
        </div>
    </form>
</body>
</html>
