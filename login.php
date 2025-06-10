<!DOCTYPE html>
<link rel="stylesheet" href="css/bootstrap.css">
<link rel="stylesheet" href="css/estilos.css?t=2">
<link rel="stylesheet" href="css/all.css">
<link rel="stylesheet" href="owl/owl.carousel.min.css">
<link rel="stylesheet" href="owl/owl.theme.default.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<meta charset="utf-8">
<title>Persefone Eternity | Login</title>
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
<html>
    <head>
        <title></title>
    </head>
    <body>
        
        <div class="cuerpo">
        <h2 class= "titulo">Iniciar Sesión</h2><br>
        <form class="col-10 offset-1" action="validar.php" method="POST">
            
            <label for="">correo:</label><br>
            <input class="form-control" type="text" name="correo" required><br>

            <label for="">Contraseña:</label><br>
            <input class="form-control" type="password" name="contraseña" required><br>

            <br>
            <br>    
            <div class="d-grid gap-2 col-6 mx-auto">
                <input class="btn btn-primary" type="submit" value="Iniciar Sesión"><br><br>
            </div>
            <p class="p">¿No tienes una cuenta? <a href="register.php">Registrate</a></p>
        </form>
        </div>
    </body>

</html>