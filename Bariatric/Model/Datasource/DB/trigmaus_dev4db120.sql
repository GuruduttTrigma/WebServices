-- phpMyAdmin SQL Dump
-- version 4.0.10
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 10, 2016 at 11:29 PM
-- Server version: 5.5.48-cll
-- PHP Version: 5.5.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `trigmaus_dev4db120`
--

-- --------------------------------------------------------

--
-- Table structure for table `abouts`
--

CREATE TABLE IF NOT EXISTS `abouts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(250) NOT NULL,
  `description` text NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `abouts`
--

INSERT INTO `abouts` (`id`, `title`, `description`, `date`) VALUES
(1, 'About Us', 'Terminology\r\n\r\nThe term bariatrics was coined around 1965,[1] from the Greek root bar- ("weight" as in barometer), suffix -iatr ("treatment," as in pediatrics), and suffix -ic ("pertaining to"). The field encompasses dieting, exercise and behavioral therapy approaches to weight loss, as well as pharmacotherapy and surgery. The term is also used in the medical field as somewhat of a euphemism to refer to people of larger sizes without regard to their participation in any treatment specific to weight loss, such as medical supply catalogs featuring larger hospital gowns and hospital beds referred to as "bariatric."\r\nBariatric patients\r\n', '2015-09-18');

-- --------------------------------------------------------

--
-- Table structure for table `access_tokens`
--

CREATE TABLE IF NOT EXISTS `access_tokens` (
  `oauth_token` varchar(40) NOT NULL,
  `client_id` char(36) NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `expires` int(11) NOT NULL,
  `scope` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`oauth_token`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `auth_codes`
--

CREATE TABLE IF NOT EXISTS `auth_codes` (
  `code` varchar(40) NOT NULL,
  `client_id` char(36) NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `redirect_uri` varchar(200) NOT NULL,
  `expires` int(11) NOT NULL,
  `scope` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`code`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `faqs`
--

CREATE TABLE IF NOT EXISTS `faqs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(250) NOT NULL,
  `description` text NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `faqs`
--

INSERT INTO `faqs` (`id`, `title`, `description`, `date`) VALUES
(1, 'Send Ur feedback1', 'Send Ur feedback1', '2015-09-17'),
(3, 'Send Ur feedback', 'Send Ur feedbackSend Ur feedbackSend Ur feedbackSend Ur feedback', '2015-09-17');

-- --------------------------------------------------------

--
-- Table structure for table `followers`
--

CREATE TABLE IF NOT EXISTS `followers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `follower_id` int(11) NOT NULL,
  `date` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=102 ;

-- --------------------------------------------------------

--
-- Table structure for table `food_breakfasts`
--

CREATE TABLE IF NOT EXISTS `food_breakfasts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `goal_food_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `food_breakfasts`
--

INSERT INTO `food_breakfasts` (`id`, `goal_food_id`, `name`, `image`) VALUES
(1, 1, 'Breakfast1', 'lean_protein.png'),
(2, 1, 'Breakfast2', 'vegetables.png'),
(3, 1, 'Breakfast3', 'salad.png'),
(4, 1, 'Breakfast4', 'protein_shake.png');

-- --------------------------------------------------------

--
-- Table structure for table `food_dinners`
--

CREATE TABLE IF NOT EXISTS `food_dinners` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `goal_food_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `food_dinners`
--

INSERT INTO `food_dinners` (`id`, `goal_food_id`, `name`, `image`) VALUES
(1, 3, 'Dinner1', 'lean_protein.png'),
(2, 3, 'Dinner2', 'vegetables.png'),
(3, 3, 'Dinner3', 'salad.png'),
(4, 3, 'Dinner4', 'protein_shake.png');

-- --------------------------------------------------------

--
-- Table structure for table `food_lunches`
--

CREATE TABLE IF NOT EXISTS `food_lunches` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `goal_food_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `food_lunches`
--

INSERT INTO `food_lunches` (`id`, `goal_food_id`, `name`, `image`) VALUES
(1, 2, 'Lean Protein', 'lean_protein.png'),
(2, 2, 'Vegetables', 'vegetables.png'),
(3, 2, 'Salad', 'salad.png'),
(4, 2, 'Protein Shake', 'protein_shake.png');

-- --------------------------------------------------------

--
-- Table structure for table `food_my_recipes`
--

CREATE TABLE IF NOT EXISTS `food_my_recipes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `goal_food_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `food_my_recipes`
--

INSERT INTO `food_my_recipes` (`id`, `goal_food_id`, `name`, `image`) VALUES
(1, 6, 'my_recipe1', 'lean_protein.png'),
(2, 6, 'my_recipe2', 'vegetables.png'),
(3, 6, 'my_recipe3', 'salad.png'),
(4, 6, 'my_recipe4', 'protein_shake.png');

-- --------------------------------------------------------

--
-- Table structure for table `food_snacks`
--

CREATE TABLE IF NOT EXISTS `food_snacks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `goal_food_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `food_snacks`
--

INSERT INTO `food_snacks` (`id`, `goal_food_id`, `name`, `image`) VALUES
(1, 4, 'Snack1', 'lean_protein.png'),
(2, 4, 'Snack2', 'vegetables.png'),
(3, 4, 'Snack4', 'salad.png'),
(4, 4, 'Snack4', 'protein_shake.png');

-- --------------------------------------------------------

--
-- Table structure for table `food_waters`
--

CREATE TABLE IF NOT EXISTS `food_waters` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `goal_food_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `food_waters`
--

INSERT INTO `food_waters` (`id`, `goal_food_id`, `name`, `image`) VALUES
(1, 5, 'Water', 'lean_protein.png'),
(2, 5, 'Coffee/Tea', 'vegetables.png'),
(3, 5, 'Other', 'salad.png');

-- --------------------------------------------------------

--
-- Table structure for table `goals`
--

CREATE TABLE IF NOT EXISTS `goals` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `goals`
--

