<?php
    session_start();

    // Verificar si el usuario ha iniciado sesión
    if(isset($_SESSION['usuario'])){
        $nombre_usuario = $_SESSION['nombre_completo'];  // Obtener el nombre completo del usuario
    }else{
        header("location: ../vista/index.php");  // Redirigir al inicio si no está autenticado
        exit;
    }

    include '../modelo/conexion_be.php'; // Asegúrate de que la conexión esté bien configurada
?>

<?php
// Consulta para obtener el video
$query = "SELECT * FROM videos WHERE id = 1";  // Aquí '1' es el id del video que quieres mostrar
$result = mysqli_query($conexion, $query);

// Verifica si la consulta tuvo éxito
if (mysqli_num_rows($result) > 0) {
    $video = mysqli_fetch_assoc($result); // Obtener los datos del video
    $url = $video['url']; // Asumiendo que 'video_url' es el nombre de la columna
} else {
    echo "No se encontró el video.";
}
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
    <title>Portal Educativo - Aprendizaje Interactivo</title>
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
        <script>
        const iniciales = "<?php echo $iniciales; ?>";
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

/* Animaciones */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

.animate-fadeIn {
    animation: fadeIn 0.3s ease-out forwards;
}

/* Transición suave para el modo oscuro */
.transition-colors {
    transition-property: background-color, border-color, color, fill, stroke;
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    transition-duration: 150ms;
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

/* Transición para el texto transcrito */
.transcription-container {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.5s ease-out;
}

.transcription-container.show {
    max-height: 1000px;
}

/* Estilos para el sistema de estrellas */
.star-rating {
    display: inline-flex;
    flex-direction: row-reverse;
}

.star-rating input {
    display: none;
}

.star-rating label {
    color: #d1d5db;
    font-size: 1.5rem;
    padding: 0 0.1rem;
    cursor: pointer;
    transition: color 0.2s;
}

.star-rating input:checked ~ label,
.star-rating input:hover ~ label,
.star-rating label:hover,
.star-rating label:hover ~ label {
    color: #f59e0b;
}

.star-rating input:checked + label {
    color: #f59e0b;
}

.star-rating-sm label {
    font-size: 1rem;
}

.rating-average {
    font-size: 0.9rem;
    color: #6b7280;
    margin-left: 0.5rem;
}

.dark .rating-average {
    color: #9ca3af;
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

    <!-- Sección de usuario en sidebar (solo visible en desktop) -->
    <div class="p-4 border-b border-gray-200 dark:border-gray-700 hidden md:block">
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
                <a href="../control/cerrar_sesion.php">cerrar sesión</a>
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
                                    $urlt = 'lacelula.php';  // Redirige a lacelula.php para el tema "La Célula"
                                } else {
                                    $urlt = strtolower(str_replace(' ', '_', $tema['nombre'])) . '.php'; // Redirige a la página del tema correspondiente
                                }
            
                                // Mostrar el tema con el enlace correspondiente
                                echo '<li class="mb-1">
                                        <a href="' . $urlt . '" class="flex items-center px-3 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
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

<!-- Contenido La Célula -->
<main id="celulaContent" class="flex-1 p-4 md:p-6">
    <div class="max-w-6xl mx-auto">
        <!-- Ruta de navegación -->
        <div class="flex items-center text-sm mb-6">
            <a href="bienvenida.php" class="text-primary-600 dark:text-primary-400 hover:underline">Inicio</a>
            <span class="mx-2 text-gray-400">/</span>
            <span class="text-gray-500 dark:text-gray-400">La Célula</span>
        </div>
        
        <!-- Título y descripción -->
        <div class="mb-6">
            <h1 class="text-2xl md:text-3xl font-bold mb-2">La Célula: Estructura y Función</h1>
            <p class="text-gray-600 dark:text-gray-300">Aprende sobre los componentes fundamentales de la célula y cómo interactúan para mantener la vida.</p>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Sección de video y contenido principal -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Video -->
                <div class="bg-black rounded-xl overflow-hidden shadow-lg">
                    <div class="aspect-w-16 aspect-h-9">
                        <iframe class="w-full h-64 md:h-96" src="<?php echo $url; ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    <div class="p-4 bg-gray-50 dark:bg-gray-800">
                        <div class="flex justify-between items-center mb-2">
                            <div class="flex items-center">
                                <span class="text-sm text-gray-600 dark:text-gray-300 mr-4">
                                    <i class="fas fa-eye mr-1"></i> 85 vistas
                                </span>
                                <div class="flex items-center">
                                    <div class="star-rating">
                                        <input type="radio" id="video-star5" name="video-rating" value="5" />
                                        <label for="video-star5" title="5 estrellas">★</label>
                                        <input type="radio" id="video-star4" name="video-rating" value="4" />
                                        <label for="video-star4" title="4 estrellas">★</label>
                                        <input type="radio" id="video-star3" name="video-rating" value="3" />
                                        <label for="video-star3" title="3 estrellas">★</label>
                                        <input type="radio" id="video-star2" name="video-rating" value="2" />
                                        <label for="video-star2" title="2 estrellas">★</label>
                                        <input type="radio" id="video-star1" name="video-rating" value="1" />
                                        <label for="video-star1" title="1 estrella">★</label>
                                    </div>
                                    <span class="rating-average ml-2">(45 estrellas)</span>
                                </div>
                            </div>
                        </div>
                        <h2 class="text-lg font-semibold">Introducción a la célula</h2>
                    </div>
                </div>
                
                <!-- Sección de texto transcrito -->
                <div class="bg-white dark:bg-dark-800 rounded-xl shadow-lg overflow-hidden">
                    <div class="p-4 border-b border-gray-200 dark:border-gray-700">
                        <h2 class="text-lg font-semibold">Texto transcrito del video</h2>
                    </div>
                    <div class="p-4">
                        <button id="transcribeBtn" class="w-full bg-primary-600 hover:bg-primary-700 text-white py-2 rounded-lg text-sm font-medium mb-4">
                            <i class="fas fa-keyboard mr-2"></i> Transcribir texto
                        </button>
                        
                        <div id="transcriptionContainer" class="transcription-container">
                            <div class="prose dark:prose-invert max-w-none">
                                <h3 class="font-semibold mb-3">Introducción a la célula</h3>
                                <p class="mb-4">
                                    La célula es la unidad básica de la vida. Todos los organismos vivos están compuestos por células, desde las bacterias más simples hasta los organismos multicelulares más complejos como los seres humanos.
                                </p>
                                
                                <h3 class="font-semibold mb-3">Tipos de células</h3>
                                <p class="mb-4">
                                    Existen dos tipos principales de células: procariotas y eucariotas. Las células procariotas, como las bacterias, son más simples y no tienen un núcleo definido. Las células eucariotas, que encontramos en plantas, animales y hongos, are más complejas y tienen un núcleo que alberga el material genético.
                                </p>
                                
                                <h3 class="font-semibold mb-3">Estructura celular</h3>
                                <p class="mb-4">
                                    Las células eucariotas están compuestas por varios orgánulos, cada uno con funciones específicas. Entre los más importantes se encuentran:
                                </p>
                                <ul class="list-disc pl-5 mb-4">
                                    <li><strong>Núcleo:</strong> Contiene el ADN y controla las actividades celulares.</li>
                                    <li><strong>Mitocondrias:</strong> Producen energía para la célula.</li>
                                    <li><strong>Retículo endoplásmico:</strong> Participa en la síntesis de proteínas y lípidos.</li>
                                    <li><strong>Aparato de Golgi:</strong> Modifica, clasifica y empaqueta proteínas.</li>
                                    <li><strong>Ribosomas:</strong> Sintectan proteínas.</li>
                                    <li><strong>Membrana plasmática:</strong> Regula el paso de sustancias.</li>
                                </ul>
                                
                                <h3 class="font-semibold mb-3">Diferencias entre células animales y vegetales</h3>
                                <p class="mb-4">
                                    Las células vegetales tienen algunas estructuras adicionales que no se encuentran en las células animales:
                                </p>
                                <ul class="list-disc pl-5 mb-4">
                                    <li><strong>Pared celular:</strong> Proporciona soporte y protección.</li>
                                    <li><strong>Cloroplastos:</strong> Realizan la fotosíntesis.</li>
                                    <li><strong>Vacuola central:</strong> Almacena agua y nutrientes.</li>
                                </ul>
                                
                                <p>
                                    Comprender la estructura y función de las células es fundamental para estudiar la biología, ya que todos los procesos vitales ocurren a nivel celular.
                                </p>
                            </div>
                            
                            <!-- Estadísticas del texto -->
                            <div class="flex justify-between items-center mt-6 pt-4 border-t border-gray-200 dark:border-gray-700">
                                <div class="flex items-center text-sm text-gray-600 dark:text-gray-300">
                                    <i class="fas fa-eye mr-2"></i>
                                    <span id="readCount">58</span> leídos
                                </div>
                                <div class="flex items-center">
                                    <div class="star-rating star-rating-sm">
                                        <input type="radio" id="text-star5" name="text-rating" value="5" />
                                        <label for="text-star5" title="5 estrellas">★</label>
                                        <input type="radio" id="text-star4" name="text-rating" value="4" />
                                        <label for="text-star4" title="4 estrellas">★</label>
                                        <input type="radio" id="text-star3" name="text-rating" value="3" />
                                        <label for="text-star3" title="3 estrellas">★</label>
                                        <input type="radio" id="text-star2" name="text-rating" value="2" />
                                        <label for="text-star2" title="2 estrellas">★</label>
                                        <input type="radio" id="text-star1" name="text-rating" value="1" />
                                        <label for="text-star1" title="1 estrella">★</label>
                                    </div>
                                    <span class="rating-average ml-2">(24 estrellas)</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Sidebar derecha -->
            <div class="space-y-6">
                <!-- Comentarios -->
                <div class="bg-white dark:bg-dark-800 rounded-xl shadow-lg overflow-hidden">
                    <div class="p-4 border-b border-gray-200 dark:border-gray-700">
                        <h2 class="text-lg font-semibold flex items-center">
                            <i class="fas fa-comments mr-2"></i> Comentarios
                        </h2>
                    </div>
                    <div class="p-4">
                        <!-- Formulario de comentario -->
                        <div class="mb-6">
                            <div class="flex items-start space-x-3">
                            <div class="h-10 w-10 rounded-full bg-primary-500 flex items-center justify-center text-white">
                                <span><?php echo $iniciales?></span>
                            </div>
                                <div class="flex-1">
                                    <form id="commentForm" class="comment-form">
                                        <textarea id="commentText" rows="3" class="w-full bg-gray-100 dark:bg-gray-700 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-primary-500" placeholder="Escribe tu comentario..." required></textarea>
                                        <div class="flex justify-end mt-2">
                                            <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                                                Publicar comentario
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Lista de comentarios -->
                        <div class="space-y-4" id="commentsContainer">
                            <!-- Comentario 1 -->
                            <div class="flex space-x-3 animate-fadeIn">
                                <div class="flex-shrink-0">
                                    <img class="h-10 w-10 rounded-full" src="https://images.unsplash.com/photo-1519244703995-f4e0f30006d5?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="Usuario">
                                </div>
                                <div class="flex-1">
                                    <div class="bg-gray-100 dark:bg-gray-700 rounded-lg p-3">
                                        <div class="flex items-center justify-between mb-1">
                                            <span class="font-medium">Carlos Martínez</span>
                                            <span class="text-xs text-gray-500 dark:text-gray-400">Hace 2 horas</span>
                                        </div>
                                        <p class="text-gray-700 dark:text-gray-300">Excelente explicación sobre la membrana celular. Me ayudó mucho a entender su función selectiva.</p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Comentario 2 -->
                            <div class="flex space-x-3 animate-fadeIn">
                                <div class="flex-shrink-0">
                                    <img class="h-10 w-10 rounded-full" src="https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="Usuario">
                                </div>
                                <div class="flex-1">
                                    <div class="bg-gray-100 dark:bg-gray-700 rounded-lg p-3">
                                        <div class="flex items-center justify-between mb-1">
                                            <span class="font-medium">Ana Rodríguez</span>
                                            <span class="text-xs text-gray-500 dark:text-gray-400">Ayer</span>
                                        </div>
                                        <p class="text-gray-700 dark:text-gray-300">¿Podrían explicar con más detalle la diferencia entre células procariotas y eucariotas? Gracias.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
 
                <!-- Videos recomendados -->
                <div class="bg-white dark:bg-dark-800 rounded-xl shadow-lg overflow-hidden">
                    <div class="p-4 border-b border-gray-200 dark:border-gray-700">
                        <h2 class="text-lg font-semibold flex items-center">
                            <i class="fas fa-play-circle mr-2"></i> Contenido recomendado
                        </h2>
                    </div>
                    <div class="p-4 space-y-4">
                        <!-- Video de Tipos de Reacciones Químicas -->
                        <div class="flex group">
                            <div class="flex-shrink-0 relative">
                                <iframe class="w-40 h-28 rounded-lg object-cover" src="https://www.youtube.com/embed/MLcHCEnBKmo" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium group-hover:text-primary-600 dark:group-hover:text-primary-400 line-clamp-2">Tipos de Reacciones Químicas</h3>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Química • 12 vistas</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</main>

<script>
    // Función para el sistema de calificación con estrellas del video
    document.querySelectorAll('.star-rating input').forEach(star => {
        star.addEventListener('change', function() {
            const rating = parseInt(this.value);  // Nueva calificación del usuario
            const ratingContainer = this.closest('.star-rating');
            const averageSpan = ratingContainer.nextElementSibling;

            // Extraemos el número actual de estrellas visibles
            const text = averageSpan.textContent;
            const starsMatch = text.match(/(\d+) estrellas/);
            let currentStars = starsMatch ? parseInt(starsMatch[1]) : 0;

            // Guardamos la calificación anterior del usuario en dataset del contenedor
            let previousRating = ratingContainer.dataset.previousRating ? parseInt(ratingContainer.dataset.previousRating) : 0;

            // Calculamos el nuevo total:
            // Removemos la calificación anterior y sumamos la nueva
            let newStars = currentStars - previousRating + rating;

            // Actualizamos el texto visual
            averageSpan.textContent = `(${newStars} estrellas)`;

            // Guardamos la nueva calificación para la próxima vez que cambie
            ratingContainer.dataset.previousRating = rating;

            alert(`¡Gracias por tu calificación de ${rating} estrellas!`);
        });
    });
        
    // Función para transcribir texto
    document.getElementById('transcribeBtn').addEventListener('click', function() {
        const container = document.getElementById('transcriptionContainer');
        const button = this;
        
        container.classList.toggle('show');
        
        if (container.classList.contains('show')) {
            button.innerHTML = '<i class="fas fa-times mr-2"></i> Ocultar texto';
            
            // Incrementar contador de lecturas
            const readCount = document.getElementById('readCount');
            readCount.textContent = parseInt(readCount.textContent) + 1;
        } else {
            button.innerHTML = '<i class="fas fa-keyboard mr-2"></i> Transcribir texto';
        }
    });

    // Función para agregar comentarios con validación
    document.getElementById('commentForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const textarea = document.getElementById('commentText');
        const commentText = textarea.value.trim();
        
        if (!commentText) {
            alert('Por favor escribe un comentario antes de publicar');
            return;
        }
        
        const newComment = document.createElement('div');
        newComment.className = 'flex space-x-3 animate-fadeIn';
        newComment.innerHTML = `
            <div class="h-10 w-10 rounded-full bg-primary-500 flex items-center justify-center text-white">
                    <span><?php echo $iniciales?></span>
            </div>
            <div class="flex-1">
                <div class="bg-gray-100 dark:bg-gray-700 rounded-lg p-3">
                    <div class="flex items-center justify-between mb-1">
                        <span class="font-medium">Tú</span>
                        <span class="text-xs text-gray-500 dark:text-gray-400">Ahora mismo</span>
                    </div>
                    <p class="text-gray-700 dark:text-gray-300">${commentText}</p>
                </div>
            </div>
        `;
        
        document.getElementById('commentsContainer').insertBefore(newComment, document.getElementById('commentsContainer').firstChild);
        textarea.value = '';
        
    });

    // Asignar eventos de cierre de sesión a ambos botones
    document.getElementById('logoutBtn').addEventListener('click', function(e) {
        e.preventDefault();
        handleLogout();
    });

    document.getElementById('logoutBtnDesktop').addEventListener('click', function(e) {
        e.preventDefault();
        handleLogout();
    });
</script>
</body>
</html>