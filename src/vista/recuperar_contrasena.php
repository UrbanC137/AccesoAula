<?php
// Conexión a la base de datos
include '../modelo/conexion_be.php'; // Asegúrate de que la conexión esté configurada correctamente

// Verificar si se recibió el formulario por POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir los datos del formulario
    $correo = mysqli_real_escape_string($conexion, $_POST['correo']);
    $nueva_contrasena = mysqli_real_escape_string($conexion, $_POST['nueva_contrasena']);
    $confirmar_contrasena = mysqli_real_escape_string($conexion, $_POST['confirmar_contrasena']);

    // Verificar que las contraseñas coinciden
    if ($nueva_contrasena != $confirmar_contrasena) {
        echo '<script>alert("Las contraseñas no coinciden. Por favor, intente de nuevo."); window.history.back();</script>';
        exit;
    }

    // Actualizar la contraseña en la base de datos
    $query = "UPDATE usuarios SET contrasena = '$nueva_contrasena' WHERE correo = '$correo'";
    $resultado = mysqli_query($conexion, $query);

    if ($resultado) {
        echo '<script>alert("Contraseña restablecida con éxito. Ahora puedes iniciar sesión con tu nueva contraseña."); window.location.href = "index.php";</script>';
    } else {
        echo '<script>alert("Hubo un problema al restablecer la contraseña. Intenta de nuevo."); window.history.back();</script>';
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contraseña | Seguridad</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .password-strength {
            height: 4px;
            transition: all 0.3s ease;
        }
        
        .toggle-password {
            cursor: pointer;
            transition: all 0.2s ease;
        }
        
        .toggle-password:hover {
            transform: scale(1.1);
        }
        
        .form-container {
            box-shadow: 0 10px 30px -5px rgba(0, 0, 0, 0.1);
            animation: fadeIn 0.5s ease-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .input-field:focus + .input-label, 
        .input-field:not(:placeholder-shown) + .input-label {
            transform: translateY(-18px) scale(0.9);
            background-color: white;
            padding: 0 4px;
            color: #4f46e5;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-50 min-h-screen flex items-center justify-center p-4">
    <div class="form-container bg-white rounded-xl p-8 w-full max-w-md">
        <div class="text-center mb-8">
            <div class="mx-auto mb-4 flex justify-center">
            </div>
            <h1 class="text-2xl font-bold text-gray-800">Recuperar contraseña</h1>
            <p class="text-gray-600 mt-2">Ingresa tu correo y establece una nueva contraseña segura</p>
        </div>
        
        <form id="passwordResetForm" action="recuperar_contrasena.php" method="POST" class="space-y-6">
            <!-- Email Field -->
            <div class="relative">
                <input type="email" id="email" name="correo" class="input-field w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition duration-200" placeholder=" " required autofocus>
                <label for="email" class="input-label absolute left-4 top-3.5 text-gray-500 pointer-events-none transition-all duration-200">Correo electrónico</label>
                <div class="absolute right-3 top-3.5 text-gray-400">
                    <i class="fas fa-envelope"></i>
                </div>
            </div>
            
            <!-- New Password Field -->
            <div class="relative">
                <input type="password" id="newPassword" name="nueva_contrasena" class="input-field w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition duration-200" placeholder=" " required minlength="8">
                <label for="newPassword" class="input-label absolute left-4 top-3.5 text-gray-500 pointer-events-none transition-all duration-200">Nueva contraseña</label>
                <div id="toggleNewPassword" class="absolute right-3 top-3.5 text-gray-400 toggle-password">
                    <i class="far fa-eye"></i>
                </div>
            </div>
            
            <!-- Confirm Password Field -->
            <div class="relative">
                <input type="password" id="confirmPassword" name="confirmar_contrasena" class="input-field w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition duration-200" placeholder=" " required>
                <label for="confirmPassword" class="input-label absolute left-4 top-3.5 text-gray-500 pointer-events-none transition-all duration-200">Confirmar contraseña</label>
            </div>
            
            <!-- Submit Button -->
            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-3 px-4 rounded-lg transition duration-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transform hover:scale-105 active:scale-95" id="submitBtn">
                Restablecer contraseña
            </button>
        </form>
        
        <div class="mt-6 text-center text-sm">
            <a href="index.php" class="font-medium text-indigo-600 hover:text-indigo-500">Volver al inicio de sesión</a>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle password visibility
            const toggleNewPassword = document.getElementById('toggleNewPassword');
            const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
            const newPassword = document.getElementById('newPassword');
            const confirmPassword = document.getElementById('confirmPassword');
            
            toggleNewPassword.addEventListener('click', function() {
                const type = newPassword.getAttribute('type') === 'password' ? 'text' : 'password';
                newPassword.setAttribute('type', type);
                this.querySelector('i').classList.toggle('fa-eye');
                this.querySelector('i').classList.toggle('fa-eye-slash');
            });
            
            toggleConfirmPassword.addEventListener('click', function() {
                const type = confirmPassword.getAttribute('type') === 'password' ? 'text' : 'password';
                confirmPassword.setAttribute('type', type);
                this.querySelector('i').classList.toggle('fa-eye');
                this.querySelector('i').classList.toggle('fa-eye-slash');
            });
            
            // Check password match
            confirmPassword.addEventListener('input', checkPasswordMatch);
            
            function checkPasswordMatch() {
                const newPassValue = newPassword.value;
                const confirmPassValue = confirmPassword.value;
                
                if (confirmPassValue && newPassValue !== confirmPassValue) {
                    alert('Las contraseñas no coinciden');
                }
            }
            
            // Form submission
            const form = document.getElementById('passwordResetForm');
            const submitBtn = document.getElementById('submitBtn');
            
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Validate form
                const email = document.getElementById('email').value;
                const newPassValue = newPassword.value;
                const confirmPassValue = confirmPassword.value;
                
                if (!email) {
                    alert('Por favor ingresa tu correo electrónico');
                    return;
                }
                
                if (newPassValue.length < 8) {
                    alert('La contraseña debe tener al menos 8 caracteres');
                    return;
                }
                
                if (newPassValue !== confirmPassValue) {
                    alert('Las contraseñas no coinciden');
                    return;
                }
                
                // Simulate form submission
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Procesando...';
                
                // In a real app, you would send this to your backend
                setTimeout(() => {
                    alert('Contraseña restablecida con éxito. Ahora puedes iniciar sesión con tu nueva contraseña.');
                    submitBtn.disabled = false;
                    submitBtn.textContent = 'Restablecer contraseña';
                    form.reset();
                    
                    // Reset all indicators
                    document.getElementById('strengthBar').style.width = '0%';
                    document.getElementById('strengthText').textContent = 'Seguridad de la contraseña';
                    document.getElementById('strengthPercent').textContent = '0%';
                    document.getElementById('passwordMatch').classList.add('hidden');
                    document.getElementById('passwordMismatch').classList.add('hidden');
                    
                    // Reset requirements
                    document.getElementById('reqLength').innerHTML = '<span class="text-gray-600">Mínimo 8 caracteres</span>';
                    document.getElementById('reqUpper').innerHTML = '<span class="text-gray-600">Al menos una letra mayúscula</span>';
                    document.getElementById('reqNumber').innerHTML = '<span class="text-gray-600">Al menos un número</span>';
                    document.getElementById('reqSpecial').innerHTML = '<span class="text-gray-600">Al menos un carácter especial</span>';
                }, 1500);
            });
        });
    </script>
</body>
</html>