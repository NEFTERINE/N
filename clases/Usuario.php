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
        $contraseña_hasheada = password_hash($contraseña, PASSWORD_DEFAULT);

        $stmt = $this->conexion->prepare("INSERT INTO usuario (correo, contraseña, estatus_usuario ,type) VALUES (?, ?, ?, ?)");
        // 's' para string, 's' para string, 'i' para integer
        $estatus_default = 1; // Asignar un valor por defecto para el estatus
        $type_default = 1; // Asignar un valor por defecto para el tipo
        $stmt->bind_param("ssii", $correo, $contraseña_hasheada, $estatus_default, $type_default);

        return $stmt->execute();
    }
    // function insertar($correo, $contraseña)
    // {
    //     $consulta = "INSERT INTO usuario (pk_usuario, correo, contraseña, estatus_usuario, type) 
    //                  VALUES (NULL, '{$correo}', '{$contraseña}', 1, 1)";
    //     $respuesta = $this->conexion->query($consulta);
    //     return $this->conexion->insert_id;
    // }
    function insertar_U_C($correo, $contraseña, $type)
    {
        // Hashear la contraseña antes de guardarla
        $contraseña_hasheada = password_hash($contraseña, PASSWORD_DEFAULT);

        $stmt = $this->conexion->prepare("INSERT INTO usuario (correo, contraseña, estatus_usuario ,type) VALUES (?, ?, ?, ?)");
        // 's' para string, 's' para string, 'i' para integer
        $estatus_default = 1; // Asignar un valor por defecto para el estatus
        $stmt->bind_param("ssii", $correo, $contraseña_hasheada, $estatus_default, $type);

        return $stmt->execute();
    }

    // Inserta un nuevo usuario con el tipo (normal o superusuario) configuracion normal
    // function insertar_U_C($correo, $contraseña, $type)
    // {

    //     $consulta = "INSERT INTO usuario (pk_usuario, correo, contraseña, estatus_usuario, type) 
    //              VALUES (NULL, '{$correo}', '{$contraseña}', 1, {$type})"; // 1 = tipo 'usuario normal'

    //     $this->conexion->query($consulta);
    //     return $this->conexion->insert_id;
    // }
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
    // function validar($correo, $contraseña)
    // {
    //     $consulta = "SELECT * FROM usuario WHERE correo='{$correo}' AND contraseña='{$contraseña}' AND estatus_usuario=1";
    //     $respuesta = $this->conexion->query($consulta);
    //     return $respuesta;
    // }
    function validar($correo, $contraseña_ingresada)
    {
        
        // Usar sentencia preparada para evitar inyección SQL
        $stmt = $this->conexion->prepare("SELECT pk_usuario, type, contraseña FROM usuario WHERE correo = ? AND estatus_usuario = 1");
        $stmt->bind_param("s", $correo); // 's' indica que $correo es un string
        $stmt->execute();
        $resultado = $stmt->get_result();
        $datos = $resultado->fetch_assoc(); // <--- Aquí obtenemos los datos una vez

        if ($datos) {
            // Un usuario con ese correo fue encontrado
            $contraseña_hash_almacenada = $datos['contraseña'];

            // === Lógica de migración para contraseñas no hasheadas ===
            $is_hashed = (strpos($contraseña_hash_almacenada, '$2y$') === 0 || strpos($contraseña_hash_almacenada, '$2a$') === 0 || strpos($contraseña_hash_almacenada, '$2b$') === 0);

            if ($is_hashed) {
                // La contraseña ya está hasheada, simplemente la verificamos
                if (password_verify($contraseña_ingresada, $contraseña_hash_almacenada)) {
                    return $datos; // <--- DEVOLVER EL ARRAY DE DATOS SI ES CORRECTO
                }
            } else {
                // La contraseña NO está hasheada (es texto plano de un usuario antiguo)
                // Comparamos directamente (¡solo por esta vez!)
                if ($contraseña_ingresada === $contraseña_hash_almacenada) {
                    // La contraseña en texto plano es correcta, ahora la hasheamos y actualizamos en la BD
                    $nueva_contraseña_hasheada = password_hash($contraseña_ingresada, PASSWORD_DEFAULT);
                    $stmt_update = $this->conexion->prepare("UPDATE usuario SET contraseña = ? WHERE pk_usuario = ?");
                    $stmt_update->bind_param("si", $nueva_contraseña_hasheada, $datos['pk_usuario']);
                    $stmt_update->execute();
                    $stmt_update->close(); // Cerrar el statement de actualización

                    return $datos; // <--- DEVOLVER EL ARRAY DE DATOS SI ES CORRECTO
                }
            }
        }

        // Si no se encontró usuario o la contraseña no coincide, retorna falso
        return false; // <--- DEVOLVER FALSE EN CASO DE FALLO
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

    function nombre($pk_usuario){
        $consulta = "SELECT u.correo, p.nombres, p.ap_paterno, p.ap_materno
                     FROM usuario u
                     LEFT JOIN usuario_personas up ON u.pk_usuario = up.fk_usuario
                     LEFT JOIN persona p ON up.fk_persona = p.pk_persona
                     WHERE u.pk_usuario = ?";

        $stmt = $this->conexion->prepare($consulta);

        if (!$stmt) {
            error_log("Error al preparar la consulta en mostrarPorId: " . $this->conexion->error);
            return false;
        }

        // 2. Vincula el parámetro: 'i' para indicar que $pk_usuario es un entero
        if (!$stmt->bind_param("i", $pk_usuario)) {
            error_log("Error al vincular parámetros en mostrarPorId: " . $stmt->error);
            $stmt->close();
            return false;
        }

        // 3. Ejecuta la consulta
        if (!$stmt->execute()) {
            error_log("Error al ejecutar consulta en mostrarPorId: " . $stmt->error);
            $stmt->close();
            return false;
        }

        // 4. Obtiene el resultado
        $resultado = $stmt->get_result();

        // 5. Cierra el statement
        $stmt->close();

        return $resultado;
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

    // @param string $correo El correo electrónico del usuario.
    // @param string $contraseña La contraseña en texto plano.
    // @param int $type El tipo de usuario.
    // @return int|false El ID del usuario insertado en caso de éxito, o false si falla.

    function insertar2($correo, $contraseña, $type)
    {
        // 1. Hashear la contraseña antes de guardarla (¡CRUCIAL!)
        $contraseña_hasheada = password_hash($contraseña, PASSWORD_DEFAULT);

        // 2. Usar sentencias preparadas para prevenir inyección SQL
        // Asegúrate de que los campos en VALUES coincidan con la cantidad y tipo de marcadores '?'
        // y que 'estatus_usuario' tenga su propio marcador '?' si se inserta un valor fijo.
        $consulta = "INSERT INTO usuario(correo, contraseña, estatus_usuario, type) 
                     VALUES (?, ?, ?, ?)";

        $stmt = $this->conexion->prepare($consulta);

        // Definimos el estatus por defecto
        $estatus_usuario = 1;

        // 3. Vincular los parámetros con sus tipos correctos
        // 'ssii' -> s (string para correo), s (string para contraseña hasheada),
        //           i (integer para estatus_usuario), i (integer para type)
        if (!$stmt->bind_param("ssii", $correo, $contraseña_hasheada, $estatus_usuario, $type)) {
            error_log("Error al vincular parámetros en insertar2: " . $stmt->error);
            return false;
        }

        // 4. Ejecutar la consulta
        if ($stmt->execute()) {
            return $this->conexion->insert_id; // Devuelve el ID del nuevo usuario
        } else {
            error_log("Error al ejecutar consulta en insertar2: " . $stmt->error);
            return false; // Error en la inserción
        }
    }
    // function insertar2($correo, $contraseña, $type)
    // {
    //     $consulta = "INSERT INTO usuario(pk_usuario, correo, contraseña, estatus_usuario, type) 
    //                  VALUES (NULL, '{$correo}', '{$contraseña}', 1, '{$type}')";
    //     $respuesta = $this->conexion->query($consulta);
    //     return $this->conexion->insert_id;
    // }
}
