<?php
class Rol
{
    function __construct()
    {
        require_once('conexion.php');
        $this->conexion = new Conexion();
    }

    function insertar($fk_persona, $fk_tipo, $fk_rol, $fk_territorio) {
    $consulta = "INSERT INTO lider_coordinador 
                 (pk_lider_coordinador, fk_persona, fk_tipo, fk_rol, fk_territorio) 
                 VALUES (NULL, '{$fk_persona}', '{$fk_tipo}', '{$fk_rol}', '{$fk_territorio}')";
    
    $respuesta = $this->conexion->query($consulta);
    return $this->conexion->insert_id;
    }
    // Muestra todos los tipos de usuarios
function mostrarTodo($fk_tipo = null) {
    if ($fk_tipo !== null) {
        $consulta = "SELECT * FROM rol WHERE fk_tipo = '{$fk_tipo}' AND estatus_rol = 1";
    } else {
        $consulta = "SELECT * FROM rol WHERE estatus_rol = 1";
    }
    return $this->conexion->query($consulta);
}

    function mostrarT(){
     $consulta = "SELECT * FROM rol";
    return $this->conexion->query($consulta);
    }
//rol relacionado con promotor mediante la id
    

}
?>
