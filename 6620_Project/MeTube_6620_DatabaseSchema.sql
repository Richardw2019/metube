-- phpMyAdmin SQL Dump
-- version 4.0.10deb1ubuntu0.1
-- http://www.phpmyadmin.net
--
-- Host: mysql1.cs.clemson.edu
-- Generation Time: Nov 23, 2021 at 11:38 PM
-- Server version: 5.5.52-0ubuntu0.12.04.1
-- PHP Version: 5.5.9-1ubuntu4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `MeTube_6620_zt8l`
--

-- --------------------------------------------------------

--
-- Table structure for table `Channel_Subscriptions`
--

CREATE TABLE IF NOT EXISTS `Channel_Subscriptions` (
  `user_id` int(11) NOT NULL,
  `channel_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Channel_Subscriptions`
--

INSERT INTO `Channel_Subscriptions` (`user_id`, `channel_id`) VALUES
(4, 6),
(12, 4);

-- --------------------------------------------------------

--
-- Table structure for table `Commenting`
--

CREATE TABLE IF NOT EXISTS `Commenting` (
  `user_id` varchar(100) DEFAULT NULL,
  `file_id` int(11) NOT NULL,
  `comment` varchar(255) NOT NULL,
  `comment_id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL,
  `comment_level` int(11) NOT NULL,
  PRIMARY KEY (`comment_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=33 ;

--
-- Dumping data for table `Commenting`
--

INSERT INTO `Commenting` (`user_id`, `file_id`, `comment`, `comment_id`, `parent_id`, `comment_level`) VALUES
('batman', 4, 'Gotham but with Andrew Cuomo', 1, 1, 1),
('batman', 4, 'This is a comment!', 3, 3, 1),
('batman', 4, 'brug!! what!!', 4, 4, 1),
('batman', 20, 'nice car', 5, 5, 1),
('jplineb', 2, 'I love this movie', 6, 6, 1),
('jplineb', 2, 'This movie is great!', 7, 7, 1),
('bilbo', 2, 'great film', 8, 8, 1),
('spiderman', 2, 'Do root comments work here?', 10, 10, 1),
('bilbo', 2, 'okkk\r\n', 11, 11, 1),
('batman', 2, 'I am JUSTICE', 14, 14, 1),
('batman', 2, 'i doo too!', 18, 6, 2),
('batman', 4, 'I want a nice drink', 23, 3, 2),
('batman', 4, 'Shut up', 24, 3, 2),
('batman', 4, 'shut up', 25, 3, 2),
('ember1', 2, 'hello', 26, 26, 1),
('ember1', 2, 'Hello testing', 27, 27, 1),
('ember1', 2, 'Hello I am testing', 28, 28, 1),
('ember1', 2, 'Hello', 29, 18, 3),
('ember1', 20, 'I know right', 30, 5, 2),
('spiderman', 21, 'BRO I LOVE A GOOD PORSCHE', 31, 31, 1),
('ember1', 27, 'This movie is awesome', 32, 32, 1);

-- --------------------------------------------------------

--
-- Table structure for table `Contact_List`
--

CREATE TABLE IF NOT EXISTS `Contact_List` (
  `user_id` int(11) NOT NULL,
  `contact_id` int(11) NOT NULL,
  `contact_user_id` varchar(255) NOT NULL,
  `contact_firstname` varchar(255) NOT NULL,
  `contact_lastname` varchar(255) NOT NULL,
  `block_status` varchar(255) NOT NULL DEFAULT 'No',
  `contact_category` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Contact_List`
--

INSERT INTO `Contact_List` (`user_id`, `contact_id`, `contact_user_id`, `contact_firstname`, `contact_lastname`, `block_status`, `contact_category`) VALUES
(0, 0, '', '', '', 'Yes', 'friend'),
(4, 8, 'batman', 'batman', 'gotham', 'Yes', 'friend'),
(12, 6, 'jplineb', 'John', 'Lineberger', 'No', 'friend'),
(6, 8, 'batman', 'batman', 'gotham', 'Yes', 'colleague'),
(10, 8, 'batman', 'batman', 'gotham', 'Yes', 'favorite'),
(13, 6, 'jplineb', 'John', 'Lineberger', 'Yes', 'friend'),
(13, 4, 'bilbo', 'Richard', 'Garcia', 'No', 'family');

-- --------------------------------------------------------

--
-- Table structure for table `Favorites_List`
--

CREATE TABLE IF NOT EXISTS `Favorites_List` (
  `user_numeric_id` int(11) NOT NULL,
  `video_id` int(11) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_extension` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Favorites_List`
--

INSERT INTO `Favorites_List` (`user_numeric_id`, `video_id`, `file_name`, `file_extension`, `file_path`) VALUES
(4, 2, 'back to the future', 'jpg', '../uploaded_files/back_to_the_future.jpg'),
(4, 4, 'TestVideo', 'mp4', '../uploaded_files/TestVideo.mp4'),
(4, 5, 'Cat Video', 'mov', '../uploaded_files/cat_compressed.mov'),
(4, 9, 'The Great Secret Trial', 'mp3', '../uploaded_files/The-Great-Secret-Trial.mp3'),
(4, 20, 'Konika Minolta DPI Car', 'jpg', '../uploaded_files/dev-1766-compressed.jpg'),
(12, 6, 'Dog running', 'mov', '../uploaded_files/dog_compressed_2.mov'),
(12, 4, 'TestVideo', 'mp4', '../uploaded_files/TestVideo.mp4'),
(8, 4, 'TestVideo', 'mp4', '../uploaded_files/TestVideo.mp4');

-- --------------------------------------------------------

--
-- Table structure for table `File_Playlist`
--

CREATE TABLE IF NOT EXISTS `File_Playlist` (
  `playlist_id` int(11) NOT NULL,
  `video_id` int(11) NOT NULL,
  `extension` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `File_Playlist`
--

INSERT INTO `File_Playlist` (`playlist_id`, `video_id`, `extension`) VALUES
(11, 5, 'mov'),
(11, 2, 'jpg'),
(11, 9, 'mp3');

-- --------------------------------------------------------

--
-- Table structure for table `Media_Ratings`
--

CREATE TABLE IF NOT EXISTS `Media_Ratings` (
  `user_id` int(11) NOT NULL,
  `video_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Media_Ratings`
--

INSERT INTO `Media_Ratings` (`user_id`, `video_id`, `rating`) VALUES
(8, 4, 3),
(4, 2, 5),
(10, 4, 5),
(13, 2, 1),
(10, 21, 5),
(13, 27, 4);

-- --------------------------------------------------------

--
-- Table structure for table `Multimedia_Files`
--

CREATE TABLE IF NOT EXISTS `Multimedia_Files` (
  `file_title` varchar(255) NOT NULL,
  `file_type` varchar(255) NOT NULL,
  `keywords` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `sharing_mode` varchar(255) NOT NULL,
  `file_path` varchar(200) DEFAULT NULL,
  `size` float NOT NULL,
  `file_owner` varchar(255) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `view_count` int(11) NOT NULL,
  `upload_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=31 ;

--
-- Dumping data for table `Multimedia_Files`
--

INSERT INTO `Multimedia_Files` (`file_title`, `file_type`, `keywords`, `category`, `description`, `sharing_mode`, `file_path`, `size`, `file_owner`, `id`, `view_count`, `upload_date`) VALUES
('back to the future', 'picture', 'movie, time travel', 'movies', 'movie poster for back to the future', 'public', '../uploaded_files/back_to_the_future.jpg', 0.0855, 'rgarci3', 2, 36, '2021-11-17 15:03:21'),
('TestVideo', 'video', 'Milky Way, Space, Night', 'landscapes', 'This is a video of the Milky Way at night', 'public', '../uploaded_files/TestVideo.mp4', 1.5815, 'Sethi', 4, 15, '2021-11-19 10:16:00'),
('Cat Video', 'video', 'cat', 'nature', 'A video of a cat in crap quality', 'public', '../uploaded_files/cat_compressed.mov', 1.607, 'test_user', 5, 14, '2021-11-18 09:11:21'),
('Dog running', 'video', 'dog, running,', 'nature', 'A video of a dog running', 'public', '../uploaded_files/dog_compressed_2.mov', 1.526, 'test_user', 6, 4, '2021-11-16 11:20:23'),
('The Great Secret Trial', 'audio', 'Ace Attorney, OST', 'video games', 'OST from The Great Ace Attorney 2', 'public', '../uploaded_files/The-Great-Secret-Trial.mp3', 1.769, 'batman', 9, 5, '2021-11-18 10:15:16'),
('iphone', 'picture', 'apple', 'science', 'picture of iphone', 'public', '../uploaded_files/iphone.jfif', 0.0316, 'bilbo ', 17, 1, '2021-11-18 09:14:22'),
('Konika Minolta DPI Car', 'picture', 'race, car, Acura, IMSA, DPI', 'science', 'Photo of a Acura DPI Car taken at Road Atlanta', 'public', '../uploaded_files/dev-1766-compressed.jpg', 1.7481, 'jplineb', 20, 3, '2021-11-22 21:24:49'),
('911 RSR', 'picture', 'race, car, 911, IMSA, Porsche', 'science', 'Photo of a Porsche 911 RSR taken at Road Atlanta', 'public', '../uploaded_files/911-compressed.jpg', 1.2236, 'jplineb', 21, 8, '2021-11-22 21:25:38'),
('New York', 'picture', 'nyc, city', 'landscapes', 'street of new york', 'public', '../uploaded_files/new York.jfif', 0.5654, 'bilbo', 22, 0, '2021-11-22 21:49:35'),
('Baby driver Poster', 'picture', 'movie, poster, baby, driver, Subaru', 'movies', 'A poster for the movie baby driver', 'public', '../uploaded_files/baby_driver.jpeg', 1.3278, 'spiderman', 27, 1, '2021-11-24 04:15:59'),
('Spidermans Keyboard', 'picture', 'key, board, warrior', 'science', 'A picture for my keyboard, No LOOKING', 'private', '../uploaded_files/keyboard.jpeg', 0.0977, 'spiderman', 28, 0, '2021-11-24 04:18:13'),
('Drake music smash volume 1', 'audio', 'Drake, Not Kanye, music mash', 'science', 'A music smash of drakes songs', 'public', '../uploaded_files/final_song.mp3', 1.2977, 'ember1', 29, 0, '2021-11-24 04:28:31'),
('Kanye music mash up', 'audio', 'kanye, drake, music, 2021', 'nature', 'mash up of kanye music', 'public', '../uploaded_files/main_final_song.mp3', 1.603, 'ember1', 30, 0, '2021-11-24 04:29:43');

-- --------------------------------------------------------

--
-- Table structure for table `Playlist_Tracker`
--

CREATE TABLE IF NOT EXISTS `Playlist_Tracker` (
  `playlist_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(255) NOT NULL,
  `playlist_name` varchar(255) NOT NULL,
  PRIMARY KEY (`playlist_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `Playlist_Tracker`
--

INSERT INTO `Playlist_Tracker` (`playlist_id`, `user_id`, `playlist_name`) VALUES
(10, '4', 'dfa'),
(11, '4', 'playlist tester'),
(12, '12', 'playlist tester 2'),
(13, '12', 'movies');

-- --------------------------------------------------------

--
-- Table structure for table `Users`
--

CREATE TABLE IF NOT EXISTS `Users` (
  `user_id` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `Users`
--

INSERT INTO `Users` (`user_id`, `last_name`, `first_name`, `user_password`, `email`, `id`) VALUES
('ar', 'd', 'richardw', 'dd', 'addf@clemson.edu', 1),
('ar', 'd', 'richardw', 'dd', 'addf@clemson.edu', 2),
('ar', 'd', 'richardw', 'dd', 'addf@clemson.edu', 3),
('bilbo', 'Garcia', 'Richard', 'ring', 'rgarci@clemson.edu', 4),
('jplineb', 'Lineberger', 'John', 'stupid_password', 'jplineb@clemson.edu', 6),
('test_user', 'test_last', 'test_first', 'test_password', 'test_email@clemson.edu', 7),
('batman', 'gotham', 'batman', 'gotham', 'batman@clemson.edu', 8),
('robin', 'gotham', 'robin', 'gotham', 'robin@clemson.edu', 9),
('spiderman', 'nyc', 'spiderman', 'nyc', 'spiderman@clemson.edu', 10),
('ember2', 'Garcia', 'Richard', 'adf', 'test@clemson.edu', 12),
('ember1', 'garcia ', 'richard', 'clemson1', 'test1@clemson.edu', 13);

-- --------------------------------------------------------

--
-- Table structure for table `User_Messages`
--

CREATE TABLE IF NOT EXISTS `User_Messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `message` text NOT NULL,
  `sent_by` int(11) NOT NULL,
  `sent_to` int(11) NOT NULL,
  `sent_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=105 ;

--
-- Dumping data for table `User_Messages`
--

INSERT INTO `User_Messages` (`id`, `message`, `sent_by`, `sent_to`, `sent_date`) VALUES
(91, 'testing', 4, 6, '2021-11-22 05:30:58'),
(92, 'testing back', 6, 4, '2021-11-22 05:39:05'),
(95, 'testing again', 4, 6, '2021-11-22 05:53:43'),
(96, 'test', 4, 6, '2021-11-23 07:01:20'),
(97, 'i hate your guts', 8, 6, '2021-11-23 22:24:25'),
(98, 'Whats up dog', 6, 4, '2021-11-24 02:53:44'),
(99, 'howdy partner', 13, 4, '2021-11-24 02:55:04'),
(100, 'your guts, i hate', 8, 6, '2021-11-24 02:56:10'),
(101, 'Whats up dog', 13, 4, '2021-11-24 03:04:26'),
(102, 'hello batman', 13, 8, '2021-11-24 03:37:23'),
(103, 'Hello Ember', 8, 13, '2021-11-24 03:38:24'),
(104, 'how are you?', 13, 8, '2021-11-24 03:43:45');

-- --------------------------------------------------------

--
-- Stand-in structure for view `user_search`
--
CREATE TABLE IF NOT EXISTS `user_search` (
`file_path` varchar(200)
,`file_title` varchar(255)
,`id` int(11)
);
-- --------------------------------------------------------

--
-- Structure for view `user_search`
--
DROP TABLE IF EXISTS `user_search`;

CREATE ALGORITHM=UNDEFINED DEFINER=`MeTube_6620_vao3`@`%` SQL SECURITY DEFINER VIEW `user_search` AS select `Multimedia_Files`.`file_path` AS `file_path`,`Multimedia_Files`.`file_title` AS `file_title`,`Multimedia_Files`.`id` AS `id` from `Multimedia_Files` where (`Multimedia_Files`.`category` = 'Nature');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
