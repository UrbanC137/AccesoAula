<?php
    session_start();

    // Verificar si el usuario ha iniciado sesión
    if(isset($_SESSION['usuario'])){
        $nombre_usuario = $_SESSION['nombre_completo'];  // Obtener el nombre completo del usuario
    }else{
        header("location: index.php");  // Redirigir al inicio si no está autenticado
        exit;
    }

    include 'php/conexion_be.php'; // Asegúrate de que la conexión esté bien configurada
?>

<?php
// Supongamos que esta es la cadena del nombre del usuario
$nombre_usuario = $_SESSION['nombre_completo'];

// Separamos el nombre en partes (palabras)
$nombre_partes = explode(" ", $nombre_usuario);

// Inicializamos una variable para almacenar las iniciales
$iniciales = "";

// Iteramos sobre las palabras y tomamos la primera letra de cada una
foreach ($nombre_partes as $parte) {
    // Concatenamos la primera letra de cada parte al resultado
    $iniciales .= strtoupper($parte[0]);
}
?>

<?php
// Obtener las categorías
$queryCategorias = "SELECT * FROM categorias";
$resultCategorias = mysqli_query($conexion, $queryCategorias);
// Obtener los temas de cada categoría
$queryTemas = "SELECT * FROM temas WHERE categoria_id = ?"; // Usaremos parámetros para evitar inyecciones SQL
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduPortal - Inicio</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            200: '#bae6fd',
                            300: '#7dd3fc',
                            400: '#38bdf8',
                            500: '#0ea5e9',
                            600: '#0284c7',
                            700: '#0369a1',
                            800: '#075985',
                            900: '#0c4a6e',
                        },
                        dark: {
                            800: '#1e293b',
                            900: '#0f172a',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        /* Scrollbar personalizada */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #1e293b;
        }
        ::-webkit-scrollbar-thumb {
            background: #475569;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #64748b;
        }

        /* Dropdown menu */
        .dropdown-menu {
            display: none;
            position: absolute;
            right: 0;
            top: 100%;
            background-color: white;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.1);
            z-index: 1;
            border-radius: 0.5rem;
            overflow: hidden;
        }

        .dark .dropdown-menu {
            background-color: #1e293b;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.3);
        }

        .dropdown:hover .dropdown-menu {
            display: block;
        }

        .dropdown-item {
            padding: 0.75rem 1rem;
            text-decoration: none;
            display: block;
            color: #4b5563;
            transition: background-color 0.2s;
        }

        .dark .dropdown-item {
            color: #e5e7eb;
        }

        .dropdown-item:hover {
            background-color: #f3f4f6;
        }

        .dark .dropdown-item:hover {
            background-color: #334155;
        }

        /* Transición suave para el modo oscuro */
        .transition-colors {
            transition-property: background-color, border-color, color, fill, stroke;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 150ms;
        }
        
        /* Efecto hover para imágenes */
        .img-hover-zoom {
            overflow: hidden;
            border-radius: 0.5rem;
        }
        
        .img-hover-zoom img {
            transition: transform 0.5s ease;
        }
        
        .img-hover-zoom:hover img {
            transform: scale(1.05);
        }
    </style>
