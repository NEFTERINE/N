<html><title>SIGCE| Login</title></html>

<?php

include('clases/Usuario.php');
$usuario= new Usuario;

$correo= $_POST['correo'];
$contraseña= $_POST['contraseña'];

$resultado=$usuario-> validar($correo, $contraseña);
$num_rows= mysqli_num_rows($resultado);

$datos= mysqli_fetch_assoc($resultado);


if ($num_rows <= 0) {
    echo "<script>
        alert('No existe el usuario');
        location.href= 'login.php';
    </script>";
} else {
    session_start();
    $_SESSION['pk_usuario'] = $datos['pk_usuario'];
    $_SESSION['type'] = $datos['type'];
    $_SESSION['correo'] = $correo;
    // echo "Tipo de usuario: " . ($_SESSION['type'] ?? 'no definido');

    // $_SESSION['contrasena'] = $contrasena;

    // Redirección según tipo de usuario
    switch ($_SESSION['type']) {
        case 1:
            echo "<script>
                alert('Bienvenido');
                location.href= 'index.php';
            </script>";
            break;
        case 2:
            echo "<script>
                alert('Bienvenido lider');
                location.href= 'index.php';
            </script>";
            break;
        case 3:
            echo "<script>
                alert('Bienvenido coordinador');
                location.href= 'index.php';
            </script>";
            break;
        case 4:
            echo "<script>
                alert('Bienvenido representante de casilla');
                location.href= 'index.php';
            </script>";
            break;
        case 5:
            echo "<script>
                alert('Bienvenido promotor');
                location.href= 'index.php';
            </script>";
            break;
        default:
            echo "<script>
                alert('Tipo de usuario desconocido');
                location.href= 'login.php';
            </script>";
            break;
    }
}
?>


