<?php 

class Promovido
{
	function __construct()
	{
        require_once('conexion.php');
        $this->conexion=new Conexion();
	} 

function insertar($fk_persona, $fk_promotor) {
    $consulta = "INSERT INTO promovido (pk_promovido, fk_persona, fk_promotor)
                 VALUES (NULL, '{$fk_persona}', '{$fk_promotor}'";

    $this->conexion->query($consulta);
    return $this->conexion->insert_id;
    
}
    function mostrarTodo()
    {
        $consulta = "SELECT * FROM promovido";
        $respuesta = $this->conexion->query($consulta);
        return $respuesta;
    }
}
?>