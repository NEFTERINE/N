<?php
require_once('clases/Lider_coordinador.php');
session_start();

// Validamos que se haya enviado todo lo necesario
if (
    isset($_POST['fk_tipo']) &&
    isset($_POST['fk_rol']) &&
    isset($_POST['fk_territorio']) &&
    isset($_GET['pk_lider_coordinador'])
) {
    $pk_lider_coordinador = $_GET['pk_lider_coordinador'];
    $fk_tipo = $_POST['fk_tipo'];
    $fk_rol = $_POST['fk_rol'];
    $fk_territorio = $_POST['fk_territorio'];

    $lider = new Lider_coordinador();

    // Método que debes crear en tu clase para actualizar:
    $respuesta = $lider->actualizar($pk_lider_coordinador,$fk_tipo, $fk_rol, $fk_territorio);

    if ($respuesta) {
        echo "<script>
            alert('Coordinador actualizado correctamente');
            window.location.href = 'lista_coordinador.php';
        </script>";
    } else {
        echo "<script>
            alert('Error al actualizar los datos');
            window.history.back();
        </script>";
    }
} else {
    echo "<script>
        alert('Faltan datos por completar');
        window.history.back();
    </script>";
}
?>
