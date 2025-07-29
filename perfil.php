<?php 
session_start(); // Asegúrate de que la sesión se inicie al principio
require_once('menu.php'); 
require_once('clases/Usuario.php');

$usuario_obj = new Usuario(); 

$correo_usuario_display = 'N/A';
$nombre_completo_usuario = 'N/A';
$tipo_usuario_texto = 'Tipo no definido';
$resultado_correo = null; // Inicializa a null
$respuesta = null;       // Inicializa $respuesta a null para evitar "Undefined variable"

// Solo si hay una sesión activa de usuario
if (isset($_SESSION['pk_usuario'])) {
    $pk_usuario_logueado = $_SESSION['pk_usuario'];

    // --- IMPORTANTE: Asegúrate de que estos métodos usen SENTENCIAS PREPARADAS ---
    $resultado_correo = $usuario_obj->buscar($pk_usuario_logueado); 
    if ($resultado_correo && $fila_correo = $resultado_correo->fetch_assoc()) { 
        $correo_usuario_display = htmlspecialchars($fila_correo['correo'] ?? 'N/A');
    }

    // Método para obtener el nombre completo y otros datos de persona
    $respuesta = $usuario_obj->nombre($pk_usuario_logueado); 

    // Determinar el texto del tipo de usuario
    if (isset($_SESSION['type'])) {
        switch ($_SESSION['type']) {
            case 1: $tipo_usuario_texto = "Usuario"; break;
            case 2: $tipo_usuario_texto = "Líder"; break;
            case 3: $tipo_usuario_texto = "Coordinador"; break;
            case 4: $tipo_usuario_texto = "Representante de Casilla"; break;
            case 5: $tipo_usuario_texto = "Promotor"; break;
            default: $tipo_usuario_texto = "Tipo desconocido"; break;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
<title>Persefone Eternity | Perfil</title>
<link rel="stylesheet" href="css/bootstrap.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="owl/owl.carousel.min.css">
<link rel="stylesheet" href="owl/owl.theme.default.min.css">
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="css/estilos.css?a=15">
<link rel="stylesheet" href="css/all.css">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">

<style>


p a {
    text-decoration: none; 
    color: #333;
}
p a:hover {
    color: black;
    transition: color 0.3s;
    cursor: pointer;
    text-decoration: underline;
}
.menu {
    position: fixed;
    top: 0;
    width: 100%;
    z-index: 10;
}
.card {
    position: relative;
    z-index: 1;
}
header {
    background: none;
}

</style>
</head>
<body>

<div class="content-wrapper"> <section class="py-4"> <div class="container">
            
            <div class="row"> 
                <div class="col-lg-10 col-md-6 mb-4">  <div class="card">
                        <div class="card-body text-center mt-3 ">
                            <h3>Hola,</h3>
                            <h5 class="my-3"><?= $correo_usuario_display ?></h5>
                            <p class="text-muted"><?= $tipo_usuario_texto ?></p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-10 col-md-7 mb-4"> 
                    <div class="card mb-4 mb-lg-0">
                        <div class="card-body p-0">
                            <ul class="list-group list-group-flush rounded-3">
                                <?php
                                if (isset($_SESSION['type']) && in_array($_SESSION['type'], [2, 3, 4, 5])) {
                                    echo '<li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                            <a href="admin.php"><i class="fa-solid fa-gear" style="color: #333"></i></a>
                                            <p class="mb-0"><a href="admin.php">Administración de la Página</a></p>
                                          </li>';
                                }
                                ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                    <a href="cerrar_sesion.php" style="color: black">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-box-arrow-left" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M6 12.5a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v2a.5.5 0 0 1-1 0v-2A1.5 1.5 0 0 1 6.5 2h8A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5h-8A1.5 1.5 0 0 1 5 12.5v-2a.5.5 0 0 1 1 0z"/>
                                            <path fill-rule="evenodd" d="M.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L1.707 7.5H10.5a.5.5 0 0 1 0 1H1.707l2.147 2.146a.5.5 0 0 1-.708.708z"/>
                                        </svg>
                                    </a>
                                    <p class="mb-0"><a href="cerrar_sesion.php">Cerrar Sesión</a></p>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                    <a href="eliminar_usuario.php?pk_usuario=<?= htmlspecialchars($_SESSION['pk_usuario'] ?? '') ?>" onclick="return confirm('¿Estás seguro de que deseas eliminar tu cuenta? \nNOTA: No podrás recuperarla una vez eliminada')"><i class="fa-solid fa-trash" style="color: #333"></i></a>
                                    <p class="mb-0"><a href="eliminar_usuario.php?pk_usuario=<?= htmlspecialchars($_SESSION['pk_usuario'] ?? '') ?>" onclick="return confirm('¿Estás seguro de que deseas eliminar tu cuenta? \nNOTA: No podrás recuperarla una vez eliminada')">Eliminar Cuenta</a></p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row"> 
                <div class="col-lg-12 col-md-12"> <div class="card mb-3"> 
                        <div class="card-body">
                            <h4 class="card-title text-center mb-4">Mis Datos</h4>
                            <?php
                            // Aseguramos que $respuesta sea un objeto mysqli_result antes de usarlo
                            if ($respuesta && $respuesta instanceof mysqli_result) {
                                // Rebobinamos el puntero si ya fue usado antes, para mysqli_fetch_array()
                                // No es necesario si es la primera vez que se itera el resultado
                                mysqli_data_seek($respuesta, 0); 
                                if ($respuesta->num_rows > 0) {
                                    while ($fila = mysqli_fetch_array($respuesta)) {
                                        $nombres = htmlspecialchars($fila['nombres'] ?? '');
                                        $ap_paterno = htmlspecialchars($fila['ap_paterno'] ?? '');
                                        $ap_materno = htmlspecialchars($fila['ap_materno'] ?? '');

                                        $partes_nombre_display = array_filter([$nombres, $ap_paterno, $ap_materno]);
                                        $nombre_completo_display = implode(' ', $partes_nombre_display);
                                        if (empty($nombre_completo_display)) {
                                            $nombre_completo_display = "No disponible";
                                        }
                                        
                                        $correo_display = htmlspecialchars($fila['correo'] ?? 'N/A');
                                    ?>
                                    <div class="row mb-2">
                                        <div class="col-sm-4">
                                            <p class="mb-0"><strong>Nombre Completo:</strong></p>
                                        </div>
                                        <div class="col-sm-8">
                                            <p class="text-muted mb-0"><?= $nombre_completo_display ?></p>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row mb-2">
                                        <div class="col-sm-4">
                                            <p class="mb-0"><strong>Correo:</strong></p>
                                        </div>
                                        <div class="col-sm-8">
                                            <p class="text-muted mb-0"><?= $correo_display ?></p>
                                        </div>
                                    </div>
                                    <?php
                                    } // Cierre del while
                                    mysqli_free_result($respuesta); // Libera la memoria del resultado
                                } else {
                                    echo '<div class="alert alert-info text-center" role="alert">No se encontraron datos de perfil.</div>';
                                }
                            } else {
                                echo '<div class="alert alert-info text-center" role="alert">No se encontraron datos de perfil.</div>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
</div> <footer>
  <div class="container">
    <div class="autor">
      <p>© 2025 SIGCE. | Todos los derechos reservados.</p>
    </div>
  </div>
</footer>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="owl/owl.carousel.min.js"></script>
<script>
$('.owl-carousel').owlCarousel({
  loop: true,
  nav: true,
  dots: false,
  responsiveClass: true,
  responsive: {
    0: {
      items: 1
    },
    600: {
      items: 2
    },
    1000: {
      items: 3
    }
  }
});
</script>
</body>
</html>