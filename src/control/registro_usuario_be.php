<?php
include '../modelo/conexion_be.php';

$nombre_completo = $_POST['nombre_completo'] ?? null;
$correo = $_POST['correo'] ?? null;
$usuario = $_POST['usuario'] ?? null;
$contrasena = $_POST['contrasena'] ?? null;

if (!$nombre_completo || !$correo || !$usuario || !$contrasena) {
    echo '
        <script>
            alert("Por favor, complete todos los campos.");
            window.location = "../vista/index.php";
        </script>
    ';
    exit;
}

// Sanitizar inputs para seguridad
$nombre_completo = mysqli_real_escape_string($conexion, $nombre_completo);
$correo = mysqli_real_escape_string($conexion, $correo);
$usuario = mysqli_real_escape_string($conexion, $usuario);
$contrasena = mysqli_real_escape_string($conexion, $contrasena);

$query = "INSERT INTO usuarios(nombre_completo, correo, usuario, contrasena)
          VALUES('$nombre_completo', '$correo', '$usuario', '$contrasena')";

$ejecutar = mysqli_query($conexion, $query);

if($ejecutar){
    echo '
        <script>
            alert("Usuario almacenado exitosamente");
            window.location = "../vista/index.php";
        </script>
    ';
} else {
    echo '
        <script>
            alert("Error al almacenar usuario.");
            window.location = "../vista/index.php";
        </script>
    ';
}

?>