</head>
<body class="bg-gray-100 dark:bg-dark-900 text-gray-800 dark:text-gray-200 transition-colors min-h-screen">
    <div class="flex flex-col md:flex-row min-h-screen">
        <!-- Menú lateral -->
        <aside class="w-full md:w-64 bg-white dark:bg-dark-800 shadow-lg md:h-screen md:sticky md:top-0 z-10">
            <div class="p-4 border-b border-gray-200 dark:border-gray-700">
                <h1 class="text-xl font-bold text-primary-600 dark:text-primary-400 flex items-center">
                    <i class="fas fa-graduation-cap mr-2"></i> EduPortal
                </h1>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Aprendizaje interactivo</p>
            </div>
            
            <!-- Sección de usuario -->
            <div class="p-4 border-b border-gray-200 dark:border-gray-700">
                <div class="dropdown relative">
                    <button class="flex items-center space-x-3 w-full focus:outline-none">
                        <div class="h-10 w-10 rounded-full bg-primary-500 flex items-center justify-center text-white">
                            <span><?php echo $iniciales?></span>
                        </div>
                        <div class="text-left">
                            <h1><?php echo $nombre_usuario; ?></h1>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Estudiante</p>
                        </div>
                        <i class="fas fa-chevron-down text-xs ml-auto"></i>
                    </button>
                    <div class="dropdown-menu">
                        <a href="php/cerrar_sesion.php">cerrar sesión</a>
                    </div>
                </div>
            </div>
            
            <!-- Barra de búsqueda -->
            <div class="p-4">
                <div class="relative">
                    <input type="text" placeholder="Buscar módulos..." class="w-full bg-gray-100 dark:bg-gray-700 rounded-lg px-4 py-2 pl-10 focus:outline-none focus:ring-2 focus:ring-primary-500">
                    <i class="fas fa-search absolute left-3 top-2.5 text-gray-400"></i>
                </div>
            </div>
            
            <!-- Menú de navegación -->
            <nav class="overflow-y-auto h-[calc(100vh-260px)]">
                <!-- Menú de categorías -->
                <div class="px-4 py-2">
                    <ul>
                        <?php
                        // Mostrar las categorías (Biología, Química, Física)
                        while ($categoria = mysqli_fetch_assoc($resultCategorias)) {
                            echo '<li class="mb-1">
                                    <h3 class="text-xs uppercase font-semibold text-gray-500 dark:text-gray-400 mb-2">' . $categoria['nombre'] . '</h3>
                                </li>';

                            // Mostrar los temas para cada categoría
                            $stmt = mysqli_prepare($conexion, $queryTemas);
                            mysqli_stmt_bind_param($stmt, "i", $categoria['id']);
                            mysqli_stmt_execute($stmt);
                            $resultTemas = mysqli_stmt_get_result($stmt);

                            while ($tema = mysqli_fetch_assoc($resultTemas)) {
                                // Crear el enlace para "La Célula"
                                if ($tema['nombre'] == 'La Célula') {
                                    $url = 'lacelula.php';  // Redirige a lacelula.php para el tema "La Célula"
                                } else {
                                    $url = strtolower(str_replace(' ', '_', $tema['nombre'])) . '.php'; // Redirige a la página del tema correspondiente
                                }
            
                                // Mostrar el tema con el enlace correspondiente
                                echo '<li class="mb-1">
                                        <a href="' . $url . '" class="flex items-center px-3 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                                            <i class="fas fa-book mr-2"></i> ' . $tema['nombre'] . '
                                        </a>
                                    </li>';
                            }
                        }
                        ?>
                    </ul>
                </div>
            </nav>
        </aside>
        
        <!-- Contenido principal -->
        <main class="flex-1 p-4 md:p-6">
            <div class="max-w-6xl mx-auto">
                <!-- Hero Section -->
                <div class="bg-white dark:bg-dark-800 rounded-xl shadow-lg p-6 mb-6 overflow-hidden">
                    <div class="flex flex-col md:flex-row items-center">
                        <div class="md:w-1/2 mb-6 md:mb-0 md:pr-8">
                            <h1 class="text-3xl md:text-4xl font-bold mb-4 text-primary-600 dark:text-primary-400">Bienvenido a EduPortal</h1>
                            <p class="text-lg text-gray-600 dark:text-gray-300 mb-6">
                                Tu plataforma de aprendizaje interactivo donde podrás explorar, descubrir y dominar nuevos conocimientos a través de recursos educativos innovadores.
                            </p>
                            <div class="flex space-x-4">
                                <button class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-2 rounded-lg font-medium transition-colors">
                                    Explorar cursos
                                </button>
                                <button class="border border-primary-600 text-primary-600 dark:text-primary-400 hover:bg-primary-50 dark:hover:bg-gray-700 px-6 py-2 rounded-lg font-medium transition-colors">
                                    Conoce más
                                </button>
                            </div>
                        </div>
                        <div class="md:w-1/2 img-hover-zoom">
                            <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1471&q=80" 
                                 alt="Estudiantes aprendiendo" 
                                 class="w-full rounded-lg shadow-md">
                        </div>
                    </div>
                </div>
                
                <!-- Qué ofrecemos -->
                <div class="bg-white dark:bg-dark-800 rounded-xl shadow-lg p-6 mb-6">
                    <h2 class="text-2xl font-bold mb-6 text-center">¿Qué ofrece EduPortal?</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="flex">
                            <div class="bg-primary-100 dark:bg-gray-700 p-3 rounded-full h-12 w-12 flex items-center justify-center mr-4 flex-shrink-0">
                                <i class="fas fa-book-open text-primary-600 dark:text-primary-400 text-xl"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-lg mb-2">Contenido educativo de calidad</h3>
                                <p class="text-gray-600 dark:text-gray-300">
                                    Accede a materiales didácticos cuidadosamente seleccionados y organizados por expertos en cada área del conocimiento.
                                </p>
                            </div>
                        </div>
                        
                        <div class="flex">
                            <div class="bg-indigo-100 dark:bg-gray-700 p-3 rounded-full h-12 w-12 flex items-center justify-center mr-4 flex-shrink-0">
                                <i class="fas fa-laptop-code text-indigo-600 dark:text-indigo-400 text-xl"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-lg mb-2">Aprendizaje interactivo</h3>
                                <p class="text-gray-600 dark:text-gray-300">
                                    Experimenta con simulaciones, cuestionarios interactivos y actividades prácticas que refuerzan tu comprensión.
                                </p>
                            </div>
                        </div>
                        
                        <div class="flex">
                            <div class="bg-green-100 dark:bg-gray-700 p-3 rounded-full h-12 w-12 flex items-center justify-center mr-4 flex-shrink-0">
                                <i class="fas fa-chalkboard-teacher text-green-600 dark:text-green-400 text-xl"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-lg mb-2">Enfoque pedagógico</h3>
                                <p class="text-gray-600 dark:text-gray-300">
                                    Metodologías basadas en las últimas investigaciones educativas para maximizar tu retención y comprensión.
                                </p>
                            </div>
                        </div>
                        
                        <div class="flex">
                            <div class="bg-yellow-100 dark:bg-gray-700 p-3 rounded-full h-12 w-12 flex items-center justify-center mr-4 flex-shrink-0">
                                <i class="fas fa-user-friends text-yellow-600 dark:text-yellow-400 text-xl"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-lg mb-2">Comunidad de aprendizaje</h3>
                                <p class="text-gray-600 dark:text-gray-300">
                                    Conéctate con otros estudiantes, comparte dudas y colabora en proyectos educativos.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Galería de imágenes -->
                <div class="bg-white dark:bg-dark-800 rounded-xl shadow-lg p-6 mb-6">
                    <h2 class="text-2xl font-bold mb-6 text-center">Explora nuestro mundo educativo</h2>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        <div class="img-hover-zoom">
                            <img src="https://images.unsplash.com/photo-1434030216411-0b793f4b4173?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" 
                                 alt="Laboratorio de ciencias" 
                                 class="w-full h-48 object-cover rounded-lg shadow">
                        </div>
                        <div class="img-hover-zoom">
                            <img src="https://images.unsplash.com/photo-1546410531-bb4caa6b424d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1471&q=80" 
                                 alt="Libros y materiales" 
                                 class="w-full h-48 object-cover rounded-lg shadow">
                        </div>
                        <div class="img-hover-zoom">
                            <img src="https://images.unsplash.com/photo-1523240795612-9a054b0db644?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" 
                                 alt="Estudiante usando computadora" 
                                 class="w-full h-48 object-cover rounded-lg shadow">
                        </div>
                    </div>
                </div>
                
                <!-- CTA Final -->
                <div class="bg-gradient-to-r from-primary-500 to-primary-700 rounded-xl shadow-lg p-8 text-center text-white">
                    <h2 class="text-2xl font-bold mb-4">¿Listo para comenzar tu viaje de aprendizaje?</h2>
                    <p class="mb-6 max-w-2xl mx-auto">
                        EduPortal está diseñado para acompañarte en cada paso de tu formación. Descubre cómo podemos ayudarte a alcanzar tus metas educativas.
                    </p>
                    <button class="bg-white text-primary-600 hover:bg-gray-100 px-8 py-3 rounded-lg font-medium text-lg transition-colors">
                        Empieza ahora
                    </button>
                </div>
            </div>
        </main>
    </div>

    <script>
        // Efecto hover para las tarjetas de módulos
        document.querySelectorAll('nav a').forEach(link => {
            link.addEventListener('mouseenter', function() {
                this.classList.add('bg-gray-50', 'dark:bg-gray-700');
            });
            
            link.addEventListener('mouseleave', function() {
                if(!this.classList.contains('bg-primary-100')) {
                    this.classList.remove('bg-gray-50', 'dark:bg-gray-700');
                }
            });
        });
    </script>
</body>
</html>