INSERT INTO `goals` (`id`, `name`, `date`) VALUES
(1, 'Weight', '2015-09-18 00:00:00'),
(2, 'Sleep', '2015-09-18 00:00:00'),
(3, 'Food', '2015-09-18 00:00:00'),
(4, 'Supplements', '2015-09-18 00:00:00'),
(5, 'Activity', '2015-09-18 00:00:00'),
(6, 'MyProfress', '2015-09-18 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `goals_weights`
--

CREATE TABLE IF NOT EXISTS `goals_weights` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `current_weight` int(11) NOT NULL,
  `goal_weight` int(11) NOT NULL,
  `height` int(11) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=40 ;

--
-- Dumping data for table `goals_weights`
--

INSERT INTO `goals_weights` (`id`, `user_id`, `current_weight`, `goal_weight`, `height`, `date`) VALUES
(1, 4, 22, 20, 5, '2015-09-17'),
(4, 29, 56, 400, 0, '0000-00-00'),
(5, 29, 562, 4002, 0, '2015-12-15'),
(6, 29, 564, 4002, 0, '2015-12-15'),
(7, 29, 560, 4002, 0, '2015-12-15'),
(8, 29, 56, 400, 0, '2015-12-16'),
(9, 34, 25, 56, 0, '2015-12-16'),
(10, 34, 125, 56, 0, '2015-12-16'),
(11, 34, 252, 56, 0, '2015-12-16'),
(12, 34, 252, 56, 0, '2015-12-23'),
(13, 34, 25, 56, 0, '2015-12-28'),
(14, 34, 256, 56, 0, '2015-12-28'),
(15, 34, 300, 56, 0, '2015-12-28'),
(16, 34, 350, 56, 0, '2015-12-28'),
(17, 29, 111, 56, 0, '2015-12-28'),
(18, 29, 56, 400, 0, '2015-12-28'),
(19, 34, 250, 56, 0, '2015-12-28'),
(20, 34, 500, 56, 0, '2015-12-28'),
(21, 34, 250, 56, 0, '2015-12-28'),
(22, 34, 520, 56, 0, '2015-12-28'),
(23, 34, 400, 56, 0, '2015-12-28'),
(24, 34, 400, 58, 0, '2015-12-28'),
(25, 34, 400, 58, 0, '2015-12-28'),
(26, 34, 520, 58, 0, '2015-12-28'),
(27, 34, 500, 58, 0, '2015-12-28'),
(28, 34, 520, 58, 0, '2015-12-28'),
(29, 34, 555, 58, 0, '2015-12-29'),
(30, 34, 600, 58, 0, '2016-01-16'),
(31, 34, 500, 58, 0, '2016-01-16'),
(35, 61, 200, 0, 0, '2016-01-20'),
(33, 34, 800, 58, 0, '2016-01-19'),
(34, 34, 700, 58, 0, '2016-01-19'),
(36, 57, 258, 125, 0, '2016-01-25'),
(37, 62, 250, 0, 0, '2016-01-26'),
(38, 61, 129, 126, 0, '2016-01-30'),
(39, 76, 65, 0, 0, '2016-01-31');

-- --------------------------------------------------------

--
-- Table structure for table `goal_activities`
--

CREATE TABLE IF NOT EXISTS `goal_activities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  `image` varchar(255) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `goal_activities`
--

INSERT INTO `goal_activities` (`id`, `name`, `image`, `date`) VALUES
(1, 'Walk', 'walk1.png', '2015-09-18'),
(2, 'Running', 'running1.png', '2015-09-18'),
(3, 'Weight', 'weight1.png', '2015-09-18'),
(4, 'Swimming', 'swimming1.png', '2015-09-18'),
(5, 'Yoga', 'yoga1.png', '2015-09-18'),
(6, 'Other', 'other1.png', '2015-09-18');

-- --------------------------------------------------------

--
-- Table structure for table `goal_activity_users`
--

CREATE TABLE IF NOT EXISTS `goal_activity_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `goal_activity_id` int(11) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=127 ;

--
-- Dumping data for table `goal_activity_users`
--

INSERT INTO `goal_activity_users` (`id`, `user_id`, `goal_activity_id`, `date`) VALUES
(50, 57, 4, '2016-01-20'),
(49, 57, 2, '2016-01-20'),
(48, 57, 1, '2016-01-20'),
(82, 57, 3, '2016-01-25'),
(80, 57, 2, '2016-01-25'),
(85, 57, 1, '2016-01-25'),
(83, 57, 5, '2016-01-25'),
(51, 57, 3, '2016-01-20'),
(78, 29, 1, '2016-01-21'),
(81, 57, 4, '2016-01-25'),
(84, 57, 6, '2016-01-25'),
(102, 57, 2, '2016-01-27'),
(96, 57, 2, '2016-01-26'),
(101, 57, 1, '2016-01-27'),
(95, 57, 4, '2016-01-26'),
(103, 57, 4, '2016-01-27'),
(104, 57, 3, '2016-01-27'),
(109, 58, 2, '2016-01-28'),
(110, 58, 3, '2016-01-28'),
(111, 58, 6, '2016-01-28'),
(112, 58, 5, '2016-01-28'),
(113, 58, 4, '2016-01-29'),
(114, 58, 1, '2016-01-29'),
(123, 58, 4, '2016-01-30'),
(124, 58, 2, '2016-01-30'),
(125, 58, 3, '2016-01-30'),
(126, 58, 1, '2016-01-30');

-- --------------------------------------------------------

--
-- Table structure for table `goal_foods`
--

CREATE TABLE IF NOT EXISTS `goal_foods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `food_name` varchar(250) NOT NULL,
  `image` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `goal_foods`
--

INSERT INTO `goal_foods` (`id`, `food_name`, `image`) VALUES
(1, 'Breakfast', 'breakfast.png'),
(2, 'Lunch', 'lunch.png'),
(3, 'Dinner', 'dinner.png'),
(4, 'Snack', 'snaks.png'),
(5, 'Water', 'water.png'),
(6, 'My Recipes', 'my-recepies.png');

-- --------------------------------------------------------

--
-- Table structure for table `goal_food_users`
--

CREATE TABLE IF NOT EXISTS `goal_food_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `goal_food_id` varchar(250) NOT NULL,
  `phase_id` int(11) NOT NULL,
  `food` varchar(255) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=99 ;

--
-- Dumping data for table `goal_food_users`
--

INSERT INTO `goal_food_users` (`id`, `user_id`, `goal_food_id`, `phase_id`, `food`, `date`) VALUES
(98, 61, '1', 3, '1', '2016-01-30'),
(97, 58, '1', 3, '4', '2016-01-28'),
(95, 57, '1', 3, '1,4', '2016-01-27'),
(91, 57, '4', 3, '4', '2016-01-26'),
(82, 57, '1', 3, '2,3', '2016-01-25'),
(81, 57, '6', 3, '1,4', '2016-01-25'),
(65, 29, '1', 1, '4,5', '2016-01-21');

-- --------------------------------------------------------

--
-- Table structure for table `goal_protein_shakes`
--

CREATE TABLE IF NOT EXISTS `goal_protein_shakes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `supplement_name` varchar(250) NOT NULL,
  `image` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `goal_protein_shakes`
--

INSERT INTO `goal_protein_shakes` (`id`, `supplement_name`, `image`) VALUES
(1, 'Protein1', 'protein1.png'),
(2, 'Protein2', 'protein2.png'),
(3, 'Protein3', 'protein3.png');

-- --------------------------------------------------------

--
-- Table structure for table `goal_protein_shake_users`
--

CREATE TABLE IF NOT EXISTS `goal_protein_shake_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `goal_protein_shake_id` varchar(250) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=132 ;

--
-- Dumping data for table `goal_protein_shake_users`
--

INSERT INTO `goal_protein_shake_users` (`id`, `user_id`, `goal_protein_shake_id`, `date`) VALUES
(33, 61, '1', '2016-01-20'),
(32, 59, '2', '2016-01-20'),
(31, 59, '1', '2016-01-20'),
(30, 57, '3', '2016-01-20'),
(29, 57, '2', '2016-01-20'),
(28, 57, '1', '2016-01-20'),
(27, 57, '1', '2016-01-20'),
(26, 57, '1', '2016-01-20'),
(25, 57, '1', '2016-01-20'),
(24, 57, '1', '2016-01-20'),
(23, 34, '3', '2016-01-16'),
(22, 34, '2', '2016-01-16'),
(21, 29, '3', '2016-01-16'),
(20, 29, '1', '2016-01-16'),
(34, 61, '2', '2016-01-20'),
(41, 29, '2', '2016-01-21'),
(40, 29, '1', '2016-01-21'),
(42, 29, '4', '2016-01-21'),
(122, 57, '2', '2016-01-25'),
(124, 57, '2', '2016-01-26'),
(127, 57, '3', '2016-01-27'),
(128, 61, '1', '2016-01-29'),
(131, 75, '1', '2016-02-01'),
(112, 34, '2', '2016-01-25');

-- --------------------------------------------------------

--
-- Table structure for table `goal_sleeps`
--

CREATE TABLE IF NOT EXISTS `goal_sleeps` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `sleep_time` varchar(250) NOT NULL,
  `wake_time` varchar(250) NOT NULL,
  `total_sleep` int(11) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `goal_sleeps`
--

INSERT INTO `goal_sleeps` (`id`, `user_id`, `sleep_time`, `wake_time`, `total_sleep`, `date`) VALUES
(2, 29, '2015-12-17 10:42:00 PM', '2015-12-18 12:42:00 AM', 2, '2016-01-19 00:00:00'),
(3, 34, '2016-01-19 15:46:08', '2016-01-19 23:46:00', 8, '2016-01-19 00:00:00'),
(4, 57, '2016-01-20 08:21:47', '2016-01-20 09:21:47', 1, '2016-01-20 00:00:00'),
(5, 61, '2016-01-30 00:02:56', '2016-01-30 07:02:56', 7, '2016-01-30 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `goal_supplements`
--

CREATE TABLE IF NOT EXISTS `goal_supplements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `supplement_name` varchar(250) NOT NULL,
  `image` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `goal_supplements`
--

INSERT INTO `goal_supplements` (`id`, `supplement_name`, `image`) VALUES
(1, 'Multi Vitamin', 'multi_vitamin.png'),
(2, 'B12', 'b12.png'),
(3, 'ProBiotic', 'probiotic.png'),
(4, 'Berberine', 'berberine.png'),
(5, 'Other', 'other.png');

-- --------------------------------------------------------

--
-- Table structure for table `goal_supplement_users`
--

CREATE TABLE IF NOT EXISTS `goal_supplement_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `goal_supplement_id` varchar(250) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=85 ;

--
-- Dumping data for table `goal_supplement_users`
--

INSERT INTO `goal_supplement_users` (`id`, `user_id`, `goal_supplement_id`, `date`) VALUES
(57, 29, '2', '2016-01-21'),
(58, 29, '3', '2016-01-21'),
(33, 59, '5', '2016-01-20'),
(32, 59, '4', '2016-01-20'),
(31, 59, '3', '2016-01-20'),
(30, 59, '2', '2016-01-20'),
(29, 59, '1', '2016-01-20'),
(18, 4, '5', '2015-12-22'),
(17, 4, '4', '2015-12-22'),
(16, 4, '1', '2015-12-22'),
(83, 75, '1', '2016-02-01'),
(72, 57, '3', '2016-01-25'),
(77, 57, '4', '2016-01-26'),
(76, 57, '1', '2016-01-26'),
(82, 57, '3', '2016-01-27'),
(81, 57, '1', '2016-01-27'),
(84, 75, '3', '2016-02-01');

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_name` varchar(255) NOT NULL,
  `role` text NOT NULL,
  `description` varchar(255) NOT NULL,
  `group_image` varchar(255) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `group_name`, `role`, `description`, `group_image`, `date`) VALUES
(3, 'GuruDutt TEam', 'Social', 'We can solve any problem.', '9speechlecture1016.jpg', '2015-09-17'),
(2, 'My Friend', 'Technology', 'My Friend', 'Falling-asleep-forest.jpg', '2015-09-16'),
(4, 'Php Developer', 'Guru', 'We have specialize in all web development.?? ', 'abcdef.jpg', '2015-09-17');

-- --------------------------------------------------------

--
-- Table structure for table `group_users`
--

CREATE TABLE IF NOT EXISTS `group_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `status` varchar(250) NOT NULL DEFAULT '' COMMENT '"1"=>''joined'',"0"=>''Not Joined''',
  `date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=118 ;

--
-- Dumping data for table `group_users`
--

INSERT INTO `group_users` (`id`, `user_id`, `group_id`, `status`, `date`) VALUES
(107, 34, 2, '1', '2015-12-16'),
(46, 41, 2, '1', '2015-12-09'),
(8, 41, 3, '1', '2015-12-04'),
(11, 27, 3, '', '0000-00-00'),
(108, 34, 4, '1', '2016-01-14'),
(109, 34, 3, '1', '2016-01-14'),
(110, 58, 3, '1', '2016-01-19'),
(111, 57, 3, '1', '2016-01-20'),
(112, 63, 3, '1', '2016-01-28'),
(117, 58, 4, '1', '2016-01-30');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE IF NOT EXISTS `notifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `name`) VALUES
(1, 'daily_reminders'),
(2, 'water_reminders_five_minutes'),
(3, 'water_reminders_thirty_minutes'),
(4, 'water_reminders_every_hours'),
(5, 'protein_reminders_weight_loss'),
(6, 'protein_reminders_back_on_track'),
(7, 'protein_reminders_maintenance'),
(8, 'vetamin_medication_reminder'),
(9, 'morning_weight_reminder'),
(10, 'sleep_reminder');

-- --------------------------------------------------------

--
-- Table structure for table `notification_types`
--

CREATE TABLE IF NOT EXISTS `notification_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `notification_types`
--

INSERT INTO `notification_types` (`id`, `name`) VALUES
(1, 'Like'),
(2, 'Comment'),
(3, 'Follow'),
(4, 'Chat');

-- --------------------------------------------------------

--
-- Table structure for table `notification_type_users`
--

CREATE TABLE IF NOT EXISTS `notification_type_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `notification_type_id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_chat_id` int(11) NOT NULL,
  `date` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=315 ;

--
-- Dumping data for table `notification_type_users`
--

INSERT INTO `notification_type_users` (`id`, `notification_type_id`, `sender_id`, `receiver_id`, `post_id`, `user_chat_id`, `date`) VALUES
(1, 1, 77, 61, 118, 0, '2016-02-01'),
(4, 3, 77, 75, 0, 0, '2016-02-01'),
(3, 2, 77, 75, 134, 0, '2016-02-01'),
(5, 1, 78, 77, 135, 0, '2016-02-01'),
(6, 2, 78, 77, 135, 0, '2016-02-01'),
(7, 3, 78, 77, 0, 0, '2016-02-01'),
(8, 4, 27, 34, 0, 45, '2016-02-01'),
(9, 1, 78, 78, 140, 0, '2016-02-01'),
(10, 4, 78, 77, 0, 46, '2016-02-02'),
(11, 4, 78, 77, 0, 47, '2016-02-02'),
(12, 4, 78, 77, 0, 48, '2016-02-02'),
(13, 4, 78, 77, 0, 49, '2016-02-02'),
(14, 4, 78, 77, 0, 50, '2016-02-02'),
(15, 1, 79, 78, 140, 0, '2016-02-02'),
(16, 1, 79, 80, 142, 0, '2016-02-02'),
(17, 1, 79, 80, 142, 0, '2016-02-02'),
(18, 2, 79, 80, 142, 0, '2016-02-02'),
(19, 2, 79, 80, 142, 0, '2016-02-02'),
(20, 3, 79, 80, 0, 0, '2016-02-02'),
(21, 3, 80, 79, 0, 0, '2016-02-02'),
(22, 3, 80, 79, 0, 0, '2016-02-02'),
(23, 4, 79, 80, 0, 51, '2016-02-02'),
(24, 4, 80, 79, 0, 52, '2016-02-02'),
(25, 4, 80, 79, 0, 53, '2016-02-02'),
(26, 4, 80, 79, 0, 54, '2016-02-02'),
(27, 4, 80, 79, 0, 55, '2016-02-02'),
(28, 4, 80, 79, 0, 56, '2016-02-02'),
(29, 4, 80, 79, 0, 57, '2016-02-02'),
(30, 4, 80, 79, 0, 58, '2016-02-02'),
(31, 4, 80, 79, 0, 59, '2016-02-02'),
(32, 4, 80, 79, 0, 60, '2016-02-02'),
(33, 4, 80, 79, 0, 61, '2016-02-02'),
(34, 4, 80, 79, 0, 62, '2016-02-02'),
(35, 4, 80, 79, 0, 63, '2016-02-02'),
(36, 4, 80, 79, 0, 64, '2016-02-02'),
(37, 4, 80, 79, 0, 65, '2016-02-02'),
(38, 4, 80, 79, 0, 66, '2016-02-02'),
(39, 4, 80, 79, 0, 67, '2016-02-02'),
(40, 4, 80, 79, 0, 68, '2016-02-02'),
(41, 4, 80, 79, 0, 69, '2016-02-02'),
(42, 4, 80, 79, 0, 70, '2016-02-02'),
(43, 4, 80, 79, 0, 71, '2016-02-02'),
(44, 4, 80, 79, 0, 72, '2016-02-02'),
(45, 4, 80, 79, 0, 73, '2016-02-02'),
(46, 4, 80, 79, 0, 74, '2016-02-02'),
(47, 4, 80, 79, 0, 75, '2016-02-02'),
(48, 4, 80, 79, 0, 76, '2016-02-02'),
(49, 4, 80, 79, 0, 77, '2016-02-02'),
(50, 4, 80, 79, 0, 78, '2016-02-02'),
(51, 4, 80, 79, 0, 79, '2016-02-02'),
(52, 4, 80, 79, 0, 80, '2016-02-02'),
(53, 4, 80, 79, 0, 81, '2016-02-02'),
(54, 4, 80, 79, 0, 82, '2016-02-02'),
(55, 4, 80, 79, 0, 83, '2016-02-02'),
(56, 4, 80, 79, 0, 84, '2016-02-02'),
(57, 4, 80, 79, 0, 85, '2016-02-02'),
(58, 4, 80, 79, 0, 86, '2016-02-02'),
(59, 4, 80, 79, 0, 87, '2016-02-02'),
(60, 4, 80, 79, 0, 88, '2016-02-02'),
(61, 4, 80, 79, 0, 89, '2016-02-02'),
(62, 4, 80, 79, 0, 90, '2016-02-02'),
(63, 4, 80, 79, 0, 91, '2016-02-02'),
(64, 4, 80, 79, 0, 92, '2016-02-02'),
(65, 4, 80, 79, 0, 93, '2016-02-02'),
(66, 4, 80, 79, 0, 94, '2016-02-02'),
(67, 4, 80, 79, 0, 95, '2016-02-02'),
(68, 4, 80, 79, 0, 96, '2016-02-02'),
(69, 4, 79, 80, 0, 97, '2016-02-02'),
(70, 4, 79, 80, 0, 98, '2016-02-02'),
(71, 4, 79, 80, 0, 99, '2016-02-02'),
(72, 4, 79, 80, 0, 100, '2016-02-02'),
(73, 4, 79, 80, 0, 101, '2016-02-02'),
(74, 4, 79, 80, 0, 102, '2016-02-02'),
(75, 1, 63, 58, 126, 0, '2016-02-02'),
(76, 3, 81, 82, 0, 0, '2016-02-02'),
(77, 1, 83, 82, 143, 0, '2016-02-02'),
(78, 1, 84, 85, 144, 0, '2016-02-02'),
(79, 1, 84, 85, 144, 0, '2016-02-02'),
(80, 1, 84, 85, 144, 0, '2016-02-02'),
(81, 1, 84, 85, 144, 0, '2016-02-02'),
(82, 1, 84, 85, 144, 0, '2016-02-02'),
(83, 1, 84, 85, 144, 0, '2016-02-02'),
(84, 2, 84, 85, 144, 0, '2016-02-02'),
(85, 3, 85, 84, 0, 0, '2016-02-02'),
(86, 3, 85, 84, 0, 0, '2016-02-02'),
(87, 3, 84, 85, 0, 0, '2016-02-02'),
(88, 4, 84, 85, 0, 103, '2016-02-02'),
(89, 4, 84, 85, 0, 104, '2016-02-02'),
(90, 4, 84, 85, 0, 105, '2016-02-02'),
(91, 4, 84, 85, 0, 106, '2016-02-02'),
(92, 4, 84, 85, 0, 107, '2016-02-02'),
(93, 4, 84, 85, 0, 108, '2016-02-02'),
(94, 4, 85, 84, 0, 109, '2016-02-02'),
(95, 4, 84, 85, 0, 110, '2016-02-02'),
(96, 4, 84, 85, 0, 111, '2016-02-02'),
(97, 4, 85, 84, 0, 112, '2016-02-02'),
(98, 4, 84, 85, 0, 113, '2016-02-02'),
(99, 4, 85, 84, 0, 114, '2016-02-02'),
(100, 4, 84, 85, 0, 115, '2016-02-02'),
(101, 4, 84, 85, 0, 116, '2016-02-02'),
(102, 4, 84, 85, 0, 117, '2016-02-02'),
(103, 4, 84, 85, 0, 118, '2016-02-02'),
(104, 4, 85, 84, 0, 119, '2016-02-02'),
(105, 4, 85, 84, 0, 120, '2016-02-02'),
(106, 4, 85, 84, 0, 121, '2016-02-02'),
(107, 4, 85, 84, 0, 122, '2016-02-02'),
(108, 4, 85, 84, 0, 123, '2016-02-02'),
(109, 4, 85, 84, 0, 124, '2016-02-02'),
(110, 4, 85, 84, 0, 125, '2016-02-02'),
(111, 4, 85, 84, 0, 126, '2016-02-02'),
(112, 4, 85, 84, 0, 127, '2016-02-02'),
(113, 4, 85, 84, 0, 128, '2016-02-02'),
(114, 4, 85, 84, 0, 129, '2016-02-02'),
(115, 4, 85, 84, 0, 130, '2016-02-02'),
(116, 4, 85, 84, 0, 131, '2016-02-02'),
(117, 4, 85, 84, 0, 132, '2016-02-02'),
(118, 4, 85, 84, 0, 133, '2016-02-02'),
(119, 4, 85, 84, 0, 134, '2016-02-02'),
(120, 4, 85, 84, 0, 135, '2016-02-02'),
(121, 4, 85, 84, 0, 136, '2016-02-02'),
(122, 4, 85, 84, 0, 137, '2016-02-02'),
(123, 4, 85, 84, 0, 138, '2016-02-02'),
(124, 4, 85, 84, 0, 139, '2016-02-02'),
(125, 4, 85, 84, 0, 140, '2016-02-02'),
(126, 4, 85, 84, 0, 141, '2016-02-02'),
(127, 4, 85, 84, 0, 142, '2016-02-02'),
(128, 4, 85, 84, 0, 143, '2016-02-02'),
(129, 4, 85, 84, 0, 144, '2016-02-02'),
(130, 1, 85, 84, 145, 0, '2016-02-02'),
(131, 1, 85, 84, 145, 0, '2016-02-02'),
(132, 1, 85, 84, 145, 0, '2016-02-02'),
(133, 1, 85, 84, 145, 0, '2016-02-02'),
(134, 2, 85, 84, 145, 0, '2016-02-02'),
(135, 2, 85, 84, 145, 0, '2016-02-02'),
(136, 2, 85, 84, 145, 0, '2016-02-02'),
(137, 2, 85, 84, 145, 0, '2016-02-02'),
(138, 2, 85, 84, 145, 0, '2016-02-02'),
(139, 1, 84, 80, 146, 0, '2016-02-02'),
(140, 1, 84, 80, 146, 0, '2016-02-02'),
(141, 2, 84, 80, 146, 0, '2016-02-02'),
(142, 2, 84, 80, 146, 0, '2016-02-02'),
(143, 2, 84, 80, 146, 0, '2016-02-02'),
(144, 2, 84, 80, 146, 0, '2016-02-02'),
(145, 4, 84, 85, 0, 145, '2016-02-02'),
(146, 4, 84, 85, 0, 146, '2016-02-02'),
(147, 4, 84, 85, 0, 147, '2016-02-02'),
(148, 4, 84, 85, 0, 148, '2016-02-02'),
(149, 4, 84, 85, 0, 149, '2016-02-02'),
(150, 4, 84, 85, 0, 150, '2016-02-02'),
(151, 4, 84, 85, 0, 151, '2016-02-02'),
(152, 4, 84, 85, 0, 152, '2016-02-02'),
(153, 4, 84, 85, 0, 153, '2016-02-02'),
(154, 4, 84, 85, 0, 154, '2016-02-02'),
(155, 4, 84, 85, 0, 155, '2016-02-02'),
(156, 4, 84, 85, 0, 156, '2016-02-02'),
(157, 4, 84, 85, 0, 157, '2016-02-02'),
(158, 4, 84, 85, 0, 158, '2016-02-02'),
(159, 4, 84, 85, 0, 159, '2016-02-02'),
(160, 4, 84, 85, 0, 160, '2016-02-02'),
(161, 1, 84, 80, 146, 0, '2016-02-02'),
(162, 1, 84, 84, 145, 0, '2016-02-02'),
(163, 1, 84, 85, 144, 0, '2016-02-02'),
(164, 1, 84, 85, 144, 0, '2016-02-02'),
(165, 1, 84, 85, 144, 0, '2016-02-02'),
(166, 2, 84, 85, 144, 0, '2016-02-02'),
(167, 2, 84, 85, 144, 0, '2016-02-02'),
(168, 2, 84, 85, 144, 0, '2016-02-02'),
(169, 2, 84, 85, 144, 0, '2016-02-02'),
(170, 2, 84, 85, 144, 0, '2016-02-02'),
(171, 2, 84, 85, 144, 0, '2016-02-02'),
(172, 2, 84, 85, 144, 0, '2016-02-02'),
(173, 2, 84, 85, 144, 0, '2016-02-02'),
(174, 2, 84, 85, 144, 0, '2016-02-02'),
(175, 2, 84, 85, 144, 0, '2016-02-02'),
(176, 2, 84, 85, 144, 0, '2016-02-02'),
(177, 2, 84, 85, 144, 0, '2016-02-02'),
(178, 2, 84, 85, 144, 0, '2016-02-02'),
(179, 2, 84, 85, 144, 0, '2016-02-02'),
(180, 2, 84, 85, 144, 0, '2016-02-02'),
(181, 2, 84, 85, 144, 0, '2016-02-02'),
(182, 2, 84, 85, 144, 0, '2016-02-02'),
(183, 4, 84, 85, 0, 161, '2016-02-02'),
(184, 4, 84, 85, 0, 162, '2016-02-02'),
(185, 4, 84, 85, 0, 163, '2016-02-02'),
(186, 4, 84, 85, 0, 164, '2016-02-02'),
(187, 4, 84, 85, 0, 165, '2016-02-02'),
(188, 4, 84, 85, 0, 166, '2016-02-02'),
(189, 4, 84, 85, 0, 167, '2016-02-02'),
(190, 4, 84, 85, 0, 168, '2016-02-02'),
(191, 4, 84, 85, 0, 169, '2016-02-02'),
(192, 4, 84, 85, 0, 170, '2016-02-02'),
(193, 4, 84, 85, 0, 171, '2016-02-02'),
(194, 4, 84, 85, 0, 172, '2016-02-02'),
(195, 4, 84, 85, 0, 173, '2016-02-02'),
(196, 4, 84, 85, 0, 174, '2016-02-02'),
(197, 4, 84, 85, 0, 175, '2016-02-02'),
(198, 4, 84, 85, 0, 176, '2016-02-02'),
(199, 4, 84, 85, 0, 177, '2016-02-02'),
(200, 4, 84, 85, 0, 178, '2016-02-02'),
(201, 4, 84, 85, 0, 179, '2016-02-02'),
(202, 4, 84, 85, 0, 180, '2016-02-02'),
(203, 4, 84, 85, 0, 181, '2016-02-02'),
(204, 4, 84, 85, 0, 182, '2016-02-02'),
(205, 4, 84, 85, 0, 183, '2016-02-02'),
(206, 4, 84, 85, 0, 184, '2016-02-02'),
(207, 4, 84, 85, 0, 185, '2016-02-02'),
(208, 4, 84, 85, 0, 186, '2016-02-02'),
(209, 4, 84, 85, 0, 187, '2016-02-02'),
(210, 4, 84, 85, 0, 188, '2016-02-02'),
(211, 4, 84, 85, 0, 189, '2016-02-02'),
(212, 4, 84, 85, 0, 190, '2016-02-02'),
(213, 4, 84, 85, 0, 191, '2016-02-02'),
(214, 4, 84, 85, 0, 192, '2016-02-02'),
(215, 4, 84, 85, 0, 193, '2016-02-02'),
(216, 4, 84, 85, 0, 194, '2016-02-02'),
(217, 4, 84, 85, 0, 195, '2016-02-02'),
(218, 4, 84, 85, 0, 196, '2016-02-02'),
(219, 4, 84, 85, 0, 197, '2016-02-02'),
(220, 4, 84, 85, 0, 198, '2016-02-02'),
(221, 4, 84, 85, 0, 199, '2016-02-02'),
(222, 4, 84, 85, 0, 200, '2016-02-02'),
(223, 4, 84, 85, 0, 201, '2016-02-02'),
(224, 4, 84, 85, 0, 202, '2016-02-02'),
(225, 4, 84, 85, 0, 203, '2016-02-02'),
(226, 4, 84, 85, 0, 204, '2016-02-02'),
(227, 4, 84, 85, 0, 205, '2016-02-02'),
(228, 4, 84, 85, 0, 206, '2016-02-02'),
(229, 4, 84, 85, 0, 207, '2016-02-02'),
(230, 4, 84, 85, 0, 208, '2016-02-02'),
(231, 4, 84, 85, 0, 209, '2016-02-02'),
(232, 4, 84, 85, 0, 210, '2016-02-02'),
(233, 4, 84, 85, 0, 211, '2016-02-02'),
(234, 4, 84, 85, 0, 212, '2016-02-02'),
(235, 4, 84, 85, 0, 213, '2016-02-02'),
(236, 4, 85, 84, 0, 214, '2016-02-03'),
(237, 4, 84, 85, 0, 215, '2016-02-03'),
(238, 4, 84, 85, 0, 216, '2016-02-03'),
(239, 4, 84, 85, 0, 217, '2016-02-03'),
(240, 4, 84, 85, 0, 218, '2016-02-03'),
(241, 4, 84, 85, 0, 219, '2016-02-03'),
(242, 4, 84, 85, 0, 220, '2016-02-03'),
(243, 4, 84, 85, 0, 221, '2016-02-03'),
(244, 4, 85, 84, 0, 222, '2016-02-03'),
(245, 4, 84, 85, 0, 223, '2016-02-03'),
(246, 4, 84, 85, 0, 224, '2016-02-03'),
(247, 4, 84, 85, 0, 225, '2016-02-03'),
(248, 4, 84, 85, 0, 226, '2016-02-03'),
(249, 4, 84, 85, 0, 227, '2016-02-03'),
(250, 4, 84, 85, 0, 228, '2016-02-03'),
(251, 4, 84, 85, 0, 229, '2016-02-03'),
(252, 4, 84, 85, 0, 230, '2016-02-03'),
(253, 4, 84, 85, 0, 231, '2016-02-03'),
(254, 4, 84, 85, 0, 232, '2016-02-03'),
(255, 4, 84, 85, 0, 233, '2016-02-03'),
(256, 4, 84, 85, 0, 234, '2016-02-03'),
(257, 4, 84, 85, 0, 235, '2016-02-03'),
(258, 4, 84, 85, 0, 236, '2016-02-03'),
(259, 4, 84, 85, 0, 237, '2016-02-03'),
(260, 4, 84, 85, 0, 238, '2016-02-03'),
(261, 4, 84, 85, 0, 239, '2016-02-03'),
(262, 4, 84, 85, 0, 240, '2016-02-03'),
(263, 4, 84, 85, 0, 241, '2016-02-03'),
(264, 4, 84, 85, 0, 242, '2016-02-03'),
(265, 4, 84, 85, 0, 243, '2016-02-03'),
(266, 4, 84, 85, 0, 244, '2016-02-03'),
(267, 1, 84, 84, 145, 0, '2016-02-03'),
(268, 1, 84, 84, 145, 0, '2016-02-03'),
(269, 1, 84, 84, 145, 0, '2016-02-03'),
(270, 4, 84, 85, 0, 245, '2016-02-03'),
(271, 4, 84, 85, 0, 246, '2016-02-03'),
(272, 4, 84, 85, 0, 247, '2016-02-03'),
(273, 4, 84, 85, 0, 248, '2016-02-03'),
(274, 4, 84, 85, 0, 249, '2016-02-03'),
(275, 4, 84, 85, 0, 250, '2016-02-03'),
(276, 4, 84, 85, 0, 251, '2016-02-03'),
(277, 4, 84, 85, 0, 252, '2016-02-03'),
(278, 4, 85, 84, 0, 253, '2016-02-03'),
(279, 4, 85, 84, 0, 254, '2016-02-03'),
(280, 4, 85, 84, 0, 255, '2016-02-03'),
(281, 4, 85, 84, 0, 256, '2016-02-03'),
(282, 4, 85, 84, 0, 257, '2016-02-03'),
(283, 4, 85, 84, 0, 258, '2016-02-03'),
(284, 4, 85, 84, 0, 259, '2016-02-03'),
(285, 4, 85, 84, 0, 260, '2016-02-03'),
(286, 4, 85, 84, 0, 261, '2016-02-03'),
(287, 4, 85, 84, 0, 262, '2016-02-03'),
(288, 4, 84, 85, 0, 263, '2016-02-03'),
(289, 4, 84, 85, 0, 264, '2016-02-03'),
(290, 4, 84, 85, 0, 265, '2016-02-03'),
(291, 4, 84, 85, 0, 266, '2016-02-03'),
(292, 4, 84, 85, 0, 267, '2016-02-03'),
(293, 4, 84, 85, 0, 268, '2016-02-03'),
(294, 4, 84, 85, 0, 269, '2016-02-03'),
(295, 4, 84, 85, 0, 270, '2016-02-03'),
(296, 4, 84, 85, 0, 271, '2016-02-03'),
(297, 4, 84, 85, 0, 272, '2016-02-03'),
(298, 4, 84, 85, 0, 273, '2016-02-03'),
(299, 4, 84, 85, 0, 274, '2016-02-03'),
(300, 4, 84, 85, 0, 275, '2016-02-03'),
(301, 4, 84, 85, 0, 276, '2016-02-03'),
(302, 4, 84, 85, 0, 277, '2016-02-03'),
(303, 4, 84, 85, 0, 278, '2016-02-03'),
(304, 4, 84, 85, 0, 279, '2016-02-03'),
(305, 4, 84, 85, 0, 280, '2016-02-03'),
(306, 4, 84, 85, 0, 281, '2016-02-03'),
(307, 4, 84, 85, 0, 282, '2016-02-03'),
(308, 4, 84, 85, 0, 283, '2016-02-03'),
(309, 4, 84, 85, 0, 284, '2016-02-03'),
(310, 4, 84, 85, 0, 285, '2016-02-03'),
(311, 4, 84, 85, 0, 286, '2016-02-03'),
(312, 4, 84, 85, 0, 287, '2016-02-03'),
(313, 4, 84, 85, 0, 288, '2016-02-03'),
(314, 1, 27, 45, 50, 0, '2016-02-24');

-- --------------------------------------------------------

--
-- Table structure for table `notification_users`
--

CREATE TABLE IF NOT EXISTS `notification_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `notification_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=79 ;

--
-- Dumping data for table `notification_users`
--

INSERT INTO `notification_users` (`id`, `user_id`, `notification_id`) VALUES
(1, 27, 1),
(2, 27, 2),
(3, 28, 1),
(16, 29, 5),
(17, 34, 0),
(35, 63, 9),
(31, 63, 2),
(33, 63, 6),
(21, 34, 7),
(41, 66, 1),
(23, 34, 4),
(32, 63, 3),
(29, 34, 5),
(30, 34, 1),
(27, 34, 10),
(36, 63, 7),
(37, 63, 8),
(38, 63, 5),
(39, 63, 4),
(40, 63, 1),
(42, 66, 2),
(44, 66, 4),
(74, 77, 6),
(73, 77, 5),
(64, 58, 1),
(65, 58, 2),
(52, 66, 9),
(53, 66, 10),
(72, 77, 4),
(71, 77, 3),
(70, 77, 2),
(69, 77, 1),
(66, 58, 7),
(75, 77, 7),
(76, 77, 8),
(77, 77, 9),
(78, 77, 10);

-- --------------------------------------------------------

--
-- Table structure for table `phases`
--

CREATE TABLE IF NOT EXISTS `phases` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `phases`
--

INSERT INTO `phases` (`id`, `name`) VALUES
(1, 'Clear Phase'),
(2, 'Full Phase'),
(3, 'Solid Phase'),
(4, 'Soft Phase');

-- --------------------------------------------------------

--
-- Table structure for table `phase_types`
--

CREATE TABLE IF NOT EXISTS `phase_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `phase_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `phase_types`
--

INSERT INTO `phase_types` (`id`, `phase_id`, `name`) VALUES
(1, 1, 'Water'),
(2, 1, 'Herbal Tea'),
(3, 1, 'SF Jello'),
(4, 1, 'SF Popsicle'),
(5, 1, 'Broth'),
(6, 1, 'Reminders'),
(7, 2, 'All Clears'),
(8, 2, 'Milks'),
(9, 2, 'Liquide Yugurt'),
(10, 2, 'Runny Smoothie'),
(11, 2, 'Blended Soup'),
(12, 2, 'Reminders');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `post_type_id` int(11) NOT NULL,
  `date` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('Public','Private') CHARACTER SET utf16 COLLATE utf16_unicode_ci NOT NULL DEFAULT 'Public',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=147 ;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `user_id`, `post_type_id`, `date`, `status`) VALUES
