-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 05-08-2025 a las 21:41:09
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `tiendaonline`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administrador`
--

CREATE TABLE `administrador` (
  `idUsuario` int(11) NOT NULL,
  `nombreAdm` varchar(45) DEFAULT NULL,
  `permisos` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `administrador`
--

INSERT INTO `administrador` (`idUsuario`, `nombreAdm`, `permisos`) VALUES
(2, 'sebastian', 'total');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carritocompras`
--

CREATE TABLE `carritocompras` (
  `idCarrito` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `estado` varchar(45) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `carritocompras`
--

INSERT INTO `carritocompras` (`idCarrito`, `idUsuario`, `estado`, `cantidad`) VALUES
(1, 1, 'activo', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carritoproducto`
--

CREATE TABLE `carritoproducto` (
  `idProducto` int(11) NOT NULL,
  `idCarrito` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `idCategoria` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `fechaCreacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`idCategoria`, `nombre`, `descripcion`, `fechaCreacion`) VALUES
(1, 'Verduras y Hortalizas', 'Productos frescos de origen vegetal', '2025-08-04 22:29:54'),
(2, 'Frutas', 'Frutas frescas y naturales', '2025-08-04 22:29:54'),
(3, 'Carnes y Pescados', 'Productos cárnicos y pescados frescos', '2025-08-04 22:29:54'),
(4, 'Lácteos', 'Leche, queso, yogurt y derivados', '2025-08-04 22:29:54'),
(5, 'Panadería', 'Pan, pasteles y productos horneados', '2025-08-04 22:29:54'),
(6, 'Licores y Bebidas Alcohólicas', 'Vinos, cervezas y licores', '2025-08-04 22:29:54'),
(7, 'Bebidas', 'Refrescos, jugos y bebidas no alcohólicas', '2025-08-04 22:29:54'),
(8, 'Productos de Limpieza', 'Detergentes, desinfectantes y limpiadores', '2025-08-04 22:29:54'),
(9, 'Productos de Higiene Personal', 'Jabones, champús y productos de cuidado', '2025-08-04 22:29:54'),
(10, 'Snacks y Golosinas', 'Papas, dulces y snacks', '2025-08-04 22:29:54'),
(11, 'Conservas', 'Productos enlatados y conservados', '2025-08-04 22:29:54'),
(12, 'Condimentos y Especias', 'Salsas, condimentos y especias', '2025-08-04 22:29:54'),
(13, 'Granos y Cereales', 'Arroz, frijoles, avena y cereales', '2025-08-04 22:29:54'),
(14, 'Congelados', 'Productos congelados y helados', '2025-08-04 22:29:54'),
(15, 'Dulces y Mermeladas', 'Mermeladas, jaleas y productos dulces', '2025-08-04 22:29:54');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `idUsuario` int(11) NOT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  `direccion` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `datosEnvio` varchar(100) DEFAULT NULL,
  `aliasTarjeta` varchar(45) DEFAULT NULL,
  `saldoTarjeta` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`idUsuario`, `nombre`, `direccion`, `email`, `datosEnvio`, `aliasTarjeta`, `saldoTarjeta`) VALUES
