<?php 
include('clases/Promovido.php');  

$pro = new Promovido();  

$pk_promovido = filter_input(INPUT_GET, 'pk_promovido', FILTER_VALIDATE_INT);

if ($pk_promovido) {
    $respuesta = $pro->eliminar($pk_promovido);

    if ($respuesta) {
        echo "<script>
            alert('Promovido eliminado');
            location.href = 'lista_promovido_id.php';
        </script>";
    } else {
        echo "<script>
            alert('Error al eliminar');
            location.href = 'lista_promovido_id.php';
        </script>";
    }
} else {
    echo "<script>
        alert( no válido');
        location.href = 'lista_promovido_id.php';
    </script>";
}
?>

