<?php 
require_once('menu.php');
require_once('clases/Promotor.php');
$prom = new Promotor();
$respuesta = $prom->mostrarP();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/estilos.css">
    <link rel="stylesheet" href="css/all.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <title>Gestión de Promotores</title>

    <style>
        .titulo {
            text-align: center;
            font-size: 30px;
            margin-bottom: 20px;
            color: black;
        }
            header {
            /* background-color: #343a40; */
            background: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="col-8 offset-2">
            <br><br><br><br><br><br><br>
            <h2 class="titulo">Gestión de Promotor</h2><br><br>
            <table class="table table-hover">
                <tr>
                    <th>Persona</th>
                    <th>Rol</th>
                    <th>Coordinador</th>
                    <th colspan="2">Opciones</th>
                </tr>
                <?php
                while ($fila = mysqli_fetch_array($respuesta)) {
                ?>
                    <tr>
                        <td><?= $fila['nombres']." ".$fila['ap_paterno']." ".$fila['ap_materno'] ?></td>
                        <td><?= $fila['nom_rol'] ?></td>
                        <td><?= $fila['nombre_coordinador'] ?></td>
                        <td>
                             <a href="editar_promotor.php?id=<?= htmlspecialchars($fila['pk_promotor']) ?>" class="btn btn-warning">Editar</a>
                        </td>
                        <td>
                            <?php
                            if ($fila['estatus_lc'] == 1) {
                                echo '<a href="eliminar_promotor.php?pk_promotor=' . $fila['pk_promotor'] . '" class="btn btn-danger" onclick="return confirm(\'¿Estás seguro de que deseas eliminar?\')">Eliminar</a>';
                            }
                            ?>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </table><br><br><br>
            <a class="btn btn-info" href="formulario_promotor.php">Agregar nuevo Promotor</a>
            
            <p class="p">¿La persona ocupa registrarse? <a href="formulario_datos_P.php">registrar</a></p>
        </div>
    </div>
    
</body>
</html>
