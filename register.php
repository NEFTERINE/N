<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, user-scalablre=no">
    <title>Perfumes</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/all.css">
    <link rel="stylesheet" href="css/estilos.css">
    <link rel="stylesheet" href="menu.php">
    <link rel="stylesheet" href="owl/owl.carousel.min.css">
    <link rel="stylesheet" href="owl/owl.theme.default.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">
    <title>Persefone Eternity | Registro</title>

</head>
<style>
.cuerpo{
	background-color: white;
	margin: 40px 100px;
	padding: 50px;
    border-radius: 5px;
}
.titulo{
    text-align: center;
    font-size: 30px;
    margin-bottom: 20px;
    color: black;
}
body{
    background-color: #f2f2f2;
}
.p{
    text-align: center;
    cursor: pointer;
    transition: color 0.3s ease; 
}
.p a{
    text-decoration: none;
}
</style>

<body>
<?php
    require_once('clases/Usuario.php');
    $usuario = new Usuario();
    $resultados = $usuario->mostrarTodo();
    ?>
    <br><br><br><br><br>
    <div class="cuerpo">
    <h2 class="titulo">Nuevo usuario</h2>
        <form class="col-10 offset-1" action="insertar_usuario.php" method="POST">
            <div class="row">
                <div class="col-12 col-lg-8">
                    <label>correo</label>
                    <input class="form-control" type="text" name="correo" required>
                </div>
            </div>  
            <div class="row">
                <div class="col-12 col-lg-8">
                    <label>Contraseña</label>
                    <input class="form-control" type="password" name="contraseña" required><br><br>
                </div>
            </div>
            <div class="d-grid gap-2 col-6 mx-auto">
                <input class="btn btn-primary" type="submit" value="Registrarse"><br><br>
            </div>
            <p class="p">¿Ya tienes una cuenta? <a href="login.php">Iniciar Sesión</a></p>
            </div>
        </form>
        
    </div>


   <footer>
        <div class="container">
            <div class="autor">
                <p>© 2025 Sistema Integral de Gestion de Compañia Electoral. | Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>
</main>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="owl/owl.carousel.min.js"></script>
<script>
$('.owl-carousel').owlCarousel({
loop:true,
nav:true,
dots:false,
responsiveClass:true,
responsive:{
0:{
    items: 1
},
600:{
    items: 2
},
1000:{
    items: 3
}
}
})
</script>
</body>

</html>
