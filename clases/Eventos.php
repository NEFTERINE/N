<?php
class Eventos
{

    function __construct()
    {
        require_once('conexion.php');
        $this->conexion = new Conexion();
    }

    function insertar($fk_persona, $fk_c_eventos, $descripcion)
    {
        $consulta = "INSERT INTO asistencia_e (pk_asistencia_e, fk_persona, fk_c_eventos, descripcion)
        VALUES (NULL,'{$fk_persona}', '{$fk_c_eventos}', '{$descripcion}')";
        $respuesta = $this->conexion->query($consulta);
        return $respuesta;
    }function obtenerAE() {
        // Consulta SQL para obtener la asistencia junto con los nombres de eventos y personas
        // Ordena por tipo_evento para agrupar fácilmente en PHP
        // *** CAMBIO AQUÍ: Añadimos AS id_asistencia para consistencia ***
        $consulta = "SELECT ae.pk_asistencia_e AS id_asistencia, ae.fecha_Registro, p.nombres, p.ap_paterno, p.ap_materno, ce.tipo_evento, ae.descripcion
                     FROM asistencia_e ae INNER JOIN persona p ON ae.fk_persona = p.pk_persona
                     INNER JOIN c_eventos ce ON ae.fk_c_eventos = ce.pk_c_eventos ORDER BY
                     ce.tipo_evento, ae.fecha_Registro DESC";

        $resultado = $this->conexion->query($consulta);

        if (!$resultado) {
            error_log("Error al obtener asistencia por evento: " . $this->conexion->error);
            return [];
        }

        $asistencia_agrupada = [];
        while ($fila = $resultado->fetch_assoc()) {
            $tipo_evento = $fila['tipo_evento'];
            if (!isset($asistencia_agrupada[$tipo_evento])) {
                $asistencia_agrupada[$tipo_evento] = [];
            }
            $asistencia_agrupada[$tipo_evento][] = $fila;
        }

        return $asistencia_agrupada;
    }

    function mostrarTodo()
    {
        $consulta = "SELECT * FROM asistencia_e";
        $respuesta = $this->conexion->query($consulta);
        return $respuesta;
    }


    // *** MÉTODO EXISTENTE, pero lo llamaremos obtenerAsistenciaSimplePorId para diferenciar ***
    // Si solo necesitas los fk_persona, fk_c_eventos, descripcion
    function obtenerAsistenciaSimplePorId($pk_asistencia_e) {
        $consulta = "SELECT pk_asistencia_e, fk_persona, fk_c_eventos, descripcion FROM asistencia_e WHERE pk_asistencia_e = ?";
        $stmt = $this->conexion->prepare($consulta);
        if ($stmt === false) {
            error_log("Error al preparar la consulta obtenerAsistenciaSimplePorId: " . $this->conexion->error);
            return null;
        }
        $stmt->bind_param("i", $pk_asistencia_e);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $datos = $resultado->fetch_assoc();
        $stmt->close();
        return $datos;
    }

    // *** NUEVO MÉTODO SUGERIDO para obtener TODOS los detalles para el formulario de edición ***
// --- Dentro de tu clase Eventos.php ---

// Este método obtendrá todos los asistentes para un evento dado su ID
function obtenerAsistentesPorIdEvento($id_evento) {
    $consulta = "SELECT ae.pk_asistencia_e AS id_asistencia, ae.fecha_Registro, ae.descripcion,
                        p.nombres, p.ap_paterno, p.ap_materno,
                        ce.tipo_evento -- Incluimos tipo_evento para el título de la página
                 FROM asistencia_e ae
                 INNER JOIN persona p ON ae.fk_persona = p.pk_persona
                 INNER JOIN c_eventos ce ON ae.fk_c_eventos = ce.pk_c_eventos
                 WHERE ae.fk_c_eventos = ?
                 ORDER BY p.ap_paterno, p.nombres"; // Ordenar por apellido y nombre

    $stmt = $this->conexion->prepare($consulta);
    if ($stmt === false) {
        error_log("Error al preparar la consulta obtenerAsistentesPorIdEvento: " . $this->conexion->error);
        return [];
    }
    $stmt->bind_param("i", $id_evento); // "i" para entero
    $stmt->execute();
    $resultado = $stmt->get_result();
    $asistentes = [];
    while ($fila = $resultado->fetch_assoc()) {
        $asistentes[] = $fila;
    }
    $stmt->close();
    return $asistentes;
}

// ... Y también asegúrate de que el método 'mostrarT()' selecciona 'pk_c_eventos'
function mostrarT()
{
    $consulta = "SELECT pk_c_eventos, tipo_evento FROM c_eventos"; // ASEGÚRATE DE ESTO
    $respuesta = $this->conexion->query($consulta);
    $tipos = [];
    while ($fila = mysqli_fetch_assoc($respuesta)) {
        $tipos[] = $fila;
    }
    return $tipos;
}

// ... Y que 'obtenerDetallesAsistenciaPorId()' y 'actualizar()' estén como te los pasé en la respuesta anterior para seguridad y funcionalidad.

    function actualizar($pk_asistencia_e, $fk_persona, $fk_c_eventos, $descripcion)
    {
        // ¡IMPORTANTE! También usar sentencias preparadas para actualizar para seguridad
        $consulta = "UPDATE asistencia_e SET fk_persona = ?, fk_c_eventos = ?, descripcion = ? WHERE pk_asistencia_e = ?";
        $stmt = $this->conexion->prepare($consulta);
        if ($stmt === false) {
            error_log("Error al preparar la consulta de actualización: " . $this->conexion->error);
            return false;
        }
        $stmt->bind_param("iisi", $fk_persona, $fk_c_eventos, $descripcion, $pk_asistencia_e); // i=integer, s=string
        $respuesta = $stmt->execute();
        $stmt->close();
        return $respuesta;
    }

    // ... (otros métodos) ...
}
