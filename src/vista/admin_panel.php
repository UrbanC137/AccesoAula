<?php
session_start();

// Verificar si el usuario ha iniciado sesión y si tiene rol de administrador
if (!isset($_SESSION['usuario']) || !isset($_SESSION['rol']) || $_SESSION['rol'] != 'administrador') {
    header("location: index.php"); // Redirigir al inicio si no está autenticado o no es admin
    exit;
}

include 'php/conexion_be.php'; // Asegúrate de que la conexión esté bien configurada

$nombre_admin = $_SESSION['nombre_completo'];
$iniciales_admin = '';
foreach (explode(" ", $nombre_admin) as $parte) {
    $iniciales_admin .= strtoupper($parte[0]);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduPortal - Panel de Administración</title>
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
        .transition-colors {
            transition-property: background-color, border-color, color, fill, stroke;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 150ms;
        }
        .rating-star {
            color: #ccc; /* Default gray for empty stars */
        }
        .rating-star.filled {
            color: #ffc107; /* Yellow for filled stars */
        }
        .notification-card {
            border-left-width: 6px;
            animation: pulse-border 1.5s infinite;
        }

        @keyframes pulse-border {
            0% { border-color: #fca5a5; }
            50% { border-color: #ef4444; }
            100% { border-color: #fca5a5; }
        }
    </style>
</head>
<body class="bg-gray-100 dark:bg-dark-900 text-gray-800 dark:text-gray-200 transition-colors min-h-screen">
    <div class="flex flex-col md:flex-row min-h-screen">
        <aside class="w-full md:w-64 bg-white dark:bg-dark-800 shadow-lg md:h-screen md:sticky md:top-0 z-10">
            <div class="p-4 border-b border-gray-200 dark:border-gray-700">
                <h1 class="text-xl font-bold text-primary-600 dark:text-primary-400 flex items-center">
                    <i class="fas fa-graduation-cap mr-2"></i> EduPortal
                </h1>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Panel de Administración</p>
            </div>
            
            <div class="p-4 border-b border-gray-200 dark:border-gray-700">
                <div class="dropdown relative">
                    <button class="flex items-center space-x-3 w-full focus:outline-none">
                        <div class="h-10 w-10 rounded-full bg-primary-500 flex items-center justify-center text-white">
                            <span><?php echo $iniciales_admin;?></span>
                        </div>
                        <div class="text-left">
                            <h1><?php echo $nombre_admin; ?></h1>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Administrador</p>
                        </div>
                        <i class="fas fa-chevron-down text-xs ml-auto"></i>
                    </button>
                    <div class="dropdown-menu">
                        <a href="php/cerrar_sesion.php" class="dropdown-item">Cerrar sesión</a>
                        <a href="bienvenida.php" class="dropdown-item">Volver a EduPortal</a>
                    </div>
                </div>
            </div>
            
            <nav class="overflow-y-auto h-[calc(100vh-180px)]">
                <div class="px-4 py-2">
                    <ul>
                        <li class="mb-1">
                            <a href="dashboard_admin.php" class="flex items-center px-3 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                                <i class="fas fa-tachometer-alt mr-2"></i> Dashboard
                            </a>
                        </li>
                        <li class="mb-1">
                            <a href="gestion_contenido_admin.php" class="flex items-center px-3 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                                <i class="fas fa-file-alt mr-2"></i> Gestión de Contenido
                            </a>
                        </li>
                        <li class="mb-1">
                            <a href="gestion_usuarios_admin.php" class="flex items-center px-3 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                                <i class="fas fa-users mr-2"></i> Gestión de Usuarios
                            </a>
                        </li>
                        <li class="mb-1">
                            <a href="admin_panel.php" class="flex items-center px-3 py-2 rounded-lg bg-primary-100 dark:bg-primary-700 text-primary-700 dark:text-primary-200">
                                <i class="fas fa-star mr-2"></i> Revisar Calificaciones
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
        </aside>
        
        <main class="flex-1 p-4 md:p-6">
            <div class="max-w-7xl mx-auto">
                <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-6">Revisión de Calificaciones de Temas</h2>

                <div id="ratingNotifications" class="mb-6 space-y-4">
                    <div class="p-4 bg-blue-50 dark:bg-blue-900 border border-blue-200 dark:border-blue-700 text-blue-800 dark:text-blue-200 rounded-lg">
                        <i class="fas fa-info-circle mr-2"></i> Cargando notificaciones de calificaciones...
                    </div>
                </div>

                <div class="bg-white dark:bg-dark-800 rounded-lg shadow p-4 mb-6">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
                        <div class="flex-1">
                            <label for="searchTopic" class="sr-only">Buscar tema</label>
                            <div class="relative">
                                <input type="text" id="searchTopic" placeholder="Buscar tema por título..." class="pl-10 pr-4 py-2 w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                                <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                            </div>
                        </div>
                        <div class="flex space-x-2">
                            <div class="relative">
                                <select id="filterRating" class="appearance-none bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg py-2 pl-3 pr-8 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                                    <option value="">Todas las calificaciones</option>
                                    <option value="low">Calificación baja (&lt; 2.5)</option>
                                    <option value="high">Calificación alta (&gt; 4.0)</option>
                                </select>
                                <i class="fas fa-chevron-down absolute right-3 top-3 text-gray-400 pointer-events-none"></i>
                            </div>
                            <div class="relative">
                                <select id="sortBy" class="appearance-none bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg py-2 pl-3 pr-8 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                                    <option value="average_desc">Promedio (Mayor a Menor)</option>
                                    <option value="average_asc">Promedio (Menor a Mayor)</option>
                                    <option value="total_ratings_desc">Más Calificaciones</option>
                                    <option value="total_ratings_asc">Menos Calificaciones</option>
                                </select>
                                <i class="fas fa-chevron-down absolute right-3 top-3 text-gray-400 pointer-events-none"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-dark-800 rounded-lg shadow p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tema Educativo</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Promedio Calificación</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Total Calificaciones</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="topicsRatingsTableBody" class="bg-white dark:bg-dark-800 divide-y divide-gray-200 dark:divide-gray-700">
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">Cargando calificaciones...</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <div id="topicDetailsModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50 hidden">
        <div class="bg-white dark:bg-dark-800 rounded-xl shadow-xl w-full max-w-3xl max-h-[90vh] overflow-y-auto text-gray-800 dark:text-gray-200">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 id="modalTopicTitle" class="text-2xl font-bold">Detalles de Calificaciones</h3>
                    <button onclick="closeTopicDetailsModal()" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                
                <p id="modalTopicAvgRating" class="text-lg font-semibold mb-2"></p>
                <p id="modalTopicTotalRatings" class="text-sm text-gray-600 dark:text-gray-400 mb-4"></p>

                <div id="individualRatingsList" class="space-y-4">
                    </div>

                <div class="mt-6 flex justify-end">
                    <button onclick="closeTopicDetailsModal()" class="bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 font-medium py-2 px-6 rounded-lg transition-colors duration-300">
                        Cerrar
                    </button>
                    <button onclick="alert('Simular edición de contenido del tema seleccionado.')" class="bg-primary-600 hover:bg-primary-700 text-white font-medium py-2 px-6 rounded-lg transition-colors duration-300 ml-3">
                        Editar Contenido del Tema
                    </button>
                </div>
            </div>
        </div>
    </div>


    <script>
        // Datos simulados para los temas y sus calificaciones
        // NOTA: Los 'id' de estos temas deberían coincidir con los IDs reales en tu tabla 'temas' de la base de datos
        // cuando pases de la simulación a la integración real con la base de datos.
        const simulatedTopicsData = [
            {
                id: 1, // Corresponde al ID de 'La Célula' en la tabla 'temas'
                titulo: "La Célula",
                average_rating: 4.2,
                total_ratings: 15,
                individual_ratings: [
                    { usuario_nombre: "María López", calificacion: 5, comentario: "¡Excelente video, muy claro!", fecha_calificacion: "2024-06-20" },
                    { usuario_nombre: "Juan Pérez", calificacion: 4, comentario: "Buen resumen, pero me gustaría más detalle en los orgánulos.", fecha_calificacion: "2024-06-18" },
                    { usuario_nombre: "Ana García", calificacion: 3, comentario: "Un poco rápido al final.", fecha_calificacion: "2024-06-15" }
                ]
            },
            {
                id: 2, // Corresponde al ID de 'Ecosistemas' en la tabla 'temas'
                titulo: "Ecosistemas",
                average_rating: 2.1,
                total_ratings: 8,
                individual_ratings: [
                    { usuario_nombre: "Pedro Ruiz", calificacion: 1, comentario: "El audio es terrible, no se entiende nada.", fecha_calificacion: "2024-06-22" },
                    { usuario_nombre: "Sofía Díaz", calificacion: 3, comentario: "El contenido es bueno, pero la calidad del video es muy baja.", fecha_calificacion: "2024-06-20" },
                    { usuario_nombre: "Luis Fernández", calificacion: 2, comentario: "Esperaba más ejemplos prácticos.", fecha_calificacion: "2024-06-19" }
                ]
            },
            {
                id: 3, // Corresponde al ID de 'Genética' en la tabla 'temas'
                titulo: "Genética",
                average_rating: 4.8,
                total_ratings: 20,
                individual_ratings: [
                    { usuario_nombre: "Elena Blanco", calificacion: 5, comentario: "¡Magnífico! Lo entendí todo a la primera.", fecha_calificacion: "2024-06-21" },
                    { usuario_nombre: "Miguel Soto", calificacion: 5, comentario: "Perfecto para repasar conceptos clave.", fecha_calificacion: "2024-06-19" },
                    { usuario_nombre: "Carlos Ortiz", calificacion: 4, comentario: "Muy completo, excelente recurso.", fecha_calificacion: "2024-06-17" }
                ]
            },
            {
                id: 4, // Corresponde al ID de 'Tabla Periódica' en la tabla 'temas'
                titulo: "Tabla Periódica",
                average_rating: 3.5,
                total_ratings: 12,
                individual_ratings: [
                    { usuario_nombre: "Lucía Morales", calificacion: 4, comentario: "Útil, pero la tabla es un poco pequeña.", fecha_calificacion: "2024-06-19" },
                    { usuario_nombre: "David Ramos", calificacion: 3, comentario: "Me ayudó a recordar algunas cosas.", fecha_calificacion: "2024-06-16" }
                ]
            },
            {
                id: 5, // Corresponde al ID de 'Reacciones' en la tabla 'temas'
                titulo: "Reacciones",
                average_rating: 4.0,
                total_ratings: 10,
                individual_ratings: [
                    { usuario_nombre: "Andrea Gil", calificacion: 4, comentario: "Explicación clara de las reacciones redox.", fecha_calificacion: "2024-06-23" }
                ]
            },
            {
                id: 6, // Corresponde al ID de 'Electricidad' en la tabla 'temas'
                titulo: "Electricidad",
                average_rating: 1.5,
                total_ratings: 3,
                individual_ratings: [
                    { usuario_nombre: "Javier Cano", calificacion: 1, comentario: "No explica bien los circuitos complejos.", fecha_calificacion: "2024-06-20" }
                ]
            },
             {
                id: 7, // Corresponde al ID de 'Mecánica' en la tabla 'temas'
                titulo: "Mecánica",
                average_rating: 3.9,
                total_ratings: 7,
                individual_ratings: [
                    { usuario_nombre: "Laura Blanco", calificacion: 4, comentario: "Las leyes de Newton, bien explicadas.", fecha_calificacion: "2024-06-15" }
                ]
            }
        ];

        const topicsData = []; // Esta variable se rellenará con los datos simulados

        // Función para cargar los datos de calificaciones (ahora simulados)
        async function loadRatings() {
            // Simular una carga asíncrona
            document.getElementById('topicsRatingsTableBody').innerHTML = `<tr><td colspan="4" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">Cargando calificaciones simuladas...</td></tr>`;
            await new Promise(resolve => setTimeout(resolve, 500)); // Pequeño retardo para simular carga

            topicsData.splice(0, topicsData.length, ...simulatedTopicsData); // Cargar datos simulados
            renderRatingsTable();
            generateRatingNotifications(); // Generar notificaciones al cargar
        }

        // Función para renderizar la tabla de calificaciones por tema
        function renderRatingsTable() {
            const tableBody = document.getElementById('topicsRatingsTableBody');
            tableBody.innerHTML = ''; // Limpiar tabla

            if (topicsData.length === 0) {
                tableBody.innerHTML = `<tr><td colspan="4" class="px-6 py-4 text-center text-gray-500">No hay calificaciones simuladas para mostrar.</td></tr>`;
                return;
            }

            // Aplicar filtros y ordenación
            let filteredData = [...topicsData];
            const searchTerm = document.getElementById('searchTopic').value.toLowerCase();
            const filterRating = document.getElementById('filterRating').value;
            const sortBy = document.getElementById('sortBy').value;

            if (searchTerm) {
                filteredData = filteredData.filter(topic => 
                    topic.titulo.toLowerCase().includes(searchTerm)
                );
            }

            if (filterRating === 'low') {
                filteredData = filteredData.filter(topic => topic.average_rating < 2.5);
            } else if (filterRating === 'high') {
                filteredData = filteredData.filter(topic => topic.average_rating > 4.0);
            }

            filteredData.sort((a, b) => {
                if (sortBy === 'average_desc') return b.average_rating - a.average_rating;
                if (sortBy === 'average_asc') return a.average_rating - b.average_rating;
                if (sortBy === 'total_ratings_desc') return b.total_ratings - a.total_ratings;
                if (sortBy === 'total_ratings_asc') return a.total_ratings - b.total_ratings;
                return 0;
            });


            filteredData.forEach(topic => {
                const row = tableBody.insertRow();
                const starsHTML = getStarsHTML(topic.average_rating);
                
                row.innerHTML = `
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">${topic.titulo}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                        ${starsHTML} (${topic.average_rating.toFixed(1)})
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">${topic.total_ratings}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <button onclick="viewTopicDetails(${topic.id}, '${topic.titulo}')" class="text-primary-600 hover:text-primary-800 dark:text-primary-400 dark:hover:text-primary-200 mr-3">Ver Comentarios</button>
                        <button onclick="alert('Simular edición de contenido del tema: ${topic.titulo} (ID: ${topic.id})')" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-200">Editar</button>
                    </td>
                `;
            });
        }

        // Función para generar HTML de estrellas de calificación
        function getStarsHTML(averageRating) {
            let stars = '';
            for (let i = 1; i <= 5; i++) {
                if (i <= Math.round(averageRating)) {
                    stars += '<i class="fas fa-star rating-star filled"></i>';
                } else {
                    stars += '<i class="far fa-star rating-star"></i>';
                }
            }
            return stars;
        }

        // Función para mostrar el modal de detalles de tema
        async function viewTopicDetails(topicId, topicTitle) {
            document.getElementById('modalTopicTitle').textContent = `Detalles de Calificaciones para el Tema: ${topicTitle}`; // Cambiado el título del modal
            document.getElementById('individualRatingsList').innerHTML = '<p class="text-gray-600 dark:text-gray-300">Cargando comentarios...</p>';
            document.getElementById('topicDetailsModal').classList.remove('hidden');

            // Cargar los datos individuales del tema desde los datos simulados
            const topic = simulatedTopicsData.find(t => t.id === topicId);

            if (topic) {
                document.getElementById('modalTopicAvgRating').innerHTML = `Promedio: ${getStarsHTML(topic.average_rating)} (${topic.average_rating.toFixed(1)})`;
                document.getElementById('modalTopicTotalRatings').textContent = `Total de calificaciones: ${topic.total_ratings}`;
                
                const commentsList = document.getElementById('individualRatingsList');
                commentsList.innerHTML = '';
                if (topic.individual_ratings && topic.individual_ratings.length > 0) {
                    topic.individual_ratings.forEach(rating => {
                        commentsList.innerHTML += `
                            <div class="p-3 bg-gray-50 dark:bg-gray-700 rounded-lg shadow-sm">
                                <p class="font-semibold">${rating.usuario_nombre} <span class="text-gray-500 text-xs">(${rating.fecha_calificacion || 'Fecha desconocida'})</span></p>
                                <p>${getStarsHTML(rating.calificacion)}</p>
                                <p class="text-gray-700 dark:text-gray-300">${rating.comentario ? rating.comentario : 'Sin comentario.'}</p>
                            </div>
                        `;
                    });
                } else {
                    commentsList.innerHTML = '<p class="text-gray-600 dark:text-gray-300">No hay calificaciones individuales con comentarios para este tema.</p>';
                }
            } else {
                document.getElementById('individualRatingsList').innerHTML = '<p class="text-red-500">Tema no encontrado en los detalles simulados.</p>';
            }
        }

        // Función para cerrar el modal de detalles
        function closeTopicDetailsModal() {
            document.getElementById('topicDetailsModal').classList.add('hidden');
        }

        // Función para generar notificaciones (ej: calificación muy baja o muy alta)
        function generateRatingNotifications() {
            const notificationsDiv = document.getElementById('ratingNotifications');
            notificationsDiv.innerHTML = ''; // Limpiar notificaciones anteriores
            let notificationCount = 0;

            topicsData.forEach(topic => {
                // Solo notificar si hay al menos 2 calificaciones para evitar ruido con una sola calificación
                if (topic.total_ratings >= 2) { 
                    // Notificación para calificaciones inusualmente bajas (ej. promedio < 2.0)
                    if (topic.average_rating < 2.0) {
                        notificationsDiv.innerHTML += `
                            <div class="p-4 bg-red-100 dark:bg-red-900 border-red-300 dark:border-red-700 text-red-800 dark:text-red-200 rounded-lg notification-card">
                                <i class="fas fa-exclamation-circle mr-2"></i> **¡Atención!** El tema "**${topic.titulo}**" tiene una calificación promedio muy baja (${topic.average_rating.toFixed(1)}/5) de ${topic.total_ratings} usuarios. Se recomienda revisión de contenido.
                                <button onclick="viewTopicDetails(${topic.id}, '${topic.titulo}')" class="ml-3 text-red-600 hover:underline">Ver detalles</button>
                            </div>
                        `;
                        notificationCount++;
                    }
                    // Notificación para calificaciones inusualmente altas (ej. promedio > 4.5)
                    else if (topic.average_rating > 4.5) {
                        notificationsDiv.innerHTML += `
                            <div class="p-4 bg-green-100 dark:bg-green-900 border-green-300 dark:border-green-700 text-green-800 dark:text-green-200 rounded-lg">
                                <i class="fas fa-check-circle mr-2"></i> **¡Excelente!** El tema "**${topic.titulo}**" tiene una calificación promedio muy alta (${topic.average_rating.toFixed(1)}/5) de ${topic.total_ratings} usuarios. Buen trabajo, ¡considera usarlo como referencia!
                                <button onclick="viewTopicDetails(${topic.id}, '${topic.titulo}')" class="ml-3 text-green-600 hover:underline">Ver detalles</button>
                            </div>
                        `;
                        notificationCount++;
                    }
                }
            });

            if (notificationCount === 0) {
                notificationsDiv.innerHTML = `
                    <div class="p-4 bg-blue-50 dark:bg-blue-900 border border-blue-200 dark:border-blue-700 text-blue-800 dark:text-blue-200 rounded-lg">
                        <i class="fas fa-info-circle mr-2"></i> No hay notificaciones de calificaciones inusuales en este momento para los temas.
                    </div>
                `;
            }
        }


        // Event Listeners para filtros y búsqueda
        document.getElementById('searchTopic').addEventListener('input', renderRatingsTable);
        document.getElementById('filterRating').addEventListener('change', renderRatingsTable);
        document.getElementById('sortBy').addEventListener('change', renderRatingsTable);

        // Cargar calificaciones al iniciar la página (ahora carga datos simulados)
        document.addEventListener('DOMContentLoaded', loadRatings);
    </script>
</body>
</html>