(69, 34, 2, '2015-12-08', 'Private'),
(68, 34, 1, '2015-12-08', 'Public'),
(43, 47, 1, '2015-12-06', 'Public'),
(42, 46, 1, '2015-12-05', 'Public'),
(41, 41, 1, '2015-12-05', 'Public'),
(40, 41, 1, '2015-12-05', 'Public'),
(35, 41, 1, '2015-12-04', 'Public'),
(75, 34, 3, '2015-12-09', 'Public'),
(36, 41, 1, '2015-12-04', 'Public'),
(37, 41, 1, '2015-12-04', 'Public'),
(38, 43, 1, '2015-12-04', 'Public'),
(47, 34, 1, '2015-12-07', 'Public'),
(48, 34, 1, '2015-12-07', 'Public'),
(49, 34, 1, '2015-12-07', 'Public'),
(70, 34, 2, '2015-12-08', 'Public'),
(51, 34, 1, '2015-12-07', 'Public'),
(74, 34, 3, '2015-12-09', 'Public'),
(73, 34, 3, '2015-12-08', 'Public'),
(72, 34, 2, '2015-12-08', 'Private'),
(71, 34, 1, '2015-12-08', 'Public'),
(67, 34, 2, '2015-12-07', 'Public'),
(77, 34, 3, '2015-12-16', 'Public'),
(78, 34, 1, '2015-12-17', 'Public'),
(79, 56, 3, '2016-01-06', 'Public'),
(80, 56, 1, '2016-01-06', 'Public'),
(81, 56, 1, '2016-01-06', 'Public'),
(82, 57, 3, '2016-01-20', 'Public'),
(83, 57, 3, '2016-01-20', 'Public'),
(84, 57, 3, '2016-01-20', 'Public'),
(85, 57, 3, '2016-01-20', 'Public'),
(86, 57, 3, '2016-01-20', 'Public'),
(87, 57, 3, '2016-01-20', 'Public'),
(88, 57, 3, '2016-01-20', 'Public'),
(89, 57, 1, '2016-01-20', 'Public'),
(90, 57, 1, '2016-01-20', 'Public'),
(91, 57, 3, '2016-01-20', 'Public'),
(92, 57, 3, '2016-01-20', 'Public'),
(93, 61, 1, '2016-01-20', 'Public'),
(94, 61, 2, '2016-01-20', 'Public'),
(95, 61, 1, '2016-01-20', 'Public'),
(96, 61, 2, '2016-01-20', 'Public'),
(97, 60, 1, '2016-01-20', 'Public'),
(98, 60, 1, '2016-01-20', 'Public'),
(99, 60, 1, '2016-01-20', 'Public'),
(100, 60, 1, '2016-01-20', 'Public'),
(101, 60, 2, '2016-01-20', 'Public'),
(102, 60, 3, '2016-01-20', 'Public'),
(103, 60, 2, '2016-01-20', 'Public'),
(104, 57, 2, '2016-01-21', 'Public'),
(105, 57, 1, '2016-01-21', 'Public'),
(106, 57, 1, '2016-01-21', 'Public'),
(107, 57, 2, '2016-01-21', 'Public'),
(108, 61, 2, '2016-01-22', 'Public'),
(109, 61, 2, '2016-01-22', 'Public'),
(110, 57, 1, '2016-01-22', 'Private'),
(111, 57, 1, '2016-01-25', 'Public'),
(112, 57, 2, '2016-01-25', 'Public'),
(113, 57, 3, '2016-01-25', 'Public'),
(114, 57, 3, '2016-01-25', 'Public'),
(115, 57, 3, '2016-01-25', 'Public'),
(116, 61, 2, '2016-01-25', 'Public'),
(117, 62, 1, '2016-01-26', 'Public'),
(118, 61, 1, '2016-01-27', 'Public'),
(119, 66, 1, '2016-01-28', 'Public'),
(120, 58, 1, '2016-01-29', 'Public'),
(121, 58, 1, '2016-01-29', 'Public'),
(122, 58, 2, '2016-01-29', 'Public'),
(123, 68, 1, '2016-01-30', 'Public'),
(124, 61, 2, '2016-01-30', 'Public'),
(125, 69, 1, '2016-01-30', 'Public'),
(126, 58, 1, '2016-01-30', 'Public'),
(127, 71, 1, '2016-01-30', 'Public'),
(128, 70, 1, '2016-01-30', 'Public'),
(129, 70, 1, '2016-01-30', 'Public'),
(130, 72, 1, '2016-01-30', 'Public'),
(131, 70, 1, '2016-01-30', 'Public'),
(132, 73, 1, '2016-01-31', 'Public'),
(133, 76, 1, '2016-01-31', 'Public'),
(134, 75, 1, '2016-01-31', 'Public'),
(135, 77, 1, '2016-02-01', 'Public'),
(136, 78, 1, '2016-02-01', 'Public'),
(137, 78, 1, '2016-02-01', 'Public'),
(138, 78, 1, '2016-02-01', 'Public'),
(139, 78, 1, '2016-02-01', 'Public'),
(140, 78, 2, '2016-02-01', 'Public'),
(141, 79, 1, '2016-02-02', 'Public'),
(142, 80, 1, '2016-02-02', 'Public'),
(143, 82, 1, '2016-02-02', 'Public'),
(144, 85, 1, '2016-02-02', 'Public'),
(145, 84, 1, '2016-02-02', 'Public'),
(146, 80, 1, '2016-02-02', 'Public');

