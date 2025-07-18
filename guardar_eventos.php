<?php
header('Content-Type: application/json');

$conexion = new mysqli('localhost','root','mysql','sigce');
if ($conexion->connect_error) {
    echo json_encode(['status' => 'error', 'message' => 'Conexión fallida']);
    exit;
}


// Recoger datos del formulario
$title         = $_POST['title'] ?? '';
$descripcion   = $_POST['descripcion'] ?? '';
$fecha_inicio  = $_POST['fecha_inicio'] ?? '';
$fecha_fin     = $_POST['fecha_fin'] ?? '';
$hora_inicio   = $_POST['hora_inicio'] ?? '';
$hora_fin      = $_POST['hora_fin'] ?? '';
$ubicacion     = $_POST['ubicacion'] ?? '';
$fk_promotor   = $_POST['fk_promotor'] ?? '';

// Validar que no haya vacíos
if (!$title || !$fecha_inicio || !$fecha_fin || !$hora_inicio || !$hora_fin || !$ubicacion || !$fk_promotor) {
    echo json_encode(['status' => 'error', 'message' => 'Faltan datos obligatorios']);
    exit;
}

// Insertar a la base de datos
$sql = "INSERT INTO c_eventos (tipo_evento, descripcion, fecha_inicio, fecha_fin, hora_inicio, hora_fin, ubicacion, fk_promotor) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conexion->prepare($sql);

if (!$stmt) {
    echo json_encode(['status' => 'error', 'message' => 'Error al preparar consulta']);
    exit;
}

$stmt->bind_param("sssssssi", $title, $descripcion, $fecha_inicio, $fecha_fin, $hora_inicio, $hora_fin, $ubicacion, $fk_promotor);

if ($stmt->execute()) {
    echo json_encode(['status' => 'ok']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Error al ejecutar consulta']);
}
?>
