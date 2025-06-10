<?php
require_once('clases/Lider_coordinador.php'); // tu clase de inserción
session_start();

// Validación simple
if (
    isset($_POST['fk_persona']) &&
    isset($_POST['fk_tipo']) &&
    isset($_POST['fk_rol']) &&
    isset($_POST['fk_territorio'])
) {
    $fk_persona = $_POST['fk_persona'];
    $fk_tipo = $_POST['fk_tipo'];
    $fk_rol = $_POST['fk_rol'];
    $fk_territorio = $_POST['fk_territorio'];

    $lider = new Lider_coordinador();

    $respuesta = $lider->insertar($fk_persona, $fk_tipo, $fk_rol, $fk_territorio);

    if ($respuesta) {
        echo "<script>
            alert('Líder/Coordinador guardado correctamente');
            window.location.href = 'lista_lideres.php';
        </script>";
    } else {
        echo "<script>
            alert('Error al guardar los datos');
            window.location.href = 'formulario_lider_coordinador.php';
        </script>";
    }
} else {
    echo "<script>
        alert('Faltan datos por completar');
        window.location.href = 'formulario_lider_coordinador.php';
    </script>";
}
?>
