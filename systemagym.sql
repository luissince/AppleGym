-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 15, 2020 at 04:01 PM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.4.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `systemagym`
--
-- --------------------------------------------------------

--
-- Table structure for table `asistenciatb`
--

CREATE TABLE `asistenciatb` (
  `idAsistencia` varchar(12) NOT NULL,
  `fechaApertura` date NOT NULL,
  `fechaCierre` date DEFAULT NULL,
  `horaApertura` time NOT NULL,
  `horaCierre` time DEFAULT NULL,
  `estado` tinyint(1) NOT NULL,
  `idPersona` varchar(12) NOT NULL,
  `tipoPersona` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `clientetb`
--

CREATE TABLE `clientetb` (
  `idCliente` varchar(12) NOT NULL,
  `dni` varchar(14) NOT NULL,
  `apellidos` varchar(80) NOT NULL,
  `nombres` varchar(80) NOT NULL,
  `sexo` tinyint(1) NOT NULL,
  `fechaNacimiento` date NOT NULL,
  `codigo` varchar(20) NOT NULL,
  `email` varchar(60) NOT NULL,
  `celular` varchar(20) NOT NULL,
  `direccion` varchar(120) NOT NULL,
  `predeterminado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `clientetb`
--

INSERT INTO `clientetb` (`idCliente`, `dni`, `apellidos`, `nombres`, `sexo`, `fechaNacimiento`, `codigo`, `email`, `celular`, `direccion`, `predeterminado`) VALUES
('CL0001', '78945621', 'ramos del solar', 'camilo', 1, '1990-10-25', '', '', '966750883', '', 1),
('CL0002', '78945612', 'ALCAL TIMAS', 'MARIA FLOR', 0, '1987-02-04', '', '', '966750883', '', 0),
('CL0003', '78945620', 'JUAN', 'DAMIAN', 0, '2020-12-25', '', '', '123456789', '', 0),
('CL0004', '12345678', 'MARIO', 'JUAN', 1, '2020-12-02', '', '', '999998600', '', 0),
('CL0005', '12345670', 'MARIA', 'ASD', 0, '2020-12-10', '', '', '123456789', '', 0),
('CL0006', '11111111', 'VULCAN', 'VULCAN', 1, '2020-12-10', '', '', '666666', '', 0),
('CL0007', '76423388', 'LARA SERNA', 'LUIS', 1, '1996-05-25', '', '', '966750883', '', 0),
('CL0008', '789456002', 'MARCOS SOLAR', 'MARIO', 1, '1993-01-05', '', '', '95422111', '', 0),
('CL0009', '78451212', 'CASTORA', 'ALEXANDRA', 1, '1555-02-10', '', '', '789456123', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `contratotb`
--

CREATE TABLE `contratotb` (
  `idContrato` varchar(12) NOT NULL,
  `idEmpleado` varchar(12) DEFAULT NULL,
  `puesto` int(11) DEFAULT NULL,
  `fechaInicio` date DEFAULT NULL,
  `fechaCulminacion` date DEFAULT NULL,
  `horario` varchar(100) DEFAULT NULL,
  `periodo` int(11) DEFAULT NULL,
  `sueldo` decimal(18,4) DEFAULT NULL,
  `estado` bit(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `contratotb`
--

INSERT INTO `contratotb` (`idContrato`, `idEmpleado`, `puesto`, `fechaInicio`, `fechaCulminacion`, `horario`, `periodo`, `sueldo`, `estado`) VALUES
('CT0001', 'EM0002', 2, '2019-11-01', '2019-11-30', '7:00 a 12:00', 1, '1000.0000', b'1'),
('CT0002', 'EM0003', 2, '2019-11-01', '2019-11-30', '7:00 a 12:00', 1, '1000.0000', b'1'),
('CT0003', 'EM0004', 1, '2019-11-01', '2019-12-31', '7:00 a 12:00 - 2:00 a 6:00', 1, '2000.0000', b'1'),
('CT0004', 'EM0006', 2, '2019-11-01', '2019-11-30', '2:00 a 6:00', 1, '1000.0000', b'1'),
('CT0005', 'EM0007', 3, '2019-11-01', '2019-12-31', '7:00 a 12:00 - 2:00 a 6:00', 1, '1500.0000', b'1'),
('CT0006', 'EM0005', 4, '2019-11-01', '2020-01-31', '7:00 a 12:00 - 2:00 a 7:00', 1, '1200.0000', b'1'),
('CT0007', '', 0, '2019-11-03', '0000-00-00', '', 0, '0.0000', b'1'),
('CT0008', '', 0, '2019-11-03', '0000-00-00', '', 0, '0.0000', b'1'),
('CT0009', '', 0, '2019-11-03', '0000-00-00', '', 0, '0.0000', b'1'),
('CT0010', '', 0, '2019-11-03', '0000-00-00', '', 0, '0.0000', b'1');

-- --------------------------------------------------------

--
-- Table structure for table `detalleventatb`
--

CREATE TABLE `detalleventatb` (
  `idVenta` varchar(12) NOT NULL,
  `idOrigen` varchar(12) NOT NULL,
  `cantidad` decimal(18,4) NOT NULL,
  `precio` decimal(18,4) NOT NULL,
  `descuento` decimal(18,4) NOT NULL,
  `procedencia` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `detalleventatb`
--

INSERT INTO `detalleventatb` (`idVenta`, `idOrigen`, `cantidad`, `precio`, `descuento`, `procedencia`) VALUES
('VT0001', 'PL0005', '5.0000', '40.0000', '0.0000', 1),
('VT0002', 'PL0006', '1.0000', '150.0000', '0.0000', 1),
('VT0003', 'PL0004', '1.0000', '250.0000', '0.0000', 1),
('VT0003', 'PL0005', '1.0000', '40.0000', '0.0000', 1),
('VT0004', 'PL0005', '2.0000', '40.0000', '0.0000', 1);

-- --------------------------------------------------------

--
-- Table structure for table `disciplinatb`
--

CREATE TABLE `disciplinatb` (
  `idDisciplina` varchar(12) NOT NULL,
  `nombre` varchar(80) NOT NULL,
  `color` varchar(20) NOT NULL,
  `descripcion` varchar(200) NOT NULL,
  `estado` bit(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `disciplinatb`
--

INSERT INTO `disciplinatb` (`idDisciplina`, `nombre`, `color`, `descripcion`, `estado`) VALUES
('DI0001', 'maquinas', '241-112-19-1', '', b'1'),
('DI0002', 'baile', '208-2-27-1', '', b'1'),
('DI0003', 'sauna', '65-117-5-1', '', b'1'),
('DI0004', 'yoga', '74-144-226-1', '', b'1'),
('DI0005', 'libre', '144-19-254-1', '', b'1'),
('DI0006', 'spinner', '74-74-74-1', '', b'1'),
('DI0007', 'masajes', '80-227-194-1', '', b'1'),
('DI0008', 'kind down', '241-112-19-1', '', b'1');

-- --------------------------------------------------------

--
-- Table structure for table `empleadotb`
--

CREATE TABLE `empleadotb` (
  `idEmpleado` varchar(12) NOT NULL,
  `tipoDocumento` varchar(20) NOT NULL,
  `numeroDocumento` varchar(20) NOT NULL,
  `apellidos` varchar(50) NOT NULL,
  `nombres` varchar(50) NOT NULL,
  `sexo` varchar(20) DEFAULT NULL,
  `fechaNacimiento` date DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `celular` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `direccion` varchar(150) DEFAULT NULL,
  `codigo` varchar(30) DEFAULT NULL,
  `ocupacion` varchar(30) DEFAULT NULL,
  `formaPago` varchar(50) DEFAULT NULL,
  `entidadBancaria` varchar(100) DEFAULT NULL,
  `numeroCuenta` varchar(150) DEFAULT NULL,
  `rol` varchar(20) DEFAULT NULL,
  `usuario` varchar(100) DEFAULT NULL,
  `clave` varchar(100) DEFAULT NULL,
  `estado` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `empleadotb`
--

INSERT INTO `empleadotb` (`idEmpleado`, `tipoDocumento`, `numeroDocumento`, `apellidos`, `nombres`, `sexo`, `fechaNacimiento`, `telefono`, `celular`, `email`, `direccion`, `codigo`, `ocupacion`, `formaPago`, `entidadBancaria`, `numeroCuenta`, `rol`, `usuario`, `clave`, `estado`) VALUES
('EM0001', 'DNI', '12345611', 'TORRES MAR', 'JUAN', 'Masculino', '1995-07-03', '', '966750883', 'juantorreempresa@hotmail.com', '', '', 'Administrador', '', '', '', 'Ninguno', 'admin', 'admin', 'Activo'),
('EM0002', 'DNI', '23150497', 'ALANIA SABINO', 'SAMUEL AMADOR', 'Masculino', '1990-10-25', '', '978005112', '', '', '', 'Instructor', 'Efectivo', '', '', 'Ninguno', '', '', 'Activo'),
('EM0003', 'DNI', '19979598', 'ALANYA HUARACA', 'TIMOTEO', 'Masculino', '1990-10-25', '', '966750883', '', '', '', 'Instructor', 'Efectivo', '', '', 'Ninguno', '', '', 'Activo'),
('EM0004', 'DNI', '25676103', 'BRAVO ESPINOZA', 'GRACIELA ELVIRA', 'Femenino', '1990-10-25', '', '978002112', '', '', '', 'Recepcionista', '', '', '', 'Ninguno', 'amiga', '123456', 'Activo'),
('EM0005', 'DNI', '20646882', 'CARDENAS HUAMAN', 'EPIFANIO', 'Masculino', '1990-10-25', '', '554333', '', '', '', 'Sin Ocupación', '', '', '', 'Ninguno', '', '', 'Activo'),
('EM0006', 'DNI', '08838810', 'GOMEZ MORENO', 'YSRAEL', 'Masculino', '1990-10-25', '', '978445002', '', '', '', 'Instructor', NULL, NULL, NULL, 'Ninguno', '', '', 'Activo'),
('EM0007', 'DNI', '10428973', 'RIOS MARTINEZ', 'SILVIA ELENA', 'Femenino', '1990-10-25', '', '988511202', '', '', '', 'Recepcionista', 'Efectivo', '', '', 'Ninguno', '', '', 'Activo');

-- --------------------------------------------------------

--
-- Table structure for table `horariotb`
--

CREATE TABLE `horariotb` (
  `idHorario` varchar(12) NOT NULL,
  `descripcion` varchar(150) NOT NULL,
  `dias` varchar(20) NOT NULL,
  `estado` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `horariotb`
--

INSERT INTO `horariotb` (`idHorario`, `descripcion`, `dias`, `estado`) VALUES
('HO0001', 'HORARIO RECEPCIONISTA NORMAL', '1,2,3,4,5', 1),
('HO0002', 'HORARIO INSTRUCTOR', '1,2,3,4,5,6,7', 1),
('HO0003', 'HORARIO RECEPCIONISTA FINES\r\n', '6,7', 1),
('HO0004', 'HORARIO DE LIMPIEZA', '1,2,3,4,5,6,7', 1);

-- --------------------------------------------------------

--
-- Table structure for table `ingresotb`
--

CREATE TABLE `ingresotb` (
  `idPrecedencia` varchar(12) NOT NULL,
  `idIngreso` int(11) NOT NULL,
  `detalle` varchar(200) NOT NULL,
  `tipo` tinyint(4) NOT NULL,
  `forma` tinyint(4) NOT NULL,
  `numero` varchar(30) NOT NULL,
  `monto` decimal(18,4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ingresotb`
--

INSERT INTO `ingresotb` (`idPrecedencia`, `idIngreso`, `detalle`, `tipo`, `forma`, `numero`, `monto`) VALUES
('VT0001', 1, 'INGRESO EN EFECTIVO DEL COMPROBANTE NT001-1', 2, 1, '', '100.0000'),
('VT0002', 2, 'INGRESO EN EFECTIVO DEL COMPROBANTE NT001-2', 1, 1, '', '150.0000'),
('VT0003', 3, 'INGRESO EN EFECTIVO DEL COMPROBANTE NT001-3', 2, 0, '', '0.0000'),
('VT0004', 4, 'INGRESO EN EFECTIVO DEL COMPROBANTE NT001-4', 1, 1, '', '80.0000');

-- --------------------------------------------------------

--
-- Table structure for table `membresiatb`
--

CREATE TABLE `membresiatb` (
  `idMembresia` varchar(12) NOT NULL,
  `idPlan` varchar(12) DEFAULT NULL,
  `idCliente` varchar(12) DEFAULT NULL,
  `idVenta` varchar(12) NOT NULL,
  `fechaInicio` date NOT NULL,
  `horaInicio` time NOT NULL,
  `fechaFin` date NOT NULL,
  `horaFin` time NOT NULL,
  `tipoMembresia` char(1) NOT NULL,
  `estado` tinyint(4) NOT NULL,
  `cantidad` decimal(18,4) NOT NULL,
  `precio` decimal(18,4) NOT NULL,
  `descuento` decimal(18,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `membresiatb`
--

INSERT INTO `membresiatb` (`idMembresia`, `idPlan`, `idCliente`, `idVenta`, `fechaInicio`, `horaInicio`, `fechaFin`, `horaFin`, `tipoMembresia`, `estado`, `cantidad`, `precio`, `descuento`) VALUES
('ME0001', 'PL0005', 'CL0009', 'VT0001', '2020-12-15', '07:49:46', '2021-05-17', '07:49:46', '1', 1, '5.0000', '40.0000', '0'),
('ME0002', 'PL0006', 'CL0009', 'VT0002', '2020-12-15', '07:51:47', '2021-01-16', '07:51:47', '1', 1, '1.0000', '150.0000', '0'),
('ME0003', 'PL0004', 'CL0001', 'VT0003', '2020-12-15', '07:53:52', '2021-04-20', '07:53:52', '1', 1, '1.0000', '250.0000', '0'),
('ME0004', 'PL0005', 'CL0001', 'VT0003', '2020-12-15', '07:53:56', '2021-01-17', '07:53:56', '1', 1, '1.0000', '40.0000', '0'),
('ME0005', 'PL0005', 'CL0004', 'VT0004', '2020-12-20', '09:08:30', '2021-02-21', '09:08:30', '1', 1, '2.0000', '40.0000', '0');

-- --------------------------------------------------------

--
-- Table structure for table `mi_empresatb`
--

CREATE TABLE `mi_empresatb` (
  `idMiEmpresa` int(11) NOT NULL,
  `representante` varchar(50) NOT NULL,
  `nombreEmpresa` varchar(100) NOT NULL,
  `ruc` varchar(20) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `celular` varchar(20) NOT NULL,
  `email` varchar(60) NOT NULL,
  `paginaWeb` varchar(120) NOT NULL,
  `direccion` varchar(200) NOT NULL,
  `terminos` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `mi_empresatb`
--

INSERT INTO `mi_empresatb` (`idMiEmpresa`, `representante`, `nombreEmpresa`, `ruc`, `telefono`, `celular`, `email`, `paginaWeb`, `direccion`, `terminos`) VALUES
(1, 'RAMOS DEL SOLAR JUAN', 'APPLE GYM PERÚ', '45678912312', '064 7894566', '963225002', 'applegymperu@hotmal.com', '', 'AV. LAS CALLES DEL MAR NRO 100', 'NO HAY NINGÚN TIPO DE REEMBOLSO POR POLÍTICAS DE LA EMPRESA.');

-- --------------------------------------------------------

--
-- Table structure for table `movimientostb`
--

CREATE TABLE `movimientostb` (
  `idMovimiento` int(255) NOT NULL,
  `idTabla` varchar(12) NOT NULL,
  `descripcion` varchar(200) NOT NULL,
  `fechaRegistro` date NOT NULL,
  `horaRegistro` time NOT NULL,
  `usuario` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `plantb`
--

CREATE TABLE `plantb` (
  `idPlan` varchar(12) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `tipoDisciplina` tinyint(4) NOT NULL,
  `sesiones` smallint(6) DEFAULT NULL,
  `meses` tinyint(4) NOT NULL,
  `dias` tinyint(4) NOT NULL,
  `freeze` tinyint(4) NOT NULL,
  `precio` double(18,4) NOT NULL,
  `descripcion` varchar(200) DEFAULT NULL,
  `estado` tinyint(1) NOT NULL,
  `prueba` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `plantb`
--

INSERT INTO `plantb` (`idPlan`, `nombre`, `tipoDisciplina`, `sesiones`, `meses`, `dias`, `freeze`, `precio`, `descripcion`, `estado`, `prueba`) VALUES
('PL0004', 'plan verano', 1, 0, 4, 0, 7, 250.0000, 'valido hasta fines de diciembre con un solo pago', 1, 0),
('PL0005', 'plan especial', 1, 0, 1, 4, 0, 40.0000, '', 1, 0),
('PL0006', 'plan normal', 1, 0, 1, 0, 3, 150.0000, '', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `plantb_disciplinatb`
--

CREATE TABLE `plantb_disciplinatb` (
  `idPlan` varchar(12) NOT NULL,
  `idDisciplina` varchar(12) NOT NULL,
  `numero` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `productotb`
--

CREATE TABLE `productotb` (
  `idProducto` varchar(12) NOT NULL,
  `clave` varchar(45) NOT NULL,
  `claveAlterna` varchar(45) DEFAULT NULL,
  `nombre` varchar(120) NOT NULL,
  `categoria` varchar(45) DEFAULT NULL,
  `impuesto` varchar(45) DEFAULT NULL,
  `cantidad` decimal(18,4) DEFAULT NULL,
  `costo` decimal(18,4) NOT NULL,
  `precio` decimal(18,4) NOT NULL,
  `estado` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `productotb`
--

INSERT INTO `productotb` (`idProducto`, `clave`, `claveAlterna`, `nombre`, `categoria`, `impuesto`, `cantidad`, `costo`, `precio`, `estado`) VALUES
('PD0001', '2342333', '', 'papitas lays', 'Golosinas', 'Ninguno', '0.0000', '1.0000', '2.0000', 'Inactivo'),
('PD0002', '5223322', '', 'galleta soda', 'Golosinas', 'Ninguno', '0.0000', '0.3000', '0.5000', 'Activo'),
('PD0003', '8769966', '', 'gaseosa', 'Golosinas', 'Ninguno', '0.0000', '2.0000', '3.5000', 'Activo'),
('PD0004', '88777766', '', 'yogurt gloria 1lt', 'Golosinas', 'Ninguno', '0.0000', '5.0000', '6.5000', 'Activo'),
('PD0005', '9866555', '', 'galleta choco soda', 'Golosinas', 'Ninguno', '0.0000', '0.5000', '0.7000', 'Activo'),
('PD0006', '2342223', '', 'agua cielo 500ml', 'Golosinas', 'Ninguno', '0.0000', '0.8000', '1.0000', 'Activo'),
('PD0007', '2342342', '', 'platano seda', 'Golosinas', 'Ninguno', '0.0000', '1.0000', '1.5000', 'Activo'),
('PD0008', '2000336', '', 'polo rojo talla x', 'Golosinas', 'Ninguno', '0.0000', '20.0000', '30.0000', 'Activo');

-- --------------------------------------------------------

--
-- Table structure for table `tabla_ocupacion`
--

CREATE TABLE `tabla_ocupacion` (
  `id` int(12) NOT NULL,
  `nombre` varchar(30) CHARACTER SET utf8 NOT NULL,
  `descripcion` varchar(50) CHARACTER SET utf8 NOT NULL,
  `claveAlterna` varchar(30) CHARACTER SET utf8 NOT NULL,
  `estado` tinyint(1) NOT NULL,
  `predeterminado` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tabla_periodo_pago`
--

CREATE TABLE `tabla_periodo_pago` (
  `id` int(12) NOT NULL,
  `nombre` varchar(30) CHARACTER SET utf8 NOT NULL,
  `descripcion` varchar(50) CHARACTER SET utf8 NOT NULL,
  `claveAlterna` varchar(30) CHARACTER SET utf8 NOT NULL,
  `estado` tinyint(1) NOT NULL,
  `predeterminado` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tabla_periodo_pago`
--

INSERT INTO `tabla_periodo_pago` (`id`, `nombre`, `descripcion`, `claveAlterna`, `estado`, `predeterminado`) VALUES
(1, 'MENSUAL', 'caleta', ' ', 1, 1),
(2, 'QUINSENAL', 'Ninguna', ' ', 1, 1),
(3, 'DIARIO', 'Ninguna', ' ', 0, 0),
(4, 'CADA 2 DIAS', 'bamban', ' ', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tabla_puesto`
--

CREATE TABLE `tabla_puesto` (
  `id` int(12) NOT NULL,
  `nombre` varchar(30) CHARACTER SET utf8 NOT NULL,
  `descripcion` varchar(50) CHARACTER SET utf8 NOT NULL,
  `claveAlterna` varchar(30) CHARACTER SET utf8 NOT NULL,
  `estado` tinyint(1) NOT NULL,
  `predeterminado` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tabla_puesto`
--

INSERT INTO `tabla_puesto` (`id`, `nombre`, `descripcion`, `claveAlterna`, `estado`, `predeterminado`) VALUES
(1, 'SECRETARIA', 'Encargado', '0', 1, 0),
(2, 'INSTRUCTOR', 'Encargado', '0', 1, 0),
(3, 'RECEPCIONISTA', 'Encargado', '0', 1, 0),
(4, 'LIMPIEZA', 'Ninguna', ' ', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tabla_rol`
--

CREATE TABLE `tabla_rol` (
  `id` int(12) NOT NULL,
  `nombre` varchar(30) CHARACTER SET utf8 NOT NULL,
  `descripcion` varchar(50) CHARACTER SET utf8 NOT NULL,
  `claveAlterna` varchar(30) CHARACTER SET utf8 NOT NULL,
  `estado` tinyint(1) NOT NULL,
  `predeterminado` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tabla_rol`
--

INSERT INTO `tabla_rol` (`id`, `nombre`, `descripcion`, `claveAlterna`, `estado`, `predeterminado`) VALUES
(1, 'admininistrador', 'Ninguna', ' 123456789', 1, 1),
(2, 'caja', 'Ninguna', ' ', 1, 1),
(3, 'vendedor', 'Ninguna', ' ', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tipocomprobantetb`
--

CREATE TABLE `tipocomprobantetb` (
  `idTipoComprobante` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `serie` varchar(16) NOT NULL,
  `numeracion` int(11) NOT NULL,
  `predeterminado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tipocomprobantetb`
--

INSERT INTO `tipocomprobantetb` (`idTipoComprobante`, `nombre`, `serie`, `numeracion`, `predeterminado`) VALUES
(1, 'Nota de Venta', 'NT001', 1, 0),
(2, 'Boleta', 'B001', 1, 0),
(3, 'Factura', 'F001', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `turnotb`
--

CREATE TABLE `turnotb` (
  `idTurno` int(11) NOT NULL,
  `idHorario` varchar(12) NOT NULL,
  `horaInicio` time NOT NULL,
  `horaSalida` time NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `turnotb`
--

INSERT INTO `turnotb` (`idTurno`, `idHorario`, `horaInicio`, `horaSalida`) VALUES
(1, 'HO0001', '08:00:00', '12:00:00'),
(2, 'HO0001', '14:00:00', '18:00:00'),
(2, 'HO0002', '08:00:00', '12:00:00'),
(3, 'HO0002', '14:00:00', '16:00:00'),
(4, 'HO0003', '08:00:00', '16:00:00'),
(5, 'HO0004', '08:00:00', '10:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `ventacreditotb`
--

CREATE TABLE `ventacreditotb` (
  `idVenta` varchar(12) NOT NULL,
  `idVentaCredito` int(11) NOT NULL,
  `monto` decimal(18,4) NOT NULL,
  `fechaRegistro` date NOT NULL,
  `horaRegistro` time NOT NULL,
  `fechaPago` date NOT NULL,
  `horaPago` time NOT NULL,
  `estado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ventacreditotb`
--

INSERT INTO `ventacreditotb` (`idVenta`, `idVentaCredito`, `monto`, `fechaRegistro`, `horaRegistro`, `fechaPago`, `horaPago`, `estado`) VALUES
('VT0001', 1, '100.0000', '2020-12-15', '07:50:02', '0000-00-00', '00:00:00', 1),
('VT0001', 2, '100.0000', '2020-12-20', '07:50:02', '0000-00-00', '00:00:00', 0),
('VT0003', 3, '100.0000', '2020-12-20', '07:54:37', '0000-00-00', '00:00:00', 0),
('VT0003', 4, '100.0000', '2020-12-26', '07:54:37', '0000-00-00', '00:00:00', 0),
('VT0003', 5, '90.0000', '2020-12-27', '07:54:37', '0000-00-00', '00:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `ventatb`
--

CREATE TABLE `ventatb` (
  `idVenta` varchar(12) NOT NULL,
  `cliente` varchar(12) NOT NULL,
  `vendedor` varchar(12) NOT NULL,
  `documento` int(11) NOT NULL,
  `serie` varchar(16) NOT NULL,
  `numeracion` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `tipo` tinyint(4) NOT NULL,
  `forma` tinyint(4) NOT NULL,
  `numero` varchar(30) NOT NULL,
  `pago` decimal(18,4) NOT NULL,
  `vuelto` decimal(18,4) NOT NULL,
  `estado` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ventatb`
--

INSERT INTO `ventatb` (`idVenta`, `cliente`, `vendedor`, `documento`, `serie`, `numeracion`, `fecha`, `hora`, `tipo`, `forma`, `numero`, `pago`, `vuelto`, `estado`) VALUES
('VT0001', 'CL0009', '0', 1, 'NT001', 1, '2020-12-15', '07:50:02', 2, 1, '', '0.0000', '0.0000', 2),
('VT0002', 'CL0009', '0', 1, 'NT001', 2, '2020-12-15', '07:51:57', 1, 1, '', '200.0000', '50.0000', 1),
('VT0003', 'CL0001', '0', 1, 'NT001', 3, '2020-12-15', '07:54:38', 2, 0, '', '0.0000', '0.0000', 2),
('VT0004', 'CL0004', '0', 1, 'NT001', 4, '2020-12-15', '09:08:41', 1, 1, '', '100.0000', '20.0000', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `asistenciatb`
--
ALTER TABLE `asistenciatb`
  ADD PRIMARY KEY (`idAsistencia`);

--
-- Indexes for table `clientetb`
--
ALTER TABLE `clientetb`
  ADD PRIMARY KEY (`idCliente`);

--
-- Indexes for table `contratotb`
--
ALTER TABLE `contratotb`
  ADD PRIMARY KEY (`idContrato`);

--
-- Indexes for table `detalleventatb`
--
ALTER TABLE `detalleventatb`
  ADD PRIMARY KEY (`idVenta`,`idOrigen`);

--
-- Indexes for table `disciplinatb`
--
ALTER TABLE `disciplinatb`
  ADD PRIMARY KEY (`idDisciplina`) USING BTREE;

--
-- Indexes for table `empleadotb`
--
ALTER TABLE `empleadotb`
  ADD PRIMARY KEY (`idEmpleado`);

--
-- Indexes for table `horariotb`
--
ALTER TABLE `horariotb`
  ADD PRIMARY KEY (`idHorario`);

--
-- Indexes for table `ingresotb`
--
ALTER TABLE `ingresotb`
  ADD PRIMARY KEY (`idIngreso`,`idPrecedencia`);

--
-- Indexes for table `membresiatb`
--
ALTER TABLE `membresiatb`
  ADD PRIMARY KEY (`idMembresia`);

--
-- Indexes for table `mi_empresatb`
--
ALTER TABLE `mi_empresatb`
  ADD PRIMARY KEY (`idMiEmpresa`);

--
-- Indexes for table `movimientostb`
--
ALTER TABLE `movimientostb`
  ADD PRIMARY KEY (`idMovimiento`,`idTabla`) USING BTREE;

--
-- Indexes for table `plantb`
--
ALTER TABLE `plantb`
  ADD PRIMARY KEY (`idPlan`);

--
-- Indexes for table `plantb_disciplinatb`
--
ALTER TABLE `plantb_disciplinatb`
  ADD PRIMARY KEY (`idPlan`,`idDisciplina`);

--
-- Indexes for table `productotb`
--
ALTER TABLE `productotb`
  ADD PRIMARY KEY (`idProducto`);

--
-- Indexes for table `tabla_ocupacion`
--
ALTER TABLE `tabla_ocupacion`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tabla_periodo_pago`
--
ALTER TABLE `tabla_periodo_pago`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tabla_puesto`
--
ALTER TABLE `tabla_puesto`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tabla_rol`
--
ALTER TABLE `tabla_rol`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tipocomprobantetb`
--
ALTER TABLE `tipocomprobantetb`
  ADD PRIMARY KEY (`idTipoComprobante`);

--
-- Indexes for table `turnotb`
--
ALTER TABLE `turnotb`
  ADD PRIMARY KEY (`idHorario`,`idTurno`);

--
-- Indexes for table `ventacreditotb`
--
ALTER TABLE `ventacreditotb`
  ADD PRIMARY KEY (`idVentaCredito`,`idVenta`);

--
-- Indexes for table `ventatb`
--
ALTER TABLE `ventatb`
  ADD PRIMARY KEY (`idVenta`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ingresotb`
--
ALTER TABLE `ingresotb`
  MODIFY `idIngreso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `mi_empresatb`
--
ALTER TABLE `mi_empresatb`
  MODIFY `idMiEmpresa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tabla_ocupacion`
--
ALTER TABLE `tabla_ocupacion`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tabla_periodo_pago`
--
ALTER TABLE `tabla_periodo_pago`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tabla_puesto`
--
ALTER TABLE `tabla_puesto`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tabla_rol`
--
ALTER TABLE `tabla_rol`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tipocomprobantetb`
--
ALTER TABLE `tipocomprobantetb`
  MODIFY `idTipoComprobante` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `ventacreditotb`
--
ALTER TABLE `ventacreditotb`
  MODIFY `idVentaCredito` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
