-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 31, 2020 at 11:28 AM
-- Server version: 10.1.25-MariaDB
-- PHP Version: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `carbooking`
--

-- --------------------------------------------------------

--
-- Table structure for table `app_configuration`
--

CREATE TABLE `app_configuration` (
  `conf_id` int(11) NOT NULL,
  `conf_key` varchar(100) NOT NULL,
  `conf_value` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `app_configuration`
--

INSERT INTO `app_configuration` (`conf_id`, `conf_key`, `conf_value`) VALUES
(1, 'date_format', 'Y-m-d'),
(2, 'time_format', 'h:i A'),
(3, 'first-day-of-the-week', 'Monday'),
(4, 'rent_interval', ''),
(5, 'calculate_type', 'both'),
(6, 'currency_symbol', 'Rs.'),
(7, 'deposit', '10'),
(8, 'deposit_type', 'percent'),
(9, 'tax', '10'),
(10, 'tax_type', 'price'),
(11, 'age_tax', ''),
(12, 'age_tax_type', 'price'),
(13, 'age_for_tax', '21');

-- --------------------------------------------------------

--
-- Table structure for table `app_discount`
--

CREATE TABLE `app_discount` (
  `discount_id` int(11) NOT NULL,
  `dlimit` int(11) NOT NULL,
  `title` varchar(250) NOT NULL,
  `from_date` varchar(200) NOT NULL,
  `to_date` varchar(200) NOT NULL,
  `promo_code` varchar(250) NOT NULL,
  `discount` float NOT NULL,
  `type` enum('price','percent') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `app_discount`
--

INSERT INTO `app_discount` (`discount_id`, `dlimit`, `title`, `from_date`, `to_date`, `promo_code`, `discount`, `type`) VALUES
(2, 5, 'New Year Promo', '1585350000', '1585605600', 'RT09584', 20, 'percent');

-- --------------------------------------------------------

--
-- Table structure for table `app_extra`
--

CREATE TABLE `app_extra` (
  `extra_id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `price` float NOT NULL,
  `calculate` varchar(200) NOT NULL,
  `type` varchar(200) NOT NULL,
  `updated_date` varchar(250) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `app_extra`
--

INSERT INTO `app_extra` (`extra_id`, `title`, `description`, `price`, `calculate`, `type`, `updated_date`, `created_date`) VALUES
(9, 'Lost Damage', 'Lost Damage', 200, 'percent', 'percent', '', '2020-03-20 12:49:49'),
(10, '3d Party Insurance', '3d Party Insurance', 199, 'percent', 'percent', '', '2020-03-21 15:10:22'),
(11, 'Extra Drivers', 'Extra Drivers', 100, 'percent', 'percent', '', '2020-03-21 15:10:42'),
(12, 'Infant Child Seats', 'Infant Child Seats', 300, 'percent', 'percent', '', '2020-03-21 15:11:31'),
(13, 'Hand Controls', 'Hand Controls', 220, 'percent', 'percent', '', '2020-03-21 15:11:48'),
(14, 'Damage Insurance', 'Damage Insurance', 50, 'percent', 'percent', '', '2020-03-21 15:14:52'),
(15, 'GPS Navigation', 'GPS Navigation', 35, 'percent', 'percent', '', '2020-03-21 15:15:19'),
(16, 'Additional driver', 'Additional driver', 40, 'percent', 'percent', '', '2020-03-21 15:16:01'),
(17, 'Basic Glass Protection', 'Basic Glass Protection', 50, 'percent', 'percent', '', '2020-03-21 15:18:54'),
(18, 'GPS Navigator', 'GPS Navigator', 20, 'price', 'perday', '', '2020-03-21 15:33:15'),
(19, 'Child Seat', 'Child Seat', 75, 'percent', 'percent', '', '2020-03-21 15:34:27'),
(20, 'Hand Controls', 'Hand Controls', 44, 'percent', 'percent', '', '2020-03-21 15:34:55');

-- --------------------------------------------------------

--
-- Table structure for table `app_groups`
--

CREATE TABLE `app_groups` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `app_groups`
--

INSERT INTO `app_groups` (`id`, `name`, `description`) VALUES
(1, 'admin', 'Administrator'),
(2, 'agent', 'General User');

-- --------------------------------------------------------

--
-- Table structure for table `app_locations`
--

CREATE TABLE `app_locations` (
  `location_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `latitude` varchar(50) NOT NULL,
  `longitude` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `app_locations`
--

INSERT INTO `app_locations` (`location_id`, `name`, `latitude`, `longitude`) VALUES
(1, 'Akkarepattu', '7.2194', '81.8498'),
(3, 'Kalmunai', '7.4144', '81.8306'),
(4, 'Sainthamaruthu', '7.3930', '81.8361'),
(5, 'Padiyatalawa', '7.3925', '81.2436'),
(6, 'Pothuvil', '6.8753', '81.8306'),
(7, 'Samanthurai', '7.3575', '81.7951'),
(8, 'Siripura', '7.7270', '81.0161'),
(9, 'Uhana', '7.3630', '81.6353'),
(10, 'Anuradhapura', '8.3114', '80.4037'),
(11, 'Eppawala', '8.1441', '80.4119'),
(12, 'Galenbindunuwewa', '8.2921', '80.7173'),
(13, 'Galnewa', '8.0369', '80.4725'),
(14, 'Habarana', '8.0322', '80.7519'),
(15, 'Kekirawa', '8.0421', '80.5938'),
(16, 'Medawachchiya', '8.5375', '80.4910'),
(17, 'Mihinthale', '8.3534', '80.5049'),
(18, 'Nochchiyagama', '8.2926', '80.2266'),
(19, 'Thalawa', '8.1490', '80.4089'),
(20, 'Thambuttegama', '8.1613', '80.3001'),
(21, 'Horoupathana', '8.5771', '80.8808'),
(22, 'Kebithigollewa', '8.6409', '80.6697'),
(23, 'Padaviya', '8.8341', '80.7607'),
(24, 'Badulla', '6.9934', '81.0550'),
(25, 'Bandarawela', '6.8259', '80.9982'),
(26, 'Diyatalawa', '6.8070', '80.9572'),
(27, 'Ella', '6.8667', '81.0466'),
(28, 'Hali Ela', '6.9566', '81.0341'),
(29, 'Haputale', '6.7654', '80.9526'),
(30, 'Mahiyanganaya', '7.3316', '81.0037'),
(31, 'Passara', '6.9349', '81.1527'),
(32, 'Welimada', '6.9019', '80.9079'),
(33, 'Batticaloa', '7.7310', '81.6747'),
(34, 'Angoda', '6.9367', '79.9270'),
(35, 'Athurugiriya', '6.8723', '80.0004'),
(36, 'Avissawella', '6.9543', '80.2046'),
(37, 'Battaramulla', '6.8980', '79.9223'),
(38, 'Boralesgamuwa', '6.8410', '79.9017'),
(39, 'Colombo 01', '6.9271', '79.8612'),
(40, 'Colombo 02', '6.9222', '79.8549'),
(41, 'Colombo 03', '6.9010', '79.8549'),
(42, 'Colombo 04', '6.8865', '79.8563'),
(43, 'Colombo 05', '6.8908', '79.8717'),
(44, 'Colombo 06', '6.8747', '79.8605'),
(45, 'Colombo 07', '6.9117', '79.8646'),
(46, 'Colombo 08', '6.9122', '79.8829'),
(47, 'Colombo 09 ', '6.9332', '79.8773'),
(48, 'Colombo 10', '6.9224', '79.8661'),
(49, 'Colombo 11', '6.9367', '79.8535'),
(50, 'Colombo 12', '6.9382', '79.8605'),
(51, 'Colombo 13', '6.9488', '79.8605'),
(52, 'Colombo 14', '6.9511', '79.8741'),
(53, 'Colombo 15', '6.9702', '79.8717'),
(54, 'Dehiwala    ', '6.8301', '79.8801'),
(55, 'Hanwella    ', '6.8978', '80.0814'),
(56, 'Homagama    ', '6.8433', '80.0032'),
(57, 'Kaduwela    ', '6.9291', '79.9828'),
(58, 'Kesbewa     ', '6.7787', '79.9473'),
(59, 'Kohuwala    ', '6.8625', '79.8855'),
(60, 'Kolonnawa   ', '6.9284', '79.8950'),
(61, 'Kottawa   ', '6.8412', '79.9654'),
(62, 'Kotte   ', '6.8868', '79.9187'),
(63, 'Maharagama  ', '6.8511', '79.9212'),
(64, 'Malabe  ', '6.9061', '79.9696'),
(65, 'Moratuwa ', '6.7881', '79.8913'),
(66, 'Mount Lavinia', '6.8301', '79.8801'),
(67, 'Nawala  ', '6.8964', '79.8885'),
(68, 'Nugegoda ', '6.8649', '79.8997'),
(69, 'Padukka  ', '6.8454', '80.1038'),
(70, 'Pannipitiya ', '6.8464', '79.9484'),
(71, 'Piliyandala ', '6.8018', '79.9227'),
(72, 'Rajagiriya  ', '6.9094', '79.8943'),
(73, 'Ratmalana ', '6.8195', '79.8801'),
(74, 'Thalawathugoda ', '6.8759', '79.9392'),
(75, 'Wellampitiya  ', '6.9424', '79.9046'),
(76, 'Mattegoda  ', '6.8135', '79.9724'),
(77, 'Pelawatta  ', '6.8906', '79.9249'),
(78, 'Ahangama ', '5.9740', '80.3622'),
(79, 'Ambalangoda ', '6.2442', '80.0591'),
(80, 'Batapola ', '6.2242', '80.1138'),
(81, 'Bentota ', '6.4189', '80.0060'),
(82, 'Baddegama ', '6.1688', '80.1794'),
(83, 'Elpitiya ', '6.2880', '80.1596'),
(84, 'Galle ', '6.0535', '80.2210'),
(85, 'Hikkaduwa ', '6.1395', '80.1063'),
(86, 'Karapitiya ', '6.0706', '80.2252'),
(87, 'Udugama  ', '6.2179', '80.3380'),
(88, 'Neluwa ', '6.3731', '80.3575'),
(89, 'Balapitiya ', '6.2784', '80.0403'),
(90, 'Ahungalla  ', '6.3133', '80.0409'),
(91, 'Delgoda ', '6.9879', '80.0158'),
(92, 'Divulapitiya ', '7.2303', '80.0165'),
(93, 'Gampaha ', '7.0840', '80.0098'),
(94, 'Ganemulla ', '7.0624', '79.9668'),
(95, 'Ja-Ela', '7.0668', '79.9041'),
(96, 'Kadawatha ', '7.0047', '79.9542'),
(97, 'Kandana ', '7.0478', '79.8970'),
(98, 'Katunayaka ', '7.1725', '79.8853'),
(99, 'Kelaniya ', '6.9518', '79.9133'),
(100, 'Kiribathgoda ', '6.9778', '79.9272'),
(101, 'Minuwangoda  ', '7.1842', '79.9500'),
(102, 'Meerigama  ', '7.2427', '80.1270'),
(103, 'Negombo  ', '7.2008', '79.8737'),
(104, 'Nittambuwa ', '7.1424', '80.1038'),
(105, 'Ragama  ', '7.0280', '79.9230'),
(106, 'Veyangoda  ', '7.1541', '80.0594'),
(107, 'Wattala  ', '6.9907', '79.8932'),
(108, 'Peliyagoda ', '6.9585', '79.9056'),
(109, 'Pugoda ', '6.9750', '80.1181'),
(110, 'Weliweriya ', '7.0319', '80.0283'),
(111, 'Yakkala ', '7.0864', '80.0335'),
(112, 'Ambalantota ', '6.1226', '81.0238'),
(113, 'Beliatta ', '6.0482', '80.7339'),
(114, 'Hambantota ', '6.1429', '81.1212'),
(115, 'Tangalla ', '6.0243', '80.7941'),
(116, 'Tissamaharamaya ', '6.2792', '81.2877'),
(117, 'Suriyawewa ', '6.3194', '81.0024'),
(118, 'Middeniya ', '6.2514', '80.7642'),
(119, 'Weerawila ', '6.2421', '81.2292'),
(120, 'Chavakachcheri ', '9.6665', '80.1321'),
(121, 'Jaffna  ', '9.6615', '80.0255'),
(122, 'Nallur ', '9.6702', '80.0395'),
(123, 'Aluthgama ', '6.4346', '80.0004'),
(124, 'Bandaragama ', '6.7144', '79.9891'),
(125, 'Beruwala ', '6.4738', '79.9920'),
(126, 'Horana ', '6.7230', '80.0647'),
(127, 'Ingiriya ', '6.7404', '80.1625'),
(128, 'Kalutara  ', '6.5854', '79.9607'),
(129, 'Matugama ', '6.5219', '80.1137'),
(130, 'Panadura ', '6.7106', '79.9074'),
(131, 'Wadduwa ', '6.6363', '79.9528'),
(132, 'Welipenna ', '6.4682', '80.1066'),
(133, 'Agalawatta ', '6.5423', '80.1575'),
(134, 'Baduraliya ', '6.5171', '80.2312'),
(135, 'Millaniya ', '6.6805', '80.0207'),
(136, 'Akurana ', '7.3690', '80.6133'),
(137, 'Ampitiya ', '7.2686', '80.6632'),
(138, 'Digana ', '7.2942', '80.7381'),
(139, 'Galagedara ', '7.3700', '80.5327'),
(140, 'Gampola ', '7.1268', '80.5647'),
(141, 'Gelioya ', '7.2153', '80.5980'),
(142, 'Kadugannawa ', '7.2550', '80.5188'),
(143, 'Kandy ', '7.2906', '80.6337'),
(144, 'Katugasthota ', '7.3360', '80.6214'),
(145, 'Kundasale ', '7.3096', '80.7104'),
(146, 'Madawala  ', '7.3276', '80.6743'),
(147, 'Nawalapitiya ', '7.0447', '80.5161'),
(148, 'Peradeniya ', '7.2699', '80.5938'),
(149, 'Pilimathalawa ', '7.2663', '80.5522'),
(150, 'Wattegama ', '7.3491', '80.6854 '),
(151, 'Dehiowita ', '6.9639', '80.2642'),
(152, 'Deraniyagala ', '6.9349', '80.3380'),
(153, 'Galigamuwa ', '7.2359', '80.3116'),
(154, 'Kegalle ', '7.2513', '80.3464'),
(155, 'Kitulgala ', '6.9898', '80.4271'),
(156, 'Mawanella ', '7.2481', '80.4466'),
(157, 'Rambukkana ', '7.3135', '80.3881'),
(158, 'Ruwanwella ', '7.0459', '80.2537'),
(159, 'Warakapola ', '7.2268', '80.1959'),
(160, 'Yatiyantota   ', '7.0289', '80.2955'),
(161, 'Aranayaka', '7.1497', '80.4650'),
(162, 'Kilinochchi ', '9.3803', '80.3770'),
(163, 'Alawwa ', '7.2954', '80.2366'),
(164, 'Bingiriya ', '7.5982', '79.9372'),
(165, 'Galgamuwa ', '7.9865', '80.2879'),
(166, 'Giriulla ', '7.3318', '80.1233'),
(167, 'Hettipola ', '7.5331', '80.9152'),
(168, 'Ibbagamuwa ', '7.5554', '80.4564'),
(169, 'Mawathagama ', '7.4322', '80.4438'),
(170, 'Kurunegala ', '7.4818', '80.3609'),
(171, 'Kuliyapitiya ', '7.4721', '80.0446'),
(172, 'Narammala ', '7.4325', '80.2154'),
(173, 'Nikaweratiya ', '7.7464', '80.1317'),
(174, 'Pannala ', '7.3295', '80.0228'),
(175, 'Polgahawela ', '7.3275', '80.2935'),
(176, 'Wariyapola ', '7.6239', '80.2433'),
(177, 'Dambadeniya ', '7.3697', '80.1512'),
(178, 'Yapahuwa ', '7.8179', '80.3116'),
(179, 'Melsiripura ', '7.6450', '80.5077'),
(180, 'Mannar ', '8.9810', '79.9044'),
(181, 'Dambulla ', '7.8742', '80.6511'),
(182, 'Galewela ', '7.7565', '80.5772'),
(183, 'Matale ', '7.4675', '80.6234'),
(184, 'Palapathwela ', '7.5377', '80.6271'),
(185, 'Rattota ', '7.5173', '80.6715'),
(186, 'Sigiriya ', '7.9512', '80.7448'),
(187, 'Ukuwela ', '7.4235', '80.6306'),
(188, 'Yatawatta ', '7.5635', '80.5877'),
(189, 'Naula ', '7.7071', '80.6521'),
(190, 'Akuressa ', '6.1001', '80.4760'),
(191, 'Deniyaya ', '6.3425', '80.5597'),
(192, 'Dikwella ', '5.9717', '80.6951'),
(193, 'Hakmana ', '6.0796', '80.6577'),
(194, 'Kamburugamuwa ', '5.9486', '80.4938'),
(195, 'Kamburupitiya ', '6.0779', '80.5633'),
(196, 'Kekanadura ', '5.9638', '80.6133'),
(197, 'Matara ', '5.9549', '80.5550'),
(198, 'Weligama ', '5.9774', '80.4288'),
(199, 'Buttala ', '6.7589', '81.2491');

-- --------------------------------------------------------

--
-- Table structure for table `app_login_attempts`
--

CREATE TABLE `app_login_attempts` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `login` varchar(100) NOT NULL,
  `time` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `app_membership`
--

CREATE TABLE `app_membership` (
  `membership_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `price` int(11) NOT NULL,
  `limitation` int(11) NOT NULL,
  `duration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `app_membership`
--

INSERT INTO `app_membership` (`membership_id`, `title`, `description`, `price`, `limitation`, `duration`) VALUES
(1, 'Free', 'Free Membership', 0, 10, 30),
(2, 'Plus', 'everything is basic', 1500, 20, 60),
(6, 'Business', 'Business plan', 3500, 30, 90);

-- --------------------------------------------------------

--
-- Table structure for table `app_users`
--

CREATE TABLE `app_users` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(254) NOT NULL,
  `activation_selector` varchar(255) DEFAULT NULL,
  `activation_code` varchar(255) DEFAULT NULL,
  `forgotten_password_selector` varchar(255) DEFAULT NULL,
  `forgotten_password_code` varchar(255) DEFAULT NULL,
  `forgotten_password_time` int(11) UNSIGNED DEFAULT NULL,
  `remember_selector` varchar(255) DEFAULT NULL,
  `remember_code` varchar(255) DEFAULT NULL,
  `created_on` int(11) UNSIGNED NOT NULL,
  `last_login` int(11) UNSIGNED DEFAULT NULL,
  `active` tinyint(1) UNSIGNED DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT '0',
  `membership_id` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `app_users`
--

INSERT INTO `app_users` (`id`, `ip_address`, `username`, `password`, `email`, `activation_selector`, `activation_code`, `forgotten_password_selector`, `forgotten_password_code`, `forgotten_password_time`, `remember_selector`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`, `phone`, `avatar`, `membership_id`) VALUES
(1, '127.0.0.1', 'administrator', '$2y$12$e.Qavk.TYDM2ikdiIpUQXOVwXMJxAC.F7pgK0rGi7IIS82VgZMLyi', 'admin@admin.com', NULL, '', NULL, NULL, NULL, 'd71f9d61bc354db5b0e145bcc6f869837dc146c6', '$2y$10$4kx02h.8xat5WNQ3JYtuneIcBp6eqPoVg8uu0PcEpYmcAew9Qdy7a', 1268889823, 1585645245, 1, 'Admin', 'istratorxx', '12345', '0', 1),
(2, '::1', 'devid@gmail.com', '$2y$10$u1bh4awPRywFwLBVOwQfI.FeYoYzpUplfTPIiSiQvdWdkGLJvLbv6', 'devid@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1578072038, 1578665958, 1, 'Devid', 'Bekkom', '087247484', '73081.jpg', 6),
(3, '::1', 'johndoe@gmail.com', '$2y$10$DV1NB8LEJAWh.xuDMZl0NumihdcfivhzZ1.xfbtGv8zYMxWIUdsuW', 'johndoe@gmail.com', NULL, NULL, NULL, NULL, NULL, 'a07acfc522a7d8cab47ae896fea51c5a2d7354fb', '$2y$10$FaYFhs.lgXSEoMwKACILYOYuBE0AkqJUDiy5u4SJ2x7CC/5iPliZC', 1578152416, 1585637990, 1, 'manic', 'sidowski', '098464935', '6db69e91c3e70e4b58d0fa1e4635789d.jpg', 2);

-- --------------------------------------------------------

--
-- Table structure for table `app_users_groups`
--

CREATE TABLE `app_users_groups` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `group_id` mediumint(8) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `app_users_groups`
--

INSERT INTO `app_users_groups` (`id`, `user_id`, `group_id`) VALUES
(1, 1, 1),
(2, 2, 2),
(3, 3, 2);

-- --------------------------------------------------------

--
-- Table structure for table `app_vehicles`
--

CREATE TABLE `app_vehicles` (
  `vehicle_id` int(11) NOT NULL,
  `vehicle_type_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `make` varchar(250) NOT NULL,
  `model` varchar(250) NOT NULL,
  `registration_number` varchar(250) NOT NULL,
  `mileage` varchar(250) NOT NULL,
  `fuel` varchar(250) NOT NULL,
  `description` text NOT NULL,
  `location_id` int(11) NOT NULL,
  `passengers` int(11) NOT NULL,
  `bags` int(11) NOT NULL,
  `doors` int(11) NOT NULL,
  `transmission` varchar(250) NOT NULL,
  `air_conditioning` enum('T','F') NOT NULL,
  `images` varchar(250) NOT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '0',
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `app_vehicles`
--

INSERT INTO `app_vehicles` (`vehicle_id`, `vehicle_type_id`, `user_id`, `year`, `make`, `model`, `registration_number`, `mileage`, `fuel`, `description`, `location_id`, `passengers`, `bags`, `doors`, `transmission`, `air_conditioning`, `images`, `status`, `create_date`) VALUES
(3, 7, 1, 2011, 'Volkswagen', 'A3', 'KLK87345', '450000', 'diesel', 'Lorem Ipsum available, but the majority have suffered alteration in some form', 197, 6, 4, 4, 'manual', 'T', '38647.png,38647.jpg,386471.jpg', '1', '2020-01-12 04:14:41'),
(4, 6, 1, 20018, 'Slea', 'Leag 2', 'POIH847598', '89000', 'gas', 'Lorem Ipsum available, but the majority have suffered alteration in some form', 84, 4, 2, 2, 'manual', 'T', '74189.jpg,741891.jpg', '1', '2020-01-12 04:16:42'),
(5, 9, 1, 2000, 'Lamborghini', 'Ace 3', 'CMNH9474', '6103843', 'hybrid', 'Lorem Ipsum available, but the majority have suffered alteration in some form', 43, 2, 2, 2, 'manual', 'T', '51402.jpg', '1', '2020-01-12 04:23:28'),
(6, 6, 3, 2008, 'Maruti', 'Brezza', 'KKR5464', '3397', 'diesel', 'Morbi mollis vestibulum sollicitudin. Nunc in eros a justo facilisis rutrum.', 197, 4, 2, 3, 'manual', 'F', '48637.jpg,486371.jpg', '1', '2020-02-14 14:19:26'),
(7, 9, 3, 2001, 'BMW', 'Diatto', 'NMK76HA', '8734', 'petrol', 'Lorem ipsum, or lipsum as it is sometimes known, is dummy text used in laying out print, graphic or web designs. The passage is attributed to an unknown typesetter in the 15th century who is thought to have scrambled parts of Cicero’s De Finibus Bonorum et Malorum for use in a type specimen book.', 197, 4, 2, 4, 'semi-automatic', 'T', '83925.jpg,839251.jpg', '1', '2020-02-14 14:21:50'),
(8, 6, 3, 2006, 'Mahindra', 'XUV 500', 'IONF47438', '335700', 'electric', 'One of our top priorities is to adjust each package we offer to our\r\ncustomer’s exact needs. Rental Ca', 197, 4, 4, 4, 'automatic', 'T', '48205.jpg,482051.jpg', '1', '2020-02-14 15:03:30'),
(10, 8, 3, 2014, 'Godzilla', 'JX', 'HKI09584', '88232', 'petrol', 'If using the PDO driver with PostgreSQL, or using the Interbase driver', 84, 4, 2, 3, 'manual', 'T', '65931.jpg,659311.jpg', '1', '2020-03-19 15:41:44');

-- --------------------------------------------------------

--
-- Table structure for table `app_vehicle_bloking`
--

CREATE TABLE `app_vehicle_bloking` (
  `vehicle_bloking_id` int(11) NOT NULL,
  `vehicle_id` int(11) DEFAULT NULL,
  `from_date` varchar(250) DEFAULT NULL,
  `to_date` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `app_vehicle_booking`
--

CREATE TABLE `app_vehicle_booking` (
  `vehicle_booking_id` int(11) NOT NULL,
  `booking_number` varchar(250) DEFAULT NULL,
  `start_time` varchar(250) DEFAULT NULL,
  `end_time` varchar(250) DEFAULT NULL,
  `pickup_date` int(11) NOT NULL,
  `pickup_hour` int(11) NOT NULL,
  `pickup_minutes` int(11) NOT NULL,
  `return_date` int(11) NOT NULL,
  `return_hour` int(11) NOT NULL,
  `return_minutes` int(11) NOT NULL,
  `vehicle_id` int(11) NOT NULL,
  `price_id` int(11) NOT NULL,
  `pickup_location_id` int(11) NOT NULL,
  `pickup_mileage` int(11) NOT NULL,
  `return_mileage` int(11) NOT NULL,
  `return_datetime` varchar(250) DEFAULT NULL,
  `extra_hours` int(11) NOT NULL,
  `extra_mileage` int(11) NOT NULL,
  `return_location_id` int(11) NOT NULL,
  `price_for_extra_hours` float DEFAULT NULL,
  `price_for_extra_mileage` float DEFAULT NULL,
  `vehicle_price` float DEFAULT NULL,
  `amount` float DEFAULT NULL,
  `extra_price` float DEFAULT NULL,
  `tax` float DEFAULT NULL,
  `age_tax` float DEFAULT NULL,
  `total` float DEFAULT NULL,
  `deposit` float DEFAULT NULL,
  `discount` float DEFAULT NULL,
  `promo_code` varchar(250) DEFAULT NULL,
  `first_name` varchar(250) DEFAULT NULL,
  `second_name` varchar(250) DEFAULT NULL,
  `phone` varchar(250) DEFAULT NULL,
  `email` varchar(250) DEFAULT NULL,
  `company` varchar(250) DEFAULT NULL,
  `address` varchar(250) DEFAULT NULL,
  `city` varchar(250) DEFAULT NULL,
  `postcode` varchar(250) DEFAULT NULL,
  `male` varchar(250) DEFAULT NULL,
  `age` varchar(250) DEFAULT NULL,
  `additional` text,
  `status` varchar(250) DEFAULT NULL,
  `payment_method` varchar(250) DEFAULT NULL,
  `cc_type` varchar(250) DEFAULT NULL,
  `cc_num` varchar(250) DEFAULT NULL,
  `cc_code` varchar(250) DEFAULT NULL,
  `cc_exp_month` varchar(250) DEFAULT NULL,
  `cc_exp_year` varchar(250) DEFAULT NULL,
  `date` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `app_vehicle_booking`
--

INSERT INTO `app_vehicle_booking` (`vehicle_booking_id`, `booking_number`, `start_time`, `end_time`, `pickup_date`, `pickup_hour`, `pickup_minutes`, `return_date`, `return_hour`, `return_minutes`, `vehicle_id`, `price_id`, `pickup_location_id`, `pickup_mileage`, `return_mileage`, `return_datetime`, `extra_hours`, `extra_mileage`, `return_location_id`, `price_for_extra_hours`, `price_for_extra_mileage`, `vehicle_price`, `amount`, `extra_price`, `tax`, `age_tax`, `total`, `deposit`, `discount`, `promo_code`, `first_name`, `second_name`, `phone`, `email`, `company`, `address`, `city`, `postcode`, `male`, `age`, `additional`, `status`, `payment_method`, `cc_type`, `cc_num`, `cc_code`, `cc_exp_month`, `cc_exp_year`, `date`) VALUES
(2, 'BID4295087', '1585113780', '1585293780', 1585113780, 23, 6, 1585293780, 8, 23, 3, 2, 197, 450000, 0, NULL, 0, 0, 64, NULL, NULL, 4000, 407, 60, 10, 0, 4070, 407, 0, NULL, 'Ben', 'Linus', '0773345923', 'ben2lines@gmail.com', NULL, '#556,Up Hills, sb street', 'nugegoda', '564333', 'male', '19', '', 'pending', 'offline', NULL, NULL, NULL, NULL, NULL, '1585090800'),
(3, 'BID2938167', '1585549800', '1585666800', 1585549800, 30, 8, 1585666800, 5, 0, 3, 2, 197, 450000, 0, NULL, 0, 0, 14, NULL, NULL, 3600, 635, 2740, 10, 0, 6350, 635, 0, NULL, 'Remi', 'Lyons', '078373244', 'remilyn@hotmail.com', NULL, '637, Matara Road, Palane, Weligama.', 'akuressa', '34466', 'male', '18', '', 'pending', 'offline', NULL, NULL, NULL, NULL, NULL, '1585090800'),
(4, 'BID5024398', '1585458000', '1585585800', 1585458000, 0, 7, 1585585800, 6, 30, 6, 3, 197, 3397, 0, NULL, 0, 0, 8, NULL, NULL, 5300, 531, 0, 10, 0, 5310, 531, 0, NULL, 'Tomas L', 'Paine', '4137464824', 'Tomas@info.net', 'Jewel Mart', '289 Lewis Place, Negombo', 'Negombo', '477733', 'male', '24', '', 'pending', 'offline', NULL, NULL, NULL, NULL, NULL, '1585090800'),
(5, 'BID8347209', '1585117200', '1585324200', 1585117200, 20, 7, 1585324200, 4, 50, 10, 11, 84, 88232, 0, NULL, 0, 0, 197, NULL, NULL, 1800, 271, 900, 10, 0, 2710, 271, 0, NULL, 'Monroe', 'Parker', '0763459824', 'monroeparker@yahoo.com', NULL, '#23, Pitipana juntion, homagama.', 'Homagama', '409383', 'female', '18', '', 'confirmed', 'offline', NULL, NULL, NULL, NULL, NULL, '1585177200'),
(6, 'BID6547308', '1585326600', '1585463400', 1585326600, 30, 5, 1585463400, 8, 30, 10, 11, 84, 88232, 0, NULL, 0, 0, 76, NULL, NULL, 1800, 181, 0, 10, 0, 1810, 181, 0, NULL, 'Martin', 'Gray', '0785671190', 'martingray08@gmail.com', NULL, '#88/2, Down town, vels st, kottawa.', 'kottawa', '90234', 'male', '18', '', 'pending', 'offline', NULL, NULL, NULL, NULL, NULL, '1585177200'),
(7, 'BID0324586', '1585720800', '1585933200', 1585720800, 0, 8, 1585933200, 7, 0, 10, 11, 84, 88232, 0, NULL, 0, 0, 24, NULL, NULL, 1900, 571, 3800, 10, 0, 5710, 571, 0, NULL, 'Heather', 'Wright', '0708772891', 'heatherwr@info.net', NULL, '#21, walt street , veligama', 'veligama', '76002', 'male', '23', '', 'pending', 'offline', NULL, NULL, NULL, NULL, NULL, '1585177200');

-- --------------------------------------------------------

--
-- Table structure for table `app_vehicle_booking_extra`
--

CREATE TABLE `app_vehicle_booking_extra` (
  `vehicle_booking_extra_id` int(11) NOT NULL,
  `extra_id` int(11) NOT NULL,
  `vehicle_booking_id` int(11) NOT NULL,
  `count` int(11) NOT NULL,
  `price` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `app_vehicle_booking_extra`
--

INSERT INTO `app_vehicle_booking_extra` (`vehicle_booking_extra_id`, `extra_id`, `vehicle_booking_id`, `count`, `price`) VALUES
(3, 18, 2, 0, 60),
(4, 18, 3, 0, 40),
(5, 19, 3, 0, 2700),
(6, 17, 5, 0, 900),
(7, 9, 7, 0, 3800);

-- --------------------------------------------------------

--
-- Table structure for table `app_vehicle_extra_relation`
--

CREATE TABLE `app_vehicle_extra_relation` (
  `vehicle_extra_relation_id` int(11) NOT NULL,
  `vehicle_id` int(11) NOT NULL,
  `extra_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `app_vehicle_extra_relation`
--

INSERT INTO `app_vehicle_extra_relation` (`vehicle_extra_relation_id`, `vehicle_id`, `extra_id`) VALUES
(61, 6, 10),
(62, 6, 11),
(63, 7, 12),
(64, 7, 13),
(65, 8, 14),
(66, 8, 15),
(67, 8, 16),
(68, 10, 17),
(73, 10, 9),
(74, 3, 18),
(75, 3, 19),
(76, 3, 20);

-- --------------------------------------------------------

--
-- Table structure for table `app_vehicle_prices`
--

CREATE TABLE `app_vehicle_prices` (
  `vehicle_price_id` int(11) NOT NULL,
  `vehicle_id` int(11) NOT NULL,
  `type_id` varchar(200) NOT NULL,
  `price_per_day` float NOT NULL,
  `price_per_hour` float NOT NULL,
  `limit_mileage` int(11) NOT NULL,
  `extra_mileage_price` float NOT NULL,
  `extra_hour_price` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `app_vehicle_prices`
--

INSERT INTO `app_vehicle_prices` (`vehicle_price_id`, `vehicle_id`, `type_id`, `price_per_day`, `price_per_hour`, `limit_mileage`, `extra_mileage_price`, `extra_hour_price`) VALUES
(1, 4, '6', 343, 100, 343, 656, 453),
(2, 3, '7', 1800, 200, 50, 75, 100),
(3, 6, '6', 3500, 150, 70, 100, 120),
(5, 7, '9', 6500, 160, 100, 180, 200),
(6, 5, '9', 500, 500, 500, 500, 500),
(7, 8, '6', 5000, 320, 5000, 5000, 5000),
(11, 10, '8', 400, 100, 400, 400, 400);

-- --------------------------------------------------------

--
-- Table structure for table `app_vehicle_types`
--

CREATE TABLE `app_vehicle_types` (
  `vehicle_type_id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `app_vehicle_types`
--

INSERT INTO `app_vehicle_types` (`vehicle_type_id`, `title`, `description`) VALUES
(5, 'Classic', 'Classic'),
(6, 'Sports', 'Sports'),
(7, 'Luxary', 'Luxary'),
(8, 'Mini', 'Mini'),
(9, 'Convertible', 'Convertible');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `app_configuration`
--
ALTER TABLE `app_configuration`
  ADD PRIMARY KEY (`conf_id`);

--
-- Indexes for table `app_discount`
--
ALTER TABLE `app_discount`
  ADD PRIMARY KEY (`discount_id`);

--
-- Indexes for table `app_extra`
--
ALTER TABLE `app_extra`
  ADD PRIMARY KEY (`extra_id`);

--
-- Indexes for table `app_groups`
--
ALTER TABLE `app_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_locations`
--
ALTER TABLE `app_locations`
  ADD PRIMARY KEY (`location_id`);

--
-- Indexes for table `app_login_attempts`
--
ALTER TABLE `app_login_attempts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_membership`
--
ALTER TABLE `app_membership`
  ADD PRIMARY KEY (`membership_id`);

--
-- Indexes for table `app_users`
--
ALTER TABLE `app_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uc_email` (`email`),
  ADD UNIQUE KEY `uc_activation_selector` (`activation_selector`),
  ADD UNIQUE KEY `uc_forgotten_password_selector` (`forgotten_password_selector`),
  ADD UNIQUE KEY `uc_remember_selector` (`remember_selector`);

--
-- Indexes for table `app_users_groups`
--
ALTER TABLE `app_users_groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uc_users_groups` (`user_id`,`group_id`),
  ADD KEY `fk_users_groups_users1_idx` (`user_id`),
  ADD KEY `fk_users_groups_groups1_idx` (`group_id`);

--
-- Indexes for table `app_vehicles`
--
ALTER TABLE `app_vehicles`
  ADD PRIMARY KEY (`vehicle_id`);

--
-- Indexes for table `app_vehicle_bloking`
--
ALTER TABLE `app_vehicle_bloking`
  ADD PRIMARY KEY (`vehicle_bloking_id`);

--
-- Indexes for table `app_vehicle_booking`
--
ALTER TABLE `app_vehicle_booking`
  ADD PRIMARY KEY (`vehicle_booking_id`);

--
-- Indexes for table `app_vehicle_booking_extra`
--
ALTER TABLE `app_vehicle_booking_extra`
  ADD PRIMARY KEY (`vehicle_booking_extra_id`);

--
-- Indexes for table `app_vehicle_extra_relation`
--
ALTER TABLE `app_vehicle_extra_relation`
  ADD PRIMARY KEY (`vehicle_extra_relation_id`);

--
-- Indexes for table `app_vehicle_prices`
--
ALTER TABLE `app_vehicle_prices`
  ADD PRIMARY KEY (`vehicle_price_id`);

--
-- Indexes for table `app_vehicle_types`
--
ALTER TABLE `app_vehicle_types`
  ADD PRIMARY KEY (`vehicle_type_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `app_configuration`
--
ALTER TABLE `app_configuration`
  MODIFY `conf_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `app_discount`
--
ALTER TABLE `app_discount`
  MODIFY `discount_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `app_extra`
--
ALTER TABLE `app_extra`
  MODIFY `extra_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `app_groups`
--
ALTER TABLE `app_groups`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `app_locations`
--
ALTER TABLE `app_locations`
  MODIFY `location_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=200;
--
-- AUTO_INCREMENT for table `app_login_attempts`
--
ALTER TABLE `app_login_attempts`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `app_membership`
--
ALTER TABLE `app_membership`
  MODIFY `membership_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `app_users`
--
ALTER TABLE `app_users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `app_users_groups`
--
ALTER TABLE `app_users_groups`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `app_vehicles`
--
ALTER TABLE `app_vehicles`
  MODIFY `vehicle_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `app_vehicle_bloking`
--
ALTER TABLE `app_vehicle_bloking`
  MODIFY `vehicle_bloking_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `app_vehicle_booking`
--
ALTER TABLE `app_vehicle_booking`
  MODIFY `vehicle_booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `app_vehicle_booking_extra`
--
ALTER TABLE `app_vehicle_booking_extra`
  MODIFY `vehicle_booking_extra_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `app_vehicle_extra_relation`
--
ALTER TABLE `app_vehicle_extra_relation`
  MODIFY `vehicle_extra_relation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;
--
-- AUTO_INCREMENT for table `app_vehicle_prices`
--
ALTER TABLE `app_vehicle_prices`
  MODIFY `vehicle_price_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `app_vehicle_types`
--
ALTER TABLE `app_vehicle_types`
  MODIFY `vehicle_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `app_users_groups`
--
ALTER TABLE `app_users_groups`
  ADD CONSTRAINT `fk_users_groups_groups1` FOREIGN KEY (`group_id`) REFERENCES `app_groups` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_users_groups_users1` FOREIGN KEY (`user_id`) REFERENCES `app_users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
