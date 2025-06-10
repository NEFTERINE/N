<?php 

class Tipo
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
    function mostrarTodo(){
        $consulta = "SELECT * FROM tipo";
        $respuesta = $this->conexion->query($consulta);
        return $respuesta;
    }

}
?>

<?php 