-- --------------------------------------------------------

--
-- Table structure for table `post_before_afters`
--

CREATE TABLE IF NOT EXISTS `post_before_afters` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `photo_before` varchar(255) CHARACTER SET utf32 COLLATE utf32_unicode_ci NOT NULL,
  `photo_after` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `wt_before` int(11) NOT NULL,
  `wt_after` int(11) NOT NULL,
  `description` varchar(255) CHARACTER SET utf32 COLLATE utf32_unicode_ci NOT NULL,
  `date` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=35 ;

--
-- Dumping data for table `post_before_afters`
--

INSERT INTO `post_before_afters` (`id`, `user_id`, `post_id`, `photo_before`, `photo_after`, `wt_before`, `wt_after`, `description`, `date`, `status`) VALUES
(23, 61, 96, '1453331813photo_before.png', '1453331813photo_after.png', 0, 0, 'Love this ', '2016-01-20', 'Public'),
(22, 61, 94, '1453314193photo_before.png', '1453314193photo_after.png', 0, 0, 'Enjoying my morning coffee ', '2016-01-20', 'Public'),
(21, 34, 72, '1449536296photo_before.png', '1449536296photo_after.png', 0, 0, 'double test', '2015-12-08', 'Public'),
(20, 34, 70, '1449535148photo_before.png', '1449535148photo_after.png', 0, 0, 'Test going', '2015-12-08', 'Public'),
(19, 34, 69, '1449535073photo_before.png', '1449535073photo_after.png', 0, 0, 'Test what''s ', '2015-12-08', 'Public'),
(18, 34, 67, '1449527566photo_before.png', '1449527566photo_after.png', 0, 0, 'laeksks', '2015-12-07', 'Public'),
(24, 60, 101, '1453332539photo_before.png', '1453332539photo_after.png', 0, 0, 'Testing app', '2016-01-20', 'Public'),
(25, 60, 103, '1453332848photo_before.png', '1453332848photo_after.png', 0, 0, 'Double post test', '2016-01-20', 'Public'),
(26, 57, 104, '1453396242photo_before.png', '1453396242photo_after.png', 0, 0, 'New post show', '2016-01-21', 'Public'),
(27, 57, 107, '1453414730photo_before.png', '1453414730photo_after.png', 0, 0, 'Test thumbnails ', '2016-01-21', 'Public'),
(28, 61, 108, '1453484938photo_before.png', '1453484938photo_after.png', 0, 0, 'Here ', '2016-01-22', 'Public'),
(29, 61, 109, '1453485061photo_before.png', '1453485061photo_after.png', 0, 0, '', '2016-01-22', 'Public'),
(30, 57, 112, '1453762277photo_before.png', '1453762277photo_after.png', 0, 0, 'Double post share', '2016-01-25', 'Public'),
(31, 61, 116, '1453763062photo_before.png', '1453763062photo_after.png', 0, 0, '', '2016-01-25', 'Public'),
(32, 58, 122, '1454090085photo_before.png', '1454090085photo_after.png', 0, 0, 'Tyctvyccctkbgcdyvxxdtgexswszzwwzexexrxcrtctvvyvbnunkjhysdfgwesqsxefbhyyteeqqwrtui', '2016-01-29', 'Public'),
(33, 61, 124, '1454176854photo_before.png', '1454176854photo_after.png', 0, 0, 'Feeling good!!!! ', '2016-01-30', 'Public'),
(34, 78, 140, '1454370272photo_before.png', '1454370272photo_after.png', 0, 0, 'New post look', '2016-02-01', 'Public');

-- --------------------------------------------------------

--
-- Table structure for table `post_comments`
--

CREATE TABLE IF NOT EXISTS `post_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `date` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=76 ;

--
-- Dumping data for table `post_comments`
--

INSERT INTO `post_comments` (`id`, `user_id`, `post_id`, `comment`, `date`) VALUES
(22, 34, 77, 'sdfsfdsdfsfdsfds', '2015-12-17'),
(3, 27, 49, 'djsdgkjdfkj', '2015-12-07'),
(21, 34, 49, 'ugsugudgusagudgusagduk', '2015-12-15'),
(11, 34, 67, 'good job', '2015-12-08'),
(20, 34, 75, 'C', '2015-12-14'),
(8, 34, 51, 'hello sir', '2015-12-08'),
(9, 34, 47, 'hello dear', '2015-12-08'),
(23, 34, 81, 'Hr', '2016-01-14'),
(24, 34, 80, ' Hiiiiiii', '2016-01-16'),
(25, 57, 71, ' Hello dear', '2016-01-20'),
(26, 61, 96, 'Yay me!!!', '2016-01-20'),
(27, 61, 105, 'Lol ', '2016-01-24'),
(28, 57, 109, 'Hello ', '2016-01-25'),
(29, 57, 110, 'Hello', '2016-01-25'),
(30, 57, 109, 'Hee', '2016-01-25'),
(31, 58, 118, 'Nyccc bottle ', '2016-01-27'),
(32, 58, 111, 'Yxujxjzjzuyzyz', '2016-01-28'),
(33, 66, 119, 'Hjj', '2016-01-28'),
(34, 58, 120, 'Hiiiiiiii', '2016-01-30'),
(35, 61, 124, 'So much fun! ', '2016-01-30'),
(36, 72, 131, 'Cccg', '2016-01-30'),
(37, 75, 133, 'Woowwww', '2016-01-31'),
(38, 75, 133, 'Hdhdd', '2016-01-31'),
(39, 76, 134, 'Ggg', '2016-01-31'),
(40, 76, 134, 'Gg', '2016-01-31'),
(41, 76, 134, 'Gg', '2016-01-31'),
(42, 75, 133, 'Welcome', '2016-01-31'),
(43, 77, 118, 'Good', '2016-02-01'),
(44, 77, 118, 'Good', '2016-02-01'),
(45, 77, 134, 'Good', '2016-02-01'),
(46, 78, 135, 'Hhh', '2016-02-01'),
(47, 79, 142, 'Hello', '2016-02-02'),
(48, 79, 142, 'Hhh', '2016-02-02'),
(49, 84, 144, 'zcaccscsc', '2016-02-02'),
(50, 85, 145, 'Exc', '2016-02-02'),
(51, 85, 145, 'C', '2016-02-02'),
(52, 85, 145, 'Ddddd', '2016-02-02'),
(53, 85, 145, 'Ddddd', '2016-02-02'),
(54, 85, 145, 'Cghiil', '2016-02-02'),
(55, 84, 146, 'szsxdxd', '2016-02-02'),
(56, 84, 146, 'd f', '2016-02-02'),
(57, 84, 146, 'ff', '2016-02-02'),
(58, 84, 146, 'frt', '2016-02-02'),
(59, 84, 144, 'fgh', '2016-02-02'),
(60, 84, 144, 'dfgfg', '2016-02-02'),
(61, 84, 144, 'bhhhh', '2016-02-02'),
(62, 84, 144, 'bbb', '2016-02-02'),
(63, 84, 144, 'cgg', '2016-02-02'),
(64, 84, 144, 'rvscsb', '2016-02-02'),
(65, 84, 144, 's scd dvdbdbdbr tgbhgbf g g g g g g g g g g g g d d d d f ', '2016-02-02'),
(66, 84, 144, 'dcdcdcdceddcdv', '2016-02-02'),
(67, 84, 144, 'dddg', '2016-02-02'),
(68, 84, 144, 'ccccvgg', '2016-02-02'),
(69, 84, 144, 'd dcdcdcs', '2016-02-02'),
(70, 84, 144, 'edwcs', '2016-02-02'),
(71, 84, 144, 'z dcddve', '2016-02-02'),
(72, 84, 144, 'dfujfcjc', '2016-02-02'),
(73, 84, 144, 'hh', '2016-02-02'),
(74, 84, 144, 'hhhh', '2016-02-02'),
(75, 84, 144, 'hhhhhhhhh', '2016-02-02');

-- --------------------------------------------------------

--
-- Table structure for table `post_groups`
--

CREATE TABLE IF NOT EXISTS `post_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `date` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `post_groups`
--

INSERT INTO `post_groups` (`id`, `post_id`, `group_id`, `date`) VALUES
(1, 72, 3, '');

-- --------------------------------------------------------

--
-- Table structure for table `post_inspiredes`
--

CREATE TABLE IF NOT EXISTS `post_inspiredes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=264 ;

--
-- Dumping data for table `post_inspiredes`
--

INSERT INTO `post_inspiredes` (`id`, `post_id`, `user_id`, `date`) VALUES
(25, 71, 34, '2015-12-08'),
(24, 72, 34, '2015-12-08'),
(178, 126, 58, '2016-01-30'),
(19, 70, 34, '2015-12-08'),
(17, 43, 34, '2015-12-08'),
(15, 51, 34, '2015-12-08'),
(13, 67, 34, '2015-12-08'),
(26, 69, 34, '2015-12-08'),
(28, 75, 34, '2015-12-09'),
(31, 74, 34, '2015-12-14'),
(30, 73, 34, '2015-12-14'),
(33, 38, 34, '2015-12-16'),
(34, 77, 34, '2015-12-16'),
(35, 35, 34, '2015-12-21'),
(36, 81, 34, '2016-01-14'),
(37, 80, 34, '2016-01-15'),
(38, 71, 57, '2016-01-20'),
(40, 95, 60, '2016-01-20'),
(58, 94, 61, '2016-01-25'),
(53, 104, 61, '2016-01-25'),
(43, 108, 57, '2016-01-25'),
(44, 89, 57, '2016-01-25'),
(45, 105, 57, '2016-01-25'),
(56, 110, 57, '2016-01-25'),
(47, 97, 57, '2016-01-25'),
(59, 115, 57, '2016-01-26'),
(101, 118, 58, '2016-01-30'),
(61, 113, 57, '2016-01-26'),
(63, 118, 57, '2016-01-27'),
(65, 106, 58, '2016-01-28'),
(71, 119, 66, '2016-01-28'),
(110, 124, 61, '2016-01-30'),
(169, 119, 58, '2016-01-30'),
(180, 129, 72, '2016-01-30'),
(145, 109, 58, '2016-01-30'),
(176, 125, 58, '2016-01-30'),
(148, 117, 58, '2016-01-30'),
(166, 121, 58, '2016-01-30'),
(149, 114, 58, '2016-01-30'),
(147, 120, 58, '2016-01-30'),
(177, 124, 58, '2016-01-30'),
(163, 115, 58, '2016-01-30'),
(150, 113, 58, '2016-01-30'),
(151, 112, 58, '2016-01-30'),
(167, 122, 58, '2016-01-30'),
(186, 130, 70, '2016-01-30'),
(185, 131, 72, '2016-01-30'),
(184, 50, 70, '2016-01-30'),
(188, 132, 74, '2016-01-31'),
(189, 132, 75, '2016-01-31'),
(234, 128, 75, '2016-02-01'),
(233, 134, 76, '2016-01-31'),
(235, 118, 77, '2016-02-01'),
(236, 135, 78, '2016-02-01'),
(237, 140, 78, '2016-02-01'),
(240, 142, 79, '2016-02-02'),
(242, 143, 83, '2016-02-02'),
(259, 144, 84, '2016-02-02'),
(262, 145, 84, '2016-02-03'),
(263, 50, 27, '2016-02-24');

-- --------------------------------------------------------

--
-- Table structure for table `post_photos`
--

CREATE TABLE IF NOT EXISTS `post_photos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `photo` varchar(255) CHARACTER SET utf32 COLLATE utf32_unicode_ci NOT NULL,
  `description` text NOT NULL,
  `date` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=76 ;

--
-- Dumping data for table `post_photos`
--

INSERT INTO `post_photos` (`id`, `user_id`, `post_id`, `photo`, `description`, `date`, `status`) VALUES
(24, 41, 40, '1449279440_post_photo.png', 'Test User Posting', '2015-12-05', 'Public'),
(25, 41, 41, '1449282003_post_photo.png', 'Test image', '2015-12-05', 'Public'),
(26, 46, 42, '1449283425_post_photo.png', 'Test posting\n', '2015-12-05', 'Public'),
(27, 47, 43, '1449433497_post_photo.png', 'I love being able to go to dinner with my husband and feel beautiful! ', '2015-12-06', 'Public'),
(28, 34, 47, '1449515980_post_photo.png', 'New image upload\n', '2015-12-07', 'Public'),
(19, 41, 35, '1449263850_post_photo.png', 'xyz', '2015-12-04', 'Public'),
(20, 41, 36, '1449263910_post_photo.png', 'acb', '2015-12-04', 'Public'),
(21, 41, 37, '1449263953_post_photo.png', 'abc', '2015-12-04', 'Public'),
(29, 34, 48, '1449518158_post_photo.png', 'test', '2015-12-07', 'Public'),
(22, 43, 38, '1449269592_post_photo.png', 'new post test', '2015-12-04', 'Public'),
(30, 34, 49, '1449518191_post_photo.png', 'test user photo', '2015-12-07', 'Public'),
(31, 34, 51, '1449521335_post_photo.png', 'double image posted', '2015-12-07', 'Public'),
(32, 34, 68, '1449535029_post_photo.png', 'Test cropping is done', '2015-12-08', 'Public'),
(33, 34, 71, '1449536223_post_photo.png', 'testing going', '2015-12-08', 'Public'),
(34, 34, 78, '1450379718_post_photo.png', 'sadadsadsadsadsad', '2015-12-17', 'Public'),
(35, 56, 80, '1452109883_post_photo.png', 'Hello\n', '2016-01-06', 'Public'),
(36, 56, 81, '1452109987_post_photo.png', 'Merry ', '2016-01-06', 'Public'),
(37, 57, 89, '1453307163_post_photo.png', 'Hello dear', '2016-01-20', 'Public'),
(38, 57, 90, '1453307178_post_photo.png', 'Hollow dear', '2016-01-20', 'Public'),
(39, 61, 93, '1453313768_post_photo.png', 'Having my morning coffee ', '2016-01-20', 'Public'),
(40, 61, 95, '1453325035_post_photo.png', 'Afterthought ', '2016-01-20', 'Public'),
(41, 60, 97, '1453331955_post_photo.png', 'Love to work with Apple products', '2016-01-20', 'Public'),
(42, 60, 98, '1453332333_post_photo.png', 'Test app', '2016-01-20', 'Public'),
(43, 60, 99, '1453332401_post_photo.png', 'Ffff', '2016-01-20', 'Public'),
(44, 60, 100, '1453332467_post_photo.png', 'Team work', '2016-01-20', 'Public'),
(45, 57, 105, '1453409929_post_photo.png', 'Djdjskdk', '2016-01-21', 'Public'),
(46, 57, 106, '1453410752_post_photo.png', 'Test \n', '2016-01-21', 'Public'),
(47, 57, 110, '1453485077_post_photo.png', 'Hello', '2016-01-22', 'Public'),
(48, 57, 111, '1453762249_post_photo.png', 'This is test post', '2016-01-25', 'Public'),
(49, 62, 117, '1453843289_post_photo.png', '', '2016-01-26', 'Public'),
(50, 61, 118, '1453865068_post_photo.png', 'New bottles!!! ', '2016-01-27', 'Public'),
(51, 66, 119, '1454021539_post_photo.png', 'New post by test user push', '2016-01-28', 'Public'),
(52, 58, 120, '1454027910_post_photo.png', 'Water is life', '2016-01-29', 'Public'),
(53, 58, 121, '1454029286_post_photo.png', 'New post test', '2016-01-29', 'Public'),
(54, 68, 123, '1454114394_post_photo.png', 'Test post', '2016-01-30', 'Public'),
(55, 69, 125, '1454178361_post_photo.png', 'Protein coffee in the morning makes the whole day better ', '2016-01-30', 'Public'),
(56, 58, 126, '1454179318_post_photo.png', 'Happy coding', '2016-01-30', 'Public'),
(57, 71, 127, '1454192102_post_photo.png', 'Test push notification', '2016-01-30', 'Public'),
(58, 70, 128, '1454192753_post_photo.png', 'Test push', '2016-01-30', 'Public'),
(59, 70, 129, '1454193046_post_photo.png', 'Hgghh hj', '2016-01-30', 'Public'),
(60, 72, 130, '1454195004_post_photo.png', 'Test', '2016-01-30', 'Public'),
(61, 70, 131, '1454195043_post_photo.png', 'Test', '2016-01-30', 'Public'),
(62, 73, 132, '1454204470_post_photo.png', 'Hello', '2016-01-31', 'Public'),
(63, 76, 133, '1454204954_post_photo.png', 'Hhh', '2016-01-31', 'Public'),
(64, 75, 134, '1454205140_post_photo.png', 'Hello test', '2016-01-31', 'Public'),
(65, 77, 135, '1454363468_post_photo.png', 'Ggg', '2016-02-01', 'Public'),
(66, 78, 136, '1454369008_post_photo.png', 'Cool developers', '2016-02-01', 'Public'),
(67, 78, 137, '1454369156_post_photo.png', 'Enjoy lyf with no worries ', '2016-02-01', 'Public'),
(68, 78, 138, '1454369576_post_photo.png', 'Be happy u never know what happen next', '2016-02-01', 'Public'),
(69, 78, 139, '1454369655_post_photo.png', 'Looks', '2016-02-01', 'Public'),
(70, 79, 141, '1454374718_post_photo.png', 'Guru', '2016-02-02', 'Public'),
(71, 80, 142, '1454374727_post_photo.png', 'Pathankot', '2016-02-02', 'Public'),
(72, 82, 143, '1454436720_post_photo.png', 'test push', '2016-02-02', 'Public'),
(73, 85, 144, '1454437224_post_photo.png', 'Bore in office', '2016-02-02', 'Public'),
(74, 84, 145, '1454437687_post_photo.png', 'happyyyy', '2016-02-02', 'Public'),
(75, 80, 146, '1454447151_post_photo.png', 'Rat Ghjj', '2016-02-02', 'Public');

