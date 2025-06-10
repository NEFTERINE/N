<?php
class Estado
{
    function __construct()
    {
        require_once('conexion.php');
        $this->conexion = new Conexion();
    }

    // Muestra todos los tipos de usuarios
    function mostrarTodo(){
        $consulta = "SELECT * FROM estado";
        $respuesta = $this->conexion->query($consulta);
        return $respuesta;
    }
    

}
?>
