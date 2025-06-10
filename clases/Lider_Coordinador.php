<?php
class Lider_coordinador
{

    function __construct()
    {
        require_once('conexion.php');
        $this->conexion = new Conexion();
    }

    function insertar($fk_persona, $fk_tipo, $fk_rol, $fk_territorio)
    {
        $consulta = "INSERT INTO lider_coordinador (pk_lider_coordinador, fk_persona, fk_tipo, fk_rol, fk_territorio)
                 VALUES (NULL, '{$fk_persona}', '{$fk_tipo}', '{$fk_rol}', '{$fk_territorio}')";
        $respuesta = $this->conexion->query($consulta);
        return $respuesta;
    }
    function mostrarTodo()
    {
        $consulta = "SELECT * FROM lider_coordinador";
        $respuesta = $this->conexion->query($consulta);
        return $respuesta;
    }
    function mostrarLC($pk_lider_coordinador)
    {
        $consulta = "SELECT * FROM lider_coordinador WHERE pk_lider_coordinador='{$pk_lider_coordinador}'";
        $respuesta = $this->conexion->query($consulta);
        return $respuesta->fetch_assoc();
    }
}