-- --------------------------------------------------------

--
-- Table structure for table `post_quotes`
--

CREATE TABLE IF NOT EXISTS `post_quotes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `quote` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('Public','Private') NOT NULL DEFAULT 'Public',
  `date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Table structure for table `post_texts`
--

CREATE TABLE IF NOT EXISTS `post_texts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `text` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(255) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

--
-- Dumping data for table `post_texts`
--

INSERT INTO `post_texts` (`id`, `user_id`, `post_id`, `text`, `status`, `date`) VALUES
(4, 34, 73, 'test user profile is text send to.......', 'Public', '2015-12-08'),
(5, 34, 74, 'ddodhf;dshfo;dhs;h dik di;h i;i fhd;ish fsdh; fhds; hd;ioshfodsh;ofhds dhs ;ofhds;ofhds;ohf dsh fhdsfhdshf;hds;h dhs f;hds;fhdso;hf;odhsfhd;shf;odhs f;odhf;hd; hds;fh;odsh;fhds; hsdhhd hodsh dh hds hdhdshfodhshhd hdfhdshf o;dhs hd h h hdsohhdshdsh', 'Public', '2015-12-09'),
(6, 34, 75, 'test status y gasdjgsadgsa  kahsdkhsakhdksah ahsdkhsakhdksah hklhdskhsakd lahlhjdlhas;dh ahnhdhsahd;h jlhdsha;dhsa; hklhasdh;osah ohha;sdhsa lh;h;hasd asdhhasdh;sahd; asdolsahdhsao;d sdhsadhsha sadhsadhsahd sadhsahdh asdhsadho', 'Public', '2015-12-09'),
(8, 34, 77, 'lahdfhkadhfk;lkdfhkdshf;hd;shfhdsfihd;hfhdfhkdhkfhdkhfkh kd k;hdfk;hdhfhdkfhkdf dbdfidh fhdifhlid d di fdh ifdf gdfg dug fgfug ugd gf gf ii igdfigdagfdagf g dgfgdgfgdfgdagf f gdfggda gdgdf gdafg ldg gd gd flgldiagfgdalifgda f f gdf gdga fgdlajf  gflg lf', 'Public', '2015-12-16'),
(9, 56, 79, 'Goo buddy', 'Public', '2016-01-06'),
(10, 57, 82, 'Hello I am good my first page I am heathy and I to b happy in my out happy', 'Public', '2016-01-20'),
(11, 57, 83, 'Hello I am good my first page I am heathy and I to b happy in my out happy', 'Public', '2016-01-20'),
(12, 57, 84, 'Hiii there is good job opening in shjs dhdnd djdndjbdjdnjdjjdjdjfjrje jdjdjdhd jdjdjd jdjdjd jdjdjdhd by dudjjdjdjd jdjdjdhd no djdjskdk jdjdkd', 'Public', '2016-01-20'),
(13, 57, 85, 'Hiii there is good job opening in shjs dhdnd djdndjbdjdnjdjjdjdjfjrje jdjdjdhd jdjdjd jdjdjd jdjdjdhd by dudjjdjdjd jdjdjdhd no djdjskdk jdjdkd', 'Public', '2016-01-20'),
(14, 57, 86, 'Hiii there is good job opening in shjs dhdnd djdndjbdjdnjdjjdjdjfjrje jdjdjdhd jdjdjd jdjdjd jdjdjdhd by dudjjdjdjd jdjdjdhd no djdjskdk jdjdkd', 'Public', '2016-01-20'),
(15, 57, 87, 'Jdjdjd djdjskdk dudjjdjdjd jdjdjdhd jdjdjdidjd jdjdjdidjdjdjdihfbdf jdjdjdidjdjdjdihfbdf jdjdjdidjd jdjdjdhd handoff hit jdjdjdidjdjdjdihfbdf djdjskdk is dudjjdjdjd urjdjdkdid', 'Public', '2016-01-20'),
(16, 57, 88, 'Jdjdjdidjdjdjdihfbdf dhdjdjdhjdjdjdhdhfjfjrjrjdjdjdjdjjrjd jdjdjdidjdjdjdihfbdf hdjjdidhrhfjfjfdhdjrjdjdhdb dhdndj jdjd hdjddjjdkwkwkfbfhrjrbhrfbdbjdjdjdjdjjdjdjdjdjd dhdndj jdjdjdhd sh djdjskdk dudjjdjdjd djdjskdk jdjdjdidjdjdjdihfbdf dudjjdjdjd jdjdjd', 'Public', '2016-01-20'),
(17, 57, 91, 'Hi the jdjdjd dudjjdjdjd jdjdjdhd sisjjddkkd djdjskdk a gdjbeiddb dhdjdjdhjdjdjdhdhfjfjrjrjdjdjdjdjjrjd jdjdjdidjd djdjskdk do jdjdjdidjd dudjjdjdjd jdjdjdhd jdjdjdidjdjdjdihfbdf dhdjdjdhjdjdjdhdhfjfjrjrjdjdjdjdjjrjd', 'Public', '2016-01-20'),
(18, 57, 92, 'Dudjjdjdjd jdjd dudjjdjdjd jdjdjd djdjskdk for jadfjsjsjjs dudjjdjdjd djdjskdk', 'Public', '2016-01-20'),
(19, 60, 102, 'Dhdjdjdhjdjdjdhdhfjfjrjrjdjdjdjdjjrjd dhdnd jdjd dhdjdjdhjdjdjdhdhfjfjrjrjdjdjdjdjjrjd djdjskdk jdjdjdhd jdjdjdidjdjdjdihfbdf djdjskdk djdndjbdjdnjdjjdjdjfjrje djdjskdk jdjdjdidjd dhdjdjdhjdjdjdhdhfjfjrjrjdjdjdjdjjrjd djdjskdk did djdjskdk djdjskdk djdjskdk djdjskdk dkdkdkdkdkdkcbfjejdjd dkkdkkdkdkdkdkdkdjdjdkdkkddkdkdkkdkdkdbdkdkkdkdkdjskskddjjfjf ', 'Public', '2016-01-20'),
(20, 57, 113, 'This is tenkckdklcfgkdlljkfcdlgd djfdljfldlfkhdkhfkdf dfhkldshflkhdskfhi;shad darkness fudge;finds;folds dskfhkdshkfhkldshfds fkdskfhkdshfhds;fuss fkdskfhkdshfhds;the;Fahd;he''s;f dskfhkdshkfhkldshfds;kfhdshfdhsfkhdskfhkdshfhdsfhdshfkhdsfh', 'Public', '2016-01-25'),
(21, 57, 114, 'This kskkadshfkdhfkhdkfhdkshfkd skfhdkshfkdhlkfhkdshfkhdsklhflkdhsklfhdsfkldflkhdslkfhkldshfklhdklshfkhdsfhkdshfkhkdslhfkhdsklfhkldshlkfhldshlfhlkdshfhdsklhfklhdlskfhkldshlkfhlkdshfkhdslkhfklhdjsfjkldshklfhdkshfklhdsklfhdlkshfhldskhfkldhsfhlksdhjfdhs', 'Public', '2016-01-25'),
(22, 57, 115, 'Fdgdfgdfgfdgfdgfdgkfsn fhgkfhgkhkfshg hfskghkflhgkfhklhgklfhglkfhklhgkflhkghkfdghkfhgkhdfklhklgfhdklghdkfhgfhdkl Hghghghg the hgkfdhhklghkldfhlkgh', 'Public', '2016-01-25');

-- --------------------------------------------------------

--
-- Table structure for table `post_types`
--

CREATE TABLE IF NOT EXISTS `post_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('Yes','No') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Yes',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `post_types`
--

INSERT INTO `post_types` (`id`, `name`, `status`) VALUES
(1, 'Photo', 'Yes'),
(2, 'Before/After', 'Yes'),
(3, 'Text', 'Yes'),
(4, 'Quote', 'Yes');

-- --------------------------------------------------------

--
-- Table structure for table `send_feedbacks`
--

CREATE TABLE IF NOT EXISTS `send_feedbacks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `subject` varchar(250) NOT NULL,
  `description` text NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `send_feedbacks`
--

INSERT INTO `send_feedbacks` (`id`, `user_id`, `subject`, `description`, `date`) VALUES
(4, 4, 'abc', 'Weight loss, in the context of medicine, health, or physical fitness, refers to a reduction of the total body mass, due to a mean loss of fluid, body fat or adipose tissue and/or lean mass, namely bone mineral deposits, muscle, tendon, and other connective tissue. Weight loss can either occur unintentionally due to malnourishment or an underlying disease or arise from a conscious effort to improve an actual or perceived overweight or obese state. "Unexplained" weight loss that is not caused by reduction in calorific intake or exercise is called cachexia and may be a symptom of a serious medical condition. Intentional weight loss is commonly referred to as slimming.', '2015-09-21'),
(9, 4, 'PHP info ', 'hellohello', '2015-12-04'),
(10, 4, 'PHP info ', 'hellohello', '2015-12-04'),
(11, 34, 'PHP info ', 'hellohello', '2015-12-04'),
(12, 27, 'PHP info ', 'hellohello', '2015-12-04'),
(13, 27, 'PHP info ', 'hellohello', '2015-12-04'),
(14, 27, 'PHP info ', 'hellohello', '2015-12-04'),
(15, 27, 'PHP info ', 'hellohello', '2015-12-04'),
(16, 27, 'PHP info ', 'hellohellokjdfskjdfsdfsdfsdfskjdfsdfsndfsnkdfsnkdfsnkdfsnkdfsnkdfsnkdfsndfsn', '2015-12-04'),
(8, 4, 'PHP info ', 'hellohello', '2015-12-04'),
(7, 1, 'Related to Suggest', 'i want ask any query i want to know about medicine', '2015-09-21');

-- --------------------------------------------------------

--
-- Table structure for table `sitesettings`
--

CREATE TABLE IF NOT EXISTS `sitesettings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(250) NOT NULL,
  `web_url` varchar(250) NOT NULL,
  `keywords` varchar(250) NOT NULL,
  `site_desc` varchar(500) NOT NULL,
  `facebook_url` varchar(150) NOT NULL,
  `twitter_url` varchar(150) NOT NULL,
  `googleplus` varchar(150) NOT NULL,
  `site_email` varchar(100) NOT NULL,
  `site_address` varchar(500) NOT NULL,
  `analytic_code` varchar(500) NOT NULL,
  `server` varchar(200) NOT NULL,
  `port` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `server_auth` varchar(500) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `sitesettings`
--

INSERT INTO `sitesettings` (`id`, `title`, `web_url`, `keywords`, `site_desc`, `facebook_url`, `twitter_url`, `googleplus`, `site_email`, `site_address`, `analytic_code`, `server`, `port`, `username`, `password`, `server_auth`) VALUES
(2, 'Bariatric-Support', 'http://dev414.trigma.us/Bariatric-Support/admin/', 'Bariatric-Support', 'Bariatric-Support', 'https://facebook.com/Bariatric-Support', 'https://twitter.com/Bariatric-Support', 'https://googleplus.com/Bariatric-Support', 'Gurudutt.sharma@trigma.in', 'Bariatric-Support', '', '', 0, '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `staticpages`
--

CREATE TABLE IF NOT EXISTS `staticpages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `content` longtext NOT NULL,
  `status` varchar(150) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `term_services`
--

CREATE TABLE IF NOT EXISTS `term_services` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(250) NOT NULL,
  `description` text NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `term_services`
--

INSERT INTO `term_services` (`id`, `title`, `description`, `date`) VALUES
(1, 'Term and Service', 'Term and Service', '2015-09-17'),
(2, 'Term and Service1', 'Term and Service1Term and Service1', '2015-09-17');

-- --------------------------------------------------------

--
-- Table structure for table `tracks`
--

CREATE TABLE IF NOT EXISTS `tracks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `track_type_id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `description` varchar(250) NOT NULL,
  `image` varchar(250) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=26 ;

--
-- Dumping data for table `tracks`
--

INSERT INTO `tracks` (`id`, `track_type_id`, `name`, `description`, `image`, `date`) VALUES
(6, 5, 'Salad', 'Salad', 'images.jpeg', '2015-09-16'),
(5, 5, 'Vegetables', 'Vegetables', 'images.jpeg', '2015-09-16'),
(4, 5, 'Lean Protein', 'Lean Protein', 'images.jpeg', '2015-09-16'),
(7, 5, 'Protein Shake', 'Protein Shake1', 'images.jpeg', '2015-09-16'),
(8, 7, 'Multi Vitamin', 'Multi Vitamin', '9speechlecture1016.jpg', '2015-09-18'),
(9, 7, 'B12', 'B12', '9speechlecture1016.jpg', '2015-09-18'),
(10, 7, 'Probiotic', 'Probiotic', '9speechlecture1016.jpg', '2015-09-18'),
(11, 7, 'Berberine', 'Berberine', '9speechlecture1016.jpg', '2015-09-18'),
(12, 7, 'Other', 'Other', '9speechlecture1016.jpg', '2015-09-18'),
(13, 4, 'Breakfast', 'Breakfast', '9speechlecture1016.jpg', '2015-09-18'),
(14, 4, 'Lunch', 'Lunch', '9speechlecture1016.jpg', '2015-09-18'),
(15, 4, 'Dinner', 'Dinner', '9speechlecture1016.jpg', '2015-09-18'),
(16, 4, 'Snack', 'Snack', '9speechlecture1016.jpg', '2015-09-18'),
(17, 4, 'Water', 'Water', '9speechlecture1016.jpg', '2015-09-18'),
(18, 4, 'My Recipes', 'My Recipes', '9speechlecture1016.jpg', '2015-09-18'),
(19, 6, 'Walk', 'Walk', '9speechlecture1016.jpg', '2015-09-18'),
(20, 6, 'Running', 'Running', '9speechlecture1016.jpg', '2015-09-18'),
(21, 6, 'Weights', 'Weights', '9speechlecture1016.jpg', '2015-09-18'),
(22, 6, 'Swimming', 'Swimming', '9speechlecture1016.jpg', '2015-09-18'),
(23, 6, 'Yoga', 'Yoga', '9speechlecture1016.jpg', '2015-09-18'),
(24, 6, 'Other', 'Other', '9speechlecture1016.jpg', '2015-09-18'),
(25, 7, 'Probiotic', 'Probiotic', '9speechlecture1016.jpg', '2015-09-18');

-- --------------------------------------------------------

--
-- Table structure for table `track_types`
--

CREATE TABLE IF NOT EXISTS `track_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  `count` int(11) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `track_types`
--

INSERT INTO `track_types` (`id`, `name`, `count`, `date`) VALUES
(5, 'Lunch', 50, '2015-09-16'),
(4, 'My Food ', 75, '2015-09-16'),
(6, 'My Activity', 75, '2015-09-16'),
(7, 'Suppliment', 75, '2015-09-16');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sort_order_id` int(11) NOT NULL,
  `username` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) NOT NULL,
  `password` text NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `birthday` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `lat` varchar(255) NOT NULL,
  `long` varchar(255) NOT NULL,
  `usertype_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `user_notification` enum('Yes','No') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Yes',
  `register_date` varchar(255) NOT NULL,
  `profile_image` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `contact` int(11) NOT NULL,
  `starting_wt` int(11) NOT NULL,
  `current_wt` int(11) NOT NULL,
  `goal_wt` int(11) NOT NULL,
  `goal_sleep` varchar(255) NOT NULL,
  `gender` varchar(255) NOT NULL,
  `about` text NOT NULL,
  `height` float NOT NULL,
  `location` varchar(255) NOT NULL,
  `age` int(11) NOT NULL,
  `about_me` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `registertype` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `fb_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `twiter_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `devicetype` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `device_token` text NOT NULL,
  `fbpassword` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=86 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `sort_order_id`, `username`, `name`, `password`, `email`, `birthday`, `lat`, `long`, `usertype_id`, `status`, `user_notification`, `register_date`, `profile_image`, `contact`, `starting_wt`, `current_wt`, `goal_wt`, `goal_sleep`, `gender`, `about`, `height`, `location`, `age`, `about_me`, `description`, `registertype`, `fb_id`, `twiter_id`, `devicetype`, `device_token`, `fbpassword`) VALUES
