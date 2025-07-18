<?php
require_once('clases/Promovido.php');

// Validación simple
if (
    isset($_POST['fk_persona']) &&
    isset($_POST['fk_promotor'])
) {
    
    $fk_persona     = $_POST['fk_persona'];
    $fk_promotor   = $_POST['fk_promotor'];

    $pro = new Promovido();

    $respuesta = $pro->insertar($fk_persona, $fk_promotor);

    if ($respuesta) {
        echo "<script>
            alert('Promovido guardado correctamente');
            window.location.href = 'lista_promovido.php';
        </script>";
    } else {
        echo "<script>
            alert('Error al guardar los datos');
            window.location.href = 'formulario_promovido.php';
        </script>";
    }
} else {
    echo "<script>
        alert('Faltan datos por completar');
        window.location.href = 'formulario_promovido.php';
    </script>";
}vido
?>
