-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 31-05-2025 a las 01:18:47
-- Versión del servidor: 8.4.3
-- Versión de PHP: 8.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `login_register_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `calificaciones`
--

CREATE TABLE `calificaciones` (
  `id` int NOT NULL,
  `usuario_id` int NOT NULL,
  `contenido_id` int NOT NULL,
  `tipo_contenido` enum('video','texto','otro') COLLATE utf8mb3_spanish_ci NOT NULL,
  `calificacion` tinyint UNSIGNED NOT NULL,
  `fecha_calificacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ;

--
-- Volcado de datos para la tabla `calificaciones`
--

INSERT INTO `calificaciones` (`id`, `usuario_id`, `contenido_id`, `tipo_contenido`, `calificacion`, `fecha_calificacion`) VALUES
(26, 1, 1, 'video', 5, '2025-05-23 01:13:45'),
(27, 1, 2, 'texto', 4, '2025-05-23 01:13:45'),
(28, 1, 3, 'video', 3, '2025-05-23 01:13:45'),
(29, 1, 4, 'texto', 5, '2025-05-23 01:13:45'),
(30, 1, 5, 'otro', 2, '2025-05-23 01:13:45'),
(31, 2, 1, 'texto', 5, '2025-05-23 01:13:45'),
(32, 2, 2, 'video', 4, '2025-05-23 01:13:45'),
(33, 2, 3, 'video', 2, '2025-05-23 01:13:45'),
(34, 2, 4, 'otro', 3, '2025-05-23 01:13:45'),
(35, 2, 5, 'texto', 1, '2025-05-23 01:13:45'),
(36, 3, 1, 'video', 5, '2025-05-23 01:13:45'),
(37, 3, 2, 'texto', 5, '2025-05-23 01:13:45'),
(38, 3, 3, 'otro', 4, '2025-05-23 01:13:45'),
(39, 3, 4, 'texto', 3, '2025-05-23 01:13:45'),
(40, 3, 5, 'video', 5, '2025-05-23 01:13:45'),
(41, 4, 1, 'video', 2, '2025-05-23 01:13:45'),
(42, 4, 2, 'texto', 4, '2025-05-23 01:13:45'),
(43, 4, 3, 'otro', 5, '2025-05-23 01:13:45'),
(44, 4, 4, 'texto', 3, '2025-05-23 01:13:45'),
(45, 4, 5, 'video', 4, '2025-05-23 01:13:45'),
(46, 5, 1, 'texto', 5, '2025-05-23 01:13:45'),
(47, 5, 2, 'video', 1, '2025-05-23 01:13:45'),
(48, 5, 3, 'otro', 2, '2025-05-23 01:13:45'),
(49, 5, 4, 'video', 3, '2025-05-23 01:13:45'),
(50, 5, 5, 'texto', 5, '2025-05-23 01:13:45');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` int NOT NULL,
  `nombre` varchar(50) COLLATE utf8mb3_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `nombre`) VALUES
(1, 'Biología'),
(2, 'Química'),
(3, 'Física');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentarios`
--

