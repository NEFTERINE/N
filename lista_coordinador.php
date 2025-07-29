<?php 
require_once('menu.php');
require_once('clases/Lider_Coordinador.php');
$lider = new Lider_coordinador();
$respuesta = $lider->mostrarC();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/estilos.css">
    <link rel="stylesheet" href="css/all.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <title>Gestión de Usuarios</title>

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
            <br><br><br><br>
            <h2 class="titulo">Gestión de Coordinadores</h2><br><br>
            <table class="table table-hover">
                <tr>
                    <th>Persona</th>
                    <th>Tipo</th>
                    <th>Rol</th>
                    <th>Territorio</th>
                    <th colspan="2">Opciones</th>
                </tr>
                <?php
                while ($fila = mysqli_fetch_array($respuesta)) {
                ?>
                    <tr>
                        <td><?= $fila['nombres']." ".$fila['ap_paterno']." ".$fila['ap_materno'] ?></td>
                        <td><?= $fila['tipo'] ?></td>
                        <td><?= $fila['nom_rol'] ?></td>
                        <td><?= $fila['municipio']?></td>
                        <td>
                            <a href="editar_coordinador.php?pk_lider_coordinador=<?= $fila['pk_lider_coordinador'] ?>" class="btn btn-warning">Editar</a>
                        </td>
                        <td>
                            <?php
                            if ($fila['estatus_lc'] == 1) {
                                echo '<a href="eliminar_coordinador.php?pk_lider_coordinador=' . $fila['pk_lider_coordinador'] . '" class="btn btn-danger" onclick="return confirm(\'¿Estás seguro de que deseas eliminar?\')">Eliminar</a>';
                            } else {
                                echo '<a href="activar_coordinador.php?pk_lider_coordinador=' . $fila['pk_lider_coordinador'] . '" class="btn btn-success">Activar</a>';
                            }
                            ?>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </table><br><br><br>
            <a class="btn btn-info" href="formulario_coordinador.php">Agregar Nuevo Lider</a>
        </div>
    </div>
    
</body>
</html>
