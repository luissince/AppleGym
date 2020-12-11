-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-12-2020 a las 17:13:34
-- Versión del servidor: 10.4.13-MariaDB
-- Versión de PHP: 7.4.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `systemagym`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `Sp_Listar_Ingresos_Options` (IN `transacion` TINYINT, IN `fechaInicio` VARCHAR(20), IN `fechaFin` VARCHAR(20), IN `x` INT, IN `y` INT)  NO SQL
SELECT i.idIngreso,i.fecha,i.hora,i.forma,i.monto,i.serie,i.numeracion,i.procedencia,
       v.serie as ventaSerie,v.numeracion as ventaNumeracion
       FROM ingresotb AS i INNER JOIN ventatb AS v ON i.idVenta = v.idVenta  
       WHERE 
       (transacion = 0 AND v.fecha BETWEEN fechaInicio AND fechaFin)
       OR
       ( v.procedencia = transacion AND v.fecha BETWEEN fechaInicio AND fechaFin)
       ORDER BY i.fecha DESC,i.hora DESC LIMIT x,y$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Sp_Listar_Ingresos_Options_Count` (IN `transacion` TINYINT, IN `fechaInicio` VARCHAR(20), IN `fechaFin` VARCHAR(20))  NO SQL
SELECT COUNT(i.idIngreso)
FROM ingresotb AS i INNER JOIN ventatb AS v ON i.idVenta = v.idVenta  
WHERE 
(transacion = 0 AND v.fecha BETWEEN fechaInicio AND fechaFin)
OR
(v.procedencia = transacion AND v.fecha BETWEEN fechaInicio AND fechaFin)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Sp_Listar_Ingresos_Options_Reporte` (IN `transacion` TINYINT, IN `fechaInicio` VARCHAR(20), IN `fechaFin` VARCHAR(20))  NO SQL
SELECT i.idIngreso,i.fecha,i.hora,i.forma,i.monto,i.serie,i.numeracion,i.procedencia, v.serie as ventaSerie,v.numeracion as ventaNumeracion FROM ingresotb AS i INNER JOIN ventatb AS v ON i.idVenta = v.idVenta WHERE (transacion = 0 AND v.fecha BETWEEN fechaInicio AND fechaFin) OR ( v.procedencia = transacion AND v.fecha BETWEEN fechaInicio AND fechaFin) ORDER BY i.fecha DESC,i.hora DESC$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Sp_Listar_Ventas_Reporte_Options` (IN `transaccion` INT, IN `fechaInicio` VARCHAR(20), IN `fechaFinal` VARCHAR(20), IN `tipo` TINYINT, IN `forma` TINYINT, IN `estado` TINYINT)  NO SQL
SELECT v.idVenta,e.apellidos AS apellidosEmpleado,e.nombres AS nombresEmpleado,c.apellidos AS apellidosCliente,c.nombres AS nombresCliente,v.serie,v.numeracion,v.fecha,v.hora,v.total,v.tipo,v.forma,v.numero,v.estado,v.procedencia FROM ventatb AS v INNER JOIN empleadotb AS e ON v.vendedor = e.idEmpleado INNER JOIN clientetb AS c ON v.cliente = c.idCliente
WHERE 
(transaccion = 0 AND v.fecha BETWEEN fechaInicio AND fechaFinal AND tipo = 0 AND forma = 0 AND estado = 0)
OR 
(v.procedencia = transaccion AND v.fecha BETWEEN fechaInicio AND fechaFinal AND tipo = 0 AND forma = 0 AND estado = 0)
OR
(v.procedencia = transaccion AND v.fecha BETWEEN fechaInicio AND fechaFinal AND v.tipo = tipo AND forma = 0 AND estado = 0)
OR
(v.procedencia = transaccion AND v.fecha BETWEEN fechaInicio AND fechaFinal AND tipo = 0 AND v.forma = forma AND estado = 0)
OR
(v.procedencia = transaccion AND v.fecha BETWEEN fechaInicio AND fechaFinal AND tipo = 0 AND forma = 0 AND v.estado = estado)
OR
(v.procedencia = transaccion AND v.fecha BETWEEN fechaInicio AND fechaFinal AND v.tipo = tipo AND v.forma = forma AND estado = 0)
OR
(v.procedencia = transaccion AND v.fecha BETWEEN fechaInicio AND fechaFinal AND tipo = 0 AND v.forma = forma AND v.estado = estado)
OR
(v.procedencia = transaccion AND v.fecha BETWEEN fechaInicio AND fechaFinal AND v.tipo = tipo AND forma = 0 AND v.estado = estado)
OR
(v.procedencia = transaccion AND v.fecha BETWEEN fechaInicio AND fechaFinal AND v.tipo = tipo AND v.forma = forma AND v.estado = estado)
OR
(transaccion = 0 AND v.fecha BETWEEN fechaInicio AND fechaFinal AND v.tipo = tipo AND forma = 0 AND estado = 0)
OR
(transaccion = 0 AND v.fecha BETWEEN fechaInicio AND fechaFinal AND tipo = 0 AND v.forma = forma AND estado = 0)
OR
(transaccion = 0 AND v.fecha BETWEEN fechaInicio AND fechaFinal AND tipo = 0 AND forma = 0 AND v.estado = estado)
OR
(transaccion = 0 AND v.fecha BETWEEN fechaInicio AND fechaFinal AND v.tipo = tipo AND v.forma = forma AND estado = 0)
OR
(transaccion = 0 AND v.fecha BETWEEN fechaInicio AND fechaFinal AND tipo = 0 AND v.forma = forma AND v.estado = estado)
OR
(transaccion = 0 AND v.fecha BETWEEN fechaInicio AND fechaFinal AND v.tipo = 0 AND forma = 0 AND v.estado = estado)
OR
(transaccion = 0 AND v.fecha BETWEEN fechaInicio AND fechaFinal AND v.tipo = tipo AND v.forma = forma AND v.estado = estado)
ORDER BY v.fecha DESC,v.hora DESC$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Sp_Listar_Ventas_Search_Options` (IN `transaccion` TINYINT, IN `fechaInicio` VARCHAR(20), IN `fechaFinal` VARCHAR(20), IN `tipo` TINYINT, IN `forma` TINYINT, IN `estado` TINYINT, IN `x` INT, IN `y` INT)  NO SQL
SELECT v.idVenta,e.apellidos AS apellidosEmpleado,e.nombres AS nombresEmpleado,c.apellidos AS apellidosCliente,c.nombres AS nombresCliente,v.serie,v.numeracion,v.fecha,v.hora,v.total,v.tipo,v.forma,v.numero,v.estado,v.procedencia FROM ventatb AS v INNER JOIN empleadotb AS e ON v.vendedor = e.idEmpleado INNER JOIN clientetb AS c ON v.cliente = c.idCliente
WHERE 
(transaccion = 0 AND v.fecha BETWEEN fechaInicio AND fechaFinal AND tipo = 0 AND forma = 0 AND estado = 0)
OR 
(v.procedencia = transaccion AND v.fecha BETWEEN fechaInicio AND fechaFinal AND tipo = 0 AND forma = 0 AND estado = 0)
OR
(v.procedencia = transaccion AND v.fecha BETWEEN fechaInicio AND fechaFinal AND v.tipo = tipo AND forma = 0 AND estado = 0)
OR
(v.procedencia = transaccion AND v.fecha BETWEEN fechaInicio AND fechaFinal AND tipo = 0 AND v.forma = forma AND estado = 0)
OR
(v.procedencia = transaccion AND v.fecha BETWEEN fechaInicio AND fechaFinal AND tipo = 0 AND forma = 0 AND v.estado = estado)
OR
(v.procedencia = transaccion AND v.fecha BETWEEN fechaInicio AND fechaFinal AND v.tipo = tipo AND v.forma = forma AND estado = 0)
OR
(v.procedencia = transaccion AND v.fecha BETWEEN fechaInicio AND fechaFinal AND tipo = 0 AND v.forma = forma AND v.estado = estado)
OR
(v.procedencia = transaccion AND v.fecha BETWEEN fechaInicio AND fechaFinal AND v.tipo = tipo AND forma = 0 AND v.estado = estado)
OR
(v.procedencia = transaccion AND v.fecha BETWEEN fechaInicio AND fechaFinal AND v.tipo = tipo AND v.forma = forma AND v.estado = estado)
OR
(transaccion = 0 AND v.fecha BETWEEN fechaInicio AND fechaFinal AND v.tipo = tipo AND forma = 0 AND estado = 0)
OR
(transaccion = 0 AND v.fecha BETWEEN fechaInicio AND fechaFinal AND tipo = 0 AND v.forma = forma AND estado = 0)
OR
(transaccion = 0 AND v.fecha BETWEEN fechaInicio AND fechaFinal AND tipo = 0 AND forma = 0 AND v.estado = estado)
OR
(transaccion = 0 AND v.fecha BETWEEN fechaInicio AND fechaFinal AND v.tipo = tipo AND v.forma = forma AND estado = 0)
OR
(transaccion = 0 AND v.fecha BETWEEN fechaInicio AND fechaFinal AND tipo = 0 AND v.forma = forma AND v.estado = estado)
OR
(transaccion = 0 AND v.fecha BETWEEN fechaInicio AND fechaFinal AND v.tipo = 0 AND forma = 0 AND v.estado = estado)
OR
(transaccion = 0 AND v.fecha BETWEEN fechaInicio AND fechaFinal AND v.tipo = tipo AND v.forma = forma AND v.estado = estado)
ORDER BY v.fecha DESC,v.hora DESC LIMIT x,y$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Sp_Listar_Ventas_Search_Options_Count` (IN `transaccion` TINYINT, IN `fechaInicio` DATE, IN `fechaFinal` DATE, IN `tipo` TINYINT, IN `forma` TINYINT, IN `estado` TINYINT)  NO SQL
SELECT COUNT(v.idVenta) FROM ventatb AS v INNER JOIN empleadotb AS e ON v.vendedor = e.idEmpleado INNER JOIN clientetb AS c ON v.cliente = c.idCliente
WHERE 
(transaccion = 0 AND v.fecha BETWEEN fechaInicio AND fechaFinal AND tipo = 0 AND forma = 0 AND estado = 0)
OR 
(v.procedencia = transaccion AND v.fecha BETWEEN fechaInicio AND fechaFinal AND tipo = 0 AND forma = 0 AND estado = 0)
OR
(v.procedencia = transaccion AND v.fecha BETWEEN fechaInicio AND fechaFinal AND v.tipo = tipo AND forma = 0 AND estado = 0)
OR
(v.procedencia = transaccion AND v.fecha BETWEEN fechaInicio AND fechaFinal AND tipo = 0 AND v.forma = forma AND estado = 0)
OR
(v.procedencia = transaccion AND v.fecha BETWEEN fechaInicio AND fechaFinal AND tipo = 0 AND forma = 0 AND v.estado = estado)
OR
(v.procedencia = transaccion AND v.fecha BETWEEN fechaInicio AND fechaFinal AND v.tipo = tipo AND v.forma = forma AND estado = 0)
OR
(v.procedencia = transaccion AND v.fecha BETWEEN fechaInicio AND fechaFinal AND tipo = 0 AND v.forma = forma AND v.estado = estado)
OR
(v.procedencia = transaccion AND v.fecha BETWEEN fechaInicio AND fechaFinal AND v.tipo = tipo AND forma = 0 AND v.estado = estado)
OR
(v.procedencia = transaccion AND v.fecha BETWEEN fechaInicio AND fechaFinal AND v.tipo = tipo AND v.forma = forma AND v.estado = estado)
OR
(transaccion = 0 AND v.fecha BETWEEN fechaInicio AND fechaFinal AND v.tipo = tipo AND forma = 0 AND estado = 0)
OR
(transaccion = 0 AND v.fecha BETWEEN fechaInicio AND fechaFinal AND tipo = 0 AND v.forma = forma AND estado = 0)
OR
(transaccion = 0 AND v.fecha BETWEEN fechaInicio AND fechaFinal AND tipo = 0 AND forma = 0 AND v.estado = estado)
OR
(transaccion = 0 AND v.fecha BETWEEN fechaInicio AND fechaFinal AND v.tipo = tipo AND v.forma = forma AND estado = 0)
OR
(transaccion = 0 AND v.fecha BETWEEN fechaInicio AND fechaFinal AND tipo = 0 AND v.forma = forma AND v.estado = estado)
OR
(transaccion = 0 AND v.fecha BETWEEN fechaInicio AND fechaFinal AND v.tipo = 0 AND forma = 0 AND v.estado = estado)
OR
(transaccion = 0 AND v.fecha BETWEEN fechaInicio AND fechaFinal AND v.tipo = tipo AND v.forma = forma AND v.estado = estado)$$

--
-- Funciones
--
CREATE DEFINER=`root`@`localhost` FUNCTION `Fc_Asistencia_Codigo_Almanumerico` () RETURNS VARCHAR(12) CHARSET utf8 NO SQL
BEGIN
	DECLARE CodGenerado varchar(12);
    DECLARE ValorActual varchar(12);
    DECLARE Incremental int;
    IF EXISTS(SELECT * FROM asistenciatb) THEN
        SET ValorActual = (SELECT MAX(CAST(REPLACE(REPLACE(idAsistencia,'RA',''),'','') AS UNSIGNED INTEGER)) from asistenciatb);
        SET Incremental = CAST(ValorActual AS UNSIGNED INTEGER)+1;
        IF Incremental<=9 THEN    	
                SET CodGenerado = CONCAT('RA000',Incremental);        
        ELSEIF Incremental>=10 and Incremental<=99 THEN    	
                SET CodGenerado = CONCAT('RA00',Incremental);
         ELSEIF Incremental>=100 and Incremental<=999 THEN    
                SET CodGenerado = CONCAT('RA0',Incremental);	
         ELSE 
                SET CodGenerado = CONCAT('RA',Incremental);
         END IF;   
     ELSE 
     	SET CodGenerado = 'RA0001';
     END IF;
 RETURN CodGenerado;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `Fc_Cliente_Codigo_Almanumerico` () RETURNS VARCHAR(12) CHARSET utf8 NO SQL
BEGIN
	DECLARE CodGenerado varchar(12);
    DECLARE ValorActual varchar(12);
    DECLARE Incremental int;
    IF EXISTS(SELECT * FROM clientetb) THEN
        SET ValorActual = (SELECT MAX(CAST(REPLACE(REPLACE(idCliente,'CL',''),'','')AS UNSIGNED INTEGER)) from clientetb);
        SET Incremental = CAST(ValorActual AS UNSIGNED INTEGER)+1;
        IF Incremental<=9 THEN    	
                SET CodGenerado = CONCAT('CL000',Incremental);        
        ELSEIF Incremental>=10 and Incremental<=99 THEN    	
                SET CodGenerado = CONCAT('CL00',Incremental);
         ELSEIF Incremental>=100 and Incremental<=999 THEN    
                SET CodGenerado = CONCAT('CL0',Incremental);	
         ELSE 
                SET CodGenerado = CONCAT('CL',Incremental);
         END IF;   
     ELSE 
     	SET CodGenerado = 'CL0001';
     END IF;
 RETURN CodGenerado;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `Fc_Contrato_Codigo_Almanumerico` () RETURNS VARCHAR(12) CHARSET utf8 NO SQL
BEGIN
	DECLARE CodGenerado varchar(12);
    DECLARE ValorActual varchar(12);
    DECLARE Incremental int;
    IF EXISTS(SELECT * FROM contratotb) THEN
        SET ValorActual = (SELECT MAX(CAST(REPLACE(REPLACE(idContrato,'CT',''),'','') AS UNSIGNED INTEGER)) from contratotb);
        SET Incremental = CAST(ValorActual AS UNSIGNED INTEGER)+1;
        IF Incremental<=9 THEN    	
                SET CodGenerado = CONCAT('CT000',Incremental);        
        ELSEIF Incremental>=10 and Incremental<=99 THEN    	
                SET CodGenerado = CONCAT('CT00',Incremental);
         ELSEIF Incremental>=100 and Incremental<=999 THEN    
                SET CodGenerado = CONCAT('CT0',Incremental);	
         ELSE 
                SET CodGenerado = CONCAT('CT',Incremental);
         END IF;   
     ELSE 
     	SET CodGenerado = 'CT0001';
     END IF;
 RETURN CodGenerado;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `Fc_Disciplina_Codigo_Almanumerico` () RETURNS VARCHAR(12) CHARSET utf8 NO SQL
BEGIN
	DECLARE CodGenerado varchar(12);
    DECLARE ValorActual varchar(12);
    DECLARE Incremental int;
    IF EXISTS(SELECT * FROM disciplinatb) THEN
        SET ValorActual = (SELECT MAX(CAST(REPLACE(REPLACE(idDisciplina,'DI',''),'','')AS UNSIGNED INTEGER)) from disciplinatb);
        SET Incremental = CAST(ValorActual AS UNSIGNED INTEGER)+1;
        IF Incremental<=9 THEN    	
                SET CodGenerado = CONCAT('DI000',Incremental);        
        ELSEIF Incremental>=10 and Incremental<=99 THEN    	
                SET CodGenerado = CONCAT('DI00',Incremental);
         ELSEIF Incremental>=100 and Incremental<=999 THEN    
                SET CodGenerado = CONCAT('DI0',Incremental);	
         ELSE 
                SET CodGenerado = CONCAT('DI',Incremental);
         END IF;   
     ELSE 
     	SET CodGenerado = 'DI0001';
     END IF;
 RETURN CodGenerado;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `Fc_Empleado_Codigo_Almanumerico` () RETURNS VARCHAR(12) CHARSET utf8 NO SQL
BEGIN
	DECLARE CodGenerado varchar(12);
    DECLARE ValorActual varchar(12);
    DECLARE Incremental int;
    IF EXISTS(SELECT * FROM empleadotb) THEN
        SET ValorActual = (SELECT MAX(CAST(REPLACE(REPLACE(idEmpleado,'EM',''),'','') AS UNSIGNED INTEGER)) from empleadotb);
        SET Incremental = CAST(ValorActual AS UNSIGNED INTEGER)+1;
        IF Incremental<=9 THEN    	
                SET CodGenerado = CONCAT('EM000',Incremental);        
        ELSEIF Incremental>=10 and Incremental<=99 THEN    	
                SET CodGenerado = CONCAT('EM00',Incremental);
         ELSEIF Incremental>=100 and Incremental<=999 THEN    
                SET CodGenerado = CONCAT('EM0',Incremental);	
         ELSE 
                SET CodGenerado = CONCAT('EM',Incremental);
         END IF;   
     ELSE 
     	SET CodGenerado = 'EM0001';
     END IF;
 RETURN CodGenerado;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `Fc_Horario_Codigo_Almanumerico` () RETURNS VARCHAR(12) CHARSET utf8 NO SQL
BEGIN
	DECLARE CodGenerado varchar(12);
    DECLARE ValorActual varchar(12);
    DECLARE Incremental int;
    IF EXISTS(SELECT * FROM horariotb) THEN
        SET ValorActual = (SELECT MAX(CAST(REPLACE(REPLACE(idHorario,'HO',''),'','') AS UNSIGNED INTEGER)) from horariotb);
        SET Incremental = CAST(ValorActual AS UNSIGNED INTEGER)+1;
        IF Incremental<=9 THEN    	
                SET CodGenerado = CONCAT('HO000',Incremental);        
        ELSEIF Incremental>=10 and Incremental<=99 THEN    	
                SET CodGenerado = CONCAT('H000',Incremental);
         ELSEIF Incremental>=100 and Incremental<=999 THEN    
                SET CodGenerado = CONCAT('HO0',Incremental);	
         ELSE 
                SET CodGenerado = CONCAT('H0',Incremental);
         END IF;   
     ELSE 
     	SET CodGenerado = 'H00001';
     END IF;
 RETURN CodGenerado;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `Fc_Ingreso_Codigo_Numeracion_Alfanumerico` () RETURNS VARCHAR(10) CHARSET utf8 NO SQL
BEGIN
	DECLARE CodGenerado varchar(10);
    DECLARE ValorActual varchar(10);
    DECLARE Incremental int;
    IF EXISTS(SELECT * FROM ingresotb) THEN
    	SET ValorActual = (SELECT MAX(CAST(REPLACE(REPLACE(numeracion,'',''),'','') AS UNSIGNED INTEGER)) FROM ingresotb);
        SET Incremental = CAST(ValorActual AS UNSIGNED INTEGER)+1;
        IF Incremental <=9 THEN
        	 SET CodGenerado = CONCAT('0000000',Incremental);
        ELSEIF Incremental >= 10 AND Incremental <= 99 THEN
        	 SET CodGenerado = CONCAT('000000',Incremental);
        ELSEIF Incremental >= 100 AND Incremental <= 999 THEN
        	 SET CodGenerado = CONCAT('00000',Incremental);
        ELSEIF Incremental >= 1000 AND Incremental <= 9999 THEN
        	 SET CodGenerado = CONCAT('0000',Incremental);
        ELSEIF Incremental >= 10000 AND Incremental <= 99999 THEN
        	 SET CodGenerado = CONCAT('000',Incremental);
        ELSEIF Incremental >= 100000 AND Incremental <= 999999 THEN
        	 SET CodGenerado = CONCAT('00',Incremental);
        ELSEIF Incremental >= 1000000 AND Incremental <= 9999999 THEN
        	 SET CodGenerado = CONCAT('0',Incremental);
        ELSE
        	 SET CodGenerado = CONCAT('',Incremental);
        END IF;
    ELSE
    	SET CodGenerado = "00000001";
    END IF;
	RETURN CodGenerado;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `Fc_Membresia_Codigo_Almanumerico` () RETURNS VARCHAR(12) CHARSET utf8 NO SQL
BEGIN
	DECLARE CodGenerado varchar(12);
    DECLARE ValorActual varchar(12);
    DECLARE Incremental int;
    IF EXISTS(SELECT * FROM membresiatb) THEN
        SET ValorActual = (SELECT MAX(CAST(REPLACE(REPLACE(idMembresia,'ME',''),'','')AS UNSIGNED INTEGER)) from membresiatb);
        SET Incremental = CAST(ValorActual AS UNSIGNED INTEGER)+1;
        IF Incremental<=9 THEN    	
                SET CodGenerado = CONCAT('ME000',Incremental);        
        ELSEIF Incremental>=10 and Incremental<=99 THEN    	
                SET CodGenerado = CONCAT('ME00',Incremental);
         ELSEIF Incremental>=100 and Incremental<=999 THEN    
                SET CodGenerado = CONCAT('ME0',Incremental);	
         ELSE 
                SET CodGenerado = CONCAT('ME',Incremental);
         END IF;   
     ELSE 
     	SET CodGenerado = 'ME0001';
     END IF;
 RETURN CodGenerado;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `Fc_Movimiento_Codigo_Numerico` () RETURNS VARCHAR(12) CHARSET utf8 NO SQL
BEGIN
	#Routine body goes here...
	DECLARE CodGenerado int;
	DECLARE valorActual int;
	IF EXISTS(SELECT * FROM movimientostb) THEN
		SET valorActual = (SELECT MAX(idMovimiento) from movimientostb);
		SET CodGenerado = valorActual + 1;
	ELSE
	SET CodGenerado = 1;
	END IF;
		
	RETURN CodGenerado;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `Fc_Obtener_Nombre_Periodo_Pago` (`idPeriodo` INT) RETURNS VARCHAR(30) CHARSET utf8 NO SQL
BEGIN
	DECLARE result varchar(30);
    SET result = (SELECT nombre FROM tabla_periodo_pago WHERE id = idPeriodo);
    RETURN result;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `Fc_Obtener_Nombre_Puesto` (`idPuesto` INT) RETURNS VARCHAR(30) CHARSET utf8 NO SQL
BEGIN
	DECLARE result varchar(30);
    SET result = (SELECT nombre FROM tabla_puesto WHERE id = idPuesto);
    RETURN result;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `Fc_Plan_Codigo_Almanumerico` () RETURNS VARCHAR(12) CHARSET utf8 NO SQL
BEGIN
	DECLARE CodGenerado varchar(12);
    DECLARE ValorActual varchar(12);
    DECLARE Incremental int;
    IF EXISTS(SELECT * FROM plantb) THEN
        SET ValorActual = (SELECT MAX(CAST(REPLACE(REPLACE(idPlan,'PL',''),'','') AS UNSIGNED INTEGER)) from plantb);
        SET Incremental = CAST(ValorActual AS UNSIGNED INTEGER)+1;
        IF Incremental<=9 THEN    	
                SET CodGenerado = CONCAT('PL000',Incremental);        
        ELSEIF Incremental>=10 and Incremental<=99 THEN    	
                SET CodGenerado = CONCAT('PL00',Incremental);
         ELSEIF Incremental>=100 and Incremental<=999 THEN    
                SET CodGenerado = CONCAT('PL0',Incremental);	
         ELSE 
                SET CodGenerado = CONCAT('PL',Incremental);
         END IF;   
     ELSE 
     	SET CodGenerado = 'PL0001';
     END IF;
 RETURN CodGenerado;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `Fc_Producto_Codigo_Almanumerico` () RETURNS VARCHAR(12) CHARSET utf8 NO SQL
BEGIN
	DECLARE CodGenerado varchar(12);
    DECLARE ValorActual varchar(12);
    DECLARE Incremental int;
    IF EXISTS(SELECT * FROM productotb) THEN
        SET ValorActual = (SELECT MAX(CAST(REPLACE(REPLACE(idProducto,'PD',''),'','')AS UNSIGNED INTEGER)) from productotb);
        SET Incremental = CAST(ValorActual AS UNSIGNED INTEGER)+1;
        IF Incremental<=9 THEN    	
                SET CodGenerado = CONCAT('PD000',Incremental);        
        ELSEIF Incremental>=10 and Incremental<=99 THEN    	
                SET CodGenerado = CONCAT('PD00',Incremental);
         ELSEIF Incremental>=100 and Incremental<=999 THEN    
                SET CodGenerado = CONCAT('PD0',Incremental);	
         ELSE 
                SET CodGenerado = CONCAT('PD',Incremental);
         END IF;   
     ELSE 
     	SET CodGenerado = 'PD0001';
     END IF;
 RETURN CodGenerado;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `Fc_Venta_Codigo_Almanumerico` () RETURNS VARCHAR(12) CHARSET utf8 NO SQL
BEGIN
	DECLARE CodGenerado varchar(12);
    DECLARE ValorActual varchar(12);
    DECLARE Incremental int;
    IF EXISTS(SELECT * FROM ventatb) THEN
        SET ValorActual = (SELECT MAX(CAST(REPLACE(REPLACE(idVenta,'VT',''),'','')AS UNSIGNED INTEGER)) from ventatb);
        SET Incremental = CAST(ValorActual AS UNSIGNED INTEGER)+1;
        IF Incremental<=9 THEN    	
                SET CodGenerado = CONCAT('VT000',Incremental);        
        ELSEIF Incremental>=10 and Incremental<=99 THEN    	
                SET CodGenerado = CONCAT('VT00',Incremental);
         ELSEIF Incremental>=100 and Incremental<=999 THEN    
                SET CodGenerado = CONCAT('VT0',Incremental);	
         ELSE 
                SET CodGenerado = CONCAT('VT',Incremental);
         END IF;   
     ELSE 
     	SET CodGenerado = 'VT0001';
     END IF;
 RETURN CodGenerado;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asistenciatb`
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
-- Estructura de tabla para la tabla `clientetb`
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
-- Volcado de datos para la tabla `clientetb`
--

