<?php 
include('clases/Promotor.php');  

$prom = new Promotor();  

$pk_promotor = filter_input(INPUT_GET, 'pk_promotor', FILTER_VALIDATE_INT);

if ($pk_promotor) {
    $respuesta = $prom->eliminar($pk_promotor);

    if ($respuesta) {
        echo "<script>
            alert('Promotor eliminado');
            location.href = 'lista_promotor.php';
        </script>";
    } else {
        echo "<script>
            alert('Error al eliminar');
            location.href = 'lista_promotor.php';
        </script>";
    }
} else {
    echo "<script>
        alert('ID de Promotor no válido');
        location.href = 'lista_promotor.php';
    </script>";
}
?>

