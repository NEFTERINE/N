<?php
class Promotor
{

    function __construct()
    {
        require_once('conexion.php');
        $this->conexion = new Conexion();
    }

    function insertar($fk_persona, $fk_lider_coordinador, $fk_rol)
    {
        $consulta = "INSERT INTO promotor (pk_promotor, fk_persona, fk_lider_coordinador, fk_rol, estatus_promotor)
        VALUES (NULL, '{$fk_persona}', '{$fk_lider_coordinador}', '{$fk_rol}', 1)";
        $respuesta = $this->conexion->query($consulta);
        return $respuesta;
    }
    function mostrarTodo()
    {
        $consulta = "SELECT * FROM promotor WHERE estatus_promotor = 1";
        $resultado = $this->conexion->query($consulta);
        return $resultado;
    }
    // function buscar($pk_promotor)
    // {
    //     $consulta = "SELECT * FROM promotor WHERE pk_promotor = '{$pk_promotor}'";
    //     $respuesta = $this->conexion->query($consulta);
    //     return $respuesta;
    // }
    function buscar($pk_promotor)
    {
        $consulta = "SELECT pr.*, lc.fk_tipo 
                     FROM promotor pr
                     JOIN lider_coordinador lc ON pr.fk_lider_coordinador = lc.pk_lider_coordinador
                     WHERE pr.pk_promotor = '{$pk_promotor}'";
        return $this->conexion->query($consulta);
    }

    function actualizar($pk_promotor, $fk_persona, $fk_lider_coordinador, $fk_rol)
    {
        $consulta = "UPDATE promotor SET fk_persona='{$fk_persona}', fk_lider_coordinador='{$fk_lider_coordinador}', fk_rol='{$fk_rol}' WHERE pk_promotor='{$pk_promotor}'";
        $respuesta = $this->conexion->query($consulta);
        return $respuesta;
    }
    function eliminar($pk_promotor)
    {
        $consulta = "UPDATE promotor SET estatus_promotor=0 WHERE pk_promotor='{$pk_promotor}'";
        $respuesta = $this->conexion->query($consulta);
        return $respuesta;
    }
    function buscarPorLC($fk_lider_coordinador)
    {
        $consulta = "SELECT * FROM promotor WHERE fk_lider_coordinador='{$fk_lider_coordinador}' AND estatus_promotor=1";
        $resultado = $this->conexion->query($consulta);
        return $resultado;
    }
    function mostrarP()
    {
        $consulta = "SELECT 
    pr.pk_promotor,
    CONCAT(promo.nombres, ' ', promo.ap_paterno, ' ', promo.ap_materno) AS nombre_promotor,
    r.nom_rol AS rol_promotor,
    CONCAT(lider.nombres, ' ', lider.ap_paterno, ' ', lider.ap_materno) AS nombre_lider_coordinador,
    pr.estatus_promotor
FROM promotor pr
JOIN persona promo ON pr.fk_persona = promo.pk_persona
JOIN rol r ON pr.fk_rol = r.pk_rol
JOIN lider_coordinador lc ON pr.fk_lider_coordinador = lc.pk_lider_coordinador
JOIN persona lider ON lc.fk_persona = lider.pk_persona
                WHERE pr.estatus_promotor = 1";

        return $this->conexion->query($consulta);
    }


    // function buscarPorPersona($fk_persona)
    // {
    //     $consulta = "SELECT * FROM promotor WHERE fk_persona='{$fk_persona}' AND estatus_promotor=1";
    //     $resultado = $this->conexion->query($consulta);
    //     return $resultado;
    // }

    // Dentro de la clase Promotor (o donde sea que manejes las consultas relacionadas)

    public function cPPromotor()
    {
        $consulta = "SELECT
                     P.nombres AS nombre_promotor_nombres,
                     P.ap_paterno AS nombre_promotor_ap_paterno,
                     COUNT(PR.pk_promovido) AS total_promovidos
                 FROM
                     promotor PRM
                 LEFT JOIN
                     promovido PR ON PRM.pk_promotor = PR.fk_promotor
                 LEFT JOIN
                     persona P ON PRM.fk_persona = P.pk_persona
                 GROUP BY
                     PRM.pk_promotor, P.nombres, P.ap_paterno
                 ORDER BY
                     total_promovidos DESC"; // Ordenar por la cantidad, de mayor a menor

        // Asegúrate de que $this->conexion es tu objeto de conexión a la base de datos
        $resultado = mysqli_query($this->conexion, $consulta);

        $datos_grafica = [];
        if ($resultado) {
            while ($fila = mysqli_fetch_assoc($resultado)) {
                $datos_grafica[] = [
                    'promotor_nombre_completo' => $fila['nombre_promotor_nombres'] . ' ' . $fila['nombre_promotor_ap_paterno'],
                    'cantidad' => (int)$fila['total_promovidos'] // Convertir a entero
                ];
            }
        } else {
            error_log("Error al obtener promovidos por promotor: " . mysqli_error($this->conexion));
        }
        return $datos_grafica;
    }

    function buscarPromotorPorId($pk_promotor)
    {
        $consulta = "
            SELECT
                pr.pk_promotor,
                pr.fk_persona,
                pr.fk_lider_coordinador,
                pr.fk_rol,
                pr.estatus_promotor,
                p.nombres AS nombre_persona,
                p.ap_paterno AS ap_paterno_persona,
                p.ap_materno AS ap_materno_persona,
                r.nom_rol AS nombre_rol,
                -- Obtener el nombre completo del líder/coordinador
                (SELECT CONCAT(pl.nombres, ' ', pl.ap_paterno, ' ', pl.ap_materno)
                 FROM persona pl
                 WHERE pl.pk_persona = lc.fk_persona) AS nombre_lider_coordinador,
                lc.fk_tipo AS fk_tipo_lider_coordinador -- Para filtrar los roles si es necesario
            FROM
                promotor pr
            LEFT JOIN
                persona p ON pr.fk_persona = p.pk_persona
            LEFT JOIN
                lider_coordinador lc ON pr.fk_lider_coordinador = lc.pk_lider_coordinador
            LEFT JOIN
                rol r ON pr.fk_rol = r.pk_rol
            WHERE
                pr.pk_promotor = ?
            LIMIT 1;
        ";
        $stmt = $this->conexion->prepare($consulta);
        if ($stmt === false) {
            error_log("Error al preparar la consulta buscarPromotorPorId: " . $this->conexion->error);
            return null;
        }
        $stmt->bind_param("i", $pk_promotor);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $datos = $resultado->fetch_assoc();
        $stmt->close();
        return $datos;
    }
}
