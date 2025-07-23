<?php
// session_start(); // Mueve esto a la primera línea del archivo

if (session_status() === PHP_SESSION_NONE) {
    session_start();

//     session_start(); // Si aún no está allí

// // Si el usuario NO está logueado, redirige a la página de inicio de sesión
// if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
//     header("Location: login.php");
//     exit; // Detiene la ejecución del script
// }
}

require_once('clases/conexion.php');
$conexion = new Conexion();
if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/estilos.css?a=14">
    <link rel="stylesheet" href="css/all.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer">
    <title></title>
    <style>
        /* Tu estilo personalizado */
    </style>

</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg bg-dark bg-body-tertiary " data-bs-theme="dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php"></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarScroll">
                    <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
                        <?php
                        if (isset($_SESSION['pk_usuario'])) {
                            echo '<li class="nav-item"><a class="nav-link active" aria-current="page" href="index.php">Inicio</a></li>';

                            // *** ELIMINA LAS SIGUIENTES LÍNEAS COMPLETAMENTE ***
                            if (isset($_SESSION['type']) && in_array($_SESSION['type'], [5])) {
                                echo '</li><li class="nav-item"><a class="nav-link" href="lista_asistencia_e.php"> Asistencia </a></li>';
                            }
                            // else if (isset($_SESSION['type']) && in_array($_SESSION['type'], [4, 5])) {
                            //     echo '</ul></li><li class="nav-item"><a class="nav-link" href="admin.php"></a></li></ul>';
                            // }
                            // ************************************************
                        }
                        ?>
                    </ul>
                    <ul class="navbar-nav ms-auto">
                        <?php
                        if (isset($_SESSION['pk_usuario'])) {
                            // Si el usuario está logueado
                            echo '<li class="nav-item"><a class="nav-link" href="perfil.php"><i class="fa-solid fa-user" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Perfil"></i></a></li>';
                            // Mostrar el link para administrar si es un usuario administrador (este es el correcto)
                            if (isset($_SESSION['type']) && in_array($_SESSION['type'], [2, 3, 4, 5])) {
                                echo '<li class="nav-item"><a class="nav-link" href="admin.php"><i class="fa-solid fa-gear" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Administración"></i></a></li>';
                            }
                        } else {
                            // Si el usuario NO está logueado
                            // echo '<li class="nav-item"><a class="nav-link" href="login.php"><i class="fa-solid fa-cart-shopping" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Carrito"></i></a></li>'; // Esto parece ser un comentario o código no usado
                            echo '<li class="nav-item"><a class="nav-link" href="login.php"><i class="fa-solid fa-user" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Perfil"></i></a></li>';
                            echo '<li class="nav-item"><a class="nav-link" href="login.php"><i class="fa-solid fa-arrow-right-to-bracket" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Iniciar Sesión"></i></a></li>';
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });
        });
    </script>

</body>
</html>