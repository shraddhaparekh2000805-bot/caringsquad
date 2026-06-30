-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 30, 2026 at 07:15 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `caringsquad`
--

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE `blogs` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `category_id` int(11) NOT NULL,
  `featured_image` varchar(255) DEFAULT NULL,
  `excerpt` text DEFAULT NULL,
  `content` longtext DEFAULT NULL,
  `author` varchar(100) DEFAULT 'Caring Squad',
  `read_time` varchar(30) DEFAULT NULL,
  `status` enum('Published','Draft') DEFAULT 'Published',
  `featured` tinyint(1) DEFAULT 0,
  `views` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `blog_categories`
--

CREATE TABLE `blog_categories` (
  `id` int(11) NOT NULL,
  `category_name` varchar(100) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blog_categories`
--

INSERT INTO `blog_categories` (`id`, `category_name`, `status`) VALUES
(1, 'Health & Wellness', 1),
(2, 'Elder Care', 1),
(3, 'Companionship', 1),
(5, 'News & Updates', 1);

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` int(11) NOT NULL,
  `state_id` int(11) NOT NULL,
  `city_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `state_id`, `city_name`) VALUES
(1, 7, 'Ahmedabad'),
(2, 7, 'Surat'),
(3, 7, 'Vadodara'),
(4, 7, 'Rajkot'),
(5, 7, 'Bhavnagar'),
(6, 7, 'Jamnagar'),
(7, 7, 'Junagadh'),
(8, 7, 'Gandhinagar'),
(9, 7, 'Anand'),
(10, 7, 'Nadiad'),
(11, 7, 'Mehsana'),
(12, 7, 'Patan'),
(13, 7, 'Palanpur'),
(14, 7, 'Morbi'),
(15, 7, 'Porbandar'),
(16, 7, 'Amreli'),
(17, 7, 'Botad'),
(18, 7, 'Bharuch'),
(19, 7, 'Navsari'),
(20, 7, 'Valsad'),
(21, 7, 'Godhra'),
(22, 7, 'Dahod'),
(23, 7, 'Veraval'),
(24, 7, 'Bhuj'),
(25, 7, 'Surendranagar'),
(26, 14, 'Mumbai'),
(27, 14, 'Pune'),
(28, 14, 'Nagpur'),
(29, 14, 'Nashik'),
(30, 14, 'Thane'),
(31, 14, 'Aurangabad'),
(32, 14, 'Kolhapur'),
(33, 14, 'Solapur'),
(34, 14, 'Amravati'),
(35, 14, 'Jalgaon'),
(36, 14, 'Ahmednagar'),
(37, 14, 'Satara'),
(38, 14, 'Sangli'),
(39, 14, 'Akola'),
(40, 14, 'Latur'),
(41, 14, 'Nanded'),
(42, 21, 'Jaipur'),
(43, 21, 'Jodhpur'),
(44, 21, 'Udaipur'),
(45, 21, 'Ajmer'),
(46, 21, 'Kota'),
(47, 21, 'Bikaner'),
(48, 21, 'Alwar'),
(49, 21, 'Bharatpur'),
(50, 21, 'Sikar'),
(51, 21, 'Pali'),
(52, 21, 'Barmer'),
(53, 21, 'Chittorgarh'),
(54, 21, 'Bhilwara'),
(55, 21, 'Jaisalmer'),
(56, 21, 'Tonk'),
(57, 11, 'Bengaluru'),
(58, 11, 'Mysuru'),
(59, 11, 'Mangaluru'),
(60, 11, 'Hubballi'),
(61, 11, 'Belagavi'),
(62, 11, 'Davanagere'),
(63, 11, 'Ballari'),
(64, 11, 'Shivamogga'),
(65, 11, 'Tumakuru'),
(66, 11, 'Udupi'),
(67, 11, 'Bidar'),
(68, 11, 'Vijayapura'),
(69, 11, 'Kalaburagi'),
(70, 11, 'Raichur'),
(71, 11, 'Hassan'),
(72, 12, 'Kochi'),
(73, 12, 'Thiruvananthapuram'),
(74, 12, 'Kozhikode'),
(75, 12, 'Thrissur'),
(76, 12, 'Kannur'),
(77, 12, 'Kollam'),
(78, 12, 'Alappuzha'),
(79, 12, 'Kottayam'),
(80, 12, 'Palakkad'),
(81, 12, 'Malappuram'),
(82, 12, 'Pathanamthitta'),
(83, 12, 'Kasaragod'),
(84, 23, 'Chennai'),
(85, 23, 'Coimbatore'),
(86, 23, 'Madurai'),
(87, 23, 'Salem'),
(88, 23, 'Tiruchirappalli'),
(89, 23, 'Vellore'),
(90, 23, 'Erode'),
(91, 23, 'Thoothukudi'),
(92, 23, 'Tiruppur'),
(93, 23, 'Dindigul'),
(94, 23, 'Nagercoil'),
(95, 23, 'Karur'),
(96, 23, 'Kanchipuram'),
(97, 23, 'Thanjavur'),
(98, 23, 'Cuddalore'),
(99, 24, 'Hyderabad'),
(100, 24, 'Warangal'),
(101, 24, 'Nizamabad'),
(102, 24, 'Karimnagar'),
(103, 24, 'Khammam'),
(104, 24, 'Mahabubnagar'),
(105, 24, 'Adilabad'),
(106, 24, 'Siddipet'),
(107, 24, 'Suryapet'),
(108, 24, 'Medak'),
(109, 1, 'Visakhapatnam'),
(110, 1, 'Vijayawada'),
(111, 1, 'Guntur'),
(112, 1, 'Nellore'),
(113, 1, 'Tirupati'),
(114, 1, 'Kurnool'),
(115, 1, 'Rajahmundry'),
(116, 1, 'Kadapa'),
(117, 1, 'Anantapur'),
(118, 1, 'Eluru'),
(119, 1, 'Ongole'),
(120, 1, 'Srikakulam'),
(121, 20, 'Amritsar'),
(122, 20, 'Ludhiana'),
(123, 20, 'Jalandhar'),
(124, 20, 'Patiala'),
(125, 20, 'Mohali'),
(126, 20, 'Bathinda'),
(127, 20, 'Pathankot'),
(128, 20, 'Hoshiarpur'),
(129, 20, 'Moga'),
(130, 20, 'Firozpur'),
(131, 20, 'Kapurthala'),
(132, 20, 'Sangrur'),
(133, 8, 'Gurugram'),
(134, 8, 'Faridabad'),
(135, 8, 'Panipat'),
(136, 8, 'Ambala'),
(137, 8, 'Hisar'),
(138, 8, 'Rohtak'),
(139, 8, 'Karnal'),
(140, 8, 'Sonipat'),
(141, 8, 'Yamunanagar'),
(142, 8, 'Bhiwani'),
(143, 8, 'Rewari'),
(144, 8, 'Sirsa'),
(145, 32, 'New Delhi'),
(146, 32, 'North Delhi'),
(147, 32, 'South Delhi'),
(148, 32, 'East Delhi'),
(149, 32, 'West Delhi'),
(150, 32, 'Central Delhi'),
(151, 32, 'Dwarka'),
(152, 32, 'Rohini'),
(153, 32, 'Karol Bagh'),
(154, 32, 'Saket'),
(155, 26, 'Lucknow'),
(156, 26, 'Kanpur'),
(157, 26, 'Noida'),
(158, 26, 'Ghaziabad'),
(159, 26, 'Agra'),
(160, 26, 'Varanasi'),
(161, 26, 'Prayagraj'),
(162, 26, 'Meerut'),
(163, 26, 'Bareilly'),
(164, 26, 'Aligarh'),
(165, 26, 'Gorakhpur'),
(166, 26, 'Jhansi'),
(167, 26, 'Mathura'),
(168, 26, 'Moradabad'),
(169, 26, 'Ayodhya'),
(170, 26, 'Saharanpur'),
(171, 26, 'Firozabad'),
(172, 26, 'Muzaffarnagar'),
(173, 13, 'Bhopal'),
(174, 13, 'Indore'),
(175, 13, 'Gwalior'),
(176, 13, 'Jabalpur'),
(177, 13, 'Ujjain'),
(178, 13, 'Sagar'),
(179, 13, 'Satna'),
(180, 13, 'Rewa'),
(181, 13, 'Ratlam'),
(182, 13, 'Dewas'),
(183, 13, 'Singrauli'),
(184, 13, 'Katni'),
(185, 13, 'Chhindwara'),
(186, 13, 'Vidisha'),
(187, 13, 'Shivpuri'),
(188, 4, 'Patna'),
(189, 4, 'Gaya'),
(190, 4, 'Muzaffarpur'),
(191, 4, 'Bhagalpur'),
(192, 4, 'Darbhanga'),
(193, 4, 'Purnia'),
(194, 4, 'Ara'),
(195, 4, 'Begusarai'),
(196, 4, 'Katihar'),
(197, 4, 'Munger'),
(198, 4, 'Bettiah'),
(199, 4, 'Sasaram'),
(200, 28, 'Kolkata'),
(201, 28, 'Howrah'),
(202, 28, 'Durgapur'),
(203, 28, 'Siliguri'),
(204, 28, 'Asansol'),
(205, 28, 'Kharagpur'),
(206, 28, 'Malda'),
(207, 28, 'Haldia'),
(208, 28, 'Bardhaman'),
(209, 28, 'Darjeeling'),
(210, 28, 'Jalpaiguri'),
(211, 28, 'Krishnanagar'),
(212, 19, 'Bhubaneswar'),
(213, 19, 'Cuttack'),
(214, 19, 'Rourkela'),
(215, 19, 'Sambalpur'),
(216, 19, 'Puri'),
(217, 19, 'Balasore'),
(218, 19, 'Berhampur'),
(219, 19, 'Jharsuguda'),
(220, 19, 'Baripada'),
(221, 19, 'Angul'),
(222, 19, 'Jeypore'),
(223, 19, 'Bhadrak'),
(224, 3, 'Guwahati'),
(225, 3, 'Silchar'),
(226, 3, 'Dibrugarh'),
(227, 3, 'Jorhat'),
(228, 3, 'Tezpur'),
(229, 3, 'Nagaon'),
(230, 3, 'Tinsukia'),
(231, 3, 'Bongaigaon'),
(232, 3, 'Sivasagar'),
(233, 3, 'Dhubri'),
(234, 10, 'Ranchi'),
(235, 10, 'Jamshedpur'),
(236, 10, 'Dhanbad'),
(237, 10, 'Bokaro'),
(238, 10, 'Deoghar'),
(239, 10, 'Hazaribagh'),
(240, 10, 'Giridih'),
(241, 10, 'Ramgarh'),
(242, 10, 'Chaibasa'),
(243, 10, 'Dumka'),
(244, 5, 'Raipur'),
(245, 5, 'Bilaspur'),
(246, 5, 'Durg'),
(247, 5, 'Bhilai'),
(248, 5, 'Korba'),
(249, 5, 'Jagdalpur'),
(250, 5, 'Raigarh'),
(251, 5, 'Ambikapur'),
(252, 5, 'Rajnandgaon'),
(253, 5, 'Dhamtari'),
(254, 6, 'Panaji'),
(255, 6, 'Margao'),
(256, 6, 'Vasco da Gama'),
(257, 6, 'Mapusa'),
(258, 6, 'Ponda'),
(259, 6, 'Calangute'),
(260, 6, 'Candolim'),
(261, 9, 'Shimla'),
(262, 9, 'Manali'),
(263, 9, 'Dharamshala'),
(264, 9, 'Solan'),
(265, 9, 'Mandi'),
(266, 9, 'Hamirpur'),
(267, 9, 'Kullu'),
(268, 9, 'Una'),
(269, 9, 'Bilaspur'),
(270, 9, 'Chamba'),
(271, 27, 'Dehradun'),
(272, 27, 'Haridwar'),
(273, 27, 'Rishikesh'),
(274, 27, 'Haldwani'),
(275, 27, 'Roorkee'),
(276, 27, 'Nainital'),
(277, 27, 'Rudrapur'),
(278, 27, 'Almora'),
(279, 27, 'Pithoragarh'),
(280, 27, 'Kashipur'),
(281, 22, 'Gangtok'),
(282, 22, 'Namchi'),
(283, 22, 'Gyalshing'),
(284, 22, 'Mangan'),
(285, 22, 'Rangpo'),
(286, 2, 'Itanagar'),
(287, 2, 'Tawang'),
(288, 2, 'Ziro'),
(289, 2, 'Pasighat'),
(290, 2, 'Bomdila'),
(291, 2, 'Naharlagun'),
(292, 2, 'Tezu'),
(293, 16, 'Shillong'),
(294, 16, 'Tura'),
(295, 16, 'Jowai'),
(296, 16, 'Nongpoh'),
(297, 16, 'Williamnagar'),
(298, 15, 'Imphal'),
(299, 15, 'Thoubal'),
(300, 15, 'Bishnupur'),
(301, 15, 'Churachandpur'),
(302, 15, 'Ukhrul'),
(303, 17, 'Aizawl'),
(304, 17, 'Lunglei'),
(305, 17, 'Champhai'),
(306, 17, 'Kolasib'),
(307, 17, 'Serchhip'),
(308, 18, 'Kohima'),
(309, 18, 'Dimapur'),
(310, 18, 'Mokokchung'),
(311, 18, 'Tuensang'),
(312, 18, 'Wokha'),
(313, 25, 'Agartala'),
(314, 25, 'Udaipur'),
(315, 25, 'Dharmanagar'),
(316, 25, 'Kailashahar'),
(317, 25, 'Belonia'),
(318, 33, 'Srinagar'),
(319, 33, 'Jammu'),
(320, 33, 'Anantnag'),
(321, 33, 'Baramulla'),
(322, 33, 'Pulwama'),
(323, 33, 'Kupwara'),
(324, 33, 'Kathua'),
(325, 34, 'Leh'),
(326, 34, 'Kargil'),
(327, 34, 'Diskit'),
(328, 34, 'Nubra'),
(329, 30, 'Chandigarh'),
(330, 36, 'Puducherry'),
(331, 36, 'Karaikal'),
(332, 36, 'Mahe'),
(333, 36, 'Yanam'),
(334, 29, 'Port Blair'),
(335, 29, 'Havelock Island'),
(336, 29, 'Diglipur'),
(337, 29, 'Rangat'),
(338, 35, 'Kavaratti'),
(339, 35, 'Agatti'),
(340, 35, 'Minicoy'),
(341, 35, 'Amini'),
(342, 31, 'Daman'),
(343, 31, 'Diu'),
(344, 31, 'Silvassa');

-- --------------------------------------------------------

--
-- Table structure for table `contact_inquiries`
--

CREATE TABLE `contact_inquiries` (
  `id` int(11) NOT NULL,
  `fullname` varchar(120) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `city` varchar(100) NOT NULL,
  `address` varchar(300) NOT NULL,
  `whoami` varchar(120) NOT NULL,
  `inquiryfor` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_inquiries`
--

INSERT INTO `contact_inquiries` (`id`, `fullname`, `mobile`, `email`, `city`, `address`, `whoami`, `inquiryfor`, `description`, `created_at`) VALUES
(1, 'Test User', '9876543210', 'test@example.com', 'Ahmedabad', 'Test Address', 'Student', 'Elder Care', 'Test inquiry message', '2026-06-30 04:56:57'),
(2, 'mudra bhanvadiya', '8799434640', 'mudrabhanvadiya@gmail.com', 'ahmedabad', '707 stc', 'tester', 'testing', 'im mudra bhanvaadiya.', '2026-06-30 04:59:24'),
(3, 'mudra bhanvadiya', '8799434640', 'mudrabhanvadiya@gmail.com', 'ahmedabad', '707 stc', 'student', 'travel companion', 'im mudra bhanvadiya. looking for travel companion', '2026-06-30 04:59:35'),
(4, 'Shruti Parekh', '9773246009', 'itsshrutiparekh@gmail.com', 'ahmedabad', '707 stc', 'student', 'travel companion', 'im shraddha parekh.', '2026-06-30 05:00:17'),
(5, 'Shruti Parekh', '9773246009', 'itsshrutiparekh@gmail.com', 'ahmedabad', '707 stc', 'student', 'travel companion', 'helloooo', '2026-06-30 05:04:56');

-- --------------------------------------------------------

--
-- Table structure for table `doctors`
--

CREATE TABLE `doctors` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `gender` varchar(20) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `mobile` varchar(20) DEFAULT NULL,
  `whatsapp` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `degree` varchar(255) NOT NULL,
  `speciality` varchar(255) NOT NULL,
  `experience` varchar(100) DEFAULT NULL,
  `rating` decimal(2,1) DEFAULT NULL,
  `language` varchar(255) DEFAULT NULL,
  `fee` varchar(50) DEFAULT NULL,
  `available_time` varchar(255) DEFAULT NULL,
  `hospital` varchar(255) DEFAULT NULL,
  `current_designation` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` enum('Active','Inactive') DEFAULT 'Active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `profession` varchar(255) DEFAULT NULL,
  `license_number` varchar(255) DEFAULT NULL,
  `council` varchar(255) DEFAULT NULL,
  `online_consultation` varchar(50) DEFAULT NULL,
  `home_visit` varchar(50) DEFAULT NULL,
  `consultation_mode` text DEFAULT NULL,
  `platform` text DEFAULT NULL,
  `video_whatsapp` varchar(20) DEFAULT NULL,
  `audio_mobile` varchar(20) DEFAULT NULL,
  `clinic_fee` varchar(50) DEFAULT NULL,
  `cs_fee` varchar(50) DEFAULT NULL,
  `priority_fee` varchar(50) DEFAULT NULL,
  `consultation_duration` varchar(100) DEFAULT NULL,
  `consultation_languages` text DEFAULT NULL,
  `availability` text DEFAULT NULL,
  `available_days` text DEFAULT NULL,
  `priority_consultation` varchar(50) DEFAULT NULL,
  `response_time` varchar(100) DEFAULT NULL,
  `emergency_charges` varchar(50) DEFAULT NULL,
  `max_priority_consultation` varchar(50) DEFAULT NULL,
  `followup_available` varchar(50) DEFAULT NULL,
  `followup_fee` varchar(50) DEFAULT NULL,
  `free_followup_period` varchar(100) DEFAULT NULL,
  `report_review` varchar(50) DEFAULT NULL,
  `digital_prescription` varchar(50) DEFAULT NULL,
  `home_visit_available` varchar(50) DEFAULT NULL,
  `service_radius` varchar(100) DEFAULT NULL,
  `home_visit_fee` varchar(50) DEFAULT NULL,
  `linkedin_profile` text DEFAULT NULL,
  `website_profile` text DEFAULT NULL,
  `professional_bio` longtext DEFAULT NULL,
  `special_consultation_fee` varchar(100) DEFAULT NULL,
  `special_fee_amount` varchar(50) DEFAULT NULL,
  `dr_id` varchar(10) NOT NULL,
  `caring_squad_fee` decimal(10,2) NOT NULL DEFAULT 0.00,
  `state_id` int(11) DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL,
  `display_name` varchar(255) DEFAULT NULL,
  `display_degree` varchar(255) DEFAULT NULL,
  `display_speciality` varchar(255) DEFAULT NULL,
  `display_experience` varchar(100) DEFAULT NULL,
  `display_languages` varchar(255) DEFAULT NULL,
  `consultation_type` varchar(100) DEFAULT NULL,
  `sub_specialization` varchar(255) DEFAULT NULL,
  `additional_certifications` text DEFAULT NULL,
  `registration_valid_till` date DEFAULT NULL,
  `additional_registrations` text DEFAULT NULL,
  `areas_covered` text DEFAULT NULL,
  `discounted_home_visit_fee` varchar(50) DEFAULT NULL,
  `display_profile` varchar(10) DEFAULT NULL,
  `display_photo` varchar(10) DEFAULT NULL,
  `display_fee` varchar(10) DEFAULT NULL,
  `founding_expert` varchar(10) DEFAULT NULL,
  `city_ambassador` varchar(10) DEFAULT NULL,
  `online_expert_panel` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctors`
--

INSERT INTO `doctors` (`id`, `name`, `gender`, `dob`, `mobile`, `whatsapp`, `email`, `degree`, `speciality`, `experience`, `rating`, `language`, `fee`, `available_time`, `hospital`, `current_designation`, `city`, `state`, `description`, `image`, `status`, `created_at`, `profession`, `license_number`, `council`, `online_consultation`, `home_visit`, `consultation_mode`, `platform`, `video_whatsapp`, `audio_mobile`, `clinic_fee`, `cs_fee`, `priority_fee`, `consultation_duration`, `consultation_languages`, `availability`, `available_days`, `priority_consultation`, `response_time`, `emergency_charges`, `max_priority_consultation`, `followup_available`, `followup_fee`, `free_followup_period`, `report_review`, `digital_prescription`, `home_visit_available`, `service_radius`, `home_visit_fee`, `linkedin_profile`, `website_profile`, `professional_bio`, `special_consultation_fee`, `special_fee_amount`, `dr_id`, `caring_squad_fee`, `state_id`, `city_id`, `display_name`, `display_degree`, `display_speciality`, `display_experience`, `display_languages`, `consultation_type`, `sub_specialization`, `additional_certifications`, `registration_valid_till`, `additional_registrations`, `areas_covered`, `discounted_home_visit_fee`, `display_profile`, `display_photo`, `display_fee`, `founding_expert`, `city_ambassador`, `online_expert_panel`) VALUES
(29, '', NULL, NULL, NULL, NULL, NULL, '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1782206844_Dr.Anamika Jha.jpeg', 'Active', '2026-06-23 09:27:24', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'jghjfghmdghmd,tyiou98765rredsfghj', NULL, NULL, 'D2026A1', 900.00, NULL, NULL, 'Mudra Patel', 'MBBS, MD', 'Cardiologist', '2 year', 'English, Hindi', 'Video Consultation', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `newsletter_subscribers`
--

CREATE TABLE `newsletter_subscribers` (
  `id` int(11) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `states`
--

CREATE TABLE `states` (
  `id` int(11) NOT NULL,
  `state_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `states`
--

INSERT INTO `states` (`id`, `state_name`) VALUES
(29, 'Andaman and Nicobar Islands'),
(1, 'Andhra Pradesh'),
(2, 'Arunachal Pradesh'),
(3, 'Assam'),
(4, 'Bihar'),
(30, 'Chandigarh'),
(5, 'Chhattisgarh'),
(31, 'Dadra and Nagar Haveli and Daman and Diu'),
(32, 'Delhi'),
(6, 'Goa'),
(7, 'Gujarat'),
(8, 'Haryana'),
(9, 'Himachal Pradesh'),
(33, 'Jammu and Kashmir'),
(10, 'Jharkhand'),
(11, 'Karnataka'),
(12, 'Kerala'),
(34, 'Ladakh'),
(35, 'Lakshadweep'),
(13, 'Madhya Pradesh'),
(14, 'Maharashtra'),
(15, 'Manipur'),
(16, 'Meghalaya'),
(17, 'Mizoram'),
(18, 'Nagaland'),
(19, 'Odisha'),
(36, 'Puducherry'),
(20, 'Punjab'),
(21, 'Rajasthan'),
(22, 'Sikkim'),
(23, 'Tamil Nadu'),
(24, 'Telangana'),
(25, 'Tripura'),
(26, 'Uttar Pradesh'),
(27, 'Uttarakhand'),
(28, 'West Bengal');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blog_categories`
--
ALTER TABLE `blog_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `state_id` (`state_id`);

--
-- Indexes for table `contact_inquiries`
--
ALTER TABLE `contact_inquiries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `doctors`
--
ALTER TABLE `doctors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_state` (`state_id`),
  ADD KEY `fk_city` (`city_id`);

--
-- Indexes for table `newsletter_subscribers`
--
ALTER TABLE `newsletter_subscribers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `states`
--
ALTER TABLE `states`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `state_name` (`state_name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `blog_categories`
--
ALTER TABLE `blog_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=345;

--
-- AUTO_INCREMENT for table `contact_inquiries`
--
ALTER TABLE `contact_inquiries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `doctors`
--
ALTER TABLE `doctors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `newsletter_subscribers`
--
ALTER TABLE `newsletter_subscribers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `states`
--
ALTER TABLE `states`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cities`
--
ALTER TABLE `cities`
  ADD CONSTRAINT `cities_ibfk_1` FOREIGN KEY (`state_id`) REFERENCES `states` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `doctors`
--
ALTER TABLE `doctors`
  ADD CONSTRAINT `fk_city` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`),
  ADD CONSTRAINT `fk_state` FOREIGN KEY (`state_id`) REFERENCES `states` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
