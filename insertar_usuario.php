<?php
include('clases/Usuario.php');
session_start();

$usuario=new Usuario();

$correo=$_POST['correo'];
$contraseña=$_POST['contraseña'];

$pk_usuario=$usuario->insertar($correo,$contraseña);

if($pk_usuario){
    $_SESSION['pk_usuario']=$pk_usuario;
    $_SESSION['correo']=$correo;
    $_SESSION['contraseña']=$contraseña;

    echo "<script>
        alert('GUARDADO');
        location.href= 'index.php'
        </script>";
}else{
    echo "<script>
        alert('ERROR');
        location.href= 'register.php'
        </script>";
}

 ?>