(1, 2, 'admin', 'admin', '0e51b15da108488127eb0ea8ccc4245df04f6a51', 'gurudutt.sharma@trigma.in', '', '', '', 1, 1, 'Yes', '12-Nov-2015', 'trigma-100x100.png', 34634636, 0, 0, 0, '', '', '', 0, '', 0, '', 'dfhdfh', '', '', '', '', '', ''),
(27, 8, '', 'guru', '0e51b15da108488127eb0ea8ccc4245df04f6a51', 'gduddrrudutt.sharma@trigma.in', '2012-12-12', '31.75', '77.78', 2, 1, 'No', '01-Dec-2015', '', 123233333, 0, 0, 0, '', '', '', 0, '', 0, '', '', 'manual', '', '', '', '3444444', ''),
(29, 4, '', 'gurudutt1', '0e51b15da108488127eb0ea8ccc4245df04f6a51', 'gurudutt.sharma@trwigma.in', '', '', '', 2, 1, 'No', '01-Dec-2015', '', 123, 0, 56, 400, '', '', '', 0, '', 0, '', '', 'manual', '', '', '', '', ''),
(30, 5, '', 'jack', 'dab835ed8613ad86cbb98b8f18f4cdec57d3a368', 'jack@a.com', '', '', '', 2, 1, 'No', '01-Dec-2015', '', 1234567891, 0, 0, 0, '', '', '', 0, '', 0, '', '', 'manual', '', '', '', '', ''),
(31, 3, '', 'gurudutt1', '0e51b15da108488127eb0ea8ccc4245df04f6a51', 'g@c.m', '', '', '', 2, 1, 'No', '02-Dec-2015', '', 123, 0, 0, 0, '', '', '', 0, '', 0, '', '', 'manual', '', '', '', '', ''),
(57, 9, 'datt', 'guru datt', '0e51b15da108488127eb0ea8ccc4245df04f6a51', 'datt@gmail.com', '2016-01-21', '', '', 2, 1, 'No', '19-Jan-2016', '2016-01-21-10:52:3157image.png', 1234567894, 123, 258, 125, '', 'Male', 'hii I I am there', 5.5, '', 0, '', '', 'manual', '', '', '', '', ''),
(58, 2, '', 'datt1', '0e51b15da108488127eb0ea8ccc4245df04f6a51', 'datt1@gmail.com', '', '(null)', '(null)', 2, 1, 'No', '19-Jan-2016', '2016-01-30-6:43:3658image.png', 1234567890, 0, 0, 0, '', '', '', 0, '', 0, '', '', 'manual', '', '', '', '', ''),
(34, 10, 'sam', 'Sam', '4f6149fd556c37cfd3965d5539b181e17449d9c6', 'sam@a.com', '2015-12-08', '', '', 2, 1, 'No', '02-Dec-2015', '2015-12-07-4:24:2134image.png', 1234567891, 52, 700, 58, '', 'Male', 'lnlfngklfndlkgldfgl', 58, '', 0, '', '', 'manual', '', '', '', '', ''),
(35, 2, '', 'Jack', '0e51b15da108488127eb0ea8ccc4245df04f6a51', 'jack@gmail.com', '', '', '', 2, 1, 'No', '03-Dec-2015', '', 1234567891, 0, 0, 0, '', '', '', 0, '', 0, '', '', 'manual', '', '', '', '', ''),
(36, 3, '', 'jack', '0e51b15da108488127eb0ea8ccc4245df04f6a51', 'jack@yahoo.com', '', '', '', 2, 1, 'No', '03-Dec-2015', '', 1234567891, 0, 0, 0, '', '', '', 0, '', 0, '', '', 'manual', '', '', '', '', ''),
(37, 4, '', 'jack', '0e51b15da108488127eb0ea8ccc4245df04f6a51', 'jonny@gmail.com', '', '', '', 2, 1, 'No', '03-Dec-2015', '', 1234567891, 0, 0, 0, '', '', '', 0, '', 0, '', '', 'manual', '', '', '', '', ''),
(38, 5, '', 'sammy', 'eac4da46f63550847c6caf22b562c6df109b0694', 'sammy@gmail.com', '', '', '', 2, 1, 'No', '03-Dec-2015', '', 1234567891, 0, 0, 0, '', '', '', 0, '', 0, '', '', 'manual', '', '', '', '', ''),
(39, 6, '', 'mandy', 'dab835ed8613ad86cbb98b8f18f4cdec57d3a368', 'mandy@gmail.com', '', '', '', 2, 1, 'No', '03-Dec-2015', '', 1234567891, 0, 0, 0, '', '', '', 0, '', 0, '', '', 'manual', '', '', '', '', ''),
(40, 7, 'guru', 'nike', '81c1ab7cb1dd64074052e1acef436b94fc9ea3a0', 'nike@gmail.com', '12-02-1991', '', '', 2, 1, 'No', '03-Dec-2015', '2015-12-04-12:31:1340image.png', 1234567891, 45, 54, 234, '', 'Male', '', 34.6, '', 0, '', '', 'manual', '', '', '', '', ''),
(41, 3, 'usertest', 'test', 'aac11b40c4bb5b15882c8382b71c5dca08304ee7', 'test@gmail.com', '2014-12-05', '', '', 2, 1, 'No', '04-Dec-2015', '2015-12-04-11:09:2441image.png', 1234567891, 23, 66, 123, '', 'Male', 'healthy', 5, '', 0, '', '', 'manual', '', '', '', '', ''),
(43, 4, '', 'jacky', '94ff0cb9fc84609705746aa15b5f00b23e22c5d7', 'abc@a.com', '', '', '', 2, 1, 'No', '04-Dec-2015', '', 2147483647, 0, 0, 0, '', '', '', 0, '', 0, '', '', 'manual', '', '', '', '', ''),
(44, 5, '', 'ferry', '94ff0cb9fc84609705746aa15b5f00b23e22c5d7', 'ferry@gmail.com', '', '', '', 2, 1, 'No', '05-Dec-2015', '', 1234567891, 0, 0, 0, '', '', '', 0, '', 0, '', '', 'manual', '', '', '', '', ''),
(45, 6, '', 'test toddy', '94ff0cb9fc84609705746aa15b5f00b23e22c5d7', 'test@gmail.co', '', '', '', 2, 1, 'No', '05-Dec-2015', '', 1234567860, 0, 0, 0, '', '', '', 0, '', 0, '', '', 'manual', '', '', '', '', ''),
(46, 7, 'Bill', 'Bill', 'aac11b40c4bb5b15882c8382b71c5dca08304ee7', 'Bill@a.com', '2015-12-05', '', '', 2, 1, 'No', '05-Dec-2015', '2015-12-05-2:44:3846image.png', 1234567890, 123, 90, 45, '', 'Male', 'healthy life', 5.6, '', 0, '', '', 'manual', '', '', '', '', ''),
(47, 8, 'melaniewildman', 'Melanie Wildman', '726e14f84b0863d73d622aa032be687d92bcd8da', 'melanie@wlfmedical.ca', '1974-08-31', '', '', 2, 1, 'No', '06-Dec-2015', '2015-12-06-7:58:3547image.png', 2147483647, 237, 126, 130, '', 'Female', '', 5, '', 0, '', '', 'manual', '', '', '', '', ''),
(48, 9, '', 'jammy', '0e51b15da108488127eb0ea8ccc4245df04f6a51', 'jammy@a.com', '', '', '', 2, 1, 'No', '08-Dec-2015', '', 1234567891, 0, 0, 0, '', '', '', 0, '', 0, '', '', 'manual', '', '', '', '', ''),
(49, 10, '', 'luky', 'aac11b40c4bb5b15882c8382b71c5dca08304ee7', 'lucky@a.com', '', '', '', 2, 1, 'No', '08-Dec-2015', '', 1234567891, 0, 0, 0, '', '', '', 0, '', 0, '', '', 'manual', '', '', '', '', ''),
(50, 1, '', 'hike', '4f6149fd556c37cfd3965d5539b181e17449d9c6', 'hike@a.com', '', '', '', 2, 1, 'No', '08-Dec-2015', '', 1452369871, 0, 0, 0, '', '', '', 0, '', 0, '', '', 'manual', '', '', '', '', ''),
(54, 2, '', 'gurudutt1', '0e51b15da108488127eb0ea8ccc4245df04f6a51', 'gurudfutt.sharma@trigma.in', '', '', '', 4, 1, 'No', '23-Dec-2015', '', 123, 0, 0, 0, '', '', '', 0, '', 0, '', '', 'manual', '', '', '', '', ''),
(55, 3, '', 'tom', '0e51b15da108488127eb0ea8ccc4245df04f6a51', 'tom@a.com', '', '', '', 2, 1, 'No', '04-Jan-2016', '', 1234567890, 0, 0, 0, '', '', '', 0, '', 0, '', '', 'manual', '', '', '', '', ''),
(56, 4, '', 'jacky', '0e51b15da108488127eb0ea8ccc4245df04f6a51', 'jacky@a.com', '', '', '', 2, 1, 'No', '04-Jan-2016', '2016-01-04-7:30:3956image.png', 2147483647, 0, 0, 0, '', '', '', 0, '', 0, '', '', 'manual', '', '', '', '', ''),
(59, 5, '', 'jack', '0e51b15da108488127eb0ea8ccc4245df04f6a51', 'jocky@gmail.com', '', '', '', 2, 1, 'No', '20-Jan-2016', '', 1234567890, 0, 0, 0, '', '', '', 0, '', 0, '', '', 'manual', '', '', '', '', ''),
(60, 6, 'happy coding', 'test user', '0e51b15da108488127eb0ea8ccc4245df04f6a51', 'user123@gmail.com', '2016-01-20', '', '', 2, 1, 'No', '20-Jan-2016', '2016-01-20-11:20:3060image.png', 1234567890, 125, 145, 85, '', 'Male', 'hii I want to lose my weight', 5.5, '', 0, '', '', 'manual', '', '', '', '', ''),
(61, 7, 'Melp', 'melanie', 'dab835ed8613ad86cbb98b8f18f4cdec57d3a368', 'melanie@nutracelle.com', '1974-04-29', '', '', 2, 1, 'Yes', '20-Jan-2016', '2016-01-27-3:27:0261image.png', 2147483647, 236, 129, 126, '', 'Female', '', 5, '', 0, '', '', 'manual', '', '', '', '', ''),
(62, 8, '', 'Craig Paul', '43b5271199cd279bfb7a3a7b014c0934f8a3db44', 'craig@wlfmedical.ca', '', '', '', 2, 1, 'No', '26-Jan-2016', '', 2147483647, 0, 250, 0, '', '', '', 0, '', 0, '', '', 'manual', '', '', '', '', ''),
(63, 0, 'guru sharma', 'push test', '0e51b15da108488127eb0ea8ccc4245df04f6a51', 'push@a.com', '', '(null)', '(null)', 2, 1, 'Yes', '28-Jan-2016', '2016-02-01-6:48:5063image.png', 1234567890, 0, 0, 0, '', '', '', 0, '', 0, '', '', 'manual', '', '', '', '8d52c2f872f4f7b9f8217ec12898de08ede1707af7b944a6eabe8e973e594b9f', ''),
(66, 0, '', 'push user 1', '0e51b15da108488127eb0ea8ccc4245df04f6a51', 'push1@a.com', '', '', '', 2, 1, 'No', '28-Jan-2016', '', 1234567890, 0, 0, 0, '', '', '', 0, '', 0, '', '', 'manual', '', '', '', '97a423a2a73d891b99b300eb481468509de74555e4d6545965d07418f0ef274d', ''),
(67, 0, '', 'gurudutt1', '0e51b15da108488127eb0ea8ccc4245df04f6a51', 'guru33dutt.sharma@trigma.in', '', 'chd', 'dl', 2, 1, 'No', '29-Jan-2016', '', 123, 0, 0, 0, '', '', '', 0, '', 0, '', '', 'manual', '', '', '', '123', ''),
(68, 0, '', 'tom', '0e51b15da108488127eb0ea8ccc4245df04f6a51', 'jerry@a.com', '', '30.72755886', '76.84676047', 2, 1, 'No', '30-Jan-2016', '', 1234567890, 0, 0, 0, '', '', '', 0, '', 0, '', '', 'manual', '', '', '', 'f1bf5de0d90aec53bafd495e6bdd433a86a19eaab9f8713c75527f62f59dda1f', ''),
(69, 0, '', 'Robyn ', '0c0e5d8c2b9d1b72d288cf32495fd22fd7b062c3', 'robynmurphy@gmail.com', '', '(null)', '(null)', 2, 1, 'No', '30-Jan-2016', '', 2147483647, 0, 0, 0, '', '', '', 0, '', 0, '', '', 'manual', '', '', '', '1a8c350b4aa2220c71f1cda8627792f564f324602fe20561db6e296895f7f6a9', ''),
(70, 0, '', 'jhon', '0e51b15da108488127eb0ea8ccc4245df04f6a51', 'jhon@a.com', '', '19.01761470', '72.85616440', 2, 1, 'Yes', '30-Jan-2016', '', 1234567890, 0, 0, 0, '', '', '', 0, '', 0, '', '', 'manual', '', '', '', 'bfa4f5538a74d59897273f4de92748fd1217e57462ad56c942a80d65b761ccf8', ''),
(71, 0, '', 'Johnny', '0e51b15da108488127eb0ea8ccc4245df04f6a51', 'jonny@a.com', '', '(null)', '(null)', 2, 1, 'Yes', '30-Jan-2016', '', 1234567890, 0, 0, 0, '', '', '', 0, '', 0, '', '', 'manual', '', '', '', '8de382175d40f4fdb3ae731057fa844d13de1f524d2486f0ea6c6de131cb9b36', ''),
(72, 0, '', 'mike', '0e51b15da108488127eb0ea8ccc4245df04f6a51', 'mike@a.com', '', '30.72761862', '76.84671198', 2, 1, 'No', '30-Jan-2016', '', 1234567890, 0, 0, 0, '', '', '', 0, '', 0, '', '', 'manual', '', '', '', 'af83e537c003e841b0aacbc51401e66478e4863a60c57e42ca326120ae899fb9', ''),
(73, 0, '', 'try', 'f147d70beaad7e63b9df3e362f4e52f1b891b8af', 'rrr@g.com', '', '30.72758233', '76.84680179', 2, 1, 'Yes', '31-Jan-2016', '', 2147483647, 0, 0, 0, '', '', '', 0, '', 0, '', '', 'manual', '', '', '', 'af83e537c003e841b0aacbc51401e66478e4863a60c57e42ca326120ae899fb9', ''),
(74, 0, '', 'test user ', '0e51b15da108488127eb0ea8ccc4245df04f6a51', 'c@a.con', '', '(null)', '(null)', 2, 1, 'Yes', '31-Jan-2016', '', 1234567908, 0, 0, 0, '', '', '', 0, '', 0, '', '', 'manual', '', '', '', '93231e10f27a010aeb63f5c21c0f32fbc3694db121e9f697bfaa2ab54f775f05', ''),
(75, 0, '', 'new test ', '0e51b15da108488127eb0ea8ccc4245df04f6a51', 'new@a.com', '', '(null)', '(null)', 2, 1, 'Yes', '31-Jan-2016', '2016-01-31-1:51:3675image.png', 1234567890, 0, 0, 0, '', '', '', 0, '', 0, '', '', 'manual', '', '', '', '620f78f7b2f506b8cb17f1aa43b4d3977b9985e92daafc11086c78d6398a4b0a', ''),
(76, 0, '', 'you', '38f762c780cf9697f41d5400f4db4822d063471f', 'yyy@g.com', '', '(null)', '(null)', 2, 1, 'Yes', '31-Jan-2016', '2016-01-31-1:52:0176image.png', 2147483647, 0, 65, 0, '', '', '', 0, '', 0, '', '', 'manual', '', '', '', 'f04fddf9e08f213073d5667539994bea2ee97c5d91b32768262f7a4065c2418c', ''),
(77, 0, '', 'Ggg', '0e51b15da108488127eb0ea8ccc4245df04f6a51', 'ggg@gmail.com', '', '(null)', '(null)', 2, 1, 'Yes', '01-Feb-2016', '', 2147483647, 0, 0, 0, '', '', '', 0, '', 0, '', '', 'manual', '', '', '', '2bb1279c0ad0f95bc3e0a29320134f4b73882ef126f8e9d00b2a5c1565479b73', ''),
(78, 0, '', 'Ggg', '0e51b15da108488127eb0ea8ccc4245df04f6a51', 'hjj@gmail.com', '', '(null)', '(null)', 2, 1, 'No', '01-Feb-2016', '', 2147483647, 0, 0, 0, '', '', '', 0, '', 0, '', '', 'manual', '', '', '', '2bb1279c0ad0f95bc3e0a29320134f4b73882ef126f8e9d00b2a5c1565479b73', ''),
(79, 0, '', 'gab', '0e51b15da108488127eb0ea8ccc4245df04f6a51', 'gzb@gmail.com', '', '(null)', '(null)', 2, 1, 'Yes', '02-Feb-2016', '', 2147483647, 0, 0, 0, '', '', '', 0, '', 0, '', '', 'manual', '', '', '', 'bc2b5d2eb0987101f70e1a85720ca07226a85e7eb77a43a771e054b76e2d8206', ''),
(80, 0, '', 'Pathankot', '0e51b15da108488127eb0ea8ccc4245df04f6a51', 'p@a.com', '', '(null)', '(null)', 2, 1, 'Yes', '02-Feb-2016', '', 1234567890, 0, 0, 0, '', '', '', 0, '', 0, '', '', 'manual', '', '', '', 'f0099354c33897e9e7b1c7370aa96617a603615252bd3d8426d15094c5d1dc40', ''),
(81, 0, '', 'check push', '38f762c780cf9697f41d5400f4db4822d063471f', 'check1@a.com', '', '30.72767736', '76.84670765', 2, 1, 'No', '02-Feb-2016', '', 1234567890, 0, 0, 0, '', '', '', 0, '', 0, '', '', 'manual', '', '', '', 'f9369b0b027f122097c08ba49f08b1e9b63edaeb91b452645c068441be9d68ec', ''),
(82, 0, '', 'check push2', '38f762c780cf9697f41d5400f4db4822d063471f', 'check2@a.com', '', '(null)', '(null)', 2, 1, 'No', '02-Feb-2016', '', 1234567890, 0, 0, 0, '', '', '', 0, '', 0, '', '', 'manual', '', '', '', '94e71fb4e6bc844e9e0978c26d15ea714db3f36b3a9286081acf4ffbd2dced5d', ''),
(83, 0, '', 'check push', '38f762c780cf9697f41d5400f4db4822d063471f', 'cheak@a.com', '', '30.72767736', '76.84670765', 2, 1, 'No', '02-Feb-2016', '', 1236549870, 0, 0, 0, '', '', '', 0, '', 0, '', '', 'manual', '', '', '', 'f9369b0b027f122097c08ba49f08b1e9b63edaeb91b452645c068441be9d68ec', ''),
(84, 0, '', 'trigma', '0e51b15da108488127eb0ea8ccc4245df04f6a51', 'trigma@a.com', '', '(null)', '(null)', 2, 1, 'Yes', '02-Feb-2016', '', 1234567890, 0, 0, 0, '', '', '', 0, '', 0, '', '', 'manual', '', '', '', 'd8ac0cf261e5ead369ddf1f0a41d2e3ea1687c785c703b39ea230cc186a971a2', ''),
(85, 0, '', 'Trigma user ', '0e51b15da108488127eb0ea8ccc4245df04f6a51', 'trigma1@a.com', '', '(null)', '(null)', 2, 1, 'Yes', '02-Feb-2016', '', 2147483647, 0, 0, 0, '', '', '', 0, '', 0, '', '', 'manual', '', '', '', 'a70616dbb1c760a54fe565f4688839c472f318138d6477e536e3cbb2210666f4', '');

