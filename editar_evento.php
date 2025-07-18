<?php
$conexion = new mysqli('localhost', 'root', 'mysql', 'sigce');

$id           = $_POST['id'];
$tipo_evento  = $_POST['tipo_evento'];
$descripcion  = $_POST['descripcion'];
$fecha_inicio = $_POST['fecha_inicio'];
$fecha_fin    = $_POST['fecha_fin'];
$hora_inicio  = $_POST['hora_inicio'];
$hora_fin     = $_POST['hora_fin'];
$ubicacion    = $_POST['ubicacion'];
$fk_promotor  = $_POST['fk_promotor'];

$sql = "UPDATE c_eventos SET tipo_evento=?, descripcion=?, fecha_inicio=?, fecha_fin=?, hora_inicio=?, hora_fin=?, ubicacion=?, fk_promotor=?
        WHERE pk_c_eventos=?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("sssssssii", $tipo_evento, $descripcion, $fecha_inicio, $fecha_fin, $hora_inicio, $hora_fin, $ubicacion, $fk_promotor, $id);
$stmt->execute();

header("Location: index.php");
