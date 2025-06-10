<?php
require_once('menu.php');
require_once('clases/Usuario.php');

// Crear una instancia de la clase Usuario
$usuario = new Usuario();

// Verifica si el parámetro 'id_usuario' está presente en la URL
if (isset($_GET['pk_usuario'])) {
    // Obtiene el ID del usuario desde la URL
    $id_usuario = $_GET['pk_usuario'];

    // Depuración: Verificar si se recibe el id_usuario
    if (empty($pk_usuario)) {
        die("Error: No se ha proporcionado un ID de usuario.");
    }

    // Llama al método 'activarUsuario' para activar al usuario
    $resultado = $usuario->activarUsuario($pk_usuario);

    // Verificar si la activación fue exitosa
    if ($resultado) {
        // Redirige a la página de gestión de usuarios
        header("Location: lista_usuarios.php");
        exit(); // Asegura que no se ejecute código adicional después de la redirección
    } else {
        // Si no fue exitoso, muestra un mensaje de error
        echo "Error al activar el usuario. Verifica la conexión y la consulta.";
    }
} else {
    // Si no se proporciona un ID de usuario, muestra un mensaje de error
    echo "Error: No se ha especificado un ID de usuario.";
}
?>
