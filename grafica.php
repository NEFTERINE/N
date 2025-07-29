<?php
session_start();
require_once('menu.php'); // Asegúrate de incluir el menú
// ... tus includes y session_start() ...
require_once('clases/Promotor.php'); // Asegúrate de incluir la clase Promotor

$promotor_obj = new Promotor();
$datos_promovidos_para_grafica = $promotor_obj->cPPromotor();

// Prepara los datos para JavaScript
$labels_promovidos = [];
$data_promovidos = [];
foreach ($datos_promovidos_para_grafica as $item) {
    $labels_promovidos[] = $item['promotor_nombre_completo'];
    $data_promovidos[] = $item['cantidad'];
}
// ... el resto de tu código HTML y PHP ...
?>

<head>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>
<style>
  .grafica-pequeña {
    max-width: 1200px;
    height: auto;
    margin: auto;
  }
  button {
    margin: 20px;
  }
  
</style>

<button class="btn btn-primary" onclick="window.location.href='index.php';">Volver</button>
<div class="grafica-pequeña">
  <canvas id="promovidosChart"></canvas>
</div>
<script>
    // Usa los datos preparados por PHP
    const labelsPromovidos = <?php echo json_encode($labels_promovidos); ?>;
    const dataPromovidos = <?php echo json_encode($data_promovidos); ?>;

    const ctxPromovidos = document.getElementById('promovidosChart').getContext('2d');
    new Chart(ctxPromovidos, {
        type: 'bar',
        data: {
            labels: labelsPromovidos,
            datasets: [{
                label: 'Cantidad de Promovidos por Promotor', // Nuevo label para la leyenda
                data: dataPromovidos,
                backgroundColor: 'rgba(75, 192, 192, 0.5)', // Color diferente
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Número de Promovidos'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Nombre del Promotor'
                    }
                }
            },
            plugins: {
                title: {
                    display: true,
                    text: 'Total de Promovidos Asignados por Cada Promotor' // Título de la gráfica
                }
            }
        }
    });
</script>