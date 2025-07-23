<?php 
require_once('menu.php');
require_once('clases/Usuario.php');

$usuario = new Usuario();
$resultado = $usuario->buscar($_SESSION['pk_usuario']);
$respuesta = $usuario->mostrarPorId($_SESSION['pk_usuario']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
<title>Persefone Eternity | Perfil</title>
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="css/estilos.css?a=2">
<link rel="stylesheet" href="css/all.css">
<link rel="stylesheet" href="css/bootstrap.css">
<link rel="stylesheet" href="menu.php">
<link rel="stylesheet" href="owl/owl.carousel.min.css">
<link rel="stylesheet" href="owl/owl.theme.default.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">
</head>
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
.row {
  margin-left: 10px;
  margin-right: 10px;
}
   header {
            background: none;
        }
</style>
<br><br><br><br><br><br><br>
<body>
<section>
    <div class="row">
      <div class="col-lg-4">
        <div class="card mb-4">
          <div class="card-body text-center">
            <h3>Hola,</h3>
            <?php 
              while($fila = mysqli_fetch_array($resultado )) {
            ?>
            <h5 class="my-3"><?= $fila['correo'] ?></h5>
            <?php
              }
if (isset($_SESSION['type'])) {
    switch ($_SESSION['type']) {
        case 1:
            echo "<p>Usuario</p>";
            break;
        case 2:
            echo "<p>Líder</p>";
            break;
        case 3:
            echo "<p>Coordinador</p>";
            break;
        case 4:
            echo "<p>Representante de Casilla</p>";
            break;
        case 5:
            echo "<p>Promotor</p>";
            break;
        default:
            echo "<p>Tipo desconocido</p>";
    }
} else {
    echo "<p>Tipo no definido</p>";
}
?>
          </div>
        </div>
        <div class="card mb-4 mb-lg-0">
          <div class="card-body p-0">
            <ul class="list-group list-group-flush rounded-3">
              <?php
                if (isset($_SESSION['type']) && in_array($_SESSION['type'], [2, 3])) {
                  echo '<li class="list-group-item d-flex justify-content-between align-items-center p-3">
                    <a href="admin.php"><i class="fa-solid fa-gear" style="color: #333"></i></a>
                    <p class="mb-0"><a href="admin.php">Administración de la Página</a></p>
                  </li>';
                }
                else if (isset($_SESSION['type']) && $_SESSION['type'] == 4) {
                  echo '<li class="list-group-item d-flex justify-content-between align-items-center p-3">
                    <a href="admin.php"><i class="fa-solid fa-gear" style="color: #333"></i></a>
                    <p class="mb-0"><a href="admin.php">Administración de la Página</a></p>
                  </li>';
                }
                else if (isset($_SESSION['type']) && $_SESSION['type'] == 5) {
                  echo '<li class="list-group-item d-flex justify-content-between align-items-center p-3">
                  <a href="admin.php"><i class="fa-solid fa-gear" style="color: #333"></i></a>
                  <p class="mb-0"><a href="admin.php">Administración de la Página</a></p>
                </li>';
              }
              ?>
              <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                <a href="cerrar_sesion.php"><i style="color: black">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-box-arrow-left" viewBox="0 0 16 16">
                  <path fill-rule="evenodd" d="M6 12.5a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v2a.5.5 0 0 1-1 0v-2A1.5 1.5 0 0 1 6.5 2h8A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5h-8A1.5 1.5 0 0 1 5 12.5v-2a.5.5 0 0 1 1 0z"/>
                  <path fill-rule="evenodd" d="M.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L1.707 7.5H10.5a.5.5 0 0 1 0 1H1.707l2.147 2.146a.5.5 0 0 1-.708.708z"/>
                </svg>
                </i></a>
                <p class="mb-0"><a href="cerrar_sesion.php">Cerrar Sesión</a></p>
              </li>
              <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                <a href="eliminar_usuario.php?pk_usuario=<?= $_SESSION['pk_usuario'] ?>" onclick="return confirm('¿Estás seguro de que deseas eliminar tu cuenta? \nNOTA: No podrás recuperarla una vez eliminada')"><i class="fa-solid fa-trash" style="color: #333"></i></a>
                <p class="mb-0"><a href="eliminar_usuario.php?pk_usuario=<?= $_SESSION['pk_usuario'] ?>" onclick="return confirm('¿Estás seguro de que deseas eliminar tu cuenta? \nNOTA: No podrás recuperarla una vez eliminada')">Eliminar Cuenta</a></p>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <div class="col-lg-8">
        <div class="card mb-4">
        <?php 
          while ($fila = mysqli_fetch_array($respuesta)) {
        ?>
          <div class="card-body">
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Nombre Completo</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0"><?= $fila['nombres'], " ", $fila['ap_paterno'], " ", $fila['ap_materno'] ?></p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-9">
                <p class="text-muted mb-0"><?= $fila['correo'] ?></p>
              </div>
            </div>

          </div>
          <?php
            }
          ?>
        </div>
      </div>
    </div>
</section>
<footer>
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
