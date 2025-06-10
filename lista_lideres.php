<?php 
require_once('menu.php');
require_once('clases/Usuario.php');
$usuario = new Usuario();
$respuesta = $usuario->mostrarTodo();
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
            /* background-color: #343a40; */
            background: none;
        }
    </style>
</head>
<body>
    <!-- <div class="container">
        <div class="col-8 offset-2">
            <br><br><br><br><br><br><br>
            <h2 class="titulo">Gestión de Usuarios</h2><br><br>
            <table class="table table-hover">
                <tr>
                    <th>Nombre de Usuario</th>
                    <th>Estado</th>
                    <th>Tipo</th>
                    <th colspan="2">Opciones</th>
                </tr>
                <?php
                while ($fila = mysqli_fetch_array($respuesta)) {
                ?>
                    <tr>
                        <td><?= $fila['correo'] ?></td>
                        <td><?= $fila['estatus_usuario'] == 1 ? 'Activo' : 'Inactivo' ?></td>
                        <td><?= $fila['type'] == 1 ? 'Usuario' : 'Superusuario' ?></td>
                        <td>
                            <a href="editar_usuario2.php?pk_usuario=<?= $fila['pk_usuario'] ?>" class="btn btn-warning">Editar</a>
                        </td>
                        <td>
                            <?php
                            if ($fila['estatus_usuario'] == 1) {
                                echo '<a href="eliminar_usuario2.php?pk_usuario=' . $fila['pk_usuario'] . '" class="btn btn-danger" onclick="return confirm(\'¿Estás seguro de que deseas eliminar este usuario?\')">Eliminar</a>';
                            } else {
                                echo '<a href="activar_usuario.php?pk_usuario=' . $fila['pk_usuario'] . '" class="btn btn-success">Activar</a>';
                            }
                            ?>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </table><br><br><br>
            <a class="btn btn-info" href="agregar_n_usuario.php">Agregar Nuevo Usuario</a>
        </div>
    </div> -->
    
</body>
</html>
