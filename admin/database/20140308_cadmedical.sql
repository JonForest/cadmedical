-- phpMyAdmin SQL Dump
-- version 4.0.8
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 08, 2014 at 09:17 PM
-- Server version: 5.1.72-cll
-- PHP Version: 5.3.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ablef014_cadmedical`
--

-- --------------------------------------------------------

--
-- Table structure for table `adminusers`
--

CREATE TABLE IF NOT EXISTS `adminusers` (
  `adminUsersId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `lastUpdated` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`adminUsersId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `categoryId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `heroText` text NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `created` datetime NOT NULL,
  `lastUpdated` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`categoryId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`categoryId`, `name`, `heroText`, `status`, `created`, `lastUpdated`) VALUES
(1, 'Eyewear', '<div>The complete <span class="stand-out">eyewear</span> solution</div><div class="subText">Eye protection for clinicians and patients.</div>', 1, '2014-03-03 05:53:09', '0000-00-00 00:00:00'),
(2, 'Gonad Shield', '<div>The complete <span class="stand-out">gonad shield</span> solution</div><div class="subText">Protection where it is really needed.<br>Light weight protection for reproductive organs.</div>', 1, '2014-03-03 05:53:09', '0000-00-00 00:00:00'),
(3, 'Hand Protection', '<div>The complete <span class="stand-out">hand protection</span> solution</div><div class="subText">Disposable gloves that provide the highest possible, Lead free, protection.</div>', 1, '2014-03-03 05:53:09', '0000-00-00 00:00:00'),
(4, 'Head and Patient Shield', '<div>The complete <span class="stand-out">head and patient</span> solution</div><div class="subText">Protection where it is needed most.<br>Designed for Cardiology, Radiology and Dentistry.</div>', 1, '2014-03-03 05:53:09', '0000-00-00 00:00:00'),
(5, 'Thyroid Shield', '<div>The complete <span class="stand-out">thyroid shield</span> solution</div><div class="subText">Complete protection to neck and sternum.<br>Cardiology, Radiology and Dentistry applications.</div>', 1, '2014-03-03 05:53:09', '0000-00-00 00:00:00'),
(6, 'Ultra Apron', '<div>The complete <span class="stand-out">apron</span> solution</div><div class="subText">Ergonomic, durable and light weight.</div>', 1, '2014-03-03 05:53:09', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE IF NOT EXISTS `images` (
  `imageId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `productId` int(10) unsigned NOT NULL,
  `imagePath` varchar(255) DEFAULT NULL,
  `imageTitle` varchar(100) DEFAULT NULL,
  `caption` text,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `created` datetime NOT NULL,
  `lastUpdated` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`imageId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=31 ;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`imageId`, `productId`, `imagePath`, `imageTitle`, `caption`, `status`, `created`, `lastUpdated`) VALUES
(3, 3, '353127ffe6b75emaxx10.jpg', 'MAXX 10', 'Lead Equivalence: 0.75 mm Pb', 1, '2014-03-02 00:49:02', '2014-03-02 01:37:22'),
(9, 7, '753128db638a14front.jpg', 'F-RON', 'Lead Equivalence: 0.75 mm Pb', 1, '2014-03-02 01:47:34', '2014-03-02 01:49:02'),
(5, 4, '4531286b38fabbfront_side.jpg', 'F-SIDE', 'Lead Equivalence: 0.75 mm Pb', 1, '2014-03-02 01:17:39', '2014-03-02 01:37:50'),
(6, 5, '55312898a94db2aviators.jpg', 'AVIATOR', 'Lead Equivalence: 0.75 mm Pb', 1, '2014-03-02 01:29:46', '2014-03-02 01:38:26'),
(8, 6, '653128bd005da1maxx30.jpg', 'MAXX 30', 'Lead Equivalence: 0.75 mm Pb', 1, '2014-03-02 01:39:28', '2014-03-02 01:41:45'),
(10, 7, '753128e8507109illusion.jpg', 'ILLUSION', 'Lead Equivalence: 0.75 mm Pb', 1, '2014-03-02 01:51:01', '2014-03-02 01:52:54'),
(12, 8, '85312901638f1dfit_over.jpg', 'F-OVER', 'Lead Equivalence: 0.75 mm Pb', 1, '2014-03-02 01:57:42', '2014-03-02 01:58:59'),
(13, 9, '95313a597eb9d2gonad__ovarian.jpg', 'Designed for Cardiology and Radiology', 'Lead Equivalence: 1.0 mm Pb', 1, '2014-03-02 21:41:43', '2014-03-03 00:45:37'),
(14, 10, '105313a7c8aa34bgonad__ovarian.jpg', '', '', 1, '2014-03-02 21:51:04', '2014-03-02 21:51:36'),
(15, 11, '115313d1337ead3glove.jpg', 'Hand Protection', 'Lead equivalence 0.25 mm Pb, 0.35 mm Pb, and 0.5 mm Pb\n', 1, '2014-03-03 00:47:47', '2014-03-03 00:52:54'),
(20, 17, '1753152d837b2e6patient_shields.jpg', 'Patient Shield', 'Lead Equivalence: 0.35, 0.50 and 1 mm Pb', 1, '2014-03-04 01:33:55', '2014-03-04 01:35:23'),
(17, 12, '125313d37672e08head_shield.jpg', 'Head Shield', 'Lead Equivalence: 0.25mm Pb', 1, '2014-03-03 00:57:26', '2014-03-03 00:58:52'),
(21, 17, '1753152e9a67d25harmony.jpg', 'Harmony', 'Lead Equivalence: 0.35mm Pb or 0.5mm Pb', 1, '2014-03-04 01:38:34', '2014-03-04 01:43:13'),
(22, 18, '18531530dc1ff89505_classic.jpg', 'Classic', 'Lead Equivalence: 0.35mm Pb or 0.5mm Pb', 1, '2014-03-04 01:48:12', '2014-03-04 01:49:42'),
(23, 19, '1953163bf869340patient_shields.jpg', 'Patient Shield', 'Lead Equivalence: 0.35, 0.50 and 1 mm Pb', 1, '2014-03-04 20:47:52', '2014-03-04 20:49:19'),
(24, 20, '2053163da606de7elegant.jpg', 'Elegant', 'Lead Equivalence: 0.35mm Pb or 0.5mm Pb', 1, '2014-03-04 20:55:02', '2014-03-04 20:56:06'),
(25, 21, '2153163f1c5978bslimline.jpg', 'Slimline', 'Lead Equivalence: 0.35mm Pb or 0.5mm Pb', 1, '2014-03-04 21:01:16', '2014-03-04 21:02:36'),
(26, 23, '23531641c03a73emaxima - complete frontal overlap.jpg', 'Maxima', 'Lead equivalence: 0.25mmPb, 0.35mmPb and 0.50mmPb Leadlite, Ultralite and Zerolead', 1, '2014-03-04 21:12:32', '2014-03-04 21:15:44'),
(27, 24, '2453164316d742ddouble_sided_maxima.jpg', 'Maxima - Complete frontal overlap', 'Lead equivalence: 0.25mmPb, 0.35mmPb and 0.50mmPb\nLeadlite, Ultralite and Zerolead', 1, '2014-03-04 21:18:14', '2014-03-04 21:20:33'),
(28, 25, '255316445d308edoptima - partial overlap.jpg', 'Optima', 'Lead equivalence: 0.25mmPb, 0.35mmPb and 0.50mmPb Leadlite, Ultralite and Zerolead', 1, '2014-03-04 21:23:41', '2014-03-04 21:25:14'),
(29, 26, '265316464d755e7coat apron.jpg', 'Coat Apron', 'Lead equivalence: 0.25mmPb, 0.35mmPb and 0.50mmPb Leadlite, Ultralite and Zerolead', 1, '2014-03-04 21:31:57', '2014-03-04 21:34:31'),
(30, 27, '27531647824743fsurgical apron.jpg', 'Surgical Apron', 'Lead equivalence: 0.25mmPb, 0.35mmPb and 0.50mmPb Leadlite, Ultralite and Zerolead', 1, '2014-03-04 21:37:06', '2014-03-04 21:41:03');

-- --------------------------------------------------------

--
-- Table structure for table `prices`
--

CREATE TABLE IF NOT EXISTS `prices` (
  `priceId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `productId` int(10) unsigned NOT NULL,
  `price` float DEFAULT NULL,
  `priceDiscriminator` varchar(500) DEFAULT NULL,
  `priceFrom` tinyint(1) DEFAULT '0',
  `priceOnRequest` tinyint(4) NOT NULL DEFAULT '0',
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `created` datetime NOT NULL,
  `lastupdated` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`priceId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=32 ;

--
-- Dumping data for table `prices`
--

INSERT INTO `prices` (`priceId`, `productId`, `price`, `priceDiscriminator`, `priceFrom`, `priceOnRequest`, `status`, `created`, `lastupdated`) VALUES
(1, 3, 299, NULL, 0, 0, 1, '2014-03-08 04:33:51', '0000-00-00 00:00:00'),
(2, 4, 289, NULL, 0, 0, 1, '2014-03-08 04:33:51', '0000-00-00 00:00:00'),
(3, 5, 329, NULL, 0, 0, 1, '2014-03-08 04:33:51', '0000-00-00 00:00:00'),
(4, 6, 329, NULL, 0, 0, 1, '2014-03-08 04:33:51', '0000-00-00 00:00:00'),
(5, 7, 329, NULL, 0, 0, 1, '2014-03-08 04:33:51', '0000-00-00 00:00:00'),
(6, 8, 299, NULL, 0, 0, 1, '2014-03-08 04:33:51', '0000-00-00 00:00:00'),
(7, 9, 0, NULL, 0, 0, 1, '2014-03-08 04:33:51', '0000-00-00 00:00:00'),
(8, 11, 59, NULL, 0, 0, 1, '2014-03-08 04:33:51', '0000-00-00 00:00:00'),
(9, 12, 0, NULL, 0, 0, 1, '2014-03-08 04:33:51', '0000-00-00 00:00:00'),
(10, 17, 119, NULL, 0, 0, 1, '2014-03-08 04:33:51', '0000-00-00 00:00:00'),
(11, 18, 129, NULL, 0, 0, 1, '2014-03-08 04:33:51', '0000-00-00 00:00:00'),
(12, 19, 0, NULL, 0, 0, 1, '2014-03-08 04:33:51', '0000-00-00 00:00:00'),
(13, 20, 119, NULL, 0, 0, 1, '2014-03-08 04:33:51', '0000-00-00 00:00:00'),
(14, 21, 109, NULL, 0, 0, 1, '2014-03-08 04:33:51', '0000-00-00 00:00:00'),
(15, 22, 429, NULL, 0, 0, 1, '2014-03-08 04:33:51', '0000-00-00 00:00:00'),
(16, 23, 429, NULL, 0, 0, 1, '2014-03-08 04:33:51', '0000-00-00 00:00:00'),
(17, 24, 429, NULL, 0, 0, 1, '2014-03-08 04:33:51', '0000-00-00 00:00:00'),
(18, 25, 429, NULL, 0, 0, 1, '2014-03-08 04:33:51', '0000-00-00 00:00:00'),
(19, 26, 339, NULL, 0, 0, 1, '2014-03-08 04:33:51', '0000-00-00 00:00:00'),
(20, 27, 339, NULL, 0, 0, 1, '2014-03-08 04:33:51', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `productdetailitems`
--

CREATE TABLE IF NOT EXISTS `productdetailitems` (
  `productDetailItemId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `productId` int(10) unsigned NOT NULL,
  `description` text,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `created` datetime NOT NULL,
  `lastUpdated` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`productDetailItemId`),
  KEY `FK_productsdetailsitems_product` (`productId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=197 ;

--
-- Dumping data for table `productdetailitems`
--

INSERT INTO `productdetailitems` (`productDetailItemId`, `productId`, `description`, `status`, `created`, `lastUpdated`) VALUES
(41, 3, 'Padding on the temples and bridge of the nose', 1, '2014-03-02 01:37:22', '2014-03-02 01:37:22'),
(42, 3, 'Semi-rigid case and adjustable strap', 1, '2014-03-02 01:37:22', '2014-03-02 01:37:22'),
(43, 4, 'Protects wearers from frontal and lateral radiation', 1, '2014-03-02 01:37:50', '2014-03-02 01:37:50'),
(44, 4, 'Very popular model', 1, '2014-03-02 01:37:50', '2014-03-02 01:37:50'),
(45, 5, 'Protective and stylish', 1, '2014-03-02 01:38:26', '2014-03-02 01:38:26'),
(46, 5, 'Wrapped frame protects the complete eye', 1, '2014-03-02 01:38:26', '2014-03-02 01:38:26'),
(47, 5, 'No danger of lateral radiation', 1, '2014-03-02 01:38:26', '2014-03-02 01:38:26'),
(48, 5, 'Molded frame snugly fits the nose', 1, '2014-03-02 01:38:26', '2014-03-02 01:38:26'),
(53, 6, 'Unisex Sports model', 1, '2014-03-02 01:46:21', '2014-03-02 01:46:21'),
(54, 6, 'One size fits all', 1, '2014-03-02 01:46:21', '2014-03-02 01:46:21'),
(55, 6, 'Padding on the temples and bridge of the nose', 1, '2014-03-02 01:46:21', '2014-03-02 01:46:21'),
(56, 6, 'Semi-rigid case, adjustable strap and six base lens curvatures', 1, '2014-03-02 01:46:21', '2014-03-02 01:46:21'),
(59, 7, 'Sophisticated rimless Illusion', 1, '2014-03-02 01:52:54', '2014-03-02 01:52:54'),
(60, 7, 'Comfort soft temple padding', 1, '2014-03-02 01:52:54', '2014-03-02 01:52:54'),
(61, 7, 'Premium scratch-proof hard coat', 1, '2014-03-02 01:52:54', '2014-03-02 01:52:54'),
(62, 7, 'Semi-rigid case and adjustable cord', 1, '2014-03-02 01:52:54', '2014-03-02 01:52:54'),
(65, 8, 'For clinicians with eyeglasses', 1, '2014-03-02 01:58:59', '2014-03-02 01:58:59'),
(66, 8, 'Perfect fit over the wearerâ€™s existing eyeglasses', 1, '2014-03-02 01:58:59', '2014-03-02 01:58:59'),
(67, 8, 'No compromise on clarity of vision', 1, '2014-03-02 01:58:59', '2014-03-02 01:58:59'),
(76, 9, 'One size fits all', 1, '2014-03-03 00:45:37', '2014-03-03 00:45:37'),
(77, 9, 'Ease of wear and removal', 1, '2014-03-03 00:45:37', '2014-03-03 00:45:37'),
(78, 9, 'Adjustable belt for Ovarian Shields', 1, '2014-03-03 00:45:37', '2014-03-03 00:45:37'),
(79, 9, 'Light weight Protection for reproductive organs', 1, '2014-03-03 00:45:37', '2014-03-03 00:45:37'),
(80, 9, 'Price on request', 1, '2014-03-03 00:45:37', '2014-03-03 00:45:37'),
(89, 11, 'Disposable gloves that provide the highest possible protection', 1, '2014-03-03 00:52:54', '2014-03-03 00:52:54'),
(90, 11, 'Lead Free Radiation Protection', 1, '2014-03-03 00:52:54', '2014-03-03 00:52:54'),
(91, 11, 'Sterile and powder free', 1, '2014-03-03 00:52:54', '2014-03-03 00:52:54'),
(92, 11, 'Rolled and beaded cuff', 1, '2014-03-03 00:52:54', '2014-03-03 00:52:54'),
(93, 11, 'Safe for the environment ', 1, '2014-03-03 00:52:54', '2014-03-03 00:52:54'),
(94, 11, 'Any size and thickness', 1, '2014-03-03 00:52:54', '2014-03-03 00:52:54'),
(95, 11, 'Flexible and textured for grip, and tactile sensitivity', 1, '2014-03-03 00:52:54', '2014-03-03 00:52:54'),
(96, 11, 'Hypoallergenic', 1, '2014-03-03 00:52:54', '2014-03-03 00:52:54'),
(112, 12, 'Snug fit', 1, '2014-03-03 06:09:14', '2014-03-03 06:09:14'),
(113, 12, 'Complete protection to head and ears', 1, '2014-03-03 06:09:14', '2014-03-03 06:09:14'),
(114, 12, 'Flexible and supple', 1, '2014-03-03 06:09:14', '2014-03-03 06:09:14'),
(115, 12, 'Designed for ease of wear and removal', 1, '2014-03-03 06:09:14', '2014-03-03 06:09:14'),
(116, 12, 'Price on request', 1, '2014-03-03 06:09:14', '2014-03-03 06:09:14'),
(125, 17, 'Most popular design', 1, '2014-03-04 01:43:13', '2014-03-04 01:43:13'),
(126, 17, 'Wide coverage', 1, '2014-03-04 01:43:13', '2014-03-04 01:43:13'),
(127, 17, 'One size fits all', 1, '2014-03-04 01:43:13', '2014-03-04 01:43:13'),
(128, 18, 'Popular new design', 1, '2014-03-04 01:49:42', '2014-03-04 01:49:42'),
(129, 18, 'Patented collar design fits thyroid gland perfectly', 1, '2014-03-04 01:49:42', '2014-03-04 01:49:42'),
(130, 18, 'Wide coverage', 1, '2014-03-04 01:49:42', '2014-03-04 01:49:42'),
(131, 18, 'One size fits all', 1, '2014-03-04 01:49:42', '2014-03-04 01:49:42'),
(132, 19, 'Protection for any part of the body', 1, '2014-03-04 20:49:19', '2014-03-04 20:49:19'),
(133, 19, 'Vibrant colours', 1, '2014-03-04 20:49:19', '2014-03-04 20:49:19'),
(134, 19, 'Customised sizes and shapes available on request', 1, '2014-03-04 20:49:19', '2014-03-04 20:49:19'),
(135, 19, 'Price provided on request', 1, '2014-03-04 20:49:19', '2014-03-04 20:49:19'),
(136, 20, 'Classic thyroid shield', 1, '2014-03-04 20:56:06', '2014-03-04 20:56:06'),
(137, 20, 'Adjustable fastener', 1, '2014-03-04 20:56:06', '2014-03-04 20:56:06'),
(138, 20, 'Easily attaches to Double Sided Apron and Vest', 1, '2014-03-04 20:56:06', '2014-03-04 20:56:06'),
(139, 21, 'Perfect fit and protection', 1, '2014-03-04 21:02:36', '2014-03-04 21:02:36'),
(140, 21, 'Easily attached to Dental Apron', 1, '2014-03-04 21:02:36', '2014-03-04 21:02:36'),
(149, 22, 'Adjustable Velcro panels for snug fit', 1, '2014-03-04 21:09:18', '2014-03-04 21:09:18'),
(150, 22, 'Specially designed to be worn for long durations', 1, '2014-03-04 21:09:18', '2014-03-04 21:09:18'),
(151, 22, 'Equitable weight distribution on waist and shoulders to prevent fatigue', 1, '2014-03-04 21:09:18', '2014-03-04 21:09:18'),
(152, 22, 'Fully overlapping skirt for added lower body protection', 1, '2014-03-04 21:09:18', '2014-03-04 21:09:18'),
(153, 22, 'Vest overlaps skirt up to 15 cm for additional lower body protection', 1, '2014-03-04 21:09:18', '2014-03-04 21:09:18'),
(154, 22, 'Front opening for ease of wearing', 1, '2014-03-04 21:09:18', '2014-03-04 21:09:18'),
(155, 22, 'Wide overlap on skirt front', 1, '2014-03-04 21:09:18', '2014-03-04 21:09:18'),
(156, 22, 'Price Example â€“ 0.35 mm Pb (from $429)', 1, '2014-03-04 21:09:18', '2014-03-04 21:09:18'),
(157, 23, 'Complete upper body protection with fully overlapping vest', 1, '2014-03-04 21:15:44', '2014-03-04 21:15:44'),
(158, 23, 'Specially designed to be worn for long durations', 1, '2014-03-04 21:15:44', '2014-03-04 21:15:44'),
(159, 23, 'Equitable weight distribution on waist and shoulders to prevent fatigue', 1, '2014-03-04 21:15:44', '2014-03-04 21:15:44'),
(160, 23, 'Fully overlapping skirt for added lower body protection', 1, '2014-03-04 21:15:44', '2014-03-04 21:15:44'),
(161, 23, 'Front opening for ease of wearing', 1, '2014-03-04 21:15:44', '2014-03-04 21:15:44'),
(162, 23, 'Wide overlap on skirt front', 1, '2014-03-04 21:15:44', '2014-03-04 21:15:44'),
(163, 23, 'Price Example â€“ 0.35 mm Pb (from $429)', 1, '2014-03-04 21:15:44', '2014-03-04 21:15:44'),
(164, 23, 'Price Example â€“ Ultralite â€“ 0.35 mm Pb (from $719) ', 1, '2014-03-04 21:15:44', '2014-03-04 21:15:44'),
(165, 24, 'Complete frontal overlap for improved fit', 1, '2014-03-04 21:20:33', '2014-03-04 21:20:33'),
(166, 24, 'Wide adjustable elastic belt for reduced back and shoulder stress', 1, '2014-03-04 21:20:33', '2014-03-04 21:20:33'),
(167, 24, 'Side slit fastener to prevent accidental radiation exposure', 1, '2014-03-04 21:20:33', '2014-03-04 21:20:33'),
(168, 24, 'Specially designed to be worn for long durations', 1, '2014-03-04 21:20:33', '2014-03-04 21:20:33'),
(169, 24, 'Equal protection on both shoulder panels', 1, '2014-03-04 21:20:33', '2014-03-04 21:20:33'),
(170, 24, 'Price Example â€“ 0.35 mm Pb (from $429)', 1, '2014-03-04 21:20:33', '2014-03-04 21:20:33'),
(171, 24, 'Price Example â€“ Ultralite â€“ 0.35 mm Pb (from $719) ', 1, '2014-03-04 21:20:33', '2014-03-04 21:20:33'),
(172, 25, 'Frontal overlap of 15 cm', 1, '2014-03-04 21:25:14', '2014-03-04 21:25:14'),
(173, 25, 'Velcro panels for improved fit', 1, '2014-03-04 21:25:14', '2014-03-04 21:25:14'),
(174, 25, 'Adjustable in-built elastic belt for reduced back and shoulder stress', 1, '2014-03-04 21:25:14', '2014-03-04 21:25:14'),
(175, 25, 'Side slits for better mobility', 1, '2014-03-04 21:25:14', '2014-03-04 21:25:14'),
(176, 25, 'Price Example â€“ 0.35 mm Pb (from $429)', 1, '2014-03-04 21:25:14', '2014-03-04 21:25:14'),
(177, 26, 'Complete frontal protection', 1, '2014-03-04 21:34:31', '2014-03-04 21:34:31'),
(178, 26, 'Wide stretchable insert with Velcro fastening for snug fit', 1, '2014-03-04 21:34:31', '2014-03-04 21:34:31'),
(179, 26, 'Comfortable to wear for long durations', 1, '2014-03-04 21:34:31', '2014-03-04 21:34:31'),
(180, 26, 'Padded shoulders for reduced shoulder stress and equitable distribution of weight', 1, '2014-03-04 21:34:31', '2014-03-04 21:34:31'),
(181, 26, 'Also available with snap lock instead of Velcro', 1, '2014-03-04 21:34:31', '2014-03-04 21:34:31'),
(182, 26, 'Easy to wear and remove', 1, '2014-03-04 21:34:31', '2014-03-04 21:34:31'),
(183, 26, 'Price Example â€“ 0.35 mm Pb (from $339)', 1, '2014-03-04 21:34:31', '2014-03-04 21:34:31'),
(184, 27, 'Specially designed for the surgical theatre', 1, '2014-03-04 21:41:03', '2014-03-04 21:41:03'),
(185, 27, 'Easily slides out from under a surgeonâ€™s scrubs when taking off', 1, '2014-03-04 21:41:03', '2014-03-04 21:41:03'),
(186, 27, 'Maximum frontal protection', 1, '2014-03-04 21:41:03', '2014-03-04 21:41:03'),
(187, 27, 'Adjustable Velcro panels for improved fit', 1, '2014-03-04 21:41:03', '2014-03-04 21:41:03'),
(188, 27, 'Ergonomic design equitably distributes weight', 1, '2014-03-04 21:41:03', '2014-03-04 21:41:03'),
(189, 27, 'Price Example â€“ 0.35 mm Pb (from $339)', 1, '2014-03-04 21:41:03', '2014-03-04 21:41:03'),
(190, 27, 'SMALL (girth up to 99cm) (height 145-155cm) ', 1, '2014-03-04 21:41:03', '2014-03-04 21:41:03'),
(191, 27, 'MEDIUM (girth 100-115cm) (height 155-165cm) ', 1, '2014-03-04 21:41:03', '2014-03-04 21:41:03'),
(192, 27, 'LARGE (girth 116-130cm) (height 155-165cm) ', 1, '2014-03-04 21:41:03', '2014-03-04 21:41:03'),
(193, 27, 'Contact us for accurate Pricing for your prefered size and material', 1, '2014-03-04 21:41:03', '2014-03-04 21:41:03'),
(194, 27, 'Products come from the UK, no customs duty for X-Ray materials apply', 1, '2014-03-04 21:41:03', '2014-03-04 21:41:03'),
(195, 27, 'Further customs charges and GST may apply', 1, '2014-03-04 21:41:03', '2014-03-04 21:41:03'),
(196, 27, 'Price includes delivery', 1, '2014-03-04 21:41:03', '2014-03-04 21:41:03');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `productId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `categoryId` int(10) unsigned DEFAULT NULL,
  `price` decimal(8,2) NOT NULL,
  `name` text,
  `sequence` int(10) unsigned DEFAULT '1',
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `created` datetime NOT NULL,
  `lastUpdated` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`productId`),
  KEY `FK_products_categories` (`categoryId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=28 ;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`productId`, `categoryId`, `price`, `name`, `sequence`, `status`, `created`, `lastUpdated`) VALUES
(3, 1, '299.00', 'Maxx 10', 1, 1, '2014-03-02 00:47:43', '2014-03-02 02:26:57'),
(4, 1, '289.00', 'Front & Side', 3, 1, '2014-03-02 01:13:06', '2014-03-02 02:26:57'),
(5, 1, '329.00', 'Aviator', 2, 1, '2014-03-02 01:27:31', '2014-03-02 02:26:57'),
(6, 1, '329.00', 'Maxx 30', 4, 1, '2014-03-02 01:34:42', '2014-03-02 02:26:57'),
(7, 1, '329.00', 'Illusion', 5, 1, '2014-03-02 01:46:30', '2014-03-02 02:26:57'),
(8, 1, '299.00', 'Fit Over', 6, 1, '2014-03-02 01:54:56', '2014-03-02 02:26:57'),
(9, 2, '0.00', 'Gonad Shield ', 0, 1, '2014-03-02 21:37:17', '2014-03-03 00:45:37'),
(11, 3, '59.00', 'Hand Protection', 7, 1, '2014-03-03 00:46:41', '2014-03-03 07:37:48'),
(12, 4, '0.00', 'Head Shield', 0, 1, '2014-03-03 00:53:19', '2014-03-03 06:09:08'),
(13, NULL, '0.00', NULL, NULL, 2, '2014-03-03 06:09:35', '0000-00-00 00:00:00'),
(16, NULL, '0.00', NULL, NULL, 2, '2014-03-03 07:52:27', '0000-00-00 00:00:00'),
(17, 5, '119.00', 'Harmony', NULL, 1, '2014-03-04 01:33:10', '2014-03-04 01:43:13'),
(18, 5, '129.00', 'Classic', 1, 1, '2014-03-04 01:46:27', '2014-03-04 01:49:42'),
(19, 4, '0.00', 'Patient Shield', 1, 1, '2014-03-04 20:47:27', '2014-03-04 20:49:19'),
(20, 5, '119.00', 'Elegant', 2, 1, '2014-03-04 20:53:21', '2014-03-04 20:56:06'),
(21, 5, '109.00', 'Slimline', 3, 1, '2014-03-04 21:00:36', '2014-03-04 21:02:36'),
(22, 6, '429.00', 'Optima - Partial Overlap', 1, 1, '2014-03-04 21:05:36', '2014-03-04 21:09:18'),
(23, 6, '429.00', 'Maxima â€“ Complete frontal overlap', 2, 1, '2014-03-04 21:10:55', '2014-03-04 21:15:44'),
(24, 6, '429.00', 'Maxima â€“ Complete frontal overlap', 3, 1, '2014-03-04 21:16:49', '2014-03-04 21:20:33'),
(25, 6, '429.00', 'Optima â€“ Partial Overlap', 4, 1, '2014-03-04 21:22:45', '2014-03-04 21:25:14'),
(26, 6, '339.00', 'Coat Apron', 5, 1, '2014-03-04 21:31:18', '2014-03-04 21:34:31'),
(27, 6, '339.00', 'Surgical Apron', 6, 1, '2014-03-04 21:36:26', '2014-03-04 21:41:03');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `productdetailitems`
--
ALTER TABLE `productdetailitems`
  ADD CONSTRAINT `productdetailitems_ibfk_1` FOREIGN KEY (`productId`) REFERENCES `products` (`productId`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`categoryId`) REFERENCES `categories` (`categoryId`) ON DELETE SET NULL;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
