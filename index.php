<?php
session_start(); // Asegúrate de iniciar la sesión al principio
require_once('menu.php'); // Tu menú superior
// Puedes incluir otras clases si necesitas cargar datos específicos para el index
// require_once('clases/Noticia.php');
// $noticia = new Noticia();
// $ultimas_noticias = $noticia->obtenerUltimas(3); // Ejemplo de obtener 3 noticias
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Persefone Eternity | Inicio</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/estilos.css">
    <link rel="stylesheet" href="css/all.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* Estilos específicos para esta página */
        body {
            padding-top: 70px; /* Espacio para el menú fijo */
            background-color: #f8f9fa; /* Fondo claro */
        }
        .hero-section {
            background-color: #007bff; /* Color primario de Bootstrap */
            color: white;
            padding: 100px 0;
            text-align: center;
            margin-bottom: 40px;
        }
        .hero-section h1 {
            font-size: 3.5rem;
            margin-bottom: 20px;
        }
        .hero-section p {
            font-size: 1.25rem;
            margin-bottom: 30px;
        }
        .features-section, .about-section, .cta-section {
            padding: 60px 0;
            text-align: center;
            margin-bottom: 40px;
        }
        .features-section .card {
            border: none;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }
        .features-section .card:hover {
            transform: translateY(-5px);
        }
        .features-section .card-body i {
            font-size: 3rem;
            margin-bottom: 20px;
            color: #007bff;
        }
        .admin-link {
            display: inline-block;
            margin-top: 20px;
        }
        /* Ajustes para el footer si es necesario */
        footer {
            background-color: #343a40; /* Darker footer */
            color: white;
            padding: 30px 0;
            text-align: center;
        }
        footer .redes a {
            color: white;
            margin: 0 10px;
            font-size: 1.5rem;
        }
        footer .autor p {
            margin-top: 15px;
            margin-bottom: 0;
        }
    </style>
</head>
<body>

    <div class="container-fluid hero-section">
        <div class="container">
            <?php if (isset($_SESSION['pk_usuario'])): ?>
                <h1>¡Bienvenido de nuevo, <?= htmlspecialchars($datos_usuario['nombres'] ?? 'Usuario') ?>!</h1>
                <p>Estamos listos para hacer la diferencia.</p>
                <?php
                // Redirecciona al panel de administración si tienen los permisos
                if (isset($_SESSION['type']) && in_array($_SESSION['type'], [2, 3, 4, 5])) {
                    echo '<a href="admin.php" class="btn btn-light btn-lg mt-3">Ir a la Administración</a>';
                } else {
                    echo '<a href="perfil.php" class="btn btn-light btn-lg mt-3">Ver mi Perfil</a>';
                }
                ?>
            <?php else: ?>
                <h1>Potencia tu Gestión Política y Social</h1>
                <p>Conecta, organiza y moviliza a tus equipos de líderes y promotores de manera eficiente.</p>
                <a href="registro.php" class="btn btn-light btn-lg me-3">Regístrate Gratis</a>
                <a href="login.php" class="btn btn-outline-light btn-lg">Iniciar Sesión</a>
            <?php endif; ?>
        </div>
    </div>

    <div class="container features-section">
        <h2 class="mb-5">Características Clave de Nuestra Plataforma</h2>
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body" onclick="window.location.href=''" style="cursor: pointer;">
                        <i class="fas fa-users"></i>
                        <h4 class="card-title">Gestión de Equipos</h4>
                        <p class="card-text">Organiza y supervisa fácilmente a tus líderes, coordinadores y promotores.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body" onclick="window.location.href='grafica.php';" style="cursor: pointer;">
                        <i class="fas fa-chart-line"></i>
                        <h4 class="card-title">Seguimiento de Avances</h4>
                        <p class="card-text">Monitorea el progreso de tus campañas y el registro de ciudadanos en tiempo real.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body" onclick="window.location.href='calendario_grafica.php';" style="cursor: pointer;">
                        <i class="fas fa-file-alt"></i>
                        <h4 class="card-title">Desarrollo de Eventos</h4>
                        <p class="card-text">Visualiza y crea eventos para tu campaña.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php /*
    <div class="container about-section">
        <h2 class="mb-5">Últimas Noticias</h2>
        <div class="row">
            <?php if (!empty($ultimas_noticias)): ?>
                <?php foreach ($ultimas_noticias as $noticia_item): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($noticia_item['titulo']) ?></h5>
                                <p class="card-text"><small class="text-muted"><?= htmlspecialchars($noticia_item['fecha']) ?></small></p>
                                <p class="card-text"><?= htmlspecialchars(substr($noticia_item['contenido'], 0, 100)) ?>...</p>
                                <a href="noticia_detalle.php?id=<?= $noticia_item['pk_noticia'] ?>" class="btn btn-sm btn-outline-primary">Leer más</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <p>No hay noticias recientes para mostrar.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
    */ ?>

    <div class="container cta-section bg-light py-5">
        <h2 class="mb-4">¿Listo para transformar tu organización?</h2>
        <p class="lead mb-4">Únete a nuestra plataforma y lleva tu gestión al siguiente nivel.</p>
        <?php if (!isset($_SESSION['pk_usuario'])): ?>
            <a href="registro.php" class="btn btn-primary btn-lg me-3">Regístrate Ahora</a>
            <a href="contacto.php" class="btn btn-secondary btn-lg">Contáctanos</a>
        <?php else: ?>
            <p>Ya estás dentro. Explora las opciones disponibles.</p>
        <?php endif; ?>
    </div>

    <footer>
        <div class="container">
            <div class="autor">
                <p>© 2025 Sistema Integral DE Gestion de Compañia Electoral. | Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="owl/owl.carousel.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> <script>
    // Tu script de Owl Carousel si lo usas
    $('.owl-carousel').owlCarousel({
        loop: true,
        nav: true,
        dots: false,
        responsiveClass: true,
        responsive: {
            0: { items: 1 },
            600: { items: 2 },
            1000: { items: 3 }
        }
    });
    </script>
</body>
</html>