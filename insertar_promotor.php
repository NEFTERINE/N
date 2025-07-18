<?php
require_once('clases/Promotor.php'); // tu clase de inserción
session_start();

// Validación simple
if (
    isset($_POST['fk_persona']) &&
    isset($_POST['fk_lider_coordinador']) &&
    isset($_POST['fk_rol'])
) {
    $fk_persona = $_POST['fk_persona'];
    $fk_lider_coordinador = $_POST['fk_lider_coordinador'];
    $fk_rol = $_POST['fk_rol'];


    $prom = new Promotor();

    $respuesta = $prom->insertar($fk_persona, $fk_lider_coordinador,  $fk_rol);

    if ($respuesta) {
        echo "<script>
            alert('Promotor guardado correctamente');
            window.location.href = 'lista_promotor.php';
        </script>";
    } else {
        echo "<script>
            alert('Error al guardar los datos');
            window.location.href = 'formulario_promotor.php';
        </script>";
    }
} else {
    echo "<script>
        alert('Faltan datos por completar');
        window.location.href = 'formulario_promotor.php';
    </script>";
}
