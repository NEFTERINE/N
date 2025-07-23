<?php
require_once('menu.php');
require_once('clases/Cliente.php');
require_once('clases/Calendario.php');


$cliente = new Cliente();
$cal =new Calendario();

$apellido = $_GET['apellido'] ?? '';


$resultados = !empty($apellido) ? $cliente->buscarApellido($apellido) : $cliente->mostrarTodo();

$tipos = $cal->mostrarT();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asistencia de eventos</title>
    <link rel="stylesheet" href="css/bootstrap.css">
</head>

<body>
        <h2>Registrar de asistencia</h2>
        <form method="GET" class="col-10 offset-1 ">
            <div class="col-12 col-lg-6">
                <label for="apellido">Buscar por apellido:</label>
                <input type="text" class="form-control" name="apellido" value="<?= htmlspecialchars($apellido) ?>" onchange="this.form.submit()">
            </div>
            <br>

        </form>

    <form method="POST" action="insertar_asistencia_e.php" class="col-10 offset-1">

            <?php if (!empty($apellido)): ?>
            <div class="col-12 col-lg-6">
                <label for="fk_persona">Seleccionar persona:</label>
                <select class="form-control" name="fk_persona" required>
                    <option value="">Selecciona una persona</option>
                    <?php while ($fila = mysqli_fetch_array($resultados)): ?>
                        <option value="<?= $fila['pk_persona'] ?>">
                            <?= $fila['nombres'] . ' ' . $fila['ap_paterno'] . ' ' . $fila['ap_materno'] ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <?php endif; ?>
            <br>
            
            <div class="col-12 col-lg-6">
                <label for="fk_c_eventos">Eventos:</label>
                <select class="form-control" name="fk_c_eventos" required>
                    <option value="">Selecciona un Evento</option>
                    <?php foreach ($tipos as $fila): ?>
                        <option value="<?= $fila['pk_c_eventos'] ?>"><?= $fila['tipo_evento'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        
        <br>

            <div class="col-12 col-lg-6">
                
                <label for="descripcion">Descripción</label>
                <input type="text" name="descripcion"  class="form-control"></input>
                <div style="color: #ffc107;">
                  *Se sugiere poner el tipo de participacion
                </div>
            </div>

            <br>

        <div class="row justify-content-center">
            <div class="col-auto">
                <input class="btn btn-primary" type="submit" value="Guardar"><br><br>
            </div>
            <div class="col-auto">
                <a href="lista_asistencia_e.php" class="btn btn-secondary">Cancelar</a>
            <p class="p">¿La persona ocupa registrarse? <a href="formulario_persona_e.php">registrar</a></p>

            </div>
        </div>
    </form>

</body>
</html>
