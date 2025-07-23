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
        $consulta = "INSERT INTO lider_coordinador (pk_lider_coordinador, fk_persona, fk_tipo, fk_rol, fk_territorio, estatus_lc)
        VALUES (NULL, '{$fk_persona}', '{$fk_tipo}', '{$fk_rol}', '{$fk_territorio}', 1)";
        $respuesta = $this->conexion->query($consulta);
        return $respuesta;
    }
function buscar($pk_lider_coordinador) {
        $pk_lider_coordinador = $this->conexion->real_escape_string($pk_lider_coordinador);

        $consulta = "
            SELECT
                lc.pk_lider_coordinador,
                lc.fk_persona,
                p.nombres AS nombre_persona,               -- Asume 'nombre' es la columna del nombre en 'persona'
                p.ap_paterno AS apellido_paterno_persona, -- Asume esta columna en 'persona'
                p.ap_materno AS apellido_materno_persona, -- Asume esta columna en 'persona'
                lc.fk_tipo,
                t.Tipo AS nombre_tipo,
                lc.fk_rol,
                r.nom_rol,
                lc.fk_territorio,
                tr.municipio,
                tr.fk_distrito,
                tr.fk_secciones,
                tr.fk_estado AS fk_estado,                 -- ¡OBTENEMOS fk_estado DESDE LA TABLA TERRITORIO!
                e.nombre_estado,                           -- De la tabla 'estado'
                lc.estatus_lc
            FROM
                lider_coordinador lc
            LEFT JOIN
                persona p ON lc.fk_persona = p.pk_persona  -- Asegúrate de que 'persona' y 'pk_persona' son correctos
            LEFT JOIN
                tipo t ON lc.fk_tipo = t.pk_tipo
            LEFT JOIN
                rol r ON lc.fk_rol = r.pk_rol
            LEFT JOIN
                territorio tr ON lc.fk_territorio = tr.pk_territorio -- Unimos con territorio
            LEFT JOIN
                estado e ON tr.fk_estado = e.pk_estado     -- ¡Y luego unimos territorio con estado!
            WHERE
                lc.pk_lider_coordinador = '{$pk_lider_coordinador}'
            LIMIT 1;
        ";

        $respuesta = $this->conexion->query($consulta);

        if ($respuesta === false) {
            error_log("Error en la consulta buscar de Lider_coordinador: " . $this->conexion->error);
            return false;
        }

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
    function actualizar($pk_lider_coordinador, $fk_tipo, $fk_rol, $fk_territorio)
    {
        $consulta = "UPDATE lider_coordinador SET  fk_tipo='{$fk_tipo}', fk_rol='{$fk_rol}', fk_territorio='{$fk_territorio}' WHERE pk_lider_coordinador='{$pk_lider_coordinador}'";
        $respuesta = $this->conexion->query($consulta);
        return $respuesta;
    }
    function eliminar($pk_lider_coordinador)
    {
        $consulta = "UPDATE lider_coordinador SET estatus_lc=0 WHERE pk_lider_coordinador='{$pk_lider_coordinador}'";
        $respuesta = $this->conexion->query($consulta);
        return $respuesta;
    }
    
    function activar($pk_lider_coordinador)
    {
        $consulta = "UPDATE lider_coordinador SET estatus_lc=1 WHERE pk_lider_coordinador='{$pk_lider_coordinador}'";
        $respuesta = $this->conexion->query($consulta);
        return $respuesta;
    }
    //funcion para mostrar solo los coordinadores
    function mostrarL()
    {
        $consulta = "SELECT lc.*, p.nombres, p.ap_paterno, p.ap_materno, t.tipo, r.nom_rol, te.municipio
                     FROM lider_coordinador lc
                     JOIN persona p ON lc.fk_persona = p.pk_persona
                     JOIN tipo t ON lc.fk_tipo = t.pk_tipo
                     JOIN rol r ON lc.fk_rol = r.pk_rol
                     JOIN territorio te ON lc.fk_territorio = te.pk_territorio
                     WHERE lc.estatus_lc = 1 AND t.tipo = 'Lider'";
        $respuesta = $this->conexion->query($consulta);
        return $respuesta;
    }
    function mostrarC()
    {
        $consulta = "SELECT lc.*, p.nombres, p.ap_paterno, p.ap_materno, t.tipo, r.nom_rol, te.municipio
                     FROM lider_coordinador lc
                     JOIN persona p ON lc.fk_persona = p.pk_persona
                     JOIN tipo t ON lc.fk_tipo = t.pk_tipo
                     JOIN rol r ON lc.fk_rol = r.pk_rol
                     JOIN territorio te ON lc.fk_territorio = te.pk_territorio
                     WHERE lc.estatus_lc = 1 AND t.tipo = 'Coordinador'";
        $respuesta = $this->conexion->query($consulta);
        return $respuesta;
    }
    function mostrar()
    {
        $consulta = "SELECT lc.*, p.nombres, p.ap_paterno, p.ap_materno, t.Tipo, r.nom_rol
                     FROM lider_coordinador lc
                     JOIN persona p ON lc.fk_persona = p.pk_persona
                     JOIN tipo t ON lc.fk_tipo = t.pk_tipo
                     JOIN rol r ON lc.fk_rol = r.pk_rol
                     WHERE lc.estatus_lc = 1 AND t.Tipo = 'Coordinador'";
        $respuesta = $this->conexion->query($consulta);
        return $respuesta;
    }
        function mostrarR()
    {
        $consulta = "SELECT lc.*, p.nombres, p.ap_paterno, p.ap_materno, t.Tipo, r.nom_rol, te.municipio
                     FROM lider_coordinador lc
                     JOIN persona p ON lc.fk_persona = p.pk_persona
                     JOIN tipo t ON lc.fk_tipo = t.pk_tipo
                     JOIN rol r ON lc.fk_rol = r.pk_rol
                     JOIN territorio te ON lc.fk_territorio = te.pk_territorio
                     WHERE lc.estatus_lc = 1 AND t.tipo = 'Representante de casilla'";
        $respuesta = $this->conexion->query($consulta);
        return $respuesta;
    }
        function buscarPorApellido($apellido){
        $consulta = "SELECT * FROM persona 
                 WHERE nombres LIKE '%{$apellido}%' 
                 oR ap_paterno LIKE '%{$apellido}%' 
                    OR ap_materno LIKE '%{$apellido}%'";
        return $this->conexion->query($consulta);
    }

    // function mostrarLideresInactivos()
    // {
    //     $consulta = "SELECT lc.*, p.nombres, p.ap_paterno, p.ap_materno, t.tipo, r.nom_rol, te.municipio
    //                  FROM lider_coordinador lc
    //                  JOIN persona p ON lc.fk_persona = p.pk_persona
    //                  JOIN tipo t ON lc.fk_tipo = t.pk_tipo
    //                  JOIN rol r ON lc.fk_rol = r.pk_rol
    //                  JOIN territorio te ON lc.fk_territorio = te.pk_territorio
    //                  WHERE lc.estatus_lc = 0";
    //     $respuesta = $this->conexion->query($consulta);
    //     return $respuesta;
    // }

    // function mostrarLideresPorTipo($tipo)
    // {
    //     $consulta = "SELECT lc.*, p.nombres, p.ap_paterno, p.ap_materno, t.tipo, r.nom_rol, te.municipio
    //                  FROM lider_coordinador lc
    //                  JOIN persona p ON lc.fk_persona = p.pk_persona
    //                  JOIN tipo t ON lc.fk_tipo = t.pk_tipo
    //                  JOIN rol r ON lc.fk_rol = r.pk_rol
    //                  JOIN territorio te ON lc.fk_territorio = te.pk_territorio
    //                  WHERE lc.estatus_lc = 1 AND t.tipo = '{$tipo}'";
    //     $respuesta = $this->conexion->query($consulta);
    //     return $respuesta;
    // }
    // function mostrarLideresPorMunicipio($municipio)
    // {
    //     $consulta = "SELECT lc.*, p.nombres, p.ap_paterno, p.ap_materno, t.tipo, r.nom_rol, te.municipio
    //                  FROM lider_coordinador lc
    //                  JOIN persona p ON lc.fk_persona = p.pk_persona
    //                  JOIN tipo t ON lc.fk_tipo = t.pk_tipo
    //                  JOIN rol r ON lc.fk_rol = r.pk_rol
    //                  JOIN territorio te ON lc.fk_territorio = te.pk_territorio
    //                  WHERE lc.estatus_lc = 1 AND te.municipio = '{$municipio}'";
    //     $respuesta = $this->conexion->query($consulta);
    //     return $respuesta;
    // }
    // function mostrarLideresPorRol($rol)
    // {
    //     $consulta = "SELECT lc.*, p.nombres, p.ap_paterno, p.ap_materno, t.tipo, r.nom_rol, te.municipio
    //                  FROM lider_coordinador lc
    //                  JOIN persona p ON lc.fk_persona = p.pk_persona
    //                  JOIN tipo t ON lc.fk_tipo = t.pk_tipo
    //                  JOIN rol r ON lc.fk_rol = r.pk_rol
    //                  JOIN territorio te ON lc.fk_territorio = te.pk_territorio
    //                  WHERE lc.estatus_lc = 1 AND r.nom_rol = '{$rol}'";
    //     $respuesta = $this->conexion->query($consulta);
    //     return $respuesta;
    // }
    // function mostrarLideresPorTerritorio($territorio)
    // {
    //     $consulta = "SELECT lc.*, p.nombres, p.ap_paterno, p.ap_materno, t.tipo, r.nom_rol, te.municipio
    //                  FROM lider_coordinador lc
    //                  JOIN persona p ON lc.fk_persona = p.pk_persona
    //                  JOIN tipo t ON lc.fk_tipo = t.pk_tipo
    //                  JOIN rol r ON lc.fk_rol = r.pk_rol
    //                  JOIN territorio te ON lc.fk_territorio = te.pk_territorio
    //                  WHERE lc.estatus_lc = 1 AND te.municipio = '{$territorio}'";
    //     $respuesta = $this->conexion->query($consulta);
    //     return $respuesta;
    // }
    // function mostrarLideresPorPersona($persona)
    // {
    //     $consulta = "SELECT lc.*, p.nombres, p.ap_paterno, p.ap_materno, t.tipo, r.nom_rol, te.municipio
    //                  FROM lider_coordinador lc
    //                  JOIN persona p ON lc.fk_persona = p.pk_persona
    //                  JOIN tipo t ON lc.fk_tipo = t.pk_tipo
    //                  JOIN rol r ON lc.fk_rol = r.pk_rol
    //                  JOIN territorio te ON lc.fk_territorio = te.pk_territorio
    //                  WHERE lc.estatus_lc = 1 AND (p.nombres LIKE '%{$persona}%' OR p.ap_paterno LIKE '%{$persona}%' OR p.ap_materno LIKE '%{$persona}%')";
    //     $respuesta = $this->conexion->query($consulta);
    //     return $respuesta;
    // }
    // function mostrarLideresPorEstado($estado)
    // {
    //     $consulta = "SELECT lc.*, p.nombres, p.ap_paterno, p.ap_materno, t.tipo, r.nom_rol, te.municipio
    //                  FROM lider_coordinador lc
    //                  JOIN persona p ON lc.fk_persona = p.pk_persona
    //                  JOIN tipo t ON lc.fk_tipo = t.pk_tipo
    //                  JOIN rol r ON lc.fk_rol = r.pk_rol
    //                  JOIN territorio te ON lc.fk_territorio = te.pk_territorio
    //                  WHERE lc.estatus_lc = 1 AND te.estado = '{$estado}'";
    //     $respuesta = $this->conexion->query($consulta);
    //     return $respuesta;
    // }
    // function mostrarLideresPorDistrito($distrito)
    // {
    //     $consulta = "SELECT lc.*, p.nombres, p.ap_paterno, p.ap_materno, t.tipo, r.nom_rol, te.municipio
    //                  FROM lider_coordinador lc
    //                  JOIN persona p ON lc.fk_persona = p.pk_persona
    //                  JOIN tipo t ON lc.fk_tipo = t.pk_tipo
    //                  JOIN rol r ON lc.fk_rol = r.pk_rol
    //                  JOIN territorio te ON lc.fk_territorio = te.pk_territorio
    //                  WHERE lc.estatus_lc = 1 AND te.distrito = '{$distrito}'";
    //     $respuesta = $this->conexion->query($consulta);
    //     return $respuesta;
    // }
    // function mostrarLideresPorSeccion($seccion)
    // {
    //     $consulta = "SELECT lc.*, p.nombres, p.ap_paterno, p.ap_materno, t.tipo, r.nom_rol, te.municipio
    //                  FROM lider_coordinador lc
    //                  JOIN persona p ON lc.fk_persona = p.pk_persona
    //                  JOIN tipo t ON lc.fk_tipo = t.pk_tipo
    //                  JOIN rol r ON lc.fk_rol = r.pk_rol
    //                  JOIN territorio te ON lc.fk_territorio = te.pk_territorio
    //                  WHERE lc.estatus_lc = 1 AND te.seccion = '{$seccion}'";
    //     $respuesta = $this->conexion->query($consulta);
    //     return $respuesta;
    // }


}