CREATE TABLE `comentarios` (
  `id` int NOT NULL,
  `estudiante_id` int DEFAULT NULL,
  `tema_id` int DEFAULT NULL,
  `comentario` text COLLATE utf8mb3_spanish_ci NOT NULL,
  `fecha_comentario` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contenidos`
--

CREATE TABLE `contenidos` (
  `id` int NOT NULL,
  `titulo` varchar(150) COLLATE utf8mb3_spanish_ci NOT NULL,
  `tipo` enum('video','texto','otro') COLLATE utf8mb3_spanish_ci NOT NULL,
  `url` text COLLATE utf8mb3_spanish_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

--
-- Volcado de datos para la tabla `contenidos`
--

INSERT INTO `contenidos` (`id`, `titulo`, `tipo`, `url`) VALUES
(1, 'Célula eucariota', 'video', 'https://www.youtube.com/embed/video1'),
(2, 'ADN y genética', 'texto', ''),
(3, 'Fotosíntesis', 'video', 'https://www.youtube.com/embed/video2'),
(4, 'Sistema digestivo', 'texto', ''),
(5, 'Funciones celulares', 'otro', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `temas`
--

CREATE TABLE `temas` (
  `id` int NOT NULL,
  `nombre` varchar(100) COLLATE utf8mb3_spanish_ci NOT NULL,
  `categoria_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

--
-- Volcado de datos para la tabla `temas`
--

INSERT INTO `temas` (`id`, `nombre`, `categoria_id`) VALUES
(1, 'La Célula', 1),
(2, 'Ecosistemas', 1),
(3, 'Genética', 1),
(4, 'Tabla Periódica', 2),
(5, 'Reacciones', 2),
(6, 'Electricidad', 3),
(7, 'Mecánica', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `textos`
--

CREATE TABLE `textos` (
  `id` int NOT NULL,
  `titulo` varchar(255) COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `contenido` text COLLATE utf8mb3_spanish_ci,
  `fecha_publicacion` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int NOT NULL,
  `nombre_completo` varchar(50) COLLATE utf8mb3_spanish_ci NOT NULL,
  `correo` varchar(50) COLLATE utf8mb3_spanish_ci NOT NULL,
  `usuario` varchar(50) COLLATE utf8mb3_spanish_ci NOT NULL,
  `contrasena` varchar(50) COLLATE utf8mb3_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre_completo`, `correo`, `usuario`, `contrasena`) VALUES
(1, 'London Poma', 'londonpoma123@gmail.com', 'LondonPoma', '123456'),
(2, 'Lucas Cueva', 'lucascueva123@gmail.com', 'LucasC', '123456'),
(3, 'Carlos Gomez', 'carlosgomez123@gmail.com', 'CalosG', '123456'),
(4, 'Luis Pancho', 'luispancho123@gmail.com', 'LuisPan', '123456'),
(5, 'Juanes Poma', 'juanespoma123@gmail.com', 'JuanesPoma', '1okZuu'),
(6, 'Carlos Rodriguez', 'carlosrodriguez123@gmail.com', 'CarlosRodriguez', 'SoKRZT'),
(7, 'Ana Martinez', 'anamartinez123@gmail.com', 'AnaMartinez', 'uPy7aG'),
(8, 'Luis Gomez', 'luisgomez123@gmail.com', 'LuisGomez', 'Jgi467'),
(9, 'Maria Fernandez', 'mariafernandez123@gmail.com', 'MariaFernandez', '0V9AUN'),
(10, 'Juan Perez', 'juanperez123@gmail.com', 'JuanPerez', 'WIDArZ'),
(11, 'Sofia Lopez', 'sofialopez123@gmail.com', 'SofiaLopez', 'igeV7p'),
(12, 'Miguel Sanchez', 'miguelsanchez123@gmail.com', 'MiguelSanchez', 'kw4NeP'),
(13, 'Pedro Gonzalez', 'pedrogonzalez123@gmail.com', 'PedroGonzalez', '8N7yRI'),
(14, 'Laura Hernandez', 'laurahernandez123@gmail.com', 'LauraHernandez', 'KohvJJ'),
(15, 'Javier Moreno', 'javiermoreno123@gmail.com', 'JavierMoreno', 'Ii7dpG'),
(16, 'Daniel Diaz', 'danieldiaz123@gmail.com', 'DanielDiaz', 'sjXJuy'),
(17, 'Carmen Ruiz', 'carmenruiz123@gmail.com', 'CarmenRuiz', '9fG1cU'),
(18, 'Antonio Garcia', 'antoniogarcia123@gmail.com', 'AntonioGarcia', 'Otr0oC'),
(19, 'Isabel Fernandez', 'isabelfernandez123@gmail.com', 'IsabelFernandez', 'fJJils'),
(20, 'David Jimenez', 'davidjimenez123@gmail.com', 'DavidJimenez', 'FY51Kp'),
(21, 'Raul Ramirez', 'raulramirez123@gmail.com', 'RaulRamirez', 'LLze0b'),
(22, 'Elena Blanco', 'elenablanco123@gmail.com', 'ElenaBlanco', 'sydxE0'),
(23, 'Jose Torres', 'josetorres123@gmail.com', 'JoseTorres', 'Bcjs9s'),
(24, 'Dolores Vega', 'doloresvega123@gmail.com', 'DoloresVega', '181Xzq'),
(25, 'Pablo Castro', 'pablocastro123@gmail.com', 'PabloCastro', 'kjEDiJ'),
(26, 'Marta Serrano', 'martaserrano123@gmail.com', 'MartaSerrano', '9DsSDM'),
(27, 'Victor Ortiz', 'victorortiz123@gmail.com', 'VictorOrtiz', 'LNqnpx'),
(28, 'Eva Martinez', 'evamartinez123@gmail.com', 'EvaMartinez', 'x9WfjL'),
(29, 'Adrian Soto', 'adriansoto123@gmail.com', 'AdrianSoto', 'Xl4HsW'),
(30, 'Fernando Gonzalez', 'fernandogonzalez123@gmail.com', 'FernandoGonzalez', '5wpLV1'),
(31, 'Ricardo Rios', 'ricardorios123@gmail.com', 'RicardoRios', 'ZgLqf4'),
(32, 'Sofia Fernandez', 'sofiafernandez123@gmail.com', 'SofiaFernandez', 'Fp09We'),
(33, 'David Torres', 'davidtorres123@gmail.com', 'DavidTorres', 'D1X9eV'),
(34, 'Raul Castillo', 'raulcastillo123@gmail.com', 'RaulCastillo', 'DF94s7'),
(35, 'Manuel Vargas', 'manuelvargas123@gmail.com', 'ManuelVargas', '7RGt2a'),
(36, 'Antonio Castilla', 'antoniocastilla123@gmail.com', 'AntonioCastilla', 'o7QoJE'),
(37, 'Ximena Paredes', 'ximenaparedes123@gmail.com', 'XimenaParedes', 'pyk5e8'),
(38, 'Nerea Martínez', 'nereamartínez123@gmail.com', 'NereaMartínez', 'uwdCCp'),
(39, 'Emilio Ruiz', 'emilioruiz123@gmail.com', 'EmilioRuiz', 'ugjJ90'),
(40, 'Raquel Muñoz', 'raquelmuñoz123@gmail.com', 'RaquelMuñoz', 'XIswtH'),
(41, 'José Rojas', 'josérojas123@gmail.com', 'JoséRojas', 'QIKTkY'),
(42, 'Sofia Villar', 'sofiavillar123@gmail.com', 'SofiaVillar', 'il7xtq'),
(43, 'Adriana Martínez', 'adrianamartínez123@gmail.com', 'AdrianaMartínez', 'IGl4c8'),
(44, 'Raúl Castilla', 'raúlcastilla123@gmail.com', 'RaúlCastilla', 'NX0tnT'),
(45, 'Sonia Gómez', 'soniagómez123@gmail.com', 'SoniaGómez', 'pJ7qBC'),
(46, 'Felipe Cordero', 'felipecordero123@gmail.com', 'FelipeCordero', 'mCF2Em'),
(47, 'Cecilia Jimenez', 'ceciliajimenez123@gmail.com', 'CeciliaJimenez', 'qqiXc2'),
(48, 'Fátima Santos', 'fátimasantos123@gmail.com', 'FátimaSantos', '3NeEUZ'),
(49, 'Irene Montero', 'irenemontero123@gmail.com', 'IreneMontero', 'D63BBX'),
(50, 'Esteban Fernández', 'estebanfernández123@gmail.com', 'EstebanFernández', 'UuaI0L'),
(51, 'Antonio Santos', 'antoniosantos123@gmail.com', 'AntonioSantos', 'Q5q4KO'),
(52, 'María Jiménez', 'maríajiménez123@gmail.com', 'MaríaJiménez', 'U2BAFz'),
(53, 'Raquel González', 'raquelgonzález123@gmail.com', 'RaquelGonzález', '8RhGAp'),
(54, 'Alberto Hernández', 'albertohernández123@gmail.com', 'AlbertoHernández', 'g1L2pn'),
(55, 'Carlos Cano', 'carloscano123@gmail.com', 'CarlosCano', 'YYeqEj'),
(56, 'Ester Serrano', 'esterserrano123@gmail.com', 'EsterSerrano', 'lTARfE'),
(57, 'Luis Torres', 'luistorres123@gmail.com', 'LuisTorres', 'CUIL22'),
(58, 'Antonio Morales', 'antoniomorales123@gmail.com', 'AntonioMorales', 'ocK4bA'),
(59, 'Salvador Vidal', 'salvadorvidal123@gmail.com', 'SalvadorVidal', '0dD2B1'),
(60, 'Rosa Valle', 'rosavalle123@gmail.com', 'RosaValle', 'U8yQz6'),
(61, 'Lidia Núñez', 'lidianúñez123@gmail.com', 'LidiaNúñez', '4W9fEg'),
(62, 'Carmen Flores', 'carmenflores123@gmail.com', 'CarmenFlores', 'gHr4dA'),
(63, 'Sandra Blanco', 'sandrablanaco123@gmail.com', 'SandraBlanco', '0t2u9g'),
(64, 'Victor Cortés', 'victorcortes123@gmail.com', 'VictorCortes', 'e3pKk5'),
(65, 'Santiago Guerrero', 'santiagoguerrero123@gmail.com', 'SantiagoGuerrero', 'q2FrD7'),
(66, 'Marcos Mendez', 'marcosmendez123@gmail.com', 'MarcosMendez', 'm4ndD3R'),
(67, 'Eugenia Prieto', 'eugeniaprieto123@gmail.com', 'EugeniaPrieto', 'X0k5bM'),
(68, 'Isabel Gómez', 'isabelgomez123@gmail.com', 'IsabelGomez', 'e9w0D8'),
(69, 'Manuel Vargas', 'manuelvargas123@gmail.com', 'ManuelVargas', '7RGt2a'),
(70, 'Antonio Castilla', 'antoniocastilla123@gmail.com', 'AntonioCastilla', 'o7QoJE'),
(71, 'Ximena Paredes', 'ximenaparedes123@gmail.com', 'XimenaParedes', 'pyk5e8'),
(72, 'Nerea Martínez', 'nereamartínez123@gmail.com', 'NereaMartínez', 'uwdCCp'),
(73, 'Emilio Ruiz', 'emilioruiz123@gmail.com', 'EmilioRuiz', 'ugjJ90'),
(74, 'Raquel Muñoz', 'raquelmuñoz123@gmail.com', 'RaquelMuñoz', 'XIswtH'),
(75, 'José Rojas', 'josérojas123@gmail.com', 'JoséRojas', 'QIKTkY'),
(76, 'Sofia Villar', 'sofiavillar123@gmail.com', 'SofiaVillar', 'il7xtq'),
(77, 'Adriana Martínez', 'adrianamartínez123@gmail.com', 'AdrianaMartínez', 'IGl4c8'),
(78, 'Raúl Castilla', 'raúlcastilla123@gmail.com', 'RaúlCastilla', 'NX0tnT'),
(79, 'Sonia Gómez', 'soniagómez123@gmail.com', 'SoniaGómez', 'pJ7qBC'),
(80, 'Felipe Cordero', 'felipecordero123@gmail.com', 'FelipeCordero', 'mCF2Em'),
(81, 'Cecilia Jimenez', 'ceciliajimenez123@gmail.com', 'CeciliaJimenez', 'qqiXc2'),
(82, 'Fátima Santos', 'fátimasantos123@gmail.com', 'FátimaSantos', '3NeEUZ'),
(83, 'Irene Montero', 'irenemontero123@gmail.com', 'IreneMontero', 'D63BBX'),
(84, 'Esteban Fernández', 'estebanfernández123@gmail.com', 'EstebanFernández', 'UuaI0L'),
(85, 'Antonio Santos', 'antoniosantos123@gmail.com', 'AntonioSantos', 'Q5q4KO'),
(86, 'María Jiménez', 'maríajiménez123@gmail.com', 'MaríaJiménez', 'U2BAFz'),
(87, 'Raquel González', 'raquelgonzález123@gmail.com', 'RaquelGonzález', '8RhGAp'),
(88, 'Alberto Hernández', 'albertohernández123@gmail.com', 'AlbertoHernández', 'g1L2pn'),
(89, 'Carlos Cano', 'carloscano123@gmail.com', 'CarlosCano', 'YYeqEj'),
(90, 'Ester Serrano', 'esterserrano123@gmail.com', 'EsterSerrano', 'lTARfE'),
(91, 'Luis Torres', 'luistorres123@gmail.com', 'LuisTorres', 'CUIL22'),
(92, 'Antonio Morales', 'antoniomorales123@gmail.com', 'AntonioMorales', 'ocK4bA'),
(93, 'Raúl Martín', 'raulmartin123@gmail.com', 'RaulMartin', 'Nm4wPi'),
(94, 'Julian Ortega', 'julianortega123@gmail.com', 'JulianOrtega', '6V7qPl'),
(95, 'Rocío Díaz', 'rociodiaz123@gmail.com', 'RocioDiaz', '0w2vCo'),
(96, 'David Perez', 'davidperez123@gmail.com', 'DavidPerez', '123456'),
(97, 'Carlo Condori', 'carloscondori123@gmail.com', 'CarloCondori', '123456'),
(98, 'Carlo Perez ', 'carlosperez125@gmail.com', 'carlosperez', '123456'),
(99, 'Carlos Ruiz', 'carlosruiz1123@gmail.com', 'carlosruiz', '20121021'),
(100, 'Juan Ruiz', 'juanruiz123@gmail.com', 'juanruiz', '20121021'),
(101, 'Jose Ruiz', 'joseruiz123@gmail.com', 'joseruiz', '20121021'),
(102, 'Carlos Gomez', 'carlosgomez123@gmail.com', 'carlosg12', '123456'),
(103, 'Jose Condori', 'josecondori123@gmail.com', 'josecondori12', '20121021'),
(104, 'Jose Palomino', 'josepalomino123@gmail.com', 'josepalo123', '20121021'),
(105, 'Luis Palomino', 'luipalomino123@gmail.com', 'PalominLuis', '20121021'),
(106, 'Jose Meza', 'josemeza123@gmail.com', 'josemeza123', '20121021'),
(107, 'Caelos Meza', 'carlosmeza123@gmail.com', 'carlosmeza123', '20121021'),
(108, 'Luisa Meza', 'luisameza123@gmail.com', 'luizameza12', '20121021'),
(109, 'Luisa Cueva', 'luisacueva123@gmail.com', 'luisacueva21', '20121021'),
(110, 'Luisa Perez', 'luisaperez123@gmail.com', 'luisaperez21', '20121021'),
(111, 'Luisa Prado', 'luisaprado123@gmail.com', 'luisaprado21', '20121021'),
(112, 'Luisa Prado lui', 'luisapra12do123@gmail.com', 'luisaprado212', '123456');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `videos`
--

CREATE TABLE `videos` (
  `id` int NOT NULL,
  `titulo` varchar(255) COLLATE utf8mb3_spanish_ci NOT NULL,
  `url` varchar(255) COLLATE utf8mb3_spanish_ci NOT NULL,
  `descripcion` text COLLATE utf8mb3_spanish_ci,
  `fecha_publicacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

--
-- Volcado de datos para la tabla `videos`
--

INSERT INTO `videos` (`id`, `titulo`, `url`, `descripcion`, `fecha_publicacion`) VALUES
(1, 'La Célula: Introducción a la Célula', 'https://www.youtube.com/embed/_ejQaAsna3k', 'Este video proporciona una introducción básica a la célula y su estructura.', '2025-05-05 04:36:21'),
(2, 'Ecosistemas: Interacciones Ecológicas', 'https://www.youtube.com/watch?v=MLcHCEnBKmo', 'Un análisis detallado de los ecosistemas y cómo las especies interactúan entre sí.', '2025-05-07 02:47:30'),
(3, 'Genética: Principios Básicos', 'https://www.youtube.com/watch?v=MLcHCEnBKmo', 'Introducción a la genética y la herencia de los caracteres genéticos.', '2025-05-07 02:47:30'),
(4, 'La Tabla Periódica: Un Viaje a la Química', 'https://www.youtube.com/watch?v=MLcHCEnBKmo', 'Un recorrido por la tabla periódica y cómo organizar los elementos químicos.', '2025-05-07 02:47:30'),
(5, 'Reacciones Químicas: Tipos y Ejemplos', 'https://www.youtube.com/watch?v=MLcHCEnBKmo', 'Tipos de reacciones químicas con ejemplos prácticos de su ocurrencia.', '2025-05-07 02:47:30'),
(6, 'Electricidad: Fundamentos y Leyes', 'https://www.youtube.com/watch?v=MLcHCEnBKmo', 'Explicación sobre los principios de la electricidad y sus aplicaciones.', '2025-05-07 02:47:30'),
(7, 'Mecánica: Leyes del Movimiento de Newton', 'https://www.youtube.com/watch?v=MLcHCEnBKmo', 'Estudio de las leyes del movimiento de Newton en la física clásica.', '2025-05-07 02:47:30'),
(8, 'Fotosíntesis: El Proceso Vital de las Plantas', 'https://www.youtube.com/watch?v=MLcHCEnBKmo', 'Descubre cómo las plantas convierten la luz solar en energía a través de la fotosíntesis.', '2025-05-07 02:47:30'),
(9, 'Ácidos y Bases: Química Básica', 'https://www.youtube.com/watch?v=MLcHCEnBKmo', 'Una introducción a los conceptos de ácidos y bases en química.', '2025-05-07 02:47:30'),
(10, 'Termodinámica: Principios y Aplicaciones', 'https://www.youtube.com/watch?v=MLcHCEnBKmo', 'Entiende los principios de la termodinámica y sus aplicaciones en la ciencia.', '2025-05-07 02:47:30');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `calificaciones`
--
ALTER TABLE `calificaciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_usuario` (`usuario_id`),
  ADD KEY `fk_contenido` (`contenido_id`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `estudiante_id` (`estudiante_id`),
  ADD KEY `tema_id` (`tema_id`);

--
-- Indices de la tabla `contenidos`
--
ALTER TABLE `contenidos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `temas`
--
ALTER TABLE `temas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categoria_id` (`categoria_id`);

--
-- Indices de la tabla `textos`
--
ALTER TABLE `textos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `videos`
--
ALTER TABLE `videos`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `calificaciones`
--
ALTER TABLE `calificaciones`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `contenidos`
--
ALTER TABLE `contenidos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `temas`
--
ALTER TABLE `temas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `textos`
--
ALTER TABLE `textos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=113;

--
-- AUTO_INCREMENT de la tabla `videos`
--
ALTER TABLE `videos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `calificaciones`
--
ALTER TABLE `calificaciones`
  ADD CONSTRAINT `fk_contenido` FOREIGN KEY (`contenido_id`) REFERENCES `contenidos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD CONSTRAINT `comentarios_ibfk_1` FOREIGN KEY (`estudiante_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comentarios_ibfk_2` FOREIGN KEY (`tema_id`) REFERENCES `temas` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `temas`
--
ALTER TABLE `temas`
  ADD CONSTRAINT `temas_ibfk_1` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
