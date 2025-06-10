<?php
require_once('clases/Usuario.php');
require_once('menu.php');

// Verificamos si se enviaron los datos del formulario
if (isset($_POST['correo'], $_POST['contraseña'], $_POST['type'])) {
    $correo = $_POST['correo'];
    $contraseña = $_POST['contraseña'];
    $type = $_POST['type'];

    // Instanciamos la clase Usuario
    $usuario = new Usuario();

    // Llamamos a la función insertar para agregar el nuevo usuario
    $usuario->insertar2($correo, $contraseña, $type);

    // Redirigir a la página de gestión de usuarios o mostrar un mensaje de éxito
    header('Location: lista_usuarios.php');
}
?>
