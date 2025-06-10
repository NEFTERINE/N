<?php 
include('clases/Usuario.php');  

$usuario = new Usuario();  

session_start();

$id_usuario = filter_input(INPUT_GET, 'pk_usuario', FILTER_VALIDATE_INT);

if ($id_usuario) {
    $respuesta = $usuario->eliminarUsuario($pk_usuario);

    if ($respuesta) {
        echo "<script>
            alert('Usuario eliminado');
            location.href = 'cerrar_sesion.php';
        </script>";
    } else {
        echo "<script>
            alert('Error al eliminar el Usuario');
            location.href = 'perfil.php';
        </script>";
    }
} else {
    echo "<script>
        alert('ID de Usuario no válido');
        location.href = 'perfil.php';
    </script>";
}
?>