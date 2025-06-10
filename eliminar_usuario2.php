<?php
require_once('menu.php');
require_once('clases/Usuario.php');
$usuario = new Usuario();

// Verifica si el parámetro 'id_usuario' está presente en la URL
if (isset($_GET['pk_usuario'])) {
    // Obtiene el ID del usuario desde la URL
    $id_usuario = $_GET['id_usuario'];

    // Llama al método 'eliminarUsuario' para desactivar al usuario
    $usuario->eliminarUsuario($pk_usuario);

    // Redirige a la página de gestión de usuarios
    header("Location: lista_usuarios.php");
    exit(); // Asegura que no se ejecuten más líneas de código después de la redirección
} else {
    // Si no se proporciona un ID de usuario, muestra un mensaje de error
    echo "Error: No se ha especificado un ID de usuario.";
}
?>
