<?php
require_once('clases/Promotor.php'); // tu clase de inserción
session_start();

// Validación simple
if (
    isset($_POST['pk_promotor'])&&
    isset($_POST['fk_persona']) &&
    isset($_POST['fk_lider_coordinador']) &&
    isset($_POST['fk_rol'])
) {
    $pk_promotor = $_POST['pk_promotor'];
    $fk_persona = $_POST['fk_persona'];
    $fk_lider_coordinador = $_POST['fk_lider_coordinador'];
    $fk_rol = $_POST['fk_rol'];


    $prom = new Promotor();

    $respuesta = $prom->actualizar($pk_promotor, $fk_persona, $fk_lider_coordinador,  $fk_rol);

    if ($respuesta) {
        echo "<script>
            alert('Promotor guardado correctamente');
            window.location.href = 'lista_promotor.php';
        </script>";
    } else {
        echo "<script>
            alert('Error al guardar los datos');
            window.location.href = 'editar_promotor.php';
        </script>";
    }
} else {
    echo "<script>
        alert('Faltan datos por completar');
        window.location.href = 'editar_promotor.php';
    </script>";
}