-- --------------------------------------------------------

--
-- Table structure for table `user_chats`
--

CREATE TABLE IF NOT EXISTS `user_chats` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=289 ;

--
-- Dumping data for table `user_chats`
--

INSERT INTO `user_chats` (`id`, `sender_id`, `receiver_id`, `message`, `date`) VALUES
(1, 27, 34, 'messagemessage', '2015-12-17 00:00:00'),
(2, 27, 34, 'messagemeserersage', '2015-12-17 00:00:00'),
(3, 27, 34, 'messagemeserersagererere', '2015-12-17 00:00:00'),
(4, 27, 34, 'messagemessage', '2015-12-17 00:00:00'),
(5, 27, 34, 'messagemessage', '2015-12-17 00:00:00'),
(6, 34, 27, 'messagemessage', '2015-12-17 00:00:00'),
(7, 34, 27, 'messagemessage', '2015-12-17 00:00:00'),
(8, 34, 27, 'messagemessage', '2015-12-17 00:00:00'),
(9, 34, 47, '', '2015-12-18 00:00:00'),
(10, 34, 47, 'Fffhaahu', '2015-12-21 00:00:00'),
(11, 34, 47, 'hiii howz u', '2015-12-21 00:00:00'),
(12, 34, 47, '', '2015-12-21 00:00:00'),
(13, 34, 47, 'fdfdsfdsfds', '2015-12-21 00:00:00'),
(14, 34, 47, 'sdfdsfdsfdsf', '2015-12-21 00:00:00'),
(15, 34, 47, 'Heellloooo guru', '2015-12-21 00:00:00'),
(16, 34, 47, 'jkfgdjsfgjdsglfgilsdfgld msdfkljbsdlifgdilsf sdfdshbf.hds.fhbds.f dsfkbd.ksbhf.dshbf.s fk.mnbdskfn.kdsbfds fdsnf/khds/fh/dsf sdfnk.dsfh.dsf.', '2015-12-21 00:00:00'),
(17, 34, 47, 'Hiii', '2015-12-24 00:00:00'),
(18, 34, 47, 'Kkdkfkdkfdjdjdjfj', '2016-01-04 00:00:00'),
(19, 56, 34, 'Hello dear', '2016-01-04 00:00:00'),
(20, 56, 34, 'Yes i am good dear', '2016-01-04 00:00:00'),
(21, 56, 34, 'Hello i am good', '2016-01-04 00:00:00'),
(22, 56, 34, 'Hello', '2016-01-04 00:00:00'),
(23, 34, 47, 'Hdjdjdjddjdd', '2016-01-15 00:00:00'),
(24, 58, 57, 'Hello dear', '2016-01-20 00:00:00'),
(25, 57, 58, 'Hello', '2016-01-20 00:00:00'),
(26, 57, 58, 'I am fine', '2016-01-20 00:00:00'),
(27, 57, 41, 'Shdjdjdhdbdijd', '2016-01-20 00:00:00'),
(28, 57, 41, 'Hello dear', '2016-01-25 00:00:00'),
(29, 57, 41, 'Fhfjfsngsngznz', '2016-01-26 00:00:00'),
(30, 57, 41, 'Zvnsgjstjtsjstjsgjgznvzncznfznfsjfsjgsjgsjgsjgsjgsnvznvznvznvznvz', '2016-01-26 00:00:00'),
(31, 58, 57, 'Gsgshdhdhd', '2016-01-28 00:00:00'),
(32, 58, 57, 'Xbxbhxhxhxhxx', '2016-01-28 00:00:00'),
(33, 58, 57, 'Cusizwivzvwzszveixwvixgisvxvisvxivedvkejpdgiexgegixevixpvwxvixvpievpxvdpvxpevupxvjepxvpevxpevpxvuepgxpepxvepuguxpegupxvepuvxosupxuvuspvpsvupxvsovxupevxupxvuepvxupeupxvepuvxuevupxvepuxvuepvxupevupxveupvxupvwzfwfzgwpvxupvwupvxpvwpx', '2016-01-28 00:00:00'),
(34, 58, 57, 'Shsjsjzjdhdurhdhdudhdhdhdidjdhhhiejjdudbdhfbejfndjdndid', '2016-01-28 00:00:00'),
(35, 58, 57, 'Hddudhdd', '2016-01-29 00:00:00'),
(36, 58, 57, 'Hhhhhhhhffgggggggxutuyzyzuztuztusruurstsuutsutsuwszuzuztjsjsjzgxgixgksjsuxusgjsgjsuxuxixjsgjsusuxuxuzjstjsrsusuqsxkxjsjgsxbggsjfsfjshsj', '2016-01-29 00:00:00'),
(37, 58, 57, 'Hiiii dear howz u :)', '2016-01-29 00:00:00'),
(38, 58, 57, '', '2016-01-29 00:00:00'),
(39, 58, 57, '', '2016-01-29 00:00:00'),
(40, 58, 57, '', '2016-01-29 00:00:00'),
(41, 58, 57, 'Whsisijsjsisgwuaiqinqwlwjjshzisbwyshswuwjab', '2016-01-29 00:00:00'),
(42, 58, 57, 'dhzheuggqyqyedbdbedbgeyuiwveyxywbsusibegdubehdkd', '2016-01-29 00:00:00'),
(43, 58, 57, '  Bscobecbiscoebcicebcbioxwhxhwpxhwbixheidohwhghjsjsjsk', '2016-01-29 00:00:00'),
(44, 27, 34, 'messagemessage', '2016-02-01 00:00:00'),
(45, 27, 34, 'messagemessage', '2016-02-01 00:00:00'),
(46, 78, 77, 'Hii', '2016-02-02 00:00:00'),
(47, 78, 77, 'Hiii', '2016-02-02 00:00:00'),
(48, 78, 77, 'Hj', '2016-02-02 00:00:00'),
(49, 78, 77, 'Hhy', '2016-02-02 00:00:00'),
(50, 78, 77, 'Xidfid', '2016-02-02 00:00:00'),
(51, 79, 80, 'Hello', '2016-02-02 00:00:00'),
(52, 80, 79, 'Hello buddy', '2016-02-02 00:00:00'),
(53, 80, 79, 'Hello', '2016-02-02 00:00:00'),
(54, 80, 79, 'Hiii', '2016-02-02 00:00:00'),
(55, 80, 79, 'Djfjf', '2016-02-02 00:00:00'),
(56, 80, 79, 'Gg', '2016-02-02 00:00:00'),
(57, 80, 79, 'Gjjdifi', '2016-02-02 00:00:00'),
(58, 80, 79, 'Ggy', '2016-02-02 00:00:00'),
(59, 80, 79, 'Fhfjfgijd', '2016-02-02 00:00:00'),
(60, 80, 79, 'Gcfj', '2016-02-02 00:00:00'),
(61, 80, 79, 'Cjfjfu', '2016-02-02 00:00:00'),
(62, 80, 79, 'Gifufifugig', '2016-02-02 00:00:00'),
(63, 80, 79, 'Fugif', '2016-02-02 00:00:00'),
(64, 80, 79, 'Jguf', '2016-02-02 00:00:00'),
(65, 80, 79, 'Chcufig', '2016-02-02 00:00:00'),
(66, 80, 79, 'Hcjfucuf', '2016-02-02 00:00:00'),
(67, 80, 79, 'Fiufif', '2016-02-02 00:00:00'),
(68, 80, 79, 'Ggchcjcufufufi', '2016-02-02 00:00:00'),
(69, 80, 79, 'Cig', '2016-02-02 00:00:00'),
(70, 80, 79, 'Fufufu', '2016-02-02 00:00:00'),
(71, 80, 79, 'Chfjfjcjci', '2016-02-02 00:00:00'),
(72, 80, 79, 'Fufjfjgi', '2016-02-02 00:00:00'),
(73, 80, 79, 'Ufjff', '2016-02-02 00:00:00'),
(74, 80, 79, 'Fichfifif', '2016-02-02 00:00:00'),
(75, 80, 79, 'Rudfif', '2016-02-02 00:00:00'),
(76, 80, 79, 'Chdjfjdjdj', '2016-02-02 00:00:00'),
(77, 80, 79, 'Vjgfgjgjfjfjgjfititt', '2016-02-02 00:00:00'),
(78, 80, 79, 'Xhzgxh', '2016-02-02 00:00:00'),
(79, 80, 79, 'Dhdhshd', '2016-02-02 00:00:00'),
(80, 80, 79, 'Ffhfj', '2016-02-02 00:00:00'),
(81, 80, 79, 'Fhfjfjfj', '2016-02-02 00:00:00'),
(82, 80, 79, 'Iggigo', '2016-02-02 00:00:00'),
(83, 80, 79, 'Dtdyd', '2016-02-02 00:00:00'),
(84, 80, 79, 'Igifig', '2016-02-02 00:00:00'),
(85, 80, 79, 'Igjfjfufifjfjfjgjfj', '2016-02-02 00:00:00'),
(86, 80, 79, 'Staatshzhd', '2016-02-02 00:00:00'),
(87, 80, 79, 'Ugggf', '2016-02-02 00:00:00'),
(88, 80, 79, 'Fifjfjdjdjxjd', '2016-02-02 00:00:00'),
(89, 80, 79, 'Fjfjfjfjgjfjgi', '2016-02-02 00:00:00'),
(90, 80, 79, 'Dufjfj', '2016-02-02 00:00:00'),
(91, 80, 79, 'Dudhd', '2016-02-02 00:00:00'),
(92, 80, 79, 'Chdhf', '2016-02-02 00:00:00'),
(93, 80, 79, 'Ghfj', '2016-02-02 00:00:00'),
(94, 80, 79, 'Hdfhdhdhdjd', '2016-02-02 00:00:00'),
(95, 80, 79, 'Eydyd', '2016-02-02 00:00:00'),
(96, 80, 79, 'Gg', '2016-02-02 00:00:00'),
(97, 79, 80, 'Dvdbdbdnf', '2016-02-02 00:00:00'),
(98, 79, 80, 'Fff', '2016-02-02 00:00:00'),
(99, 79, 80, 'Jddjdjd', '2016-02-02 00:00:00'),
(100, 79, 80, 'Hdjdjd', '2016-02-02 00:00:00'),
(101, 79, 80, 'Xbdjjd', '2016-02-02 00:00:00'),
(102, 79, 80, 'Jedjdjdjddd', '2016-02-02 00:00:00'),
(103, 84, 85, 'hiiii', '2016-02-02 00:00:00'),
(104, 84, 85, 'vdbdbsbdb', '2016-02-02 00:00:00'),
(105, 84, 85, 'fffggyy', '2016-02-02 00:00:00'),
(106, 84, 85, 'dvdbrb', '2016-02-02 00:00:00'),
(107, 84, 85, 'fevege', '2016-02-02 00:00:00'),
(108, 84, 85, 'dvdbsbsbsbhsb', '2016-02-02 00:00:00'),
(109, 85, 84, 'Kaam kr liya kr bhai', '2016-02-02 00:00:00'),
(110, 84, 85, 'haaan bhai', '2016-02-02 00:00:00'),
(111, 84, 85, 'usidjjd', '2016-02-02 00:00:00'),
(112, 85, 84, 'Hhh', '2016-02-02 00:00:00'),
(113, 84, 85, 'gdhdjdjd', '2016-02-02 00:00:00'),
(114, 85, 84, 'Hhh', '2016-02-02 00:00:00'),
(115, 84, 85, 'dhdjdjdjd', '2016-02-02 00:00:00'),
(116, 84, 85, 'jdsjxjdxcodic', '2016-02-02 00:00:00'),
(117, 84, 85, 'jdjdffkdo', '2016-02-02 00:00:00'),
(118, 84, 85, 'hhhhui', '2016-02-02 00:00:00'),
(119, 85, 84, 'Frrg', '2016-02-02 00:00:00'),
(120, 85, 84, 'Dvrh', '2016-02-02 00:00:00'),
(121, 85, 84, 'Thrbth', '2016-02-02 00:00:00'),
(122, 85, 84, 'Dcdvdgegrgrvrvr', '2016-02-02 00:00:00'),
(123, 85, 84, 'Rvevevrvrgrv', '2016-02-02 00:00:00'),
(124, 85, 84, 'Tfh', '2016-02-02 00:00:00'),
(125, 85, 84, 'Dvdvdvdvfvf', '2016-02-02 00:00:00'),
(126, 85, 84, 'Ctvtvthyhth', '2016-02-02 00:00:00'),
(127, 85, 84, 'Scrcrvrg', '2016-02-02 00:00:00'),
(128, 85, 84, 'Gnfhtj', '2016-02-02 00:00:00'),
(129, 85, 84, 'Dff fcfcefrgrvrgrgrh', '2016-02-02 00:00:00'),
(130, 85, 84, 'Fcfvfvt', '2016-02-02 00:00:00'),
(131, 85, 84, 'Execec', '2016-02-02 00:00:00'),
(132, 85, 84, 'Rxdcd r', '2016-02-02 00:00:00'),
(133, 85, 84, 'Dvdbrhrhehrh', '2016-02-02 00:00:00'),
(134, 85, 84, 'Sgegege', '2016-02-02 00:00:00'),
(135, 85, 84, 'Dccscdcdcdcfff', '2016-02-02 00:00:00'),
(136, 85, 84, 'Dcdvd', '2016-02-02 00:00:00'),
(137, 85, 84, 'H', '2016-02-02 00:00:00'),
(138, 85, 84, 'Brgdgehrhr', '2016-02-02 00:00:00'),
(139, 85, 84, 'Rceg', '2016-02-02 00:00:00'),
(140, 85, 84, 'GggggjhhhbhzgzhuUusigsixiziUjIzizizizizizixkxkxoxooiddihxhxkjgizizgixkxixixikkkkkxkckckxlxhbblvkvkvkvkvkvvkvkvkkvvkvkvjvjjvjvhcgxchchjvchxgxhchchhchcch', '2016-02-02 00:00:00'),
(141, 85, 84, 'Thrhrthrhrh', '2016-02-02 00:00:00'),
(142, 85, 84, 'Dcdcscdcefefegg', '2016-02-02 00:00:00'),
(143, 85, 84, 'Rcdcs', '2016-02-02 00:00:00'),
(144, 85, 84, 'Xer', '2016-02-02 00:00:00'),
(145, 84, 85, 'eyyudf', '2016-02-02 00:00:00'),
(146, 84, 85, 'tffg', '2016-02-02 00:00:00'),
(147, 84, 85, 'gggg', '2016-02-02 00:00:00'),
(148, 84, 85, 'ecr', '2016-02-02 00:00:00'),
(149, 84, 85, 'ggg', '2016-02-02 00:00:00'),
(150, 84, 85, 'vggggggggggddrdrfff', '2016-02-02 00:00:00'),
(151, 84, 85, 'hhhh', '2016-02-02 00:00:00'),
(152, 84, 85, 'ghjj', '2016-02-02 00:00:00'),
(153, 84, 85, 'gghhh', '2016-02-02 00:00:00'),
(154, 84, 85, 'h', '2016-02-02 00:00:00'),
(155, 84, 85, 'xexscacdvev', '2016-02-02 00:00:00'),
(156, 84, 85, 'jjjjj', '2016-02-02 00:00:00'),
(157, 84, 85, 'hhjhhhhkhh', '2016-02-02 00:00:00'),
(158, 84, 85, 'jjjjjj', '2016-02-02 00:00:00'),
(159, 84, 85, 'ghhh', '2016-02-02 00:00:00'),
(160, 84, 85, 'ghhhhj', '2016-02-02 00:00:00'),
(161, 84, 85, 'tgggggggggg', '2016-02-02 00:00:00'),
(162, 84, 85, 'gghhhhhjjjj', '2016-02-02 00:00:00'),
(163, 84, 85, 'hjgdgh', '2016-02-02 00:00:00'),
(164, 84, 85, 'bddbsbsgsh', '2016-02-02 00:00:00'),
(165, 84, 85, 'dhdbsjdj', '2016-02-02 00:00:00'),
(166, 84, 85, 'hdhdbdj', '2016-02-02 00:00:00'),
(167, 84, 85, 'daff', '2016-02-02 00:00:00'),
(168, 84, 85, 'exeeceg', '2016-02-02 00:00:00'),
(169, 84, 85, 'rrrrrrf', '2016-02-02 00:00:00'),
(170, 84, 85, 'ddd', '2016-02-02 00:00:00'),
(171, 84, 85, 'r', '2016-02-02 00:00:00'),
(172, 84, 85, 'dcdcd', '2016-02-02 00:00:00'),
(173, 84, 85, 'ff', '2016-02-02 00:00:00'),
(174, 84, 85, 'd', '2016-02-02 00:00:00'),
(175, 84, 85, 'df', '2016-02-02 00:00:00'),
(176, 84, 85, 'fff', '2016-02-02 00:00:00'),
(177, 84, 85, 'hg', '2016-02-02 00:00:00'),
(178, 84, 85, 'hhi', '2016-02-02 00:00:00'),
(179, 84, 85, 'fg', '2016-02-02 00:00:00'),
(180, 84, 85, 'xfffff', '2016-02-02 00:00:00'),
(181, 84, 85, 'ff', '2016-02-02 00:00:00'),
(182, 84, 85, 'ggg', '2016-02-02 00:00:00'),
(183, 84, 85, 'ghhhh', '2016-02-02 00:00:00'),
(184, 84, 85, 'ggh', '2016-02-02 00:00:00'),
(185, 84, 85, 'gggg', '2016-02-02 00:00:00'),
(186, 84, 85, 'gggf', '2016-02-02 00:00:00'),
(187, 84, 85, 'gg', '2016-02-02 00:00:00'),
(188, 84, 85, 'ghhhhjjj', '2016-02-02 00:00:00'),
(189, 84, 85, 'gghhugu', '2016-02-02 00:00:00'),
(190, 84, 85, 'gfdfff', '2016-02-02 00:00:00'),
(191, 84, 85, 'ffgh', '2016-02-02 00:00:00'),
(192, 84, 85, 'ggggg', '2016-02-02 00:00:00'),
(193, 84, 85, 'vgg', '2016-02-02 00:00:00'),
(194, 84, 85, 'dddgh', '2016-02-02 00:00:00'),
(195, 84, 85, 'gggg', '2016-02-02 00:00:00'),
(196, 84, 85, 'gfff', '2016-02-02 00:00:00'),
(197, 84, 85, 'dddv', '2016-02-02 00:00:00'),
(198, 84, 85, 'cascag', '2016-02-02 00:00:00'),
(199, 84, 85, 'fbdbfbdb', '2016-02-02 00:00:00'),
(200, 84, 85, 'dddffffffgg', '2016-02-02 00:00:00'),
(201, 84, 85, 'ghjjjkjj', '2016-02-02 00:00:00'),
(202, 84, 85, 'secececwf', '2016-02-02 00:00:00'),
(203, 84, 85, 'hhhhhhyhuuuuuu', '2016-02-02 00:00:00'),
(204, 84, 85, 'fggg', '2016-02-02 00:00:00'),
(205, 84, 85, 'ifjddjjddj', '2016-02-02 00:00:00'),
(206, 84, 85, 'fijf', '2016-02-02 00:00:00'),
(207, 84, 85, 'fashsh', '2016-02-02 00:00:00'),
(208, 84, 85, 'fffgfgh', '2016-02-02 00:00:00'),
(209, 84, 85, 'ghh', '2016-02-02 00:00:00'),
(210, 84, 85, 'acfffgh', '2016-02-02 00:00:00'),
(211, 84, 85, 'vhhjj', '2016-02-02 00:00:00'),
(212, 84, 85, 'fffggggg', '2016-02-02 00:00:00'),
(213, 84, 85, 'ddddd', '2016-02-02 00:00:00'),
(214, 85, 84, 'Hh', '2016-02-03 00:00:00'),
(215, 84, 85, 'ghjjhhhj', '2016-02-03 00:00:00'),
(216, 84, 85, 'ttty', '2016-02-03 00:00:00'),
(217, 84, 85, 'gggg', '2016-02-03 00:00:00'),
(218, 84, 85, 'tttttgghj', '2016-02-03 00:00:00'),
(219, 84, 85, 'ffgh', '2016-02-03 00:00:00'),
(220, 84, 85, 'ijjjj', '2016-02-03 00:00:00'),
(221, 84, 85, 'fghh', '2016-02-03 00:00:00'),
(222, 85, 84, 'Xffff', '2016-02-03 00:00:00'),
(223, 84, 85, 'hhhhhhhhhhhhhhhh', '2016-02-03 00:00:00'),
(224, 84, 85, 'rrt', '2016-02-03 00:00:00'),
(225, 84, 85, 'ggh', '2016-02-03 00:00:00'),
(226, 84, 85, 'yyy', '2016-02-03 00:00:00'),
(227, 84, 85, 'hhhyu', '2016-02-03 00:00:00'),
(228, 84, 85, 'hhggggh', '2016-02-03 00:00:00'),
(229, 84, 85, 'h', '2016-02-03 00:00:00'),
(230, 84, 85, 'h', '2016-02-03 00:00:00'),
(231, 84, 85, 'fddd', '2016-02-03 00:00:00'),
(232, 84, 85, 'ggggg', '2016-02-03 00:00:00'),
(233, 84, 85, 'ggggy', '2016-02-03 00:00:00'),
(234, 84, 85, 'ffffdf', '2016-02-03 00:00:00'),
(235, 84, 85, 'hhhh', '2016-02-03 00:00:00'),
(236, 84, 85, 'ffffffg', '2016-02-03 00:00:00'),
(237, 84, 85, 'h', '2016-02-03 00:00:00'),
(238, 84, 85, 'tggyy', '2016-02-03 00:00:00'),
(239, 84, 85, 'ggggy', '2016-02-03 00:00:00'),
(240, 84, 85, 'g', '2016-02-03 00:00:00'),
(241, 84, 85, 'jfd', '2016-02-03 00:00:00'),
(242, 84, 85, 'eddeedefefefwfafwgwg', '2016-02-03 00:00:00'),
(243, 84, 85, 'fff', '2016-02-03 00:00:00'),
(244, 84, 85, 'fmfj', '2016-02-03 00:00:00'),
(245, 84, 85, 'edwcac', '2016-02-03 00:00:00'),
(246, 84, 85, 'dffff', '2016-02-03 00:00:00'),
(247, 84, 85, 'dvdbb', '2016-02-03 00:00:00'),
(248, 84, 85, 'caav', '2016-02-03 00:00:00'),
(249, 84, 85, 'dbjj', '2016-02-03 00:00:00'),
(250, 84, 85, 'fbfbdbf', '2016-02-03 00:00:00'),
(251, 84, 85, 'gg', '2016-02-03 00:00:00'),
(252, 84, 85, 'fggggsgehehehg', '2016-02-03 00:00:00'),
(253, 85, 84, 'Uddhjd', '2016-02-03 00:00:00'),
(254, 85, 84, 'Tyhu', '2016-02-03 00:00:00'),
(255, 85, 84, 'Wffege', '2016-02-03 00:00:00'),
(256, 85, 84, 'Dvdvrvrhrhrh', '2016-02-03 00:00:00'),
(257, 85, 84, 'Scdv', '2016-02-03 00:00:00'),
(258, 85, 84, 'Gh', '2016-02-03 00:00:00'),
(259, 85, 84, 'T', '2016-02-03 00:00:00'),
(260, 85, 84, 'Egeg', '2016-02-03 00:00:00'),
(261, 85, 84, 'Rfrgrgr', '2016-02-03 00:00:00'),
(262, 85, 84, 'Gnyjyk', '2016-02-03 00:00:00'),
(263, 84, 85, 'Rhejrj', '2016-02-03 00:00:00'),
(264, 84, 85, 'Fjfjfhdhhdhddhhxfj', '2016-02-03 00:00:00'),
(265, 84, 85, 'Ggghh', '2016-02-03 00:00:00'),
(266, 84, 85, 'Uffic', '2016-02-03 00:00:00'),
(267, 84, 85, 'Xfgdffghhh', '2016-02-03 00:00:00'),
(268, 84, 85, 'Dvdbdbdg', '2016-02-03 00:00:00'),
(269, 84, 85, 'Dhj', '2016-02-03 00:00:00'),
(270, 84, 85, 'Shehsh', '2016-02-03 00:00:00'),
(271, 84, 85, 'Dhdj', '2016-02-03 00:00:00'),
(272, 84, 85, 'Cngnfjf', '2016-02-03 00:00:00'),
(273, 84, 85, 'Fbfj', '2016-02-03 00:00:00'),
(274, 84, 85, 'Dvdbdbd', '2016-02-03 00:00:00'),
(275, 84, 85, 'Rhdh', '2016-02-03 00:00:00'),
(276, 84, 85, 'Drbrhrhrhrjrjjsjrjrj', '2016-02-03 00:00:00'),
(277, 84, 85, 'Dheh', '2016-02-03 00:00:00'),
(278, 84, 85, 'Dvdgrheh', '2016-02-03 00:00:00'),
(279, 84, 85, 'Cucufucucjjv', '2016-02-03 00:00:00'),
(280, 84, 85, 'Dvd', '2016-02-03 00:00:00'),
(281, 84, 85, 'Dbdhr', '2016-02-03 00:00:00'),
(282, 84, 85, 'Fbdj', '2016-02-03 00:00:00'),
(283, 84, 85, 'Svdbd', '2016-02-03 00:00:00'),
(284, 84, 85, 'Dvd', '2016-02-03 00:00:00'),
(285, 84, 85, 'Gsgshsh', '2016-02-03 00:00:00'),
(286, 84, 85, 'Dvesvdvs', '2016-02-03 00:00:00'),
(287, 84, 85, 'Jttjri', '2016-02-03 00:00:00'),
(288, 84, 85, 'Fbfjfj', '2016-02-03 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `user_doctors`
--

CREATE TABLE IF NOT EXISTS `user_doctors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `clinic_id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `user_doctors`
--

INSERT INTO `user_doctors` (`id`, `clinic_id`, `doctor_id`) VALUES
(1, 23, 54);

-- --------------------------------------------------------

--
-- Table structure for table `user_followers`
--

CREATE TABLE IF NOT EXISTS `user_followers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `follower_id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=82 ;

--
-- Dumping data for table `user_followers`
--

INSERT INTO `user_followers` (`id`, `user_id`, `follower_id`, `date`) VALUES
(28, 63, 50, '0000-00-00 00:00:00'),
(29, 49, 34, '2015-12-18 00:00:00'),
(30, 34, 47, '2015-12-17 00:00:00'),
(37, 57, 41, '2016-01-20 00:00:00'),
(33, 56, 34, '2016-01-06 00:00:00'),
(38, 57, 58, '2016-01-20 00:00:00'),
(39, 58, 57, '2016-01-20 00:00:00'),
(40, 57, 56, '2016-01-20 00:00:00'),
(41, 57, 34, '2016-01-20 00:00:00'),
(73, 77, 75, '2016-02-01 00:00:00'),
(74, 78, 77, '2016-02-01 00:00:00'),
(77, 80, 79, '2016-02-02 00:00:00'),
(80, 85, 84, '2016-02-02 00:00:00'),
(81, 84, 85, '2016-02-02 00:00:00'),
(75, 79, 80, '2016-02-02 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `user_trackers`
--

CREATE TABLE IF NOT EXISTS `user_trackers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `tracker_type` int(11) NOT NULL,
  `tack` varchar(250) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_types`
--

CREATE TABLE IF NOT EXISTS `user_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_name` varchar(250) NOT NULL,
  `Authorities` varchar(250) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `user_types`
--

INSERT INTO `user_types` (`id`, `group_name`, `Authorities`, `status`) VALUES
(1, 'Administrators', 'All', 1),
(2, 'user', 'Few', 1),
(3, 'clinic', 'Few', 1),
(4, 'doctor', 'few', 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
