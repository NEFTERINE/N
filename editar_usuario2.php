<?php
require_once('clases/Usuario.php');
require_once('menu.php');

$usuario = new Usuario();
$pk_usuario = $_GET['pk_usuario'];  // Obtener el id del usuario desde la URL

// Obtener los detalles del usuario
$respuesta = $usuario->buscar($pk_usuario);
$datos = mysqli_fetch_assoc($respuesta);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <link rel="stylesheet" href="css/estilos.css?a=1">
    <link rel="stylesheet" href="css/all.css">
    <link rel="stylesheet" href="css/bootstrap.css?a=1">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
</head>
<style>
            header {
            /* background-color: #343a40; */
            background: none;
        }
</style>
<body>
    <br><br><br><br><br><br>
    <form class="col-10 offset-1" action="actualizar_usuario2.php" method="POST">
        <h2>Editar Usuario</h2><br>
        <input type="hidden" name="pk_usuario" value="<?=$datos['pk_usuario']?>">

        <label for="">Usuario:</label><br>
        <input value="<?=$datos['correo'] ?>" class="form-control" type="text" name="correo" required><br>
        
        <label for="">Contraseña:</label><br>
        <input value="<?=$datos['contraseña'] ?>" class="form-control" type="password" name="contraseña" required><br>
        
        <div class="form-check mb-3">
        <label for="">Ver contraseña</label>
        <input class="form-check-input" type="checkbox" onclick="contraseña.type = this. checked ? 'text' : 'password'">
        </div>

        <label for="">Tipo de Usuario:</label><br>
        <select name="type" class="form-control" required>
            <option value="1" <?= $datos['type'] == 1 ? 'selected' : '' ?>>Usuario Normal</option>
            <option value="2" <?= $datos['type'] == 2 ? 'selected' : '' ?>>lider</option>
            <option value="3" <?= $datos['type'] == 3 ? 'selected' : '' ?>>coordinador</option>
            <option value="4" <?= $datos['type'] == 4 ? 'selected' : '' ?>>promotor</option>
            <option value="5" <?= $datos['type'] == 5 ? 'selected' : '' ?>>representante</option>
        </select><br><br>

        <div class="d-grid gap-2 col-6 mx-auto">
            <input class="btn btn-primary" type="submit" value="Actualizar"><br><br>
        </div>
    </form>
</body>
</html>
