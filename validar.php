<html>
<title>SIGCE| Login</title>
</html>

<?php
session_start();

include('clases/Usuario.php');
$usuario = new Usuario();

$correo = isset($_POST['correo']) ? $_POST['correo'] : '';
$contraseña = isset($_POST['contraseña']) ? $_POST['contraseña'] : '';

// Validar credenciales usando el método modificado
// Ahora $datos_usuario contendrá el array de datos del usuario si la validación es exitosa, o false si no lo es.
$datos_usuario = $usuario->validar($correo, $contraseña);

// Comprobamos si $datos_usuario NO es false (es decir, la validación fue exitosa y es un array)
if ($datos_usuario !== false) {
    // Los datos ya están en $datos_usuario, no necesitamos mysqli_fetch_assoc() aquí
    $_SESSION['pk_usuario'] = $datos_usuario['pk_usuario'];
    $_SESSION['type'] = $datos_usuario['type']; // <--- Esto ahora se establecerá correctamente
    $_SESSION['correo'] = $correo;

    // Redirección segura usando header('Location')
    switch ($_SESSION['type']) {
        case 1:
            $_SESSION['mensaje_bienvenida'] = 'Bienvenido';
            header('Location: index.php');
            exit();
            break;
        case 2:
            header('Location: index.php'); // Redirige a la página principal del líder
            exit();
            break;
        case 3:
            header('Location: index.php'); // Redirige a la página principal del coordinador
            exit();
            break;
        case 4:
            header('Location: index.php'); // Redirige a la página principal del representante de casilla
            exit();
            break;
        case 5:
            header('Location: index.php'); // Redirige a la página principal del promotor
            exit();
            break;
        default:
            $_SESSION['error_login'] = 'Tipo de usuario desconocido.';
            header('Location: login.php');
            exit();
            break;
    }
} else {
    // Usuario no existe o contraseña incorrecta
    $_SESSION['error_login'] = 'Correo o contraseña incorrectos.';
    header('Location: login.php');
    exit();
}
?>