INSERT INTO `clientetb` (`idCliente`, `dni`, `apellidos`, `nombres`, `sexo`, `fechaNacimiento`, `codigo`, `email`, `celular`, `direccion`, `predeterminado`) VALUES
('CL0001', '78945621', 'ramos del solar', 'camilo', 1, '1990-10-25', '', '', '966750883', '', 1),
('CL0002', '78945612', 'ALCAL TIMAS', 'MARIA FLOR', 0, '1987-02-04', '', '', '966750883', '', 0),
('CL0003', '78945620', 'JUAN', 'DAMIAN', 0, '2020-12-25', '', '', '123456789', '', 0),
('CL0004', '12345678', 'MARIO', 'JUAN', 1, '2020-12-02', '', '', '999998600', '', 0),
('CL0005', '12345670', 'MARIA', 'ASD', 0, '2020-12-10', '', '', '123456789', '', 0),
('CL0006', '11111111', 'VULCAN', 'VULCAN', 1, '2020-12-10', '', '', '666666', '', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contratotb`
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
-- Volcado de datos para la tabla `contratotb`
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
-- Estructura de tabla para la tabla `detalleventatb`
--

CREATE TABLE `detalleventatb` (
  `idVenta` varchar(12) NOT NULL,
  `idOrigen` varchar(12) NOT NULL,
  `cantidad` decimal(18,4) NOT NULL,
  `precio` decimal(18,4) NOT NULL,
  `subTotal` decimal(18,4) NOT NULL,
  `descuento` decimal(18,4) NOT NULL,
  `total` decimal(18,4) NOT NULL,
  `procedencia` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `detalleventatb`
--

INSERT INTO `detalleventatb` (`idVenta`, `idOrigen`, `cantidad`, `precio`, `subTotal`, `descuento`, `total`, `procedencia`) VALUES
('VT0001', 'PL0002', '1.0000', '100.0000', '100.0000', '0.0000', '100.0000', 1),
('VT0002', 'PL0002', '1.0000', '100.0000', '100.0000', '0.0000', '100.0000', 1),
('VT0003', 'PL0002', '1.0000', '100.0000', '100.0000', '0.0000', '100.0000', 1),
('VT0004', 'PL0002', '1.0000', '100.0000', '100.0000', '0.0000', '100.0000', 1),
('VT0005', 'PD0004', '1.0000', '6.5000', '6.5000', '0.0000', '6.5000', 0),
('VT0005', 'PD0006', '2.0000', '1.0000', '2.0000', '0.0000', '2.0000', 0),
('VT0006', 'PD0003', '1.0000', '3.5000', '3.5000', '0.0000', '3.5000', 0),
('VT0006', 'PD0005', '1.0000', '0.7000', '0.7000', '0.0000', '0.7000', 0),
('VT0007', 'PL0005', '1.0000', '40.0000', '40.0000', '0.0000', '40.0000', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `disciplinatb`
--

CREATE TABLE `disciplinatb` (
  `idDisciplina` varchar(12) NOT NULL,
  `nombre` varchar(80) NOT NULL,
  `color` varchar(20) NOT NULL,
  `descripcion` varchar(200) NOT NULL,
  `estado` bit(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `disciplinatb`
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
-- Estructura de tabla para la tabla `empleadotb`
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
-- Volcado de datos para la tabla `empleadotb`
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
-- Estructura de tabla para la tabla `horariotb`
--

CREATE TABLE `horariotb` (
  `idHorario` varchar(12) NOT NULL,
  `descripcion` varchar(150) NOT NULL,
  `dias` varchar(20) NOT NULL,
  `estado` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `horariotb`
--

INSERT INTO `horariotb` (`idHorario`, `descripcion`, `dias`, `estado`) VALUES
('HO0001', 'HORARIO RECEPCIONISTA NORMAL', '1,2,3,4,5', 1),
('HO0002', 'HORARIO INSTRUCTOR', '1,2,3,4,5,6,7', 1),
('HO0003', 'HORARIO RECEPCIONISTA FINES\r\n', '6,7', 1),
('HO0004', 'HORARIO DE LIMPIEZA', '1,2,3,4,5,6,7', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingresotb`
--

CREATE TABLE `ingresotb` (
  `idIngreso` int(11) NOT NULL,
  `idVenta` varchar(12) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `forma` tinyint(4) NOT NULL,
  `monto` decimal(18,4) NOT NULL,
  `serie` varchar(5) NOT NULL,
  `numeracion` varchar(10) NOT NULL,
  `procedencia` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `membresiatb`
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
  `reserva` tinyint(4) NOT NULL,
  `tipo` tinyint(4) NOT NULL,
  `estado` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mi_empresatb`
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
-- Volcado de datos para la tabla `mi_empresatb`
--

INSERT INTO `mi_empresatb` (`idMiEmpresa`, `representante`, `nombreEmpresa`, `ruc`, `telefono`, `celular`, `email`, `paginaWeb`, `direccion`, `terminos`) VALUES
(1, 'Ramos del Solar Juan', 'Apple Gym Perú', '45678912312', '064 7894566', '963225002', 'applegymperu@hotmal.com', 'www.applegymperu.com', 'Av. las Calles del Mar nro 100', 'No hay ningún tipo de reembolso por políticas de la empresa.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movimientostb`
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
-- Estructura de tabla para la tabla `plantb`
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
-- Volcado de datos para la tabla `plantb`
--

INSERT INTO `plantb` (`idPlan`, `nombre`, `tipoDisciplina`, `sesiones`, `meses`, `dias`, `freeze`, `precio`, `descripcion`, `estado`, `prueba`) VALUES
('PL0001', 'plan x', 1, 1, 2, 0, 0, 200.0000, 'puede ingresar todos los días  a cualquier horario', 1, 1),
('PL0002', 'plan normal', 1, 1, 1, 0, 0, 100.0000, 'Todos los días a cualquier hora', 1, 0),
('PL0003', 'plan mañana', 1, 1, 1, 0, 0, 60.0000, 'solo puede ingresar en las mañanas', 1, 1),
('PL0004', 'plan verano', 1, 1, 4, 0, 7, 250.0000, 'valido hasta fines de diciembre con un solo pago', 1, 1),
('PL0005', 'plan especial', 2, 1, 1, 4, 0, 40.0000, '', 1, 0),
('PL0006', 'LIBRE', 1, 1, 0, 1, 0, 15.0000, '', 1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `plantb_disciplinatb`
--

CREATE TABLE `plantb_disciplinatb` (
  `idPlan` varchar(12) NOT NULL,
  `idDisciplina` varchar(12) NOT NULL,
  `numero` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `plantb_disciplinatb`
--

INSERT INTO `plantb_disciplinatb` (`idPlan`, `idDisciplina`, `numero`) VALUES
('PL0005', 'DI0001', 31),
('PL0005', 'DI0002', 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productotb`
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
-- Volcado de datos para la tabla `productotb`
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
-- Estructura de tabla para la tabla `tabla_ocupacion`
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
-- Estructura de tabla para la tabla `tabla_periodo_pago`
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
-- Volcado de datos para la tabla `tabla_periodo_pago`
--

INSERT INTO `tabla_periodo_pago` (`id`, `nombre`, `descripcion`, `claveAlterna`, `estado`, `predeterminado`) VALUES
(1, 'MENSUAL', 'caleta', ' ', 1, 1),
(2, 'QUINSENAL', 'Ninguna', ' ', 1, 1),
(3, 'DIARIO', 'Ninguna', ' ', 0, 0),
(4, 'CADA 2 DIAS', 'bamban', ' ', 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tabla_puesto`
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
-- Volcado de datos para la tabla `tabla_puesto`
--

INSERT INTO `tabla_puesto` (`id`, `nombre`, `descripcion`, `claveAlterna`, `estado`, `predeterminado`) VALUES
(1, 'SECRETARIA', 'Encargado', '0', 1, 0),
(2, 'INSTRUCTOR', 'Encargado', '0', 1, 0),
(3, 'RECEPCIONISTA', 'Encargado', '0', 1, 0),
(4, 'LIMPIEZA', 'Ninguna', ' ', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tabla_rol`
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
-- Volcado de datos para la tabla `tabla_rol`
--

INSERT INTO `tabla_rol` (`id`, `nombre`, `descripcion`, `claveAlterna`, `estado`, `predeterminado`) VALUES
(1, 'admininistrador', 'Ninguna', ' 123456789', 1, 1),
(2, 'caja', 'Ninguna', ' ', 1, 1),
(3, 'vendedor', 'Ninguna', ' ', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `turnotb`
--

CREATE TABLE `turnotb` (
  `idTurno` int(11) NOT NULL,
  `idHorario` varchar(12) NOT NULL,
  `horaInicio` time NOT NULL,
  `horaSalida` time NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `turnotb`
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
-- Estructura de tabla para la tabla `ventacreditotb`
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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventatb`
--

CREATE TABLE `ventatb` (
  `idVenta` varchar(12) NOT NULL,
  `cliente` varchar(12) NOT NULL,
  `vendedor` varchar(12) NOT NULL,
  `documento` tinyint(4) NOT NULL,
  `serie` varchar(15) NOT NULL,
  `numeracion` varchar(30) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `subTotal` decimal(18,4) NOT NULL,
  `descuento` decimal(18,4) NOT NULL,
  `total` decimal(18,4) NOT NULL,
  `tipo` tinyint(4) NOT NULL,
  `forma` tinyint(4) NOT NULL,
  `numero` varchar(30) NOT NULL,
  `estado` tinyint(4) NOT NULL,
  `procedencia` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `asistenciatb`
--
ALTER TABLE `asistenciatb`
  ADD PRIMARY KEY (`idAsistencia`);

--
-- Indices de la tabla `clientetb`
--
ALTER TABLE `clientetb`
  ADD PRIMARY KEY (`idCliente`);

--
-- Indices de la tabla `contratotb`
--
ALTER TABLE `contratotb`
  ADD PRIMARY KEY (`idContrato`);

--
-- Indices de la tabla `detalleventatb`
--
ALTER TABLE `detalleventatb`
  ADD PRIMARY KEY (`idVenta`,`idOrigen`);

--
-- Indices de la tabla `disciplinatb`
--
ALTER TABLE `disciplinatb`
  ADD PRIMARY KEY (`idDisciplina`) USING BTREE;

--
-- Indices de la tabla `empleadotb`
--
ALTER TABLE `empleadotb`
  ADD PRIMARY KEY (`idEmpleado`);

--
-- Indices de la tabla `horariotb`
--
ALTER TABLE `horariotb`
  ADD PRIMARY KEY (`idHorario`);

--
-- Indices de la tabla `ingresotb`
--
ALTER TABLE `ingresotb`
  ADD PRIMARY KEY (`idIngreso`);

--
-- Indices de la tabla `membresiatb`
--
ALTER TABLE `membresiatb`
  ADD PRIMARY KEY (`idMembresia`);

--
-- Indices de la tabla `mi_empresatb`
--
ALTER TABLE `mi_empresatb`
  ADD PRIMARY KEY (`idMiEmpresa`);

--
-- Indices de la tabla `movimientostb`
--
ALTER TABLE `movimientostb`
  ADD PRIMARY KEY (`idMovimiento`,`idTabla`) USING BTREE;

--
-- Indices de la tabla `plantb`
--
ALTER TABLE `plantb`
  ADD PRIMARY KEY (`idPlan`);

--
-- Indices de la tabla `plantb_disciplinatb`
--
ALTER TABLE `plantb_disciplinatb`
  ADD PRIMARY KEY (`idPlan`,`idDisciplina`);

--
-- Indices de la tabla `productotb`
--
ALTER TABLE `productotb`
  ADD PRIMARY KEY (`idProducto`);

--
-- Indices de la tabla `tabla_ocupacion`
--
ALTER TABLE `tabla_ocupacion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tabla_periodo_pago`
--
ALTER TABLE `tabla_periodo_pago`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tabla_puesto`
--
ALTER TABLE `tabla_puesto`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tabla_rol`
--
ALTER TABLE `tabla_rol`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `turnotb`
--
ALTER TABLE `turnotb`
  ADD PRIMARY KEY (`idHorario`,`idTurno`);

--
-- Indices de la tabla `ventacreditotb`
--
ALTER TABLE `ventacreditotb`
  ADD PRIMARY KEY (`idVentaCredito`,`idVenta`);

--
-- Indices de la tabla `ventatb`
--
ALTER TABLE `ventatb`
  ADD PRIMARY KEY (`idVenta`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `ingresotb`
--
ALTER TABLE `ingresotb`
  MODIFY `idIngreso` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `mi_empresatb`
--
ALTER TABLE `mi_empresatb`
  MODIFY `idMiEmpresa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `tabla_ocupacion`
--
ALTER TABLE `tabla_ocupacion`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tabla_periodo_pago`
--
ALTER TABLE `tabla_periodo_pago`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `tabla_puesto`
--
ALTER TABLE `tabla_puesto`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tabla_rol`
--
ALTER TABLE `tabla_rol`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `ventacreditotb`
--
ALTER TABLE `ventacreditotb`
  MODIFY `idVentaCredito` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
