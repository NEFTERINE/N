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
 function mostrar()
    {
 // Obtener el ID del promotor logueado desde la sesión
    $pk_promotor_logueado = isset($_SESSION['pk_promotor']) ? (int)$_SESSION['pk_promotor'] : null;

    if (!$pk_promotor_logueado) {
        // Retornar falso o vacío si no hay sesión válida
        return false;
    }

    $consulta = "
        SELECT
            pro.pk_promovido,
            pro.estatus_pro,
            CONCAT(p.nombres, ' ', p.ap_paterno, ' ', p.ap_materno) AS nombre_promovido,
            CONCAT(pp.nombres, ' ', pp.ap_paterno, ' ', pp.ap_materno) AS nombre_promotor
        FROM promovido pro
        INNER JOIN persona p ON pro.fk_persona = p.pk_persona
        INNER JOIN promotor prom ON pro.fk_promotor = prom.pk_promotor
        INNER JOIN persona pp ON prom.fk_persona = pp.pk_persona
        WHERE pro.estatus_pro = 1
          AND pro.fk_promotor = $pk_promotor_logueado
        ORDER BY nombre_promovido ASC
    ";

    $resultado = $this->conexion->query($consulta);

    if (!$resultado) {
        error_log("Error SQL en Promovido::mostrar(): " . $this->conexion->error);
        return false;
    }

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