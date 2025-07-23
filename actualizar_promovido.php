<?php 
require_once('clases/conexion.php');
require_once('clases/Promovido.php');

if (
    isset($_POST['pk_promovido']) &&
    isset($_POST['fk_persona']) &&
    isset($_POST['fk_promotor'])
) {
    $pk_promovido = $_POST['pk_promovido'];
    $fk_persona   = $_POST['fk_persona'];
    $fk_promotor  = $_POST['fk_promotor'];

    $pro = new Promovido();
    $resultado = $pro->editar($pk_promovido, $fk_persona, $fk_promotor);

    if ($resultado) {
        echo "<script>
                alert('Promovido actualizado correctamente.');
                window.location.href = 'lista_promovido_id.php';
              </script>";
    } else {
        echo "<script>
                alert('Error al actualizar el promovido.');
                window.location.href = 'editar_promovido.php?id=$pk_promovido';
              </script>";
    }
} else {
    echo "<script>
            alert('Faltan datos por completar.');
            window.history.back();
          </script>";
}
?>
