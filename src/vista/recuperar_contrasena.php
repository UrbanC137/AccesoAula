<?php
session_start();
if (isset($_SESSION['usuario'])) {
    header("location: bienvenida.php");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contraseña</title>

    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/estilos.css">
</head>
<body>

    <main>
        <div class="contenedor__todo">
            <div class="caja__trasera">
                <div class="caja__trasera-login">
                    <h3>¿Recordaste tu contraseña?</h3>
                    <p>Inicia sesión aquí</p>
                    <a href="index.php"><button>Iniciar Sesión</button></a>
                </div>
                <div class="caja__trasera-register">
                    <h3>¿No tienes cuenta aún?</h3>
                    <p>Regístrate para acceder</p>
                    <a href="index.php"><button>Regístrarse</button></a>
                </div>
            </div>

            <div class="contenedor__login-register">
                <form action="../control/procesar_recuperacion.php" method="POST" class="formulario__login">
                    <h2>Recuperar Contraseña</h2>
                    <input type="email" name="correo" placeholder="Correo electrónico registrado" required>
                    <button type="submit">Enviar enlace</button>
                    <a href="index.php" class="recuperar">Volver al inicio</a>
                </form>
            </div>
        </div>
    </main>

</body>
</html>
