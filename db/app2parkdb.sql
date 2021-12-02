-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: app2park-db.czfynb5irn0q.us-east-1.rds.amazonaws.com:3306
-- Tempo de geração: 18/08/2020 às 15:54
-- Versão do servidor: 5.7.22-log
-- Versão do PHP: 7.2.24-0ubuntu0.18.04.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `app2parkdb`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `agreements`
--

CREATE TABLE `agreements` (
  `id` int(11) NOT NULL,
  `id_agreement_app` int(11) DEFAULT NULL,
  `id_park` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `agreement_type` int(11) DEFAULT NULL,
  `date_time` datetime DEFAULT NULL,
  `agreement_begin` datetime DEFAULT NULL,
  `agreement_end` datetime DEFAULT NULL,
  `accountable_name` varchar(100) DEFAULT NULL,
  `accountable_doc` varchar(15) DEFAULT NULL,
  `accountable_cell` varchar(15) DEFAULT NULL,
  `accountable_email` varchar(50) DEFAULT NULL,
  `send_nf` int(11) DEFAULT NULL,
  `doc_nf` int(11) DEFAULT NULL,
  `company_name` varchar(30) DEFAULT NULL,
  `company_doc` varchar(30) DEFAULT NULL,
  `company_cell` varchar(15) DEFAULT NULL,
  `company_email` varchar(50) DEFAULT NULL,
  `bank_slip_send` int(11) DEFAULT NULL,
  `payment_day` int(11) DEFAULT NULL,
  `mon` int(11) DEFAULT NULL,
  `tue` int(11) DEFAULT NULL,
  `wed` int(11) DEFAULT NULL,
  `thur` int(11) DEFAULT NULL,
  `fri` int(11) DEFAULT NULL,
  `sat` int(11) DEFAULT NULL,
  `sun` int(11) DEFAULT NULL,
  `time_on` time DEFAULT NULL,
  `time_off` time DEFAULT NULL,
  `id_price_detached` int(11) NOT NULL,
  `parking_spaces` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `plates` varchar(255) DEFAULT NULL,
  `comment` varchar(255) DEFAULT NULL,
  `status_payment` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura para tabela `cashs`
--

CREATE TABLE `cashs` (
  `id` int(11) NOT NULL,
  `id_cash_app` int(11) DEFAULT NULL,
  `id_park` int(11) DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  `sinc_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura para tabela `cash_movement`
--

CREATE TABLE `cash_movement` (
  `id` int(11) NOT NULL,
  `id_cash` int(11) DEFAULT NULL,
  `id_ticket` int(11) DEFAULT NULL,
  `id_cash_movement_app` int(11) DEFAULT NULL,
  `id_ticket_app` int(11) DEFAULT NULL,
  `date_added` datetime DEFAULT NULL,
  `id_cash_type_movement` int(11) DEFAULT NULL,
  `id_payment_method` int(11) DEFAULT NULL,
  `value` decimal(10,2) DEFAULT NULL,
  `comment` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura para tabela `cash_type_movement`
--

CREATE TABLE `cash_type_movement` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Fazendo dump de dados para tabela `cash_type_movement`
--

INSERT INTO `cash_type_movement` (`id`, `name`) VALUES
(1, 'Abertura'),
(2, 'Venda'),
(3, 'Pagamento de Despesa'),
(4, 'Reforço de Caixa'),
(5, 'Sangria'),
(6, 'Fechamento');

-- --------------------------------------------------------

--
-- Estrutura para tabela `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `id_customer_app` int(11) DEFAULT NULL,
  `cell` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `doc` varchar(14) DEFAULT NULL,
  `id_status` int(11) DEFAULT NULL,
  `date_added` datetime DEFAULT CURRENT_TIMESTAMP,
  `date_edited` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura para tabela `objects`
--

CREATE TABLE `objects` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `sort_order` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Fazendo dump de dados para tabela `objects`
--

INSERT INTO `objects` (`id`, `name`, `sort_order`) VALUES
(1, 'Óculos', 1),
(2, 'Frente de rádio', 2),
(3, 'Notebook', 3),
(4, 'Mala', 4);

-- --------------------------------------------------------

--
-- Estrutura para tabela `offices`
--

CREATE TABLE `offices` (
  `id` int(11) NOT NULL,
  `office` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Fazendo dump de dados para tabela `offices`
--

INSERT INTO `offices` (`id`, `office`) VALUES
(1, 'Proprietario'),
(2, 'Administrador'),
(3, 'Gerente'),
(4, 'Caixa'),
(5, 'Manobrista'),
(6, 'Lavador'),
(7, 'Polidor'),
(8, 'Funileiro');

-- --------------------------------------------------------

--
-- Estrutura para tabela `parks`
--

CREATE TABLE `parks` (
  `id` int(11) NOT NULL,
  `name_park` varchar(255) NOT NULL,
  `doc` varchar(14) NOT NULL,
  `business_name` varchar(255) NOT NULL,
  `photo` varchar(255) DEFAULT 'https://app2parkstorage.s3.amazonaws.com/no-photo.png',
  `postal_code` varchar(20) NOT NULL,
  `street` varchar(255) NOT NULL,
  `number` varchar(10) NOT NULL,
  `complement` varchar(255) DEFAULT NULL,
  `city` varchar(50) NOT NULL,
  `state` varchar(50) NOT NULL,
  `country` varchar(50) NOT NULL,
  `id_status` int(11) NOT NULL DEFAULT '1',
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_edited` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura para tabela `park_schedule`
--

CREATE TABLE `park_schedule` (
  `id` int(11) NOT NULL,
  `id_park` int(11) NOT NULL,
  `monday_daytime_open` varchar(255) DEFAULT NULL,
  `monday_daytime_close` varchar(255) DEFAULT NULL,
  `monday_nightly_open` varchar(255) DEFAULT NULL,
  `monday_nightly_close` varchar(255) DEFAULT NULL,
  `tuesday_daytime_open` varchar(255) DEFAULT NULL,
  `tuesday_daytime_close` varchar(255) DEFAULT NULL,
  `tuesday_nightly_open` varchar(255) DEFAULT NULL,
  `tuesday_nightly_close` varchar(255) DEFAULT NULL,
  `wednesday_daytime_open` varchar(255) DEFAULT NULL,
  `wednesday_daytime_close` varchar(255) DEFAULT NULL,
  `wednesday_nightly_open` varchar(255) DEFAULT NULL,
  `wednesday_nightly_close` varchar(255) DEFAULT NULL,
  `thursday_daytime_open` varchar(255) DEFAULT NULL,
  `thursday_daytime_close` varchar(255) DEFAULT NULL,
  `thursday_nightly_open` varchar(255) DEFAULT NULL,
  `thursday_nightly_close` varchar(255) DEFAULT NULL,
  `friday_daytime_open` varchar(255) DEFAULT NULL,
  `friday_daytime_close` varchar(255) DEFAULT NULL,
  `friday_nightly_open` varchar(255) DEFAULT NULL,
  `friday_nightly_close` varchar(255) DEFAULT NULL,
  `saturday_daytime_open` varchar(255) DEFAULT NULL,
  `saturday_daytime_close` varchar(255) DEFAULT NULL,
  `saturday_nightly_open` varchar(255) DEFAULT NULL,
  `saturday_nightly_close` varchar(255) DEFAULT NULL,
  `sunday_daytime_open` varchar(255) DEFAULT NULL,
  `sunday_daytime_close` varchar(255) DEFAULT NULL,
  `sunday_nightly_open` varchar(255) DEFAULT NULL,
  `sunday_nightly_close` varchar(255) DEFAULT NULL,
  `id_status` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura para tabela `park_service_additional`
--

CREATE TABLE `park_service_additional` (
  `id` int(11) NOT NULL,
  `id_service_additional` int(11) DEFAULT NULL,
  `id_park` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `tolerance` time DEFAULT NULL,
  `sort_order` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `date_edited` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura para tabela `park_user`
--

CREATE TABLE `park_user` (
  `id` int(11) NOT NULL,
  `id_park` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_office` int(11) NOT NULL,
  `id_status` int(11) NOT NULL,
  `keyval` varchar(255) DEFAULT NULL,
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_edited` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura para tabela `payments_method`
--

CREATE TABLE `payments_method` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `flat_rate` decimal(10,2) NOT NULL,
  `variable_rate` decimal(9,6) NOT NULL,
  `min_value` decimal(10,2) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `sort_order` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Fazendo dump de dados para tabela `payments_method`
--

INSERT INTO `payments_method` (`id`, `name`, `flat_rate`, `variable_rate`, `min_value`, `status`, `sort_order`) VALUES
(1, 'Dinheiro', '0.00', '0.000000', '0.00', 1, 1),
(2, 'Cartão de Débito', '0.00', '2.000000', '5.00', 1, 2),
(3, 'Cartão de Crédito', '0.00', '6.000000', '12.00', 1, 3);

-- --------------------------------------------------------

--
-- Estrutura para tabela `payment_method_park`
--

CREATE TABLE `payment_method_park` (
  `id` int(11) NOT NULL,
  `id_park` int(11) DEFAULT NULL,
  `id_payment_method` int(11) DEFAULT NULL,
  `flat_rate` decimal(10,2) DEFAULT NULL,
  `variable_rate` decimal(9,6) DEFAULT NULL,
  `min_value` decimal(10,2) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `sort_order` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura para tabela `price_detached`
--

CREATE TABLE `price_detached` (
  `id` int(11) NOT NULL,
  `id_price_detached_app` int(11) DEFAULT NULL,
  `id_park` int(11) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `id_vehicle_type` int(11) DEFAULT NULL,
  `id_status` int(11) DEFAULT NULL,
  `cash` int(11) DEFAULT NULL,
  `sort_order` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura para tabela `price_detached_item`
--

CREATE TABLE `price_detached_item` (
  `id` int(11) NOT NULL,
  `id_price_detached_item_app` int(11) NOT NULL,
  `id_price_detached` int(11) NOT NULL,
  `id_price_detached_item_base` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `tolerance` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura para tabela `price_detached_item_base`
--

CREATE TABLE `price_detached_item_base` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `time` datetime NOT NULL,
  `type` tinyint(4) NOT NULL,
  `level` int(11) NOT NULL,
  `id_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Fazendo dump de dados para tabela `price_detached_item_base`
--

INSERT INTO `price_detached_item_base` (`id`, `name`, `time`, `type`, `level`, `id_status`) VALUES
(0, 'Taxa de Entrada', '0000-00-00 00:00:00', 0, 0, 1),
(1, '1 Minuto Adicional', '0000-00-00 00:01:00', 1, 0, 1),
(5, 'Até 5 minutos', '0000-00-00 00:05:00', 0, 5, 1),
(6, '1 Minuto Adiconal', '0000-00-00 00:01:00', 1, 5, 1),
(10, 'Até 10 minutos', '0000-00-00 00:10:00', 0, 10, 1),
(11, '1 Minuto Adiconal', '0000-00-00 00:01:00', 1, 10, 1),
(15, 'Até 15 minutos', '0000-00-00 00:15:00', 0, 15, 1),
(16, '1 Minuto Adiconal', '0000-00-00 00:01:00', 1, 15, 1),
(20, 'Até 20 minutos', '0000-00-00 00:20:00', 0, 20, 1),
(21, '1 Minuto Adiconal', '0000-00-00 00:01:00', 1, 20, 1),
(30, 'Até 30 minutos', '0000-00-00 00:30:00', 0, 30, 1),
(31, '1 Minuto Adiconal', '0000-00-00 00:01:00', 1, 30, 1),
(40, 'Até 40 minutos', '0000-00-00 00:40:00', 0, 40, 1),
(41, '1 Minuto Adiconal', '0000-00-00 00:01:00', 1, 40, 1),
(50, 'Até 50 minutos', '0000-00-00 00:50:00', 0, 50, 1),
(51, '1 Minuto Adiconal', '0000-00-00 00:01:00', 1, 50, 1),
(100, 'Até 1 hora', '0000-00-00 01:00:00', 0, 100, 1),
(101, '1 Minuto Adiconal', '0000-00-00 00:01:00', 1, 100, 1),
(105, '5 Minutos Adiconais', '0000-00-00 00:05:00', 1, 100, 1),
(110, '10 Minutos Adiconais', '0000-00-00 00:10:00', 1, 100, 1),
(115, '15 Minutos Adiconais', '0000-00-00 00:15:00', 1, 100, 1),
(130, '30 Minutoss Adiconais', '0000-00-00 00:30:00', 1, 100, 1),
(160, 'Hora Adicional', '0000-00-00 01:00:00', 1, 100, 1),
(166, '6 Horas Adicionais', '0000-00-00 06:00:00', 1, 100, 1),
(170, '12 Horas Adicionais', '0000-00-00 12:00:00', 1, 100, 1),
(180, '24 Horas Adicionais', '0000-00-01 00:00:00', 1, 100, 1),
(200, 'Até 2 horas', '0000-00-00 02:00:00', 0, 200, 1),
(201, '1 Minuto Adiconal', '0000-00-00 00:01:00', 1, 200, 1),
(205, '5 Minutos Adiconais', '0000-00-00 00:05:00', 1, 200, 1),
(210, '10 Minutos Adiconais', '0000-00-00 00:10:00', 1, 200, 1),
(215, '15 Minutos Adiconais', '0000-00-00 00:15:00', 1, 200, 1),
(230, '30 Minutoss Adiconais', '0000-00-00 00:30:00', 1, 200, 1),
(260, 'Hora Adicional', '0000-00-00 01:00:00', 1, 200, 1),
(266, '6 Horas Adicionais', '0000-00-00 06:00:00', 1, 200, 1),
(270, '12 Horas Adicionais', '0000-00-00 12:00:00', 1, 200, 1),
(280, '24 Horas Adicionais', '0000-00-01 00:00:00', 1, 200, 1),
(300, 'Até 3 horas', '0000-00-00 03:00:00', 0, 300, 1),
(301, '1 Minuto Adiconal', '0000-00-00 00:01:00', 1, 300, 1),
(305, '5 Minutos Adiconais', '0000-00-00 00:05:00', 1, 300, 1),
(310, '10 Minutos Adiconais', '0000-00-00 00:10:00', 1, 300, 1),
(315, '15 Minutos Adiconais', '0000-00-00 00:15:00', 1, 300, 1),
(330, '30 Minutoss Adiconais', '0000-00-00 00:30:00', 1, 300, 1),
(360, 'Hora Adicional', '0000-00-00 01:00:00', 1, 300, 1),
(366, '6 Horas Adicionais', '0000-00-00 06:00:00', 1, 300, 1),
(370, '12 Horas Adicionais', '0000-00-00 12:00:00', 1, 300, 1),
(380, '24 Horas Adicionais', '0000-00-01 00:00:00', 1, 300, 1),
(400, 'Até 4 horas', '0000-00-00 04:00:00', 0, 400, 1),
(401, '1 Minuto Adiconal', '0000-00-00 00:01:00', 1, 400, 1),
(405, '5 Minutos Adiconais', '0000-00-00 00:05:00', 1, 400, 1),
(410, '10 Minutos Adiconais', '0000-00-00 00:10:00', 1, 400, 1),
(415, '15 Minutos Adiconais', '0000-00-00 00:15:00', 1, 400, 1),
(430, '30 Minutoss Adiconais', '0000-00-00 00:30:00', 1, 400, 1),
(460, 'Hora Adicional', '0000-00-00 01:00:00', 1, 400, 1),
(466, '6 Horas Adicionais', '0000-00-00 06:00:00', 1, 400, 1),
(470, '12 Horas Adicionais', '0000-00-00 12:00:00', 1, 400, 1),
(480, '24 Horas Adicionais', '0000-00-01 00:00:00', 1, 400, 1),
(500, 'Até 5 horas', '0000-00-00 05:00:00', 0, 500, 1),
(501, '1 Minuto Adiconal', '0000-00-00 00:01:00', 1, 500, 1),
(505, '5 Minutos Adiconais', '0000-00-00 00:05:00', 1, 500, 1),
(510, '10 Minutos Adiconais', '0000-00-00 00:10:00', 1, 500, 1),
(515, '15 Minutos Adiconais', '0000-00-00 00:15:00', 1, 500, 1),
(530, '30 Minutoss Adiconais', '0000-00-00 00:30:00', 1, 500, 1),
(560, 'Hora Adicional', '0000-00-00 01:00:00', 1, 500, 1),
(566, '6 Horas Adicionais', '0000-00-00 06:00:00', 1, 500, 1),
(570, '12 Horas Adicionais', '0000-00-00 12:00:00', 1, 500, 1),
(580, '24 Horas Adicionais', '0000-00-01 00:00:00', 1, 500, 1),
(600, 'Até 6 horas', '0000-00-00 06:00:00', 0, 600, 1),
(601, '1 Minuto Adiconal', '0000-00-00 00:01:00', 1, 600, 1),
(605, '5 Minutos Adiconais', '0000-00-00 00:05:00', 1, 600, 1),
(610, '10 Minutos Adiconais', '0000-00-00 00:10:00', 1, 600, 1),
(615, '15 Minutos Adiconais', '0000-00-00 00:15:00', 1, 600, 1),
(630, '30 Minutoss Adiconais', '0000-00-00 00:30:00', 1, 600, 1),
(660, 'Hora Adicional', '0000-00-00 01:00:00', 1, 600, 1),
(666, '6 Horas Adicionais', '0000-00-00 06:00:00', 1, 600, 1),
(670, '12 Horas Adicionais', '0000-00-00 12:00:00', 1, 600, 1),
(680, '24 Horas Adicionais', '0000-00-01 00:00:00', 1, 600, 1),
(700, 'Até 7 horas', '0000-00-00 07:00:00', 0, 700, 1),
(701, '1 Minuto Adiconal', '0000-00-00 00:01:00', 1, 700, 1),
(705, '5 Minutos Adiconais', '0000-00-00 00:05:00', 1, 700, 1),
(710, '10 Minutos Adiconais', '0000-00-00 00:10:00', 1, 700, 1),
(715, '15 Minutos Adiconais', '0000-00-00 00:15:00', 1, 700, 1),
(730, '30 Minutoss Adiconais', '0000-00-00 00:30:00', 1, 700, 1),
(760, 'Hora Adicional', '0000-00-00 01:00:00', 1, 700, 1),
(766, '6 Horas Adicionais', '0000-00-00 06:00:00', 1, 700, 1),
(770, '12 Horas Adicionais', '0000-00-00 12:00:00', 1, 700, 1),
(780, '24 Horas Adicionais', '0000-00-01 00:00:00', 1, 700, 1),
(800, 'Até 8 horas', '0000-00-00 08:00:00', 0, 800, 1),
(801, '1 Minuto Adiconal', '0000-00-00 00:01:00', 1, 800, 1),
(805, '5 Minutos Adiconais', '0000-00-00 00:05:00', 1, 800, 1),
(810, '10 Minutos Adiconais', '0000-00-00 00:10:00', 1, 800, 1),
(815, '15 Minutos Adiconais', '0000-00-00 00:15:00', 1, 800, 1),
(830, '30 Minutoss Adiconais', '0000-00-00 00:30:00', 1, 800, 1),
(860, 'Hora Adicional', '0000-00-00 01:00:00', 1, 800, 1),
(866, '6 Horas Adicionais', '0000-00-00 06:00:00', 1, 800, 1),
(870, '12 Horas Adicionais', '0000-00-00 12:00:00', 1, 800, 1),
(880, '24 Horas Adicionais', '0000-00-01 00:00:00', 1, 800, 1),
(900, 'Até 9 horas', '0000-00-00 09:00:00', 0, 900, 1),
(901, '1 Minuto Adiconal', '0000-00-00 00:01:00', 1, 900, 1),
(905, '5 Minutos Adiconais', '0000-00-00 00:05:00', 1, 900, 1),
(910, '10 Minutos Adiconais', '0000-00-00 00:10:00', 1, 900, 1),
(915, '15 Minutos Adiconais', '0000-00-00 00:15:00', 1, 900, 1),
(930, '30 Minutoss Adiconais', '0000-00-00 00:30:00', 1, 900, 1),
(960, 'Hora Adicional', '0000-00-00 01:00:00', 1, 900, 1),
(966, '6 Horas Adicionais', '0000-00-00 06:00:00', 1, 900, 1),
(970, '12 Horas Adicionais', '0000-00-00 12:00:00', 1, 900, 1),
(980, '24 Horas Adicionais', '0000-00-01 00:00:00', 1, 900, 1),
(1000, 'Até 10 horas', '0000-00-00 10:00:00', 0, 1000, 1),
(1001, '1 Minuto Adiconal', '0000-00-00 00:01:00', 1, 1000, 1),
(1005, '5 Minutos Adiconais', '0000-00-00 00:05:00', 1, 1000, 1),
(1010, '10 Minutos Adiconais', '0000-00-00 00:10:00', 1, 1000, 1),
(1015, '15 Minutos Adiconais', '0000-00-00 00:15:00', 1, 1000, 1),
(1030, '30 Minutoss Adiconais', '0000-00-00 00:30:00', 1, 1000, 1),
(1060, 'Hora Adicional', '0000-00-00 01:00:00', 1, 1000, 1),
(1066, '6 Horas Adicionais', '0000-00-00 06:00:00', 1, 1000, 1),
(1070, '12 Horas Adicionais', '0000-00-00 12:00:00', 1, 1000, 1),
(1080, '24 Horas Adicionais', '0000-00-01 00:00:00', 1, 1000, 1),
(1100, 'Até 11 horas', '0000-00-00 11:00:00', 0, 1100, 1),
(1101, '1 Minuto Adiconal', '0000-00-00 00:01:00', 1, 1100, 1),
(1105, '5 Minutos Adiconais', '0000-00-00 00:05:00', 1, 1100, 1),
(1110, '10 Minutos Adiconais', '0000-00-00 00:10:00', 1, 1100, 1),
(1115, '15 Minutos Adiconais', '0000-00-00 00:15:00', 1, 1100, 1),
(1130, '30 Minutoss Adiconais', '0000-00-00 00:30:00', 1, 1100, 1),
(1160, 'Hora Adicional', '0000-00-00 01:00:00', 1, 1100, 1),
(1166, '6 Horas Adicionais', '0000-00-00 06:00:00', 1, 1100, 1),
(1170, '12 Horas Adicionais', '0000-00-00 12:00:00', 1, 1100, 1),
(1180, '24 Horas Adicionais', '0000-00-01 00:00:00', 1, 1100, 1),
(1200, 'Até 12 horas', '0000-00-00 12:00:00', 0, 1200, 1),
(1201, '1 Minuto Adiconal', '0000-00-00 00:01:00', 1, 1200, 1),
(1205, '5 Minutos Adiconais', '0000-00-00 00:05:00', 1, 1200, 1),
(1210, '10 Minutos Adiconais', '0000-00-00 00:10:00', 1, 1200, 1),
(1215, '15 Minutos Adiconais', '0000-00-00 00:15:00', 1, 1200, 1),
(1230, '30 Minutoss Adiconais', '0000-00-00 00:30:00', 1, 1200, 1),
(1260, 'Hora Adicional', '0000-00-00 01:00:00', 1, 1200, 1),
(1266, '6 Horas Adicionais', '0000-00-00 06:00:00', 1, 1200, 1),
(1270, '12 Horas Adicionais', '0000-00-00 12:00:00', 1, 1200, 1),
(1280, '24 Horas Adicionais', '0000-00-01 00:00:00', 1, 1200, 1),
(1500, 'Até 15 horas', '0000-00-00 15:00:00', 0, 1500, 1),
(1501, '1 Minuto Adiconal', '0000-00-00 00:01:00', 1, 1500, 1),
(1505, '5 Minutos Adiconais', '0000-00-00 00:05:00', 1, 1500, 1),
(1510, '10 Minutos Adiconais', '0000-00-00 00:10:00', 1, 1500, 1),
(1515, '15 Minutos Adiconais', '0000-00-00 00:15:00', 1, 1500, 1),
(1530, '30 Minutoss Adiconais', '0000-00-00 00:30:00', 1, 1500, 1),
(1560, 'Hora Adicional', '0000-00-00 01:00:00', 1, 1500, 1),
(1566, '6 Horas Adicionais', '0000-00-00 06:00:00', 1, 1500, 1),
(1570, '12 Horas Adicionais', '0000-00-00 12:00:00', 1, 1500, 1),
(1580, '24 Horas Adicionais', '0000-00-01 00:00:00', 1, 1500, 1),
(2000, 'Até 20 horas', '0000-00-00 20:00:00', 0, 2000, 1),
(2001, '1 Minuto Adiconal', '0000-00-00 00:01:00', 1, 2000, 1),
(2005, '5 Minutos Adiconais', '0000-00-00 00:05:00', 1, 2000, 1),
(2010, '10 Minutos Adiconais', '0000-00-00 00:10:00', 1, 2000, 1),
(2015, '15 Minutos Adiconais', '0000-00-00 00:15:00', 1, 2000, 1),
(2030, '30 Minutoss Adiconais', '0000-00-00 00:30:00', 1, 2000, 1),
(2060, 'Hora Adicional', '0000-00-00 01:00:00', 1, 2000, 1),
(2066, '6 Horas Adicionais', '0000-00-00 06:00:00', 1, 2000, 1),
(2070, '12 Horas Adicionais', '0000-00-00 12:00:00', 1, 2000, 1),
(2080, '24 Horas Adicionais', '0000-00-01 00:00:00', 1, 2000, 1),
(2400, 'Até 24 horas', '0000-00-01 00:00:00', 0, 2400, 1),
(2401, '1 Minuto Adiconal', '0000-00-00 00:01:00', 1, 2400, 1),
(2405, '5 Minutos Adiconais', '0000-00-00 00:05:00', 1, 2400, 1),
(2410, '10 Minutos Adiconais', '0000-00-00 00:10:00', 1, 2400, 1),
(2415, '15 Minutos Adiconais', '0000-00-00 00:15:00', 1, 2400, 1),
(2430, '30 Minutoss Adiconais', '0000-00-00 00:30:00', 1, 2400, 1),
(2460, 'Hora Adicional', '0000-00-00 01:00:00', 1, 2400, 1),
(2466, '6 Horas Adicionais', '0000-00-00 06:00:00', 1, 2400, 1),
(2470, '12 Horas Adicionais', '0000-00-00 12:00:00', 1, 2400, 1),
(2480, '24 Horas Adicionais', '0000-00-01 00:00:00', 1, 2400, 1),
(10000, 'Diária', '0000-00-01 00:00:00', 0, 10000, 1),
(10100, 'Hora Adicional', '0000-00-00 01:00:00', 1, 10000, 1),
(12400, 'Diária Adicional', '0000-00-01 00:00:00', 1, 10000, 1),
(70000, 'Semana', '0000-00-07 00:00:00', 0, 70000, 1),
(70100, 'Hora Adicional', '0000-00-00 01:00:00', 1, 70000, 1),
(72400, '24 Horas Adicionais', '0000-00-01 00:00:00', 1, 70000, 1),
(79000, 'Semana Adicional', '0000-00-07 00:00:00', 1, 70000, 1),
(1000000, 'Mês', '0000-01-00 00:00:00', 0, 1000000, 1),
(1000100, 'Hora Adicional', '0000-00-00 01:00:00', 1, 1000000, 1),
(1010000, '24 Horas Adicionais', '0000-00-01 00:00:00', 1, 1000000, 1),
(1070000, 'Semana Adicional', '0000-00-07 00:00:00', 1, 1000000, 1),
(1300000, 'Mês Adicional', '0000-01-00 00:00:00', 1, 1000000, 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `reset_password`
--

CREATE TABLE `reset_password` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `keyval` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura para tabela `service_additional`
--

CREATE TABLE `service_additional` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `id_vehicle_type` int(11) NOT NULL,
  `sort_order` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Fazendo dump de dados para tabela `service_additional`
--

INSERT INTO `service_additional` (`id`, `name`, `id_vehicle_type`, `sort_order`) VALUES
(1, 'Lavagem com cera - Carro Pequeno', 1, 1),
(2, 'Lavagem com cera - Carro Médio', 1, 2),
(3, 'Lavagem com cera - Carro Pequeno', 1, 3),
(4, 'Lavagem sem cera - Carro Pequeno ', 1, 4),
(5, 'Lavagem sem cera - Carro Médio ', 1, 5),
(6, 'Lavagem sem cera - Carro Pequeno', 1, 6),
(7, 'Higienização - Carro Pequeno', 1, 7),
(8, 'Higienização - Carro Médio', 1, 8),
(9, 'Higienização - Carro Pequeno ', 1, 9),
(10, 'Funilaria e Pintura - Carro ', 1, 10),
(11, 'Lavagem Completa - Moto', 2, 11),
(12, 'Funilaria e Pintura - Moto', 2, 12),
(13, 'Lavagem Completa - Caminhão', 3, 13),
(14, 'Funilaria e Pintura - Caminhão ', 3, 14);

-- --------------------------------------------------------

--
-- Estrutura para tabela `status`
--

CREATE TABLE `status` (
  `id` int(11) NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Fazendo dump de dados para tabela `status`
--

INSERT INTO `status` (`id`, `status`) VALUES
(0, 'Inativo'),
(1, 'Ativo');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tickets`
--

CREATE TABLE `tickets` (
  `id` int(11) NOT NULL,
  `id_ticket_app` int(11) DEFAULT NULL,
  `id_park` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_vehicle` int(11) DEFAULT NULL,
  `id_vehicle_app` int(11) DEFAULT NULL,
  `id_customer` int(11) DEFAULT NULL,
  `id_customer_app` int(11) DEFAULT NULL,
  `id_agreement` int(11) DEFAULT NULL,
  `id_agreement_app` int(11) DEFAULT NULL,
  `id_cupom` int(11) NOT NULL,
  `cupom_entrance_datetime` datetime NOT NULL,
  `sinc_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura para tabela `ticket_historic`
--

CREATE TABLE `ticket_historic` (
  `id` int(11) NOT NULL,
  `id_ticket_historic_app` int(11) DEFAULT NULL,
  `id_ticket` int(11) DEFAULT NULL,
  `id_ticket_app` int(11) DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  `id_ticket_historic_status` tinyint(4) DEFAULT NULL,
  `id_service_additional` int(11) DEFAULT NULL,
  `date_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura para tabela `ticket_historic_photo`
--

CREATE TABLE `ticket_historic_photo` (
  `id` int(11) NOT NULL,
  `id_historic_photo_app` int(11) DEFAULT NULL,
  `id_ticket_historic` int(11) DEFAULT NULL,
  `id_ticket_historic_app` int(11) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `date_time` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura para tabela `ticket_historic_status`
--

CREATE TABLE `ticket_historic_status` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Fazendo dump de dados para tabela `ticket_historic_status`
--

INSERT INTO `ticket_historic_status` (`id`, `name`) VALUES
(0, 'Leitura da placa do veículo'),
(1, 'Entrada cancelada'),
(2, 'Entrada aceita'),
(3, 'Aguardando manobrista para entrada'),
(4, 'Com o manobrista para entrada'),
(5, 'Executando Serviços adicionais'),
(6, 'Estacionado'),
(7, 'Cliente solicitou saída pelo APP'),
(8, 'Cliente solicitou saída pessoalmente'),
(9, 'Aguardando manobrista para saída'),
(10, 'Com o manobrista para saída'),
(11, 'Entregue para o cliente');

-- --------------------------------------------------------

--
-- Estrutura para tabela `ticket_object`
--

CREATE TABLE `ticket_object` (
  `id` int(11) NOT NULL,
  `id_ticket_object_app` int(11) NOT NULL,
  `id_ticket` int(11) NOT NULL,
  `id_ticket_app` int(11) DEFAULT NULL,
  `id_object` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura para tabela `ticket_service_additional`
--

CREATE TABLE `ticket_service_additional` (
  `id` int(11) NOT NULL,
  `id_ticket_service_additional_app` int(11) DEFAULT NULL,
  `id_ticket` int(11) DEFAULT NULL,
  `id_ticket_app` int(11) DEFAULT NULL,
  `id_park_service_additional` int(11) DEFAULT NULL,
  `name` varchar(30) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `tolerance` time DEFAULT NULL,
  `finish_estimate` datetime DEFAULT NULL,
  `price_justification` varchar(30) DEFAULT NULL,
  `observation` varchar(30) DEFAULT NULL,
  `id_status` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura para tabela `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `cell` varchar(50) NOT NULL,
  `doc` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `id_status` int(11) NOT NULL DEFAULT '1',
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_edited` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura para tabela `vehicles`
--

CREATE TABLE `vehicles` (
  `id` int(11) NOT NULL,
  `id_vehicle_type` int(11) DEFAULT NULL,
  `id_vehicle_maker` int(11) DEFAULT NULL,
  `id_vehicle_model` int(11) DEFAULT NULL,
  `id_vehicle_color` int(11) DEFAULT NULL,
  `plate` varchar(255) NOT NULL,
  `year` varchar(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura para tabela `vehicle_color`
--

CREATE TABLE `vehicle_color` (
  `id` int(11) NOT NULL,
  `color` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura para tabela `vehicle_customer`
--

CREATE TABLE `vehicle_customer` (
  `id` int(11) NOT NULL,
  `id_vehicle_customer_app` int(11) DEFAULT NULL,
  `id_customer` int(11) NOT NULL,
  `id_customer_app` int(11) DEFAULT NULL,
  `id_vehicle` int(11) NOT NULL,
  `id_vehicle_app` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura para tabela `vehicle_maker`
--

CREATE TABLE `vehicle_maker` (
  `id` int(11) NOT NULL,
  `maker` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura para tabela `vehicle_model`
--

CREATE TABLE `vehicle_model` (
  `id` int(11) NOT NULL,
  `id_vehicle_maker` int(11) NOT NULL,
  `model` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura para tabela `vehicle_type`
--

CREATE TABLE `vehicle_type` (
  `id` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  `sort_order` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Fazendo dump de dados para tabela `vehicle_type`
--

INSERT INTO `vehicle_type` (`id`, `type`, `status`, `sort_order`) VALUES
(1, 'Carro', 1, 1),
(2, 'Moto', 0, 2),
(3, 'Caminhão', 0, 3);

-- --------------------------------------------------------

--
-- Estrutura para tabela `vehicle_type_park`
--

CREATE TABLE `vehicle_type_park` (
  `id` int(11) NOT NULL,
  `id_vehicle_type` int(11) DEFAULT NULL,
  `id_park` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `sort_order` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Índices de tabelas apagadas
--

--
-- Índices de tabela `agreements`
--
ALTER TABLE `agreements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_price_detached` (`id_price_detached`),
  ADD KEY `id_park` (`id_park`) USING BTREE;

--
-- Índices de tabela `cashs`
--
ALTER TABLE `cashs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_park` (`id_park`),
  ADD KEY `id_user` (`id_user`);

--
-- Índices de tabela `cash_movement`
--
ALTER TABLE `cash_movement`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_ticket` (`id_ticket`),
  ADD KEY `id_payment_method` (`id_payment_method`),
  ADD KEY `id_cash` (`id_cash`) USING BTREE,
  ADD KEY `id_cash_type_movement` (`id_cash_type_movement`) USING BTREE;

--
-- Índices de tabela `cash_type_movement`
--
ALTER TABLE `cash_type_movement`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_status` (`id_status`);

--
-- Índices de tabela `objects`
--
ALTER TABLE `objects`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `offices`
--
ALTER TABLE `offices`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `parks`
--
ALTER TABLE `parks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_status` (`id_status`);

--
-- Índices de tabela `park_schedule`
--
ALTER TABLE `park_schedule`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_park` (`id_park`),
  ADD KEY `id_status` (`id_status`);

--
-- Índices de tabela `park_service_additional`
--
ALTER TABLE `park_service_additional`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_service_additional` (`id_service_additional`),
  ADD KEY `id_park` (`id_park`);

--
-- Índices de tabela `park_user`
--
ALTER TABLE `park_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_park` (`id_park`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_office` (`id_office`);

--
-- Índices de tabela `payments_method`
--
ALTER TABLE `payments_method`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `payment_method_park`
--
ALTER TABLE `payment_method_park`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_park` (`id_park`),
  ADD KEY `id_payment_method` (`id_payment_method`);

--
-- Índices de tabela `price_detached`
--
ALTER TABLE `price_detached`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_park` (`id_park`),
  ADD KEY `id_vehicle_type` (`id_vehicle_type`),
  ADD KEY `id_status` (`id_status`);

--
-- Índices de tabela `price_detached_item`
--
ALTER TABLE `price_detached_item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_price_detached` (`id_price_detached`),
  ADD KEY `id_price_detached_item_base` (`id_price_detached_item_base`);

--
-- Índices de tabela `price_detached_item_base`
--
ALTER TABLE `price_detached_item_base`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `reset_password`
--
ALTER TABLE `reset_password`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_user` (`id_user`);

--
-- Índices de tabela `service_additional`
--
ALTER TABLE `service_additional`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_vehicle_type` (`id_vehicle_type`);

--
-- Índices de tabela `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_vehicle` (`id_vehicle`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_park` (`id_park`),
  ADD KEY `id_customer` (`id_customer`);

--
-- Índices de tabela `ticket_historic`
--
ALTER TABLE `ticket_historic`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_ticket` (`id_ticket`),
  ADD KEY `id_ticket_historic_status` (`id_ticket_historic_status`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_service_additional` (`id_service_additional`);

--
-- Índices de tabela `ticket_historic_photo`
--
ALTER TABLE `ticket_historic_photo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_ticket_historic` (`id_ticket_historic`);

--
-- Índices de tabela `ticket_historic_status`
--
ALTER TABLE `ticket_historic_status`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `ticket_object`
--
ALTER TABLE `ticket_object`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_ticket` (`id_ticket`),
  ADD KEY `id_object` (`id_object`);

--
-- Índices de tabela `ticket_service_additional`
--
ALTER TABLE `ticket_service_additional`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_park_service_additional` (`id_park_service_additional`),
  ADD KEY `id_ticket` (`id_ticket`) USING BTREE;

--
-- Índices de tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_status` (`id_status`);

--
-- Índices de tabela `vehicles`
--
ALTER TABLE `vehicles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_vehicle_type` (`id_vehicle_type`),
  ADD KEY `id_vehicle_maker` (`id_vehicle_maker`),
  ADD KEY `id_vehicle_model` (`id_vehicle_model`),
  ADD KEY `id_vehicle_color` (`id_vehicle_color`);

--
-- Índices de tabela `vehicle_color`
--
ALTER TABLE `vehicle_color`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `vehicle_customer`
--
ALTER TABLE `vehicle_customer`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_customer` (`id_customer`),
  ADD KEY `id_vehicle` (`id_vehicle`);

--
-- Índices de tabela `vehicle_maker`
--
ALTER TABLE `vehicle_maker`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `vehicle_model`
--
ALTER TABLE `vehicle_model`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_vehicle_maker` (`id_vehicle_maker`);

--
-- Índices de tabela `vehicle_type`
--
ALTER TABLE `vehicle_type`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `vehicle_type_park`
--
ALTER TABLE `vehicle_type_park`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_vehicle_type` (`id_vehicle_type`),
  ADD KEY `id_park` (`id_park`);

--
-- AUTO_INCREMENT de tabelas apagadas
--

--
-- AUTO_INCREMENT de tabela `agreements`
--
ALTER TABLE `agreements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de tabela `cashs`
--
ALTER TABLE `cashs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de tabela `cash_movement`
--
ALTER TABLE `cash_movement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de tabela `cash_type_movement`
--
ALTER TABLE `cash_type_movement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de tabela `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de tabela `objects`
--
ALTER TABLE `objects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de tabela `offices`
--
ALTER TABLE `offices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de tabela `parks`
--
ALTER TABLE `parks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de tabela `park_schedule`
--
ALTER TABLE `park_schedule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de tabela `park_service_additional`
--
ALTER TABLE `park_service_additional`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de tabela `park_user`
--
ALTER TABLE `park_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de tabela `payments_method`
--
ALTER TABLE `payments_method`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de tabela `payment_method_park`
--
ALTER TABLE `payment_method_park`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de tabela `price_detached`
--
ALTER TABLE `price_detached`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de tabela `price_detached_item`
--
ALTER TABLE `price_detached_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de tabela `reset_password`
--
ALTER TABLE `reset_password`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de tabela `service_additional`
--
ALTER TABLE `service_additional`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de tabela `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de tabela `ticket_historic`
--
ALTER TABLE `ticket_historic`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de tabela `ticket_historic_photo`
--
ALTER TABLE `ticket_historic_photo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de tabela `ticket_object`
--
ALTER TABLE `ticket_object`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de tabela `ticket_service_additional`
--
ALTER TABLE `ticket_service_additional`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de tabela `vehicles`
--
ALTER TABLE `vehicles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de tabela `vehicle_color`
--
ALTER TABLE `vehicle_color`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de tabela `vehicle_customer`
--
ALTER TABLE `vehicle_customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de tabela `vehicle_maker`
--
ALTER TABLE `vehicle_maker`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de tabela `vehicle_model`
--
ALTER TABLE `vehicle_model`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de tabela `vehicle_type`
--
ALTER TABLE `vehicle_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de tabela `vehicle_type_park`
--
ALTER TABLE `vehicle_type_park`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Restrições para dumps de tabelas
--

--
-- Restrições para tabelas `agreements`
--
ALTER TABLE `agreements`
  ADD CONSTRAINT `fk_id_park_parks_agreements` FOREIGN KEY (`id_park`) REFERENCES `parks` (`id`),
  ADD CONSTRAINT `fk_id_user_users_agreements` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`);

--
-- Restrições para tabelas `cashs`
--
ALTER TABLE `cashs`
  ADD CONSTRAINT `fk_id_park_parks_cashiers` FOREIGN KEY (`id_park`) REFERENCES `parks` (`id`),
  ADD CONSTRAINT `fk_id_user_users_cashiers` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`);

--
-- Restrições para tabelas `cash_movement`
--
ALTER TABLE `cash_movement`
  ADD CONSTRAINT `fk_id_cash_cash_cash_movement` FOREIGN KEY (`id_cash`) REFERENCES `cashs` (`id`),
  ADD CONSTRAINT `fk_id_cash_type_movement_cash_type_movement_cash_moveme` FOREIGN KEY (`id_cash_type_movement`) REFERENCES `cash_type_movement` (`id`),
  ADD CONSTRAINT `fk_id_payment_method_payments_method_cash_movement` FOREIGN KEY (`id_payment_method`) REFERENCES `payments_method` (`id`),
  ADD CONSTRAINT `fk_id_ticket_tickets_cash_movement` FOREIGN KEY (`id_ticket`) REFERENCES `tickets` (`id`);

--
-- Restrições para tabelas `customers`
--
ALTER TABLE `customers`
  ADD CONSTRAINT `fk_id_status_drivers` FOREIGN KEY (`id_status`) REFERENCES `status` (`id`);

--
-- Restrições para tabelas `parks`
--
ALTER TABLE `parks`
  ADD CONSTRAINT `fk_id_status_parks` FOREIGN KEY (`id_status`) REFERENCES `status` (`id`);

--
-- Restrições para tabelas `park_schedule`
--
ALTER TABLE `park_schedule`
  ADD CONSTRAINT `fk_id_park_park_schedule` FOREIGN KEY (`id_park`) REFERENCES `parks` (`id`),
  ADD CONSTRAINT `fk_id_status_park_schedule` FOREIGN KEY (`id_status`) REFERENCES `status` (`id`);

--
-- Restrições para tabelas `park_service_additional`
--
ALTER TABLE `park_service_additional`
  ADD CONSTRAINT `fk_id_park_parks_park_service_additional` FOREIGN KEY (`id_park`) REFERENCES `parks` (`id`),
  ADD CONSTRAINT `fk_id_service_additional_service_additional_park_service_additio` FOREIGN KEY (`id_service_additional`) REFERENCES `service_additional` (`id`);

--
-- Restrições para tabelas `park_user`
--
ALTER TABLE `park_user`
  ADD CONSTRAINT `fk_id_office_park_user` FOREIGN KEY (`id_office`) REFERENCES `offices` (`id`),
  ADD CONSTRAINT `fk_id_park_park_user` FOREIGN KEY (`id_park`) REFERENCES `parks` (`id`),
  ADD CONSTRAINT `fk_id_user_park_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`);

--
-- Restrições para tabelas `payment_method_park`
--
ALTER TABLE `payment_method_park`
  ADD CONSTRAINT `fk_id_park_parks_payment_method_park` FOREIGN KEY (`id_park`) REFERENCES `parks` (`id`),
  ADD CONSTRAINT `fk_id_payment_method_payments_method_payment_method_park` FOREIGN KEY (`id_payment_method`) REFERENCES `payments_method` (`id`);

--
-- Restrições para tabelas `price_detached`
--
ALTER TABLE `price_detached`
  ADD CONSTRAINT `fk_id_park_parks_price_detached` FOREIGN KEY (`id_park`) REFERENCES `parks` (`id`),
  ADD CONSTRAINT `fk_id_status_type_status_price_detached` FOREIGN KEY (`id_status`) REFERENCES `status` (`id`),
  ADD CONSTRAINT `fk_id_vehicle_type_vehicle_type_price_detached` FOREIGN KEY (`id_vehicle_type`) REFERENCES `vehicle_type` (`id`);

--
-- Restrições para tabelas `price_detached_item`
--
ALTER TABLE `price_detached_item`
  ADD CONSTRAINT `fk_id_price_detached_item_base_price_detached_item` FOREIGN KEY (`id_price_detached_item_base`) REFERENCES `price_detached_item_base` (`id`),
  ADD CONSTRAINT `fk_id_price_detached_price_detached_item` FOREIGN KEY (`id_price_detached`) REFERENCES `price_detached` (`id`);

--
-- Restrições para tabelas `service_additional`
--
ALTER TABLE `service_additional`
  ADD CONSTRAINT `fk_id_vehicle_type_vehicle_type_service_additional` FOREIGN KEY (`id_vehicle_type`) REFERENCES `vehicle_type` (`id`);

--
-- Restrições para tabelas `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `fk_id_customer_customers_tickets` FOREIGN KEY (`id_customer`) REFERENCES `customers` (`id`),
  ADD CONSTRAINT `fk_id_park_parks_tickets` FOREIGN KEY (`id_park`) REFERENCES `parks` (`id`),
  ADD CONSTRAINT `fk_id_user_users_tickets` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_id_vehicle_vehicles_tickets` FOREIGN KEY (`id_vehicle`) REFERENCES `vehicles` (`id`);

--
-- Restrições para tabelas `ticket_historic`
--
ALTER TABLE `ticket_historic`
  ADD CONSTRAINT `fk_id_ticket_tickets_ticket_historic` FOREIGN KEY (`id_ticket`) REFERENCES `tickets` (`id`),
  ADD CONSTRAINT `fk_id_user_users_ticket_historic` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`);

--
-- Restrições para tabelas `ticket_historic_photo`
--
ALTER TABLE `ticket_historic_photo`
  ADD CONSTRAINT `fk_id_ticket_historic_ticket_historic_ticket_historic_photo` FOREIGN KEY (`id_ticket_historic`) REFERENCES `ticket_historic` (`id`);

--
-- Restrições para tabelas `ticket_object`
--
ALTER TABLE `ticket_object`
  ADD CONSTRAINT `fk_id_object_objects_ticket_objects` FOREIGN KEY (`id_object`) REFERENCES `objects` (`id`),
  ADD CONSTRAINT `fk_id_ticket_tickets_ticket_object` FOREIGN KEY (`id_ticket`) REFERENCES `tickets` (`id`);

--
-- Restrições para tabelas `ticket_service_additional`
--
ALTER TABLE `ticket_service_additional`
  ADD CONSTRAINT `fk_id_park_service_additional_park_services_ticket_service_addit` FOREIGN KEY (`id_park_service_additional`) REFERENCES `park_service_additional` (`id`),
  ADD CONSTRAINT `fk_id_ticket_tickets_ticket_service_additional` FOREIGN KEY (`id_ticket`) REFERENCES `tickets` (`id`);

--
-- Restrições para tabelas `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_id_status_users` FOREIGN KEY (`id_status`) REFERENCES `status` (`id`);

--
-- Restrições para tabelas `vehicles`
--
ALTER TABLE `vehicles`
  ADD CONSTRAINT `fk_id_vehicle_color_vehicles` FOREIGN KEY (`id_vehicle_color`) REFERENCES `vehicle_color` (`id`),
  ADD CONSTRAINT `fk_id_vehicle_maker_vehicles` FOREIGN KEY (`id_vehicle_maker`) REFERENCES `vehicle_maker` (`id`),
  ADD CONSTRAINT `fk_id_vehicle_model_vehicles` FOREIGN KEY (`id_vehicle_model`) REFERENCES `vehicle_model` (`id`),
  ADD CONSTRAINT `fk_id_vehicle_type_vehicles` FOREIGN KEY (`id_vehicle_type`) REFERENCES `vehicle_type` (`id`);

--
-- Restrições para tabelas `vehicle_customer`
--
ALTER TABLE `vehicle_customer`
  ADD CONSTRAINT `fk_id_customer_vehicle_customer` FOREIGN KEY (`id_customer`) REFERENCES `customers` (`id`),
  ADD CONSTRAINT `fk_id_vehicle_vehicle_customer` FOREIGN KEY (`id_vehicle`) REFERENCES `vehicles` (`id`);

--
-- Restrições para tabelas `vehicle_model`
--
ALTER TABLE `vehicle_model`
  ADD CONSTRAINT `fk_id_vehicle_maker_vehicle_model` FOREIGN KEY (`id_vehicle_maker`) REFERENCES `vehicle_maker` (`id`);

--
-- Restrições para tabelas `vehicle_type_park`
--
ALTER TABLE `vehicle_type_park`
  ADD CONSTRAINT `fk_id_park_parks_vehicle_type_park` FOREIGN KEY (`id_park`) REFERENCES `parks` (`id`),
  ADD CONSTRAINT `fk_id_vehicle_type_vehicle_type_vehicle_type_park` FOREIGN KEY (`id_vehicle_type`) REFERENCES `vehicle_type` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
