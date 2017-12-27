-- phpMyAdmin SQL Dump
-- version 2.11.0
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 07-03-2012 a las 13:38:48
-- Versión del servidor: 5.0.45
-- Versión de PHP: 5.2.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Base de datos: `cuentas`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asientos`
--

CREATE TABLE `asientos` (
  `id_asiento` int(10) unsigned NOT NULL auto_increment,
  `id_clienteproveedor` int(10) unsigned NOT NULL,
  `id_empresa` int(10) unsigned NOT NULL,
  `id_usuario` int(10) unsigned NOT NULL,
  `id_cuenta` int(10) unsigned NOT NULL,
  `fecha` date default NULL,
  `detalle` varchar(255) default NULL,
  `tipo_asiento` enum('credito','debito') default NULL,
  `importe` decimal(10,2) default NULL,
  `estado` enum('activo','anulado') default NULL,
  PRIMARY KEY  (`id_asiento`),
  KEY `asientos_FKIndex1` (`id_cuenta`),
  KEY `asientos_FKIndex2` (`id_usuario`),
  KEY `asientos_FKIndex3` (`id_empresa`),
  KEY `asientos_FKIndex4` (`id_clienteproveedor`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `asientos`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientesproveedores`
--

CREATE TABLE `clientesproveedores` (
  `id_clienteproveedor` int(10) unsigned NOT NULL auto_increment,
  `id_empresa` int(10) unsigned NOT NULL,
  `id_cuenta` int(10) unsigned NOT NULL,
  `razon_social` varchar(125) default NULL,
  `tipo` enum('cliente','proveedor') default NULL,
  `cuit` varchar(13) default NULL,
  `direccion` varchar(125) default NULL,
  `telefono` varchar(50) default NULL,
  `estado` enum('activo','inactivo') default NULL,
  PRIMARY KEY  (`id_clienteproveedor`),
  KEY `clientesproveedores_FKIndex1` (`id_cuenta`),
  KEY `clientesproveedores_FKIndex2` (`id_empresa`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Volcar la base de datos para la tabla `clientesproveedores`
--

INSERT INTO `clientesproveedores` (`id_clienteproveedor`, `id_empresa`, `id_cuenta`, `razon_social`, `tipo`, `cuit`, `direccion`, `telefono`, `estado`) VALUES
(1, 2, 95, 'Pachin Peralta', 'cliente', '20-22334443-3', 'Manuel Ocampo', '03756482090', 'activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `configuracion`
--

CREATE TABLE `configuracion` (
  `id_configuracion` int(10) unsigned NOT NULL auto_increment,
  `id_usuario` int(10) unsigned NOT NULL,
  `codigo` varchar(100) default NULL,
  `descripcion` varchar(255) default NULL,
  `numero` decimal(10,2) default NULL,
  `texto` text,
  `fecha` date default NULL,
  PRIMARY KEY  (`id_configuracion`),
  KEY `configuracion_FKIndex1` (`id_usuario`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Volcar la base de datos para la tabla `configuracion`
--

INSERT INTO `configuracion` (`id_configuracion`, `id_usuario`, `codigo`, `descripcion`, `numero`, `texto`, `fecha`) VALUES
(1, 1, '1_cuenta_caja', NULL, 15.00, NULL, NULL),
(2, 1, '1_cuenta_ctacte', NULL, 20.00, NULL, NULL),
(3, 1, '1_cuenta_proveedores', NULL, 34.00, NULL, NULL),
(4, 1, '1_cuenta_deudoresporventa', NULL, 20.00, NULL, NULL),
(5, 1, '2_cuenta_caja', NULL, 62.00, NULL, NULL),
(6, 1, '2_cuenta_ctacte', NULL, 67.00, NULL, NULL),
(7, 1, '2_cuenta_proveedores', NULL, 81.00, NULL, NULL),
(8, 1, '2_cuenta_deudoresporventa', NULL, 67.00, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuentas`
--

CREATE TABLE `cuentas` (
  `id_cuenta` int(10) unsigned NOT NULL auto_increment,
  `id_usuario` int(10) unsigned NOT NULL,
  `id_empresa` int(10) unsigned NOT NULL,
  `id_cuenta_padre` int(10) unsigned default NULL,
  `id_cuenta_contrapartida` int(10) unsigned default NULL,
  `codigo` varchar(255) default NULL,
  `cuenta` varchar(255) default NULL,
  `tipo_cuenta` enum('debito','credito') default NULL,
  PRIMARY KEY  (`id_cuenta`),
  KEY `cuentas_FKIndex1` (`id_empresa`),
  KEY `cuentas_FKIndex2` (`id_usuario`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=96 ;

--
-- Volcar la base de datos para la tabla `cuentas`
--

INSERT INTO `cuentas` (`id_cuenta`, `id_usuario`, `id_empresa`, `id_cuenta_padre`, `id_cuenta_contrapartida`, `codigo`, `cuenta`, `tipo_cuenta`) VALUES
(1, 1, 1, 0, 0, '01', 'Activo', 'debito'),
(2, 1, 1, 0, 0, '02', 'Pasivo', 'credito'),
(3, 1, 1, 0, 0, '03', 'Patrimonio Neto', 'credito'),
(4, 1, 1, 1, 0, '01.01', 'Activo Corriente', 'credito'),
(5, 1, 1, 1, 0, '01.02', 'Activo No Corriente', 'debito'),
(6, 1, 1, 5, 0, '01.02.01', 'Bienes de uso', 'debito'),
(7, 1, 1, 5, 0, '01.02.02', 'Inmuebles', 'debito'),
(8, 1, 1, 5, 0, '01.02.03', 'Muebles y Utiles', 'debito'),
(9, 1, 1, 5, 0, '01.02.04', 'Rodados', 'debito'),
(10, 1, 1, 4, 0, '01.01.01', 'Disponibilidad', 'debito'),
(11, 1, 1, 4, 0, '01.01.02', 'Creditos', 'debito'),
(12, 1, 1, 4, 0, '01.01.03', 'Otros Debitos', 'debito'),
(13, 1, 1, 4, 0, '01.01.04', 'Bienes de cambio', 'debito'),
(14, 1, 1, 4, 0, '01.01.05', 'Inversiones', 'debito'),
(15, 1, 1, 10, 0, '01.01.01.01', 'Caja', 'debito'),
(16, 1, 1, 10, 0, '01.01.01.02', 'Banco Corrientes', 'debito'),
(17, 1, 1, 10, 0, '01.01.01.03', 'Banco Macro', 'debito'),
(18, 1, 1, 10, 0, '01.01.01.04', 'Banco Nacion', 'debito'),
(19, 1, 1, 11, 0, '01.01.02.01', 'Documentos a cobrar', 'debito'),
(20, 1, 1, 11, 0, '01.01.02.02', 'Deudores por ventas', 'debito'),
(21, 1, 1, 11, 0, '01.01.02.03', 'Deudores morosos', 'debito'),
(22, 1, 1, 11, 0, '01.01.02.04', 'Valores a depositar', 'debito'),
(23, 1, 1, 11, 0, '01.01.02.05', 'Anticipo a proveedores', 'debito'),
(24, 1, 1, 12, 0, '01.01.03.01', 'Impuestos a favor', 'debito'),
(25, 1, 1, 13, 0, '01.01.04.01', 'Mercaderias', 'debito'),
(26, 1, 1, 14, 0, '01.01.05.01', 'Plazos fijos', 'debito'),
(27, 1, 1, 14, 0, '01.01.05.02', 'Titulos publicos', 'debito'),
(28, 1, 1, 2, 0, '02.01', 'Pasivo Corriente', 'credito'),
(29, 1, 1, 2, 0, '02.02', 'Pasivo No Corriente', 'credito'),
(30, 1, 1, 28, 0, '02.01.01', 'Deudas comerciales', 'credito'),
(31, 1, 1, 28, 0, '02.01.02', 'Deudas bancarias', 'credito'),
(32, 1, 1, 28, 0, '02.01.03', 'Deudas fiscales', 'credito'),
(33, 1, 1, 28, 0, '02.01.04', 'Deudas Sociales', 'credito'),
(34, 1, 1, 30, 0, '02.01.01.01', 'Proveedores', 'credito'),
(35, 1, 1, 30, 0, '02.01.01.02', 'Deudores por ventas', 'credito'),
(36, 1, 1, 30, 0, '02.01.01.03', 'Anticipos de clientes', 'credito'),
(37, 1, 1, 31, 0, '02.01.02.01', 'Prestamos a pagar', 'credito'),
(38, 1, 1, 32, 0, '02.01.03.01', 'Impuestos y tasas a pagar', 'credito'),
(39, 1, 1, 33, 0, '02.01.04.01', 'Sueldos y Jornales a pagar', 'credito'),
(40, 1, 1, 33, 0, '02.01.04.02', 'Cargas sociales a depositar', 'credito'),
(41, 1, 1, 29, 0, '02.02.01', 'Deudas a Largo Plazo', 'credito'),
(42, 1, 1, 3, 0, '03.01', 'Capital', 'credito'),
(43, 1, 1, 3, 0, '03.02', 'Resultado No Asignado', 'credito'),
(44, 1, 1, 3, 0, '03.03', 'Reserva Legal', 'credito'),
(45, 1, 1, 0, 0, '04', 'Resultado', 'debito'),
(46, 1, 1, 45, 0, '04.01', 'Ganancia', 'debito'),
(47, 1, 1, 45, 0, '04.02', 'Perdidas', 'credito'),
(48, 2, 1, 0, 0, '01', 'Activo', 'debito'),
(49, 1, 2, 0, 0, '02', 'Pasivo', 'credito'),
(50, 1, 2, 0, 0, '03', 'Patrimonio Neto', 'credito'),
(51, 1, 2, 1, 0, '01.01', 'Activo Corriente', 'credito'),
(52, 1, 2, 1, 0, '01.02', 'Activo No Corriente', 'debito'),
(53, 1, 2, 5, 0, '01.02.01', 'Bienes de uso', 'debito'),
(54, 1, 2, 5, 0, '01.02.02', 'Inmuebles', 'debito'),
(55, 1, 2, 5, 0, '01.02.03', 'Muebles y Utiles', 'debito'),
(56, 1, 2, 5, 0, '01.02.04', 'Rodados', 'debito'),
(57, 1, 2, 4, 0, '01.01.01', 'Disponibilidad', 'debito'),
(58, 1, 2, 4, 0, '01.01.02', 'Creditos', 'debito'),
(59, 1, 2, 4, 0, '01.01.03', 'Otros Debitos', 'debito'),
(60, 1, 2, 4, 0, '01.01.04', 'Bienes de cambio', 'debito'),
(61, 1, 2, 4, 0, '01.01.05', 'Inversiones', 'debito'),
(62, 1, 2, 10, 0, '01.01.01.01', 'Caja', 'debito'),
(63, 1, 2, 10, 0, '01.01.01.02', 'Banco Corrientes', 'debito'),
(64, 1, 2, 10, 0, '01.01.01.03', 'Banco Macro', 'debito'),
(65, 1, 2, 10, 0, '01.01.01.04', 'Banco Nacion', 'debito'),
(66, 1, 2, 11, 0, '01.01.02.01', 'Documentos a cobrar', 'debito'),
(67, 1, 2, 11, 0, '01.01.02.02', 'Deudores por ventas', 'debito'),
(68, 1, 2, 11, 0, '01.01.02.03', 'Deudores morosos', 'debito'),
(69, 1, 2, 11, 0, '01.01.02.04', 'Valores a depositar', 'debito'),
(70, 1, 2, 11, 0, '01.01.02.05', 'Anticipo a proveedores', 'debito'),
(71, 1, 2, 12, 0, '01.01.03.01', 'Impuestos a favor', 'debito'),
(72, 1, 2, 13, 0, '01.01.04.01', 'Mercaderias', 'debito'),
(73, 1, 2, 14, 0, '01.01.05.01', 'Plazos fijos', 'debito'),
(74, 1, 2, 14, 0, '01.01.05.02', 'Titulos publicos', 'debito'),
(75, 1, 2, 2, 0, '02.01', 'Pasivo Corriente', 'credito'),
(76, 1, 2, 2, 0, '02.02', 'Pasivo No Corriente', 'credito'),
(77, 1, 2, 28, 0, '02.01.01', 'Deudas comerciales', 'credito'),
(78, 1, 2, 28, 0, '02.01.02', 'Deudas bancarias', 'credito'),
(79, 1, 2, 28, 0, '02.01.03', 'Deudas fiscales', 'credito'),
(80, 1, 2, 28, 0, '02.01.04', 'Deudas Sociales', 'credito'),
(81, 1, 2, 30, 0, '02.01.01.01', 'Proveedores', 'credito'),
(82, 1, 2, 30, 0, '02.01.01.02', 'Deudores por ventas', 'credito'),
(83, 1, 2, 30, 0, '02.01.01.03', 'Anticipos de clientes', 'credito'),
(84, 1, 2, 31, 0, '02.01.02.01', 'Prestamos a pagar', 'credito'),
(85, 1, 2, 32, 0, '02.01.03.01', 'Impuestos y tasas a pagar', 'credito'),
(86, 1, 2, 33, 0, '02.01.04.01', 'Sueldos y Jornales a pagar', 'credito'),
(87, 1, 2, 33, 0, '02.01.04.02', 'Cargas sociales a depositar', 'credito'),
(88, 1, 2, 29, 0, '02.02.01', 'Deudas a Largo Plazo', 'credito'),
(89, 1, 2, 3, 0, '03.01', 'Capital', 'credito'),
(90, 1, 2, 3, 0, '03.02', 'Resultado No Asignado', 'credito'),
(91, 1, 2, 3, 0, '03.03', 'Reserva Legal', 'credito'),
(92, 1, 2, 0, 0, '04', 'Resultado', 'debito'),
(93, 1, 2, 45, 0, '04.01', 'Ganancia', 'debito'),
(94, 1, 2, 45, 0, '04.02', 'Perdidas', 'credito'),
(95, 2, 2, 67, 0, '01.01.02.02.01', 'Pachin Peralta', 'credito');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresas`
--

CREATE TABLE `empresas` (
  `id_empresa` int(10) unsigned NOT NULL auto_increment,
  `empresa` varchar(75) default NULL,
  PRIMARY KEY  (`id_empresa`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Volcar la base de datos para la tabla `empresas`
--

INSERT INTO `empresas` (`id_empresa`, `empresa`) VALUES
(1, 'Agencia'),
(2, 'Codex');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(10) unsigned NOT NULL auto_increment,
  `id_empresa` int(10) unsigned NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `clave` varchar(75) NOT NULL,
  `nombre` varchar(25) NOT NULL,
  `email` varchar(125) NOT NULL,
  `activo` enum('si','no') NOT NULL,
  `tipo` enum('invitado','registrado','administrador','vendedor') NOT NULL,
  `session` varchar(255) NOT NULL,
  `codigo` varchar(75) default NULL,
  `porcentaje_vendedor` decimal(10,2) default NULL,
  `url_logo` varchar(255) default NULL,
  `razon_social` varchar(125) default NULL,
  `cuit` varchar(11) default NULL,
  `direccion` varchar(125) default NULL,
  `telefono` varchar(75) default NULL,
  `contacto` varchar(75) default NULL,
  PRIMARY KEY  (`id_usuario`),
  KEY `usuarios_FKIndex1` (`id_empresa`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Volcar la base de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `id_empresa`, `usuario`, `clave`, `nombre`, `email`, `activo`, `tipo`, `session`, `codigo`, `porcentaje_vendedor`, `url_logo`, `razon_social`, `cuit`, `direccion`, `telefono`, `contacto`) VALUES
(1, 1, 'admin', '123', 'Miguel', 'keloxers', 'si', 'administrador', '', NULL, NULL, NULL, '', '', '', '', ''),
(2, 2, 'patricia', '123', 'Patricia', 'pato@na.com', 'si', 'administrador', '0f78a50efa72fbcfc69fe039d42ec854', NULL, NULL, NULL, '', '', '', '', '');
