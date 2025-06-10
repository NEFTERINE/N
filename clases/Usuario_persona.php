<?php
class Usuario_persona {
    private $conexion;

    function __construct() {
        require_once('conexion.php');
        $this->conexion = new Conexion();
    }

    function conectar($fk_usuario, $fk_persona) {
        $consulta = "INSERT INTO usuario_personas(fk_usuario, fk_persona) VALUES ('{$fk_usuario}', '{$fk_persona}')";
        return $this->conexion->query($consulta);
    }
}
?>
