<?php 
include('clases/Lider_Coordinador.php');  

$lider = new Lider_coordinador();  

$pk_lider_coordinador = filter_input(INPUT_GET, 'pk_lider_coordinador', FILTER_VALIDATE_INT);

if ($pk_lider_coordinador) {
    $respuesta = $lider->eliminar($pk_lider_coordinador);

    if ($respuesta) {
        echo "<script>
            alert('Coordinador eliminado');
            location.href = 'lista_coordinador.php';
        </script>";
    } else {
        echo "<script>
            alert('Error al eliminar');
            location.href = 'lista_coordinador.php';
        </script>";
    }
} else {
    echo "<script>
        alert('ID de Coordinador no válido');
        location.href = 'lista_coordinador.php';
    </script>";
}
?>

