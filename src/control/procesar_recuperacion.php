<?php
include '../modelo/conexion_be.php';

$correo = $_POST['correo'] ?? null;

if (!$correo) {
    echo '<script>
        alert("Por favor, ingrese un correo.");
        window.location = "../vista/recuperar_contrasena.php";
    </script>';
    exit;
}

$correo = mysqli_real_escape_string($conexion, $correo);

$buscar = mysqli_query($conexion, "SELECT * FROM usuarios WHERE correo='$correo'");

if (mysqli_num_rows($buscar) > 0) {
    // Simulación de envío de correo
    echo '<script>
        alert("Hemos enviado instrucciones de recuperación a tu correo (simulado).");
        window.location = "../vista/index.php";
    </script>';
} else {
    echo '<script>
        alert("El correo no está registrado.");
        window.location = "../vista/recuperar_contrasena.php";
    </script>';
}
?>
