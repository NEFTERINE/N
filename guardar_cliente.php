<?php
include('clases/conexion.php');
include('clases/Cliente.php');


    // Puedes agregar más validaciones si quieres

    if (isset($_POST['nombres'], $_POST['a_paterno'], $_POST['a_materno'], $_POST['edad'], $_POST['fecha'], $_POST['telefono'], $_POST['direccion'])) {

    $nombres = $_POST['nombres'];
    $a_paterno = $_POST['a_paterno'];
    $a_materno = $_POST['a_materno'];
    $edad = $_POST['edad'];
    $fecha = $_POST['fecha'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];


    // Instanciamos la clase Usuario
    $cliente = new Cliente();

    // Llamamos a la función insertar para agregar el nuevo usuario
    $papel->insertar($nombres, $a_paterno, $a_materno, $edad, $fecha_nac, $telefono, $direccion, $fk_usuario);

    // Redirigir a la página de gestión de usuarios o mostrar un mensaje de éxito
    header('Location: lista_persona.php');
}
?>