<?php
// session_start(); // Mueve esto a la primera línea del archivo

if (session_status() === PHP_SESSION_NONE) {
    session_start();
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

                            echo  '<li class="nav-item"><a class="nav-link active" aria-current="page" href="index.php">Inicio</a></li>';
                            
                            if (isset($_SESSION['type']) && in_array($_SESSION['type'], [2, 3])) {

                                
                                echo  '<li class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">Otros</a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <li><a class="dropdown-item" href="formulario_persona.php">Nuevo Usuario</a></li>
                                    <li><a class="dropdown-item" href="formulario_datos.php">Datos</a></li>
                                    <li><a class="dropdown-item" href="lista_usuarios.php">Lista Usuario</a></li>';

                                echo '</ul></li><li class="nav-item"><a class="nav-link" href="admin.php"></a></li></ul>';

                            }
                            else if (isset($_SESSION['type']) && in_array($_SESSION['type'], [4, 5])) {

                                echo  '<li class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Otros</a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <li><a class="dropdown-item" href="formulario_cliente.php">Cliente</a></li>';

                                echo '</ul></li><li class="nav-item"><a class="nav-link" href="admin.php"></a></li></ul>';
                            }

                        }
                        ?>
   
                    <ul class="navbar-nav ms-auto">
                        <?php
                        if (isset($_SESSION['pk_usuario'])) {
                           
                            // Si el usuario está logueado
                            echo '<li class="nav-item"><a class="nav-link" href="perfil.php"><i class="fa-solid fa-user" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Perfil"></i></a></li>';
                            // Mostrar el link para administrar si es un usuario administrador
                            if (isset($_SESSION['type']) && in_array($_SESSION['type'], [2, 3])) {
                                echo '<li class="nav-item"><a class="nav-link" href="admin.php"><i class="fa-solid fa-gear" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Administración"></i></a></li>';
                            }
                        } else {
                            // Si el usuario NO está logueado
                            // echo '<li class="nav-item"><a class="nav-link" href="login.php"><i class="fa-solid fa-cart-shopping" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Carrito"></i></a></li>';
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