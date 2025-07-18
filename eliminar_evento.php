<?php
if (!isset($_GET['id'])) {
    die('ID no especificado');
}

$id = $_GET['id'];

$conexion = new mysqli('localhost', 'root', 'mysql', 'sigce');

if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

// Eliminar el evento
$sql = "DELETE FROM c_eventos WHERE pk_c_eventos = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->close();
$conexion->close();

// 🔁 Redirigir al calendario o index
header("Location: index.php"); // o calendario.php si ese es tu calendario
exit;
