<?php
    session_start();

if (!isset($_SESSION['pk_usuario']) || !in_array($_SESSION['type'], [2, 3, 5])) {
    echo '
    <div style="text-align:center; margin-top: 100px;">
        <h2 style="color: #c00;">Acceso denegado</h2>
        <p>No tienes permisos para acceder a esta función.</p>
        <a href="index.php" class="btn btn-primary mt-3">Volver al calendario</a>
    </div>';
    exit;
}


require_once('menu.php');
require_once('clases/Calendario.php');

$cale = new Calendario;
$evento = $cale->mostrar();

$cal = new Calendario;

$respuesta = $cal->mostrarTodo();


?>

    <form action="editar_evento.php" method="POST" class="col-10 offset-1">
        <input type="hidden" name="id" value="<?= $evento['pk_c_eventos'] ?>">
        <br>
        <br>

        <h2>Editar evento</h2>
        <br>

        <div class="col-12 col-lg-6">
            <label>Título:</label>
            <input type="text" name="tipo_evento" class="form-control" value="<?= $evento['tipo_evento'] ?>">
        </div>
        <br>
        <div class="col-12 col-lg-6">
            <label>Descripción:</label>
            <textarea name="descripcion" class="form-control"><?= $evento['descripcion'] ?></textarea>
        </div>
        <br>

        <div class="col-12 col-lg-6">
            <label>Fecha Inicio:</label>
            <input type="datetime-local" name="fecha_inicio" class="form-control" value="<?= date('Y-m-d\TH:i', strtotime($evento['fecha_inicio'])) ?>">
        </div>
        <br>

        <div class="col-12 col-lg-6">
            <label>Fecha Fin:</label>
            <input type="datetime-local" name="fecha_fin" class="form-control" value="<?= date('Y-m-d\TH:i', strtotime($evento['fecha_fin'])) ?>">
        </div>
        <br>

        <div class="col-12 col-lg-6">
            <label>Hora Inicio:</label>
            <input type="time" name="hora_inicio" class="form-control" value="<?= $evento['hora_inicio'] ?>">
        </div>
        <br>

        <div class="col-12 col-lg-6">
            <label>Hora Fin:</label>
            <input type="time" name="hora_fin" class="form-control" value="<?= $evento['hora_fin'] ?>">
        </div>
        <br>

        <div class="col-12 col-lg-6">
            <label>Ubicación:</label>
            <input type="text" name="ubicacion" class="form-control" value="<?= $evento['ubicacion'] ?>">
        </div>
        <br>
        
        <?php if (!empty($respuesta)): ?>
            <div class="col-12 col-lg-6">
                <label for="fk_promotor">Promotor:</label>
                <select id="fk_promotor" class="form-control" name="fk_promotor" required>
                    <option value="">Selecciona un promotor</option>
                    <?php while ($fila = mysqli_fetch_array($respuesta)): ?>
                        <option value="<?= $fila['pk_promotor'] ?>" <?= ($fila['pk_promotor'] == ($evento['fk_promotor'] ?? '')) ? 'selected' : '' ?>>
                            <?= $fila['nombres'] . ' ' . $fila['ap_paterno'] . ' ' . $fila['ap_materno'] ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
        <?php endif; ?>

        <br>
        <br>

         <div class="row justify-content-center">
            <div class="col-auto">
                <input class="btn btn-primary" type="submit" value="Actualizar">
            </div>
            <div class="col-auto">
                <a href="eliminar_evento.php?id=<?= $evento['pk_c_eventos'] ?>" class="btn btn-danger" onclick="return confirm('¿Eliminar este evento?')">Eliminar</a>
                <a href="index.php" class="btn btn-secondary">Volver al calendario</a>
            </div>

        </div>
    </form>

