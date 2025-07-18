<?php

class Cliente
{
    function __construct()
    {
        require_once('conexion.php');
        $this->conexion = new Conexion();
    }

    function insertar_C_U($nombres, $a_paterno, $a_materno, $edad, $fecha_nac, $telefono, $direccion)
    {
        $consulta = "INSERT INTO persona (pk_persona, nombres, ap_paterno, ap_materno, edad, fecha_nac, telefono, direccion, estatus_persona)
                 VALUES (NULL, '{$nombres}', '{$a_paterno}', '{$a_materno}', '{$edad}', '{$fecha_nac}', '{$telefono}', '{$direccion}', 1)";

        $respuesta = $this->conexion->query($consulta);

        if ($respuesta) {
            return $this->conexion->insert_id; // Devuelve el ID para luego relacionarlo con el usuario
        } else {
            return false;
        }
    }
    function insertar_datos($nombres, $a_paterno, $a_materno, $edad, $fecha_nac, $telefono, $direccion)
    {
        $consulta = "INSERT INTO persona (pk_persona, nombres, ap_paterno, ap_materno, edad, fecha_nac, telefono, direccion, estatus_persona)
                 VALUES (NULL, '{$nombres}', '{$a_paterno}', '{$a_materno}', '{$edad}', '{$fecha_nac}', '{$telefono}', '{$direccion}', 1)";

        $respuesta = $this->conexion->query($consulta);

        if ($respuesta) {
            return $this->conexion->insert_id; // Devuelve el ID para luego relacionarlo con el usuario
        } else {
            return false;
        }
    }


    function mostrarTodo()
    {
        $consulta = "SELECT * FROM persona";
        $respuesta = $this->conexion->query($consulta);
        return $respuesta;
    }

    function mostrarPorId($pk_persona)
    {
        $consulta = "SELECT * FROM persona p INNER JOIN usuario u ON p.fk_usuario=u.pk_usuario WHERE pk_persona='{$pk_persona}'";
        $respuesta = $this->conexion->query($consulta);
        return $respuesta;
    }

    function mostrarPorUsuarioId($pk_persona)
    {
        $consulta = "SELECT * FROM persona WHERE fk_usuario = '{$pk_persona}' AND estatus = 1";
        $respuesta = $this->conexion->query($consulta);
        return $respuesta;
    }

    function editarCliente($nombres, $a_paterno, $a_materno, $fecha_nac, $telefono, $direccion)
    {
        $consulta = "UPDATE persona SET nombres='{$nombres}', a_paterno='{$a_paterno}', a_materno='{$a_materno}', fecha_nac='{$fecha_nac}', telefono='{$telefono}', direccion='{$direccion}' WHERE pk_persona='{$pk_persona}'";
        $respuesta = $this->conexion->query($consulta);
        return $respuesta;
    }
    function eliminar($pk_persona)
    {
        $consulta = "UPDATE cliente SET estatus=0 WHERE pk_persona = '{$pk_persona}'";
        $respuesta = $this->conexion->query($consulta);
        return $respuesta;
    }
    function buscarApellido($apellido){
        $consulta = "SELECT * FROM persona 
                 WHERE ap_paterno LIKE '%{$apellido}%' 
                    OR ap_materno LIKE '%{$apellido}%'";
        return $this->conexion->query($consulta);
    }
}
