<?php 
include('clases/Lider_Coordinador.php');  

$lider = new Lider_coordinador();  

$pk_lider_coordinador = filter_input(INPUT_GET, 'pk_lider_coordinador', FILTER_VALIDATE_INT);

if ($pk_lider_coordinador) {
    $respuesta = $lider->eliminar($pk_lider_coordinador);

    if ($respuesta) {
        echo "<script>
            alert('Lider eliminado');
            location.href = 'lista_lideres.php';
        </script>";
    } else {
        echo "<script>
            alert('Error al eliminar');
            location.href = 'lista_lideres.php';
        </script>";
    }
} else {
    echo "<script>
        alert('ID de Lider no válido');
        location.href = 'lista_lideres.php';
    </script>";
}
?>

