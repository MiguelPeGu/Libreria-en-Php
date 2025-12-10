-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Servidor: db:3306
-- Tiempo de generación: 10-12-2025 a las 13:18:57
-- Versión del servidor: 8.0.44
-- Versión de PHP: 8.3.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `my_application_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `DETALLES_FACTURA`
--

CREATE TABLE `DETALLES_FACTURA` (
                                    `idDetalle` int NOT NULL,
                                    `idFactura` varchar(30) NOT NULL,
                                    `idLibro` int NOT NULL,
                                    `cantidad` int NOT NULL,
                                    `precioUd` float(10,2) NOT NULL,
  `subtotal` float(10,2) NOT NULL,
  `iva` float(10,2) NOT NULL,
  `totalLinea` float(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `DETALLES_FACTURA`
--

INSERT INTO `DETALLES_FACTURA` (`idDetalle`, `idFactura`, `idLibro`, `cantidad`, `precioUd`, `subtotal`, `iva`, `totalLinea`) VALUES
                                                                                                                                  (11, '175139001215202', 5, 8, 14.95, 119.60, 25.12, 144.72),
                                                                                                                                  (12, '175139001215202', 6, 5, 18.95, 94.75, 19.90, 114.65),
                                                                                                                                  (13, '175139001215202', 5, 8, 14.95, 119.60, 25.12, 144.72),
                                                                                                                                  (14, '175139001215202', 5, 8, 14.95, 119.60, 25.12, 144.72),
                                                                                                                                  (15, '175139001215202', 5, 8, 14.95, 119.60, 25.12, 144.72),
                                                                                                                                  (16, '175139001215202', 5, 8, 14.95, 119.60, 25.12, 144.72),
                                                                                                                                  (17, '175139001215202', 5, 8, 14.95, 119.60, 25.12, 144.72),
                                                                                                                                  (18, '175139001215202', 5, 8, 14.95, 119.60, 25.12, 144.72),
                                                                                                                                  (19, '175139001215202', 5, 8, 14.95, 119.60, 25.12, 144.72),
                                                                                                                                  (20, '175139001215202', 6, 5, 18.95, 94.75, 19.90, 114.65),
                                                                                                                                  (21, '175139001215202', 6, 5, 18.95, 94.75, 19.90, 114.65),
                                                                                                                                  (22, '175139001215202', 6, 5, 18.95, 94.75, 19.90, 114.65),
                                                                                                                                  (23, '175139001215202', 6, 5, 18.95, 94.75, 19.90, 114.65),
                                                                                                                                  (24, '175139001215202', 19, 5, 22.50, 112.50, 23.62, 136.12),
                                                                                                                                  (25, '175139001215202', 19, 5, 22.50, 112.50, 23.62, 136.12),
                                                                                                                                  (26, '175139001215202', 19, 5, 22.50, 112.50, 23.62, 136.12),
                                                                                                                                  (27, '175139001215202', 19, 5, 22.50, 112.50, 23.62, 136.12),
                                                                                                                                  (28, '175139001215202', 19, 5, 22.50, 112.50, 23.62, 136.12),
                                                                                                                                  (29, '175139001215202', 7, 5, 15.50, 77.50, 16.27, 93.78),
                                                                                                                                  (30, '175139001215202', 7, 5, 15.50, 77.50, 16.27, 93.78),
                                                                                                                                  (31, '175139001215202', 7, 5, 15.50, 77.50, 16.27, 93.78),
                                                                                                                                  (32, '175139001215202', 7, 5, 15.50, 77.50, 16.27, 93.78),
                                                                                                                                  (33, '175139001215202', 7, 5, 15.50, 77.50, 16.27, 93.78),
                                                                                                                                  (34, '175139001215202', 26, 4, 19.95, 79.80, 16.76, 96.56),
                                                                                                                                  (35, '175139001215202', 26, 4, 19.95, 79.80, 16.76, 96.56),
                                                                                                                                  (36, '175139001215202', 26, 4, 19.95, 79.80, 16.76, 96.56),
                                                                                                                                  (37, '175139001215202', 26, 4, 19.95, 79.80, 16.76, 96.56),
                                                                                                                                  (38, '145839001215202', 4, 1, 17.95, 17.95, 3.77, 21.72),
                                                                                                                                  (39, '145839001215202', 6, 3, 18.95, 56.85, 11.94, 68.79),
                                                                                                                                  (40, '145839001215202', 1, 5, 13.95, 69.75, 14.65, 84.40),
                                                                                                                                  (41, '145839001215202', 7, 6, 15.50, 93.00, 19.53, 112.53),
                                                                                                                                  (42, '145839001215202', 13, 4, 13.95, 55.80, 11.72, 67.52),
                                                                                                                                  (43, '145839001215202', 11, 1, 23.95, 23.95, 5.03, 28.98),
                                                                                                                                  (44, '145839001215202', 10, 1, 22.50, 22.50, 4.72, 27.23),
                                                                                                                                  (45, '145839001215202', 8, 1, 20.50, 20.50, 4.30, 24.80),
                                                                                                                                  (46, '145839001215202', 18, 1, 11.95, 11.95, 2.51, 14.46),
                                                                                                                                  (47, '145839001215202', 9, 1, 21.00, 21.00, 4.41, 25.41),
                                                                                                                                  (48, '145839001215202', 6, 3, 18.95, 56.85, 11.94, 68.79),
                                                                                                                                  (49, '145839001215202', 6, 3, 18.95, 56.85, 11.94, 68.79),
                                                                                                                                  (50, '145839001215202', 1, 5, 13.95, 69.75, 14.65, 84.40),
                                                                                                                                  (51, '145839001215202', 1, 5, 13.95, 69.75, 14.65, 84.40),
                                                                                                                                  (52, '145839001215202', 1, 5, 13.95, 69.75, 14.65, 84.40),
                                                                                                                                  (53, '145839001215202', 7, 6, 15.50, 93.00, 19.53, 112.53),
                                                                                                                                  (54, '145839001215202', 13, 4, 13.95, 55.80, 11.72, 67.52),
                                                                                                                                  (55, '145839001215202', 7, 6, 15.50, 93.00, 19.53, 112.53),
                                                                                                                                  (56, '145839001215202', 13, 4, 13.95, 55.80, 11.72, 67.52),
                                                                                                                                  (57, '145839001215202', 7, 6, 15.50, 93.00, 19.53, 112.53),
                                                                                                                                  (58, '145839001215202', 13, 4, 13.95, 55.80, 11.72, 67.52),
                                                                                                                                  (59, '145839001215202', 7, 6, 15.50, 93.00, 19.53, 112.53),
                                                                                                                                  (60, '145839001215202', 1, 5, 13.95, 69.75, 14.65, 84.40),
                                                                                                                                  (61, '145839001215202', 7, 6, 15.50, 93.00, 19.53, 112.53),
                                                                                                                                  (62, '163811101215202', 4, 2, 17.95, 35.90, 7.54, 43.44),
                                                                                                                                  (63, '163811101215202', 4, 2, 17.95, 35.90, 7.54, 43.44),
                                                                                                                                  (64, '152431101215202', 19, 1, 22.50, 22.50, 4.72, 27.23),
                                                                                                                                  (65, '104931101215202', 26, 1, 19.95, 19.95, 4.19, 24.14),
                                                                                                                                  (67, '185852101215202', 6, 1, 18.95, 18.95, 3.98, 22.93),
                                                                                                                                  (68, '134203101215202', 13, 4, 13.95, 55.80, 11.72, 67.52),
                                                                                                                                  (69, '134203101215202', 13, 4, 13.95, 55.80, 11.72, 67.52),
                                                                                                                                  (70, '134203101215202', 13, 4, 13.95, 55.80, 11.72, 67.52),
                                                                                                                                  (71, '134203101215202', 13, 4, 13.95, 55.80, 11.72, 67.52),
                                                                                                                                  (72, '121413101215202', 19, 1, 22.50, 22.50, 4.72, 27.23);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `FACTURAS`
--

CREATE TABLE `FACTURAS` (
                            `idFactura` varchar(30) NOT NULL,
                            `idUsuario` int NOT NULL,
                            `fecha` datetime NOT NULL,
                            `dni` varchar(15) NOT NULL,
                            `nombre` varchar(100) NOT NULL,
                            `apellidos` varchar(150) NOT NULL,
                            `telefono` varchar(20) NOT NULL,
                            `direccion` varchar(255) NOT NULL,
                            `cp` int NOT NULL,
                            `localidad` varchar(100) NOT NULL,
                            `total` float(10,2) NOT NULL,
  `metodoPago` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `FACTURAS`
--

INSERT INTO `FACTURAS` (`idFactura`, `idUsuario`, `fecha`, `dni`, `nombre`, `apellidos`, `telefono`, `direccion`, `cp`, `localidad`, `total`, `metodoPago`) VALUES
                                                                                                                                                                ('104931101215202', 1, '2025-12-10 11:39:40', '77494608H', 'Miguel', 'Perez Gutierrez', '62318646', 'C Luis MV', 29130, 'Madrid', 24.14, 'Transferencia'),
                                                                                                                                                                ('121413101215202', 1, '2025-12-10 13:14:12', '77494608H', 'Miguel', 'Perez Gutierrez', '62318646', 'C Luis MV', 29130, 'Madrid', 27.23, 'Efectivo'),
                                                                                                                                                                ('134203101215202', 1, '2025-12-10 13:02:43', '77494608H', 'daw', 'dwa', '62318646', 'dawwda', 23232, 'Barcelona', 270.07, 'Tarjeta'),
                                                                                                                                                                ('145839001215202', 1, '2025-12-10 09:38:54', '77494608H', 'Miguel', 'Perez Gutierrez', '62318646', 'C Luis MV', 29130, 'Barcelona', 1716.20, 'Efectivo'),
                                                                                                                                                                ('152431101215202', 1, '2025-12-10 11:34:25', '77494608H', 'Miguel', 'Perez Gutierrez', '62318646', 'C Luis MV', 29130, 'Valencia', 27.23, 'Transferencia'),
                                                                                                                                                                ('163811101215202', 1, '2025-12-10 11:18:36', '77494608H', 'Miguel', 'Perez Gutierrez', '62318646', 'C Luis MV', 29130, 'Barcelona', 86.88, 'Tarjeta'),
                                                                                                                                                                ('175139001215202', 1, '2025-12-10 09:31:57', '77494608H', 'Miguel', 'Perez Gutierrez', '62318646', 'C Luis MV', 29130, 'Barcelona', 3266.70, 'Efectivo'),
                                                                                                                                                                ('185852101215202', 1, '2025-12-10 12:58:58', '77494608H', 'Miguel', 'Perez Gutierrez', '62318646', 'C Luis MV', 29130, 'Barcelona', 22.93, 'Tarjeta');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `LIBROS`
--

CREATE TABLE `LIBROS` (
                          `id` int NOT NULL,
                          `isbn` varchar(20) NOT NULL,
                          `img` varchar(255) DEFAULT NULL,
                          `titulo` varchar(255) DEFAULT NULL,
                          `autor` varchar(255) DEFAULT NULL,
                          `precio` float(10,2) DEFAULT NULL,
  `iva` float(5,2) DEFAULT NULL,
  `stock` int DEFAULT NULL,
  `stock_lim` int DEFAULT NULL,
  `descripcion` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `LIBROS`
--

INSERT INTO `LIBROS` (`id`, `isbn`, `img`, `titulo`, `autor`, `precio`, `iva`, `stock`, `stock_lim`, `descripcion`) VALUES
                                                                                                                        (1, '9780061120084', 'img/libro16.jpg', 'Matar a un ruiseñor', 'Harper Lee', 13.95, 21.00, 0, 4, 'Una niña y su padre, un abogado, enfrentan el racismo y la injusticia en el sur de los EE. UU. en esta historia profunda sobre la moral y la humanidad.'),
                                                                                                                        (2, '9780307389732', 'img/libro20.jpg', 'El amor en los tiempos del cólera', 'Gabriel García Márquez', 15.95, 21.00, 33, 5, 'Un amor que desafía el tiempo, la enfermedad y la muerte. La historia de Fermina y Florentino, dos almas que esperan más de medio siglo para reunirse.'),
                                                                                                                        (3, '9780307474278', 'img/libro7.jpg', 'El niño con el pijama de rayas', 'John Boyne', 14.50, 21.00, 44, 7, 'Una conmovedora historia de amistad en tiempos de la Segunda Guerra Mundial. Un niño alemán entabla una amistad impensable con un prisionero judío en un campo de concentración.'),
                                                                                                                        (4, '9780307474279', 'img/libro22.jpg', 'Ángeles y demonios', 'Dan Brown', 17.95, 21.00, 36, 5, 'El profesor Robert Langdon se adentra en un mundo de intriga y secretos en el Vaticano, donde una organización secreta planea un atentado.'),
                                                                                                                        (5, '9780307476463', 'img/libro14.jpg', 'Los juegos del hambre', 'Suzanne Collins', 14.95, 21.00, 54, 6, 'En un futuro distópico, Katniss Everdeen lucha por su vida en un cruel juego de supervivencia. La rebelión y la justicia se convierten en sus armas.'),
                                                                                                                        (6, '9780307743657', 'img/libro18.jpg', 'El resplandor', 'Stephen King', 18.95, 21.00, 27, 6, 'Jack Torrance se convierte en el cuidador de un hotel aislado, donde las fuerzas oscuras se apoderan de él y de su familia.'),
                                                                                                                        (7, '9780439023511', 'img/libro15.jpg', 'En llamas', 'Suzanne Collins', 15.50, 21.00, 45, 5, 'Katniss regresa al juego, pero ahora la lucha por la supervivencia será más compleja. El Capitolio ya no es su único enemigo.'),
                                                                                                                        (8, '9780439064873', 'img/libro2.jpg', 'Harry Potter y la cámara secreta', 'J. K. Rowling', 20.50, 21.00, 46, 8, 'Harry Potter regresa a Hogwarts para enfrentar el misterio de una cámara secreta. Un peligro acecha en la escuela y nuevos secretos salen a la luz. Magia, valentía y un nuevo desafío aguardan a Harry.'),
                                                                                                                        (9, '9780439136365', 'img/libro3.jpg', 'Harry Potter y el prisionero de Azkaban', 'J. K. Rowling', 21.00, 21.00, 34, 7, 'Harry descubre que un prisionero peligroso ha escapado de Azkaban. En su tercer año en Hogwarts, se enfrentará a enemigos en la sombra y revelará oscuros secretos de su propio pasado.'),
                                                                                                                        (10, '9780439139601', 'img/libro4.jpg', 'Harry Potter y el cáliz de fuego', 'J. K. Rowling', 22.50, 21.00, 41, 4, 'Harry participa en el Torneo de los Tres Magos, un desafío lleno de pruebas mortales. Mientras el peligro crece, descubre que la sombra de Lord Voldemort sigue acechando.'),
                                                                                                                        (11, '9780439358071', 'img/libro5.jpg', 'Harry Potter y la Orden del Fénix', 'J. K. Rowling', 23.95, 21.00, 37, 6, 'Harry se enfrenta a nuevos desafíos dentro y fuera de Hogwarts. En un mundo en guerra, la Orden del Fénix se forma para luchar contra el regreso de Voldemort.'),
                                                                                                                        (12, '9780439554930', 'img/libro1.jpg', 'Harry Potter y la piedra filosofal', 'J. K. Rowling', 19.95, 21.00, 62, 5, 'Un joven huérfano descubre que es un mago. En su primer año en Hogwarts, debe enfrentarse a misterios que cambiarán su vida para siempre. La magia, la amistad y el coraje son los pilares de esta historia.'),
                                                                                                                        (13, '9780451524935', 'img/libro11.jpg', '1984', 'George Orwell', 13.95, 21.00, 62, 5, 'Un totalitario gobierno controla todos los aspectos de la vida en una sociedad opresiva. Winston Smith lucha contra la vigilancia constante y la manipulación de la verdad.'),
                                                                                                                        (14, '9780451526342', 'img/libro27.jpg', 'Rebelión en la granja', 'George Orwell', 8.95, 21.00, 75, 4, 'Una fábula satírica que critica la corrupción del poder, donde los animales de una granja se rebelan contra los humanos, solo para enfrentar una nueva tiranía.'),
                                                                                                                        (15, '9780553573404', 'img/libro23.jpg', 'Juego de tronos', 'George R. R. Martin', 19.95, 21.00, 50, 5, 'En un mundo medieval lleno de intriga y traiciones, las familias nobles luchan por el control del Trono de Hierro. Una saga épica de poder y guerra.'),
                                                                                                                        (16, '9780553579901', 'img/libro24.jpg', 'Choque de reyes', 'George R. R. Martin', 19.95, 21.00, 50, 5, 'La lucha por el poder se intensifica mientras los reinos se desmoronan y las fuerzas oscuras acechan. El destino de los Siete Reinos está en juego.'),
                                                                                                                        (17, '9780553582017', 'img/libro25.jpg', 'Tormenta de espadas', 'George R. R. Martin', 22.95, 21.00, 41, 6, 'Las batallas por el trono se intensifican mientras nuevos enemigos surgen en los Siete Reinos. La violencia y la intriga alcanzan nuevos niveles.'),
                                                                                                                        (18, '9780679783275', 'img/libro8.jpg', 'Orgullo y prejuicio', 'Jane Austen', 11.95, 21.00, 59, 5, 'Elizabeth Bennet y el orgulloso Sr. Darcy viven una historia de amor marcada por prejuicios y malentendidos. Una obra maestra sobre la sociedad inglesa del siglo XIX.'),
                                                                                                                        (19, '9781501128035', 'img/libro17.jpg', 'It', 'Stephen King', 22.50, 21.00, 18, 5, 'Un grupo de niños enfrenta sus miedos y a un monstruo aterrador que acecha su ciudad. Una obra maestra del horror psicológico.'),
                                                                                                                        (20, '9781982137274', 'img/libro21.jpg', 'El código Da Vinci', 'Dan Brown', 18.95, 21.00, 45, 4, 'Robert Langdon, un experto en simbología, se ve envuelto en una conspiración que involucra el misterio de la Mona Lisa y secretos antiguos.'),
                                                                                                                        (21, '9783161484100', 'img/libro6.jpg', 'El principito', 'Antoine de Saint-Exupéry', 12.95, 21.00, 55, 5, 'El Principito es una reflexión profunda sobre la vida y la naturaleza humana. Un niño que viaja de planeta en planeta, busca respuestas sobre el amor, la amistad y el propósito de la vida.'),
                                                                                                                        (22, '9788490628621', 'img/libro26.jpg', 'Los pilares de la tierra', 'Ken Follett', 19.95, 21.00, 36, 5, 'Un drama medieval que narra la construcción de una catedral en el siglo XII. A través de intrigas, traiciones y amores, el destino de varias familias se cruza.'),
                                                                                                                        (23, '9788497592208', 'img/libro9.jpg', 'La sombra del viento', 'Carlos Ruiz Zafón', 18.50, 21.00, 33, 4, 'En la Barcelona de la posguerra, un joven encuentra un libro misterioso que lo llevará a descubrir secretos oscuros y una historia de amor trágica.'),
                                                                                                                        (24, '9788497593793', 'img/libro10.jpg', 'El juego del ángel', 'Carlos Ruiz Zafón', 18.95, 21.00, 29, 6, 'Un escritor joven se ve envuelto en una trama de intriga y oscuridad, donde los libros y el destino se entrelazan en un juego peligroso.'),
                                                                                                                        (25, '9788497594258', 'img/libro28.jpg', 'La chica del tren', 'Paula Hawkins', 14.95, 21.00, 50, 6, 'Una historia de misterio y suspense narrada desde tres perspectivas. Un thriller psicológico sobre obsesión, engaños y secretos oscuros.'),
                                                                                                                        (26, '9788498381498', 'img/libro12.jpg', 'El nombre del viento', 'Patrick Rothfuss', 19.95, 21.00, 41, 8, 'Kvothe, un hombre legendario, cuenta su historia de magia, aventura y amor. Un viaje épico que explora el misterio y la música de la vida.'),
                                                                                                                        (27, '9788498383621', 'img/libro13.jpg', 'El temor de un hombre sabio', 'Patrick Rothfuss', 22.95, 21.00, 35, 4, 'En esta secuela, Kvothe sigue su búsqueda de conocimiento y poder, enfrentándose a peligros y desafíos que pondrán a prueba su destino.'),
                                                                                                                        (28, '9789588886452', 'img/libro19.jpg', 'Cien años de soledad', 'Gabriel García Márquez', 16.95, 21.00, 40, 7, 'Una saga familiar que abarca generaciones. Realismo mágico y una historia de amor y tragedia que atraviesa todo un pueblo.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `USERS`
--

CREATE TABLE `USERS` (
                         `id` int NOT NULL,
                         `usuario` varchar(100) NOT NULL,
                         `passwd` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `USERS`
--

INSERT INTO `USERS` (`id`, `usuario`, `passwd`) VALUES
    (1, 'miguel', '202cb962ac59075b964b07152d234b70');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `DETALLES_FACTURA`
--
ALTER TABLE `DETALLES_FACTURA`
    ADD PRIMARY KEY (`idDetalle`);

--
-- Indices de la tabla `FACTURAS`
--
ALTER TABLE `FACTURAS`
    ADD PRIMARY KEY (`idFactura`);

--
-- Indices de la tabla `LIBROS`
--
ALTER TABLE `LIBROS`
    ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `USERS`
--
ALTER TABLE `USERS`
    ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuario` (`usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `DETALLES_FACTURA`
--
ALTER TABLE `DETALLES_FACTURA`
    MODIFY `idDetalle` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT de la tabla `LIBROS`
--
ALTER TABLE `LIBROS`
    MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de la tabla `USERS`
--
ALTER TABLE `USERS`
    MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;