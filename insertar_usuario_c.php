<?php
require_once('clases/Usuario.php'); // Asegúrate de tener esta clase
session_start();

$usuario = new Usuario();

$correo = $_POST['correo'];
$contraseña = $_POST['contraseña'];
$type= $_POST['type'];

$pk_usuario = $usuario->insertar_U_C($correo, $contraseña, $type);

if ($pk_usuario && isset($_SESSION['pk_persona'])) {
    $pk_persona = $_SESSION['pk_persona'];

    // Ahora conectamos ambos
    require_once('clases/Usuario_persona.php');
    $relacion = new Usuario_persona();
    $relacion->conectar($pk_usuario, $pk_persona);

    unset($_SESSION['pk_persona']); // Limpieza

    echo "<script>alert('Usuario y persona relacionados.');
          window.location.href = 'lista_usuarios.php';</script>";
} else {
    echo "<script>alert('Error al crear usuario o falta el ID de persona.');
          window.location.href = 'formulario_usuario.php';</script>";
}
?>
