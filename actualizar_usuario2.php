<?php
require_once('clases/Usuario.php');
$usuario = new Usuario();

if (isset($_POST['pk_usuario'], $_POST['correo'], $_POST['contraseña'], $_POST['type'])) {
    $id_usuario = $_POST['pk_usuario'];
    $nom_usuario = $_POST['correo'];
    $contra = $_POST['contraseña'];
    $type = $_POST['type'];

    // Actualizar el usuario en la base de datos
    $usuario->editarUsuario($id_usuario, $nom_usuario, $contra, $type);
    
    // Redirigir a la página de gestión de usuarios o mostrar un mensaje de éxito
    header('Location: lista_usuarios.php');
}
?>
