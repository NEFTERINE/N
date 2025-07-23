<?php
require_once('clases/Cliente.php');

$cliente = new Cliente();

$nombres     = $_POST['nombres'];
$a_paterno   = $_POST['a_paterno'];
$a_materno   = $_POST['a_materno'];
$edad        = $_POST['edad'];
$fecha_nac   = $_POST['fecha_nac'];
$telefono    = $_POST['telefono'];
$direccion   = $_POST['direccion'];

$id_persona = $cliente->insertar_C_U($nombres, $a_paterno, $a_materno, $edad, $fecha_nac, $telefono, $direccion);

if ($id_persona) {
    // Aquí puedes guardar el ID en sesión o pasarlo a la siguiente pantalla
    session_start();
    $_SESSION['pk_persona'] = $id_persona;

    echo "<script>alert('Persona guardada. Ahora crea el usuario.');
          window.location.href = 'formulario_asistencia_e.php';</script>";
} else {
    echo "<script>alert('Error al guardar persona.');
          window.location.href = 'formulario_asistencia_e.php';</script>";
}
?>
