<?php 
require_once('menu.php');
require_once('clases/Promovido.php');
$promovido = new Promovido();
$respuesta = $promovido->mostrartodo();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/estilos.css">
    <link rel="stylesheet" href="css/all.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <title>Lista de Promovidos</title>

    <style>
        .titulo {
            text-align: center;
            font-size: 30px;
            margin-bottom: 20px;
            color: black;
        }
            header {
            background: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="col-8 offset-2">
            <br><br><br><br><br><br><br>
            <h2 class="titulo">Lista de Promovidos</h2><br><br>
            <table class="table table-hover">
                <tr>
                    <th>Nombres</th>
                    <th>Apellido Paterno</th>
                    <th>Apellido Materno</th>
                    <th>Edad</th>
                    <th>Fecha de Nacimiento</th>
                    <th>Telefono</th>
                    <th>Dirección</th>
                </tr>
                <?php
                while ($fila = mysqli_fetch_array($respuesta)) {
                ?>
                    <tr>
                        <td><?= $fila['nombres'] ?></td>
                        <td><?= $fila['ap_paterno'] ?></td>
                        <td><?= $fila['ap_materno'] ?></td>
                        <td><?= $fila['edad'] ?></td>
                        <td><?= $fila['fecha_nac'] ?></td>
                        <td><?= $fila['telefono'] ?></td>
                        <td><?= $fila['direccion'] ?></td>

                        </td>
                    </tr>
                <?php
                }
                ?>
            </table><br><br><br>
            <a class="btn btn-info" href="formulario_persona.php">Agregar persona</a>
        </div>
    </div>
</body>
</html>
