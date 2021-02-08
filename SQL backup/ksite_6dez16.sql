-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 06, 2016 at 09:08 PM
-- Server version: 5.7.16-0ubuntu0.16.04.1
-- PHP Version: 7.0.8-0ubuntu0.16.04.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ksite`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `categoryId` int(10) NOT NULL,
  `category` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`categoryId`, `category`) VALUES
(1, 'academic'),
(2, 'personal'),
(3, 'work'),
(5, 'TEST');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `postId` int(255) NOT NULL,
  `dateCreated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dateModified` timestamp NULL,
  `projectId` int(100) NOT NULL,
  `userId` int(100) NOT NULL,
  `title` varchar(30) NOT NULL,
  `content` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`postId`, `dateCreated`, `dateModified`, `projectId`, `userId`, `title`, `content`) VALUES
(1, '2016-11-24 08:56:10', '2016-11-24 08:56:10', 1, 9, 'test', 'tesst'),
(2, '2016-11-24 08:57:51', '2016-11-24 08:58:25', 1, 9, 'now its working', '**good**'),
(3, '2016-11-24 08:59:17', NULL, 1, 10, 'just checking', 'new post from guest'),
(4, '2016-11-24 08:59:36', NULL, 1, 10, 'second post', 'working'),
(5, '2016-11-24 10:16:25', NULL, 2, 9, 'new post in personal', 'work work'),
(6, '2016-11-24 10:37:49', NULL, 3, 9, 'post for project3', 'nice!!'),
(7, '2016-11-25 02:21:53', '2016-12-02 02:53:31', 2, 10, 'please work', '&lt;p&gt;all fixed now&lt;/p&gt;'),
(8, '2016-11-25 03:16:17', '2016-12-02 02:47:57', 1, 10, 'moment of the truth - YES', '&lt;p&gt;working fine&lt;/p&gt;'),
(9, '2016-12-02 01:08:07', NULL, 3, 10, 're checking', '&lt;p&gt;looks like its all &lt;strong&gt;good&lt;/strong&gt;&lt;/p&gt;');

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `projectId` int(100) NOT NULL,
  `category` varchar(15) NOT NULL,
  `title` varchar(20) NOT NULL,
  `summary` varchar(100) NOT NULL,
  `content` varchar(500) NOT NULL,
  `imgPath` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`projectId`, `category`, `title`, `summary`, `content`, `imgPath`) VALUES
(1, 'academic', 'Project 1academic', 'Bring to the table win-win survival strategies.', '&lt;p&gt;Leverage agile frameworks to provide a robust synopsis for high level overviews. Iterative approaches to corporate strategy foster collaborative thinking to further the overall value proposition. Capitalise on low hanging fruit to identify a ballpark value added activity to beta test. Override the digital divide with additional clickthroughs from DevOps. Nanotechnology immersion along the information highway will close the loop on focusing solely on the bottom line.&lt;/p&gt;', 'css/img/projects/img1.jpg'),
(2, 'personal', 'Project 1 personal', 'Bring to the table win-win survival strategies.', '&lt;p&gt;Leverage agile frameworks to provide a robust synopsis for high level overviews. Iterative approaches to corporate strategy foster collaborative thinking to further the overall value proposition. Capitalise on low hanging fruit to identify a ballpark value added activity to beta test. Override the digital divide with additional clickthroughs from DevOps. Nanotechnology immersion along the information highway will close the loop on focusing solely on the bottom line.&lt;/p&gt;', 'css/img/projects/img2.jpg'),
(3, 'work', 'Project 1work', 'Bring to the table win-win survival strategies.', '&lt;p&gt;Leverage agile frameworks to provide a robust synopsis for high level overviews. Iterative approaches to corporate strategy foster collaborative thinking to further the overall value proposition. Capitalise on low hanging fruit to identify a ballpark value added activity to beta test. Override the digital divide with additional clickthroughs from DevOps. Nanotechnology immersion along the information highway will close the loop on focusing solely on the bottom line.&lt;/p&gt;', 'css/img/projects/img3.jpg'),
(4, 'TEST', 'asfas', 'some teset', '&lt;p&gt;good&lt;/p&gt;', 'css/img/projects/projectImg.jpg'),
(5, 'TEST', 'first CRUD insert', 'some teset', 'contentt', 'css/img/projects'),
(6, 'TEST', 'work', 'another new test', '&lt;p&gt;bbbbbbb&lt;/p&gt;', 'css/img/projects/projectImg.jpg'),
(7, 'TEST', 'just to make sure', 'final test', '&lt;p&gt;its &lt;strong&gt;working&lt;/strong&gt;!&lt;/p&gt;', 'css/img/projects/projectImg5.jpg'),
(8, 'TEST', 'okok', 'yessss', '&lt;p&gt;ccccccccc&lt;/p&gt;', 'css/img/projects/projectImg5.jpg'),
(10, 'TEST', 'okokok', 'dddddddd', '&lt;p&gt;dddddddddd&lt;/p&gt;', 'css/img/projects/projectImg.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `projects2`
--

CREATE TABLE `projects2` (
  `projectId` int(100) NOT NULL,
  `category` varchar(15) NOT NULL,
  `title` varchar(20) NOT NULL,
  `summary` varchar(100) NOT NULL,
  `content` varchar(500) NOT NULL,
  `imgPath` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `projects2`
--

INSERT INTO `projects2` (`projectId`, `category`, `title`, `summary`, `content`, `imgPath`) VALUES
(1, 'academic', 'Project 1academic', 'Bring to the table win-win survival strategies.', 'aaaaa', 'css/img/projects/img1.jpg'),
(2, 'personal', 'Project 1 personal', 'Bring to the table win-win survival strategies.', '&lt;p&gt;Leverage agile frameworks to provide a robust synopsis for high level overviews. Iterative approaches to corporate strategy foster collaborative thinking to further the overall value proposition. Capitalise on low hanging fruit to identify a ballpark value added activity to beta test. Override the digital divide with additional clickthroughs from DevOps. Nanotechnology immersion along the information highway will close the loop on focusing solely on the bottom line.&lt;/p&gt;', 'css/img/projects/img2.jpg'),
(3, 'work', 'Project 1work', 'Bring to the table win-win survival strategies.', '&lt;p&gt;Leverage agile frameworks to provide a robust synopsis for high level overviews. Iterative approaches to corporate strategy foster collaborative thinking to further the overall value proposition. Capitalise on low hanging fruit to identify a ballpark value added activity to beta test. Override the digital divide with additional clickthroughs from DevOps. Nanotechnology immersion along the information highway will close the loop on focusing solely on the bottom line.&lt;/p&gt;', 'css/img/projects/img3.jpg'),
(4, 'TEST', 'another CRUD project', 'a', 'ffffff', 'css/img/projects');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userId` int(100) NOT NULL,
  `userType` varchar(10) NOT NULL DEFAULT 'guest',
  `userName` varchar(20) NOT NULL,
  `firstName` varchar(30) NOT NULL,
  `lastName` varchar(30) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(30) NOT NULL,
  `password` char(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userId`, `userType`, `userName`, `firstName`, `lastName`, `phone`, `email`, `password`) VALUES
(9, 'admin', 'k', 'Keiji', 'Maeda', '+01-204-881-4686', 'admin@gmail.com', '$2y$10$7wpFTFw0bAymzUr/pZ7uZ.AYQ3GVgOfteUpbJMg1i1NK.m1aapqIq'),
(10, 'admin', 'a', 'Aya', 'Maeda', '+01-204-881-4686', 'admin@gmail.com', '$2y$10$1pLvfDbkhzRJfZPnIdpK2uZn3KsQS2sgbeF6akSdz3OZvWt0xye6S'),
(12, 'guest', 'guest', 'guest', 'noLastName', '+01-123-123-1234', 'guest@gmail.com', '$2y$10$iYm9zIqWyFK15pUNRST6KurddVZJyoPy9I6DfN.2qbwuQ4fh4VAJW'),
(13, 'guest', 'guest2', 'sasfa', 'noLastName', '+01-123-123-1234', 'guest@gmail.com', '$2y$10$myxjern60wcgy1VkLCCLoeF4KyslpasZCPmAd8Tkt6cZ9.3QFjguS'),
(14, 'guest', 'guest3', 'guest', 'noLastName', '+01-123-123-1234', 'guest@gmail.com', '$2y$10$XIX5rGrEdyImCXE8/Rfq.uLb5P98bOsJ39.ZYtXJdHKfWwTI1osQi'),
(15, 'guest', 'guest4', 'guest', 'noLastName', '+01-123-123-1234', 'guest@gmail.com', '$2y$10$rYbmAbdeMl7mgjdV8pkVEOC1p0ZVm4KPnJtx70nDA1phvxdvYVEZa');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`categoryId`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`postId`),
  ADD KEY `userId` (`userId`),
  ADD KEY `projectId` (`projectId`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`projectId`);

--
-- Indexes for table `projects2`
--
ALTER TABLE `projects2`
  ADD PRIMARY KEY (`projectId`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `categoryId` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `postId` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `projectId` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `projects2`
--
ALTER TABLE `projects2`
  MODIFY `projectId` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userId` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `users` (`userId`),
  ADD CONSTRAINT `posts_project_fk` FOREIGN KEY (`projectId`) REFERENCES `projects` (`projectId`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