(1, 'Juan Pérez', 'Calle 123', 'juan@email.com', 'Entrega rápida', 'Visa Juan', 50000.00),
(2, 'sebastian', 'administrador central', 'admin@admin.com', NULL, NULL, NULL),
(3, 'sebas', 'santuario', 'araton51103@gmail.com', NULL, NULL, NULL),
(5, 'juan david mendivelso', 'colombia', 'juandavid@usuario.com', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detallepedido`
--

CREATE TABLE `detallepedido` (
  `idPedido` int(11) NOT NULL,
  `idProducto` int(11) NOT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `costoUnitario` decimal(10,2) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detallepedido`
--

INSERT INTO `detallepedido` (`idPedido`, `idProducto`, `cantidad`, `costoUnitario`, `total`) VALUES
(2, 17, 2, 4000.00, 8000.00),
(2, 18, 1, 3000.00, 3000.00),
(3, 17, 2, 4000.00, 8000.00),
(3, 18, 1, 3000.00, 3000.00),
(4, 21, 1, 15000.00, 15000.00),
(4, 22, 1, 5000.00, 5000.00),
(4, 23, 1, 3000.00, 3000.00),
(5, 17, 2, 4000.00, 8000.00),
(5, 18, 1, 3000.00, 3000.00),
(6, 21, 1, 15000.00, 15000.00),
(6, 22, 1, 5000.00, 5000.00),
(6, 23, 1, 3000.00, 3000.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `informacionenvio`
--

CREATE TABLE `informacionenvio` (
  `idEnvio` int(11) NOT NULL,
  `idPedido` int(11) NOT NULL,
  `tipo` varchar(45) DEFAULT NULL,
  `costo` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `informacionenvio`
--

INSERT INTO `informacionenvio` (`idEnvio`, `idPedido`, `tipo`, `costo`) VALUES
(1, 1, 'Domicilio', 5000.00),
(2, 2, 'Domicilio', 5000.00),
(3, 3, 'Domicilio', 5000.00),
(4, 4, 'Domicilio', 5000.00),
(5, 5, 'Domicilio', 5000.00),
(6, 6, 'Domicilio', 5000.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pago`
--

CREATE TABLE `pago` (
  `idPedido` int(11) NOT NULL,
  `metodoPago` varchar(45) DEFAULT NULL,
  `totalPagado` decimal(10,2) DEFAULT NULL,
  `estado` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pago`
--

INSERT INTO `pago` (`idPedido`, `metodoPago`, `totalPagado`, `estado`) VALUES
(1, 'Efectivo', 0.00, 'pendiente'),
(2, 'Efectivo', 11000.00, 'pendiente'),
(3, 'Efectivo', 11000.00, 'pendiente'),
(4, 'Nequi / Daviplata', 23000.00, 'pendiente'),
(5, 'Efectivo', 11000.00, 'pendiente'),
(6, 'Nequi / Daviplata', 23000.00, 'pendiente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido`
--

CREATE TABLE `pedido` (
  `idPedido` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `fechaPedido` date DEFAULT NULL,
  `fechaEnvio` date DEFAULT NULL,
  `estado` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedido`
--

INSERT INTO `pedido` (`idPedido`, `idUsuario`, `fechaPedido`, `fechaEnvio`, `estado`) VALUES
(1, 1, '2025-08-05', NULL, 'pendiente'),
(2, 1, '2025-08-05', NULL, 'pendiente'),
(3, 1, '2025-08-05', NULL, 'pendiente'),
(4, 5, '2025-08-05', NULL, 'pendiente'),
(5, 1, '2025-08-05', NULL, 'pendiente'),
(6, 5, '2025-08-05', NULL, 'pendiente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `idProducto` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `stock` int(45) DEFAULT NULL,
  `categoria` varchar(45) DEFAULT NULL,
  `imagen` varchar(250) DEFAULT NULL,
  `idCategoria` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`idProducto`, `nombre`, `precio`, `descripcion`, `stock`, `categoria`, `imagen`, `idCategoria`) VALUES
(17, 'leche', 4000.00, NULL, 10, NULL, 'imagenes/68913da4221b6.png', 4),
(18, 'arroz', 3000.00, NULL, 50, NULL, 'imagenes/68913debbea04.png', 13),
(19, 'avena', 5000.00, NULL, 20, NULL, 'imagenes/68913e1b47678.png', 13),
(20, 'queso', 6000.00, NULL, 50, NULL, 'imagenes/68913f3cbadd0.png', 4),
(21, 'salchichas', 15000.00, NULL, 60, NULL, 'imagenes/68913f5e109df.png', 3),
(22, 'jabon de baño', 5000.00, NULL, 15, NULL, 'imagenes/68913f7f5bfde.png', 9),
(23, 'manzana', 3000.00, NULL, 10, NULL, 'imagenes/68913f9e0c917.png', 2),
(24, 'frijol', 9000.00, NULL, 60, NULL, 'imagenes/68913fba06dc1.png', 13),
(25, 'pan bagget', 5000.00, NULL, 15, NULL, 'imagenes/6891401795e83.png', 5),
(26, 'costillas', 30000.00, NULL, 50, NULL, 'imagenes/689256c8ec2eb.png', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `idUsuario` int(11) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `contrasena` varchar(45) NOT NULL,
  `estadoSesion` tinyint(4) DEFAULT 0,
  `fechaRegistro` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`idUsuario`, `correo`, `contrasena`, `estadoSesion`, `fechaRegistro`) VALUES
(1, '', '1234', 0, '2025-07-20 14:19:59'),
(2, 'admin@admin.com', 'admin123', 0, '2025-07-20 18:11:12'),
(3, '', '1234', 0, '2025-08-02 21:07:21'),
(4, '', 'admin123', 0, '2025-08-03 19:01:14'),
(5, 'juandavid@usuario.com', '123456', 0, '2025-08-04 17:07:36');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `administrador`
--
ALTER TABLE `administrador`
  ADD PRIMARY KEY (`idUsuario`);

--
-- Indices de la tabla `carritocompras`
--
ALTER TABLE `carritocompras`
  ADD PRIMARY KEY (`idCarrito`),
  ADD KEY `idUsuario` (`idUsuario`);

--
-- Indices de la tabla `carritoproducto`
--
ALTER TABLE `carritoproducto`
  ADD PRIMARY KEY (`idProducto`,`idCarrito`),
  ADD KEY `idCarrito` (`idCarrito`);

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`idCategoria`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`idUsuario`);

--
-- Indices de la tabla `detallepedido`
--
ALTER TABLE `detallepedido`
  ADD PRIMARY KEY (`idPedido`,`idProducto`),
  ADD KEY `idProducto` (`idProducto`);

--
-- Indices de la tabla `informacionenvio`
--
ALTER TABLE `informacionenvio`
  ADD PRIMARY KEY (`idEnvio`),
  ADD KEY `idPedido` (`idPedido`);

--
-- Indices de la tabla `pago`
--
ALTER TABLE `pago`
  ADD PRIMARY KEY (`idPedido`);

--
-- Indices de la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD PRIMARY KEY (`idPedido`),
  ADD KEY `idUsuario` (`idUsuario`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`idProducto`),
  ADD KEY `idCategoria` (`idCategoria`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idUsuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `carritocompras`
--
ALTER TABLE `carritocompras`
  MODIFY `idCarrito` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `idCategoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `informacionenvio`
--
ALTER TABLE `informacionenvio`
  MODIFY `idEnvio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `pedido`
--
ALTER TABLE `pedido`
  MODIFY `idPedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `idProducto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `administrador`
--
ALTER TABLE `administrador`
  ADD CONSTRAINT `administrador_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`);

--
-- Filtros para la tabla `carritocompras`
--
ALTER TABLE `carritocompras`
  ADD CONSTRAINT `carritocompras_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`);

--
-- Filtros para la tabla `carritoproducto`
--
ALTER TABLE `carritoproducto`
  ADD CONSTRAINT `carritoproducto_ibfk_1` FOREIGN KEY (`idProducto`) REFERENCES `producto` (`idProducto`),
  ADD CONSTRAINT `carritoproducto_ibfk_2` FOREIGN KEY (`idCarrito`) REFERENCES `carritocompras` (`idCarrito`);

--
-- Filtros para la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD CONSTRAINT `cliente_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`);

--
-- Filtros para la tabla `detallepedido`
--
ALTER TABLE `detallepedido`
  ADD CONSTRAINT `detallepedido_ibfk_1` FOREIGN KEY (`idPedido`) REFERENCES `pedido` (`idPedido`),
  ADD CONSTRAINT `detallepedido_ibfk_2` FOREIGN KEY (`idProducto`) REFERENCES `producto` (`idProducto`);

--
-- Filtros para la tabla `informacionenvio`
--
ALTER TABLE `informacionenvio`
  ADD CONSTRAINT `informacionenvio_ibfk_1` FOREIGN KEY (`idPedido`) REFERENCES `pedido` (`idPedido`);

--
-- Filtros para la tabla `pago`
--
ALTER TABLE `pago`
  ADD CONSTRAINT `pago_ibfk_1` FOREIGN KEY (`idPedido`) REFERENCES `pedido` (`idPedido`);

--
-- Filtros para la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD CONSTRAINT `pedido_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`);

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `producto_ibfk_1` FOREIGN KEY (`idCategoria`) REFERENCES `categoria` (`idCategoria`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
