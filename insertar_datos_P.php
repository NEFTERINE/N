<?php
require_once('clases/Cliente.php');

if (
    isset($_POST['nombres']) &&
    isset($_POST['a_paterno']) &&
    isset($_POST['a_materno']) &&
    isset($_POST['edad']) &&
    isset($_POST['fecha_nac']) &&
    isset($_POST['telefono']) &&
    isset($_POST['direccion'])
) {
$nombres     = $_POST['nombres'] ?? null;
$a_paterno   = $_POST['a_paterno'] ?? null;
$a_materno   = $_POST['a_materno'] ?? null;
$edad        = $_POST['edad'] ?? null;
$fecha_nac   = $_POST['fecha_nac'] ?? null;
$telefono    = $_POST['telefono'] ?? null;
$direccion   = $_POST['direccion'] ?? null;

$cliente = new Cliente();

$resouesta = $cliente->insertar_C_U($nombres, $a_paterno, $a_materno, $edad, $fecha_nac, $telefono, $direccion);

if ($resouesta) {

    echo "<script>alert('Persona guardada.');
          window.location.href = 'lista_persona.php';</script>";
} else {
    echo "<script>alert('Error al guardar persona.');
          window.location.href = 'formulario_datos_P.php';</script>";
}
} else {
    echo "<script>
        alert('Faltan datos por completar');
        window.location.href = 'formulario_datos_P.php';
    </script>";
}
?>
