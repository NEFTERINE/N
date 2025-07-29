<?php 
session_start(); // ¡Asegúrate de que esto esté al principio si no lo está en menu.php!
require_once('menu.php');
require_once('clases/Promovido.php');

$pro = new Promovido();
$respuesta = $pro->mostrar(); // Ahora esta función debería devolver solo los promovidos del promotor logueado
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/estilos.css">
    <link rel="stylesheet" href="css/all.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <title>Gestión de Promovidos</title>

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
            <h2 class="titulo">Gestión de Promovidos</h2><br><br>
            <?php if (isset($_SESSION['pk_usuario'])): // Mostrar tabla solo si el usuario está logueado ?>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Persona</th>
                            <th>Promotor</th>
                            <?php if (isset($_SESSION['type']) && in_array($_SESSION['type'], [5])): // Solo mostrar "Opciones" si es type 5 ?>
                                <th colspan="2">Opciones</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($respuesta && mysqli_num_rows($respuesta) > 0) {
                            while ($fila = mysqli_fetch_array($respuesta)) {
                        ?>
                                <tr>
                                    <td><?= htmlspecialchars($fila['nombre_promovido']) ?></td>
                                    <td><?= htmlspecialchars($fila['nombre_promotor']) ?></td>
                                    <?php
                                    // Bloque de opciones para usuarios con type 5
                                    if (isset($_SESSION['type']) && in_array($_SESSION['type'], [5])) {
                                    ?>
                                        <td>
                                            <a href="editar_promovido.php?id=<?= htmlspecialchars($fila['pk_promovido']) ?>" class="btn btn-warning">Editar</a>
                                        </td>
                                        <td>
                                            <?php if ($fila['estatus_pro'] == 1): ?>
                                                <a href="eliminar_promovido.php?pk_promovido=<?= htmlspecialchars($fila['pk_promovido']) ?>" class="btn btn-danger" onclick="return confirm('¿Estás seguro de que deseas eliminar este promovido?')">Eliminar</a>
                                            <?php endif; ?>
                                        </td>
                                    <?php
                                    } // Cierre del if (in_array($_SESSION['type'], [5]))
                                    ?>
                                </tr>
                        <?php
                            } // Cierre del while
                        } else {
                            echo '<tr><td colspan="' . (isset($_SESSION['type']) && in_array($_SESSION['type'], [5]) ? '4' : '2') . '">No hay promovidos para mostrar.</td></tr>';
                        }
                        ?>
                    </tbody>
                </table>
                <br><br><br>
                <?php if (isset($_SESSION['type']) && in_array($_SESSION['type'], [5])): // Solo type 5 puede ver el botón de agregar ?>
                    <a class="btn btn-info" href="formulario_promovido.php">Agregar Nuevo Promovido</a>
                <?php endif; ?>
            <?php else: // Si el usuario no está logueado ?>
                <p>Por favor, inicia sesión para ver la información de los promovidos.</p>
            <?php endif; // Cierre del if (isset($_SESSION['pk_usuario'])) ?>
            
            <p class="p">¿La persona ocupa registrarse? <a href="formulario_datos_P.php">registrar</a></p>
        </div>
    </div>
    
</body>
</html>