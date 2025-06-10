<?php

class Usuario
{
    function __construct()
    {
        require_once('conexion.php');
        $this->conexion = new Conexion();
    }

    function insertar($correo, $contraseña)
    {
        $consulta = "INSERT INTO usuario(pk_usuario, correo, contraseña, estatus_usuario, type) 
                     VALUES (NULL, '{$correo}', '{$contraseña}', 1, 1)";
        $respuesta = $this->conexion->query($consulta);
        return $this->conexion->insert_id;
    }

    // Inserta un nuevo usuario con el tipo (normal o superusuario)
    function insertar_U_C($correo, $contraseña, $type)
    {

        $consulta = "INSERT INTO usuario(pk_usuario, correo, contraseña, estatus_usuario, type) 
                 VALUES (NULL, '{$correo}', '{$contraseña}', 1, {$type})"; // 1 = tipo 'usuario normal'

        $this->conexion->query($consulta);
        return $this->conexion->insert_id;
    }
    function correo($correo)
    {
        $consulta = "SELECT * FROM usuario WHERE correo = '{$correo}'";
        $respuesta = $this->conexion->query($consulta);
        return $respuesta;
    }

    function mostrarTodo_n()
    {
        $consulta = "SELECT u.*, p.nombres, p.ap_paterno, p.ap_materno
                 FROM usuario u
                 LEFT JOIN usuario_personas up ON u.pk_usuario = up.fk_usuario
                 LEFT JOIN persona p ON up.fk_persona = p.pk_persona";
        return $this->conexion->query($consulta);
    }


    // Muestra todos los usuarios
    function mostrarTodo()
    {
        $consulta = "SELECT * FROM usuario";
        $respuesta = $this->conexion->query($consulta);
        return $respuesta;
    }

    // Valida un usuario por nombre y contraseña
    function validar($correo, $contraseña)
    {
        $consulta = "SELECT * FROM usuario WHERE correo='{$correo}' AND contraseña='{$contraseña}' AND estatus_usuario=1";
        $respuesta = $this->conexion->query($consulta);
        return $respuesta;
    }

    // Elimina un usuario (cambia el estatus a 0)
    function eliminarUsuario($pk_usuario)
    {
        $consulta = "UPDATE usuario SET estatus_usuario=0 WHERE pk_usuario='{$pk_usuario}'";
        $respuesta = $this->conexion->query($consulta);
        return $respuesta;
    }

    // Edita los datos de un usuario, incluyendo el tipo
    function editarUsuario($pk_usuario, $correo, $contraseña, $type)
    {
        $consulta = "UPDATE usuario SET correo='{$correo}', contraseña='{$contraseña}', type='{$type}' 
                     WHERE pk_usuario='{$pk_usuario}'";
        $respuesta = $this->conexion->query($consulta);
        return $respuesta;
    }

    // Busca un usuario por su ID
    function buscar($pk_usuario)
    {
        $consulta = "SELECT * FROM usuario WHERE pk_usuario= '{$pk_usuario}'";
        $respuesta = $this->conexion->query($consulta);
        return $respuesta;
    }

    // Muestra los detalles del usuario por su ID
    function mostrarPorId($pk_usuario)
    {
        $consulta = "SELECT u.correo, p.nombres, p.ap_paterno, p.ap_materno
                 FROM usuario u
                 LEFT JOIN usuario_personas up ON u.pk_usuario = up.fk_usuario
                 LEFT JOIN persona p ON up.fk_persona = p.pk_persona
                 WHERE u.pk_usuario = '{$pk_usuario}'";
        return $this->conexion->query($consulta);
    }
    // Activa un usuario (cambia el estatus a 1)
    function activarUsuario($pk_usuario)
    {
        if (empty($pk_usuario)) {
            return false;
        }

        $consulta = "UPDATE usuario SET estatus_usuario = 1 WHERE pk_usuario = '{$pk_usuario}'";
        $respuesta = $this->conexion->query($consulta);

        return $respuesta ? true : false;
    }
    function insertar2($correo, $contraseña, $type)
    {
        $consulta = "INSERT INTO usuario(pk_usuario, correo, contraseña, estatus_usuario, type) 
                     VALUES (NULL, '{$correo}', '{$contraseña}', 1, '{$type}')";
        $respuesta = $this->conexion->query($consulta);
        return $this->conexion->insert_id;
    }
}
