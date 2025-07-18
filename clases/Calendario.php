<?php

class Calendario
{
    function __construct()
    {
        require_once('conexion.php');
        $this->conexion = new Conexion();
    }

    function mostrar()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            die('ID de evento no proporcionado.');
        }

        $consulta = $this->conexion->prepare("SELECT * FROM c_eventos WHERE pk_c_eventos = ?");
        $consulta->bind_param("i", $id);
        $consulta->execute();
        $resultado = $consulta->get_result();
        $evento = $resultado->fetch_assoc();

        if (!$evento) {
            die('Evento no encontrado.');
        }

        return $evento; // Devuélvelo para usarlo en la vista
    }
    function mostrarTodo()
    {
        $consulta = "SELECT prom.*, p.nombres, p.ap_paterno, p.ap_materno
                     FROM promotor prom
                     JOIN persona p ON prom.fk_persona = p.pk_persona";
        return $this->conexion->query($consulta);
    }
}
