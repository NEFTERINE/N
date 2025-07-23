<?php 
require_once('menu.php');
require_once('clases/Promovido.php');
$pro = new Promovido();
$respuesta = $pro->mostrar();
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
            background: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="col-8 offset-2">
            <br><br><br><br><br><br><br>
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
                                    // Bloque de opciones para usuarios con type 5// Cierre del if (in_array($_SESSION['type'], [5]))
                                    ?>
                                </tr>
                        <?php
                            } // Cierre del while
                        } 
                        else {
                            echo '<tr><td colspan="3">No hay promovidos registrados.</td></tr>';
                        }
                        ?>
                            <?php endif; ?>

                    </tbody>
                </table>
</div>
    </div>
    
</body>
</html>
            
