<?php 

class Promovido
{
	function __construct()
	{
        require_once('conexion.php');
        $this->conexion=new Conexion();
	} 

    function insertar($fk_persona, $fk_promotor) {
        $consulta = "INSERT INTO promovido (pk_promovido, fk_persona, fk_promotor, estatus_pro)
        VALUES (NULL, '{$fk_persona}', '{$fk_promotor}', 1)";
    
        $this->conexion->query($consulta);
        return $this->conexion->insert_id;
        
    }
    function mostrarTodo()
    {
        $consulta = "SELECT * FROM promovido";
        $respuesta = $this->conexion->query($consulta);
        return $respuesta;
    }
    public function mostrar()
    {
        $consulta = "SELECT
                         pro.pk_promovido,   -- <<-- ¡Añade esta línea!
                         pro.estatus_pro,    -- <<-- ¡Añade esta línea!
                         CONCAT(p.nombres, ' ', p.ap_paterno, ' ', p.ap_materno) AS nombre_promovido,
                         CONCAT(pp.nombres, ' ', pp.ap_paterno, ' ', pp.ap_materno) AS nombre_promotor
                     FROM promovido pro
                     JOIN persona p ON pro.fk_persona = p.pk_persona
                     JOIN promotor prom ON pro.fk_promotor = prom.pk_promotor
                     JOIN persona pp ON prom.fk_persona = pp.pk_persona -- Asegurarse que promotor.fk_persona exista y apunte a persona.pk_persona
                     WHERE pro.estatus_pro = 1";
    
        $resultado = $this->conexion->query($consulta);
        return $resultado;
    }
    
    function editar($pk_promovido, $fk_persona, $fk_promotor)
    {
        $consulta = "UPDATE promovido 
                     SET fk_persona = '{$fk_persona}', 
                         fk_promotor = '{$fk_promotor}' 
                     WHERE pk_promovido = '{$pk_promovido}'";
    
        return $this->conexion->query($consulta);
    }

        function buscar($pk_promovido)
    {
        $consulta = "SELECT * FROM promovido WHERE pk_promovido= '{$pk_promovido}'";
        $respuesta = $this->conexion->query($consulta);
        return $respuesta;
    }
    function eliminar($pk_promovido)
    {
        $consulta = "UPDATE promovido SET estatus_pro=0 WHERE pk_promovido='{$pk_promovido}'";
        $respuesta = $this->conexion->query($consulta);
        return $respuesta;
    }

}
?>