<?php
session_start(); // Esto debe ser lo primero, antes de cualquier salida

require_once('menu.php'); // Ahora puedes incluir el menú
require_once('clases/cliente.php');
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
    <br><br><br><br><br><br><br>
    <form class="col-10 offset-1" action="insertar_cliente_p.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="fk_usuario" value="<?= $_SESSION['pk_usuario'] ?>">

        <h2>Registro Datos</h2><br><br>
        <label>Nombre(s): </label> <br>
        <input class="form-control" type="text" name="nombres" required> <br><br>

        <label>Apellido Paterno: </label> <br>
        <input class="form-control" type="text" name="a_paterno" required> <br><br>

        <label>Apellido Materno: </label> <br>
        <input class="form-control" type="text" name="a_materno"><br><br>

        <label>Edad: </label> <br>
        <input class="form-control" type="number" name="edad" required><br><br>

        <div class="col-12 col-lg-6">
            <label>Fecha de nacimiento: </label> <br>
            <input class="form-control" type="date" name="fecha_nac" required> <br><br>
        </div>
        
        <label>Telefono: </label> <br>
        <input class="form-control" type="number" name="telefono" required> <br><br>
        
        <label>Direccion:</label> <br><br>
        <textarea class="form-control"  name="direccion" required> </textarea><br><br>

        <div class="d-grid gap-2 col-6 mx-auto">
            <input class="btn btn-primary" type="submit" value="Guardar"><br><br>
        </div>
    </form>
</body>

</html>