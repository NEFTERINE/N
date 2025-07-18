<?php
$conexion = new mysqli('localhost', 'root', 'mysql', 'sigce');

$consulta = $conexion->query("SELECT pk_c_eventos, tipo_evento, fecha_inicio AS start, fecha_fin AS end FROM c_eventos");

$eventos = [];

while($row = $consulta->fetch_assoc()) {
    $eventos[] = [
        'id' => $row['pk_c_eventos'],
        'title' => $row['tipo_evento'],
        'start' => $row['start'],
        'end' => $row['end']
    ];
}

echo json_encode($eventos);

?>
