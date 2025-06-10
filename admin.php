<?php require_once("menu.php") ?>

<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="css/estilos.css">
<link rel="stylesheet" href="css/all.css">
<link rel="stylesheet" href="css/bootstrap.css">
<link rel="stylesheet" href="owl/owl.carousel.min.css">
<link rel="stylesheet" href="owl/owl.theme.default.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">
<title>Persefone Eternity | Administración</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<style>
.titulo{
    text-align: center;
    font-size: 30px;
    margin-bottom: 20px;
    color: black;
}
th{
    background-color: #333333;
    color: black;
    font-size: 16px;
    padding: 8px;
}
td{
    font-size: 16px;
    padding: 8px;
}
.a{
    margin-right: 10px;
    /* transition: color 0.3s; */
    text-decoration: none;
    color: blue;
    font-size: 16px;
}
.a:hover {
    background-color: #dddddd;
    border-radius: 5px;
    padding: 7px 8px;
} 
            header {
            /* background-color: #343a40; */
            background: none;
        }
</style>
<body><br><br><br><br><br><br><br>
<div class="container">
    <div class="col-8 offset-2">
        <h2 class="titulo">Administración</h2>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>  </th>
                    <th>Listas</th>
                    <th>Nuevos</th>
                </tr>
            </thead>
            <tbody>
            <?php
                        if (isset($_SESSION['pk_usuario'])) {
                            if (isset($_SESSION['type']) && in_array($_SESSION['type'], [2, 3])) {
                                 echo   '<tr>
                        <td>lideres</td>
                        <td><a class="a" href="lista_lideres.php">Lista de lideres</a></td>
                        <td><a class="a" href="formulario_datos.php">Agregar un nuevo lider</a></td>
                    </tr>
                    <tr>
                        <td>coordinación</td>
                        <td><a class="a" href="lista_coordinadores.php">Lista de coordinadores</a></td>
                        <td><a class="a" href="formulario_coordinador.php">Agregar un nuevo coordinador</a></td>
                    </tr>
                    <tr>
                        <td>promotores</td>
                        <td><a class="a" href="lista_promotor.php">Lista de promotores</a></td>
                        <td><a class="a" href="formulario_promotor.php">Agregar uno nuevo promotor</a></td>
                    </tr>
                    <tr>
                        <td>promovidos</td>
                        <td><a class="a" href="lista_persona.php">Lista de promovidos</a></td>
                        <td><a class="a" href="formulario_cliente.php"></a></td>
                    </tr>
                    <tr>
                        <td>Usuarios</td>
                        <td><a class="a" href="lista_usuarios.php">Lista de Usuarios</a></td>
                        <td><a class="a" href="formulario_persona.php">Agregar Nuevo Usuario</a></td>
                    </tr>';
                        }
                        else if (isset($_SESSION['type']) && $_SESSION['type'] == 4) {
                            echo    '<tr>
                            <td>casillas</td>
                            <td><a class="a" href="lista_casilla.php">Lista de representantes de casilla</a></td>
                            <td><a class="a" href="lista_entregados.php"></a></td>
                        </tr>';
                        }
                        else if (isset($_SESSION['type']) && $_SESSION['type'] == 5){
                         echo  ' <tr>
                            <td>promotores</td>
                            <td><a class="a" href="lista_promotor.php">Lista de promotores</a></td>
                            <td><a class="a" href="formulario_categoria.php"></a></td>
                        </tr>
                        <tr>
                            <td>promovidos</td>
                            <td><a class="a" href="lista_persona.php">Lista de promovidos</a></td>
                            <td><a class="a" href="formulario_promovido.php">Agregar promovido</a></td>
                        </tr>';
                        }
                    }
                    ?>
            </tbody>
                
        </table>
    </div>
</div>
</body>
</html>