<?php
	session_start();
	include 'conexion_be.php';

	$correo = $_POST['correo'];
	$contrasena = $_POST['contrasena'];

	// Verificar si el correo y la contraseña existen en la base de datos
	$validar_login = mysqli_query($conexion, "SELECT * FROM usuarios WHERE correo='$correo' AND contrasena='$contrasena'");

	if(mysqli_num_rows($validar_login) > 0){
		// Obtener los datos del usuario
		$usuario = mysqli_fetch_assoc($validar_login);
		$_SESSION['usuario'] = $correo;  // Almacenar el correo en la sesión
		$_SESSION['nombre_completo'] = $usuario['nombre_completo'];  // Almacenar el nombre completo en la sesión
		header("location: ../bienvenida.php");  // Redirigir a la página de bienvenida
		exit;
	}else{
		echo '
		<script>
			alert("Usuario no existe, por favor verifique los datos introducidos");
			window.location = "../index.php";
		</script>
		';
		exit;
	}
?>