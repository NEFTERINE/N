<?php
session_start();
require_once('clases/Eventos.php'); // tu clase de inserción

// Validación simple
if (
    isset($_POST['fk_persona']) &&
    isset($_POST['fk_c_eventos']) &&
    isset($_POST['descripcion'])
) {
    $fk_persona = $_POST['fk_persona'] ?? null;
    $fk_c_eventos = $_POST['fk_c_eventos'] ?? null;
    $descripcion = $_POST['descripcion'] ?? null;
    


    $eve = new Eventos();

    $respuesta = $eve->actualizar($pk_asistencia_e,$fk_persona, $fk_c_eventos, $descripcion);

    if ($respuesta) {
        echo "<script>
            alert('Asistencia guardado correctamente');
            window.location.href = 'lista_eventos.php';
        </script>";
    } else {
        echo "<script>
            alert('Error al guardar los datos');
            window.location.href = 'editar_asistencia_e.php';
        </script>";
    }
} else {
    echo "<script>
        alert('Faltan datos por completar');
        window.location.href = 'editar_asistencia_e.php';
    </script>";
}
