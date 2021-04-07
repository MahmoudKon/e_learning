-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 06, 2021 at 09:39 PM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 7.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `e_learning`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `CartID` int(11) NOT NULL,
  `User_ID` int(11) NOT NULL,
  `CourseID` int(11) NOT NULL,
  `Date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`CartID`, `User_ID`, `CourseID`, `Date`) VALUES
(1, 14, 41, '2019-04-29'),
(2, 14, 42, '2019-04-29'),
(4, 1, 42, '2019-04-30'),
(6, 18, 45, '2019-05-03'),
(7, 1, 41, '2019-05-15'),
(8, 1, 48, '2019-06-18'),
(9, 20, 41, '2019-06-18'),
(10, 1, 55, '2021-03-03');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `ID` int(11) NOT NULL,
  `Name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Description` text COLLATE utf8_unicode_ci NOT NULL,
  `Ordering` int(11) DEFAULT NULL,
  `Visibility` varchar(255) COLLATE utf8_unicode_ci DEFAULT 'yes',
  `Comments` varchar(255) COLLATE utf8_unicode_ci DEFAULT 'yes',
  `Ads` varchar(255) COLLATE utf8_unicode_ci DEFAULT 'yes'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`ID`, `Name`, `Description`, `Ordering`, `Visibility`, `Comments`, `Ads`) VALUES
(1, 'Development', 'For All Developers', 1, '1', NULL, NULL),
(2, 'Business', 'This Track For Communication', 2, '0', '0', '0'),
(3, 'IT & Software', 'This Track For Network & Security', 3, '0', '0', '0'),
(4, 'Design', 'This Track For Web Design', 4, '0', '0', '0'),
(5, 'Marketing', 'This Track For Digital Marketing', 5, '0', '0', '0'),
(6, 'Teaching & Academies', 'This Track For Teacher Training', 6, '0', '0', '0');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `Comment_ID` int(11) NOT NULL,
  `Comment` text NOT NULL,
  `Status` tinyint(4) NOT NULL DEFAULT 0,
  `Comment_Date` date NOT NULL,
  `Course_ID` int(11) NOT NULL,
  `User_ID` int(11) NOT NULL,
  `Video_List_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`Comment_ID`, `Comment`, `Status`, `Comment_Date`, `Course_ID`, `User_ID`, `Video_List_ID`) VALUES
(3, 'good', 0, '2019-05-04', 40, 1, 22),
(4, 'that&#39;s good', 0, '2019-06-18', 42, 1, 22),
(5, 'test', 0, '2019-06-18', 42, 20, 36),
(6, 'test', 0, '2019-06-19', 42, 20, 20);

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `Course_ID` int(11) NOT NULL,
  `Name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Course_Describe` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `Rating` tinyint(10) NOT NULL DEFAULT 1,
  `Price` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `Tags` text COLLATE utf8_unicode_ci NOT NULL,
  `Registered` int(11) NOT NULL DEFAULT 1,
  `Img` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `Add-Date` date NOT NULL,
  `Status` varchar(255) COLLATE utf8_unicode_ci DEFAULT 'Continuous',
  `Categories_ID` int(11) NOT NULL,
  `User_ID` int(11) NOT NULL,
  `Country` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Approve` tinyint(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`Course_ID`, `Name`, `Course_Describe`, `Rating`, `Price`, `Tags`, `Registered`, `Img`, `Add-Date`, `Status`, `Categories_ID`, `User_ID`, `Country`, `Approve`) VALUES
(40, 'Course 1', 'This Track For Communication', 0, '0', 'free', 0, 'files/images-items/forms.jpg', '2019-04-28', 'Continuous', 3, 1, 'Egypt', 1),
(41, 'programing', 'You Will Be a Good Teacher', 0, '5', 'test', 0, 'files/images-items/forms.jpg', '2019-04-28', 'Continuous', 4, 1, 'Egypt', 1),
(42, 'Course 3', 'You Will Be a Good ', 0, '12', 'test', 0, 'files/images-items/gallery_1_large.jpg', '2019-04-28', 'Continuous', 1, 1, 'Egypt', 1),
(44, 'Teaching', 'You Will Be a Good Teacher', 0, '0', 'free', 0, 'files/images-items/blog_5.jpg', '2019-04-30', 'Continuous', 6, 14, 'Egypt', 1),
(45, 'DeltaLearning', 'You Will Be a Good Teacher', 0, '12', '', 0, 'files/images-items/carousel_2.jpg', '2019-04-30', 'Finished', 5, 14, 'Egypt', 1),
(48, 'any course', 'You Will Be a Good Teacher', 0, '10', 'free', 0, 'files/images-items/course_image.jpg', '2019-05-04', 'Finished', 1, 1, 'Egypt', 1),
(50, 'anyname', 'any description', 0, '10', 'any', 0, 'files/images-items/about_1.jpg', '2019-06-18', 'Finished', 3, 1, 'Egypt', 1),
(51, 'sdfasdf', 'sadfsdfasdf', 0, '10', 'any', 0, 'files/images-items/about_2.jpg', '2019-06-18', 'Finished', 4, 1, 'dafasdf', 1),
(52, 'test', 'adfsadfasdfasdfasd', 0, '12', 'test', 0, 'files/images-items/blog_2.jpg', '2019-06-19', 'Finished', 5, 20, 'Egypt', 0),
(53, 'Course For Test', 'any Test Description', 0, '', 'test', 0, 'files/images-items/comment_1.jpg', '2019-06-19', 'Continuous', 5, 1, 'Egypt', 1),
(54, 'sadfasdf', 'sdasdf', 0, '2', 'sdf', 0, 'files/images-items/blog_1.jpg', '2019-06-19', 'Continuous', 2, 22, 'sdaf', 0),
(55, 'Justina Chapman', 'Justina ChapmanJustina ChapmanJustina ChapmanJustina ChapmanJustina Chapman', 1, '0', 'test', 1, 'files/images-items/comment_3.jpg', '2021-03-03', 'Continuous', 1, 1, 'egypt', 1),
(56, 'test course', 'this course for test', 1, '0', 'test', 1, 'files/images-items/shutterstock_554314555_copy.jpg', '2021-04-06', 'Continuous', 1, 1, 'egypt', 1);

-- --------------------------------------------------------

--
-- Table structure for table `course_comment`
--

CREATE TABLE `course_comment` (
  `CommentID` int(11) NOT NULL,
  `Comment` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `Date` date NOT NULL,
  `User_ID` int(11) NOT NULL,
  `Course_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `course_comment`
--

INSERT INTO `course_comment` (`CommentID`, `Comment`, `Date`, `User_ID`, `Course_ID`) VALUES
(10, 'good', '2019-05-03', 1, 42),
(12, 'that&#39;s good', '2019-05-03', 1, 42),
(16, 'good', '2019-06-18', 1, 48),
(17, 'Hello', '2019-06-18', 20, 41);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `PostID` int(11) NOT NULL,
  `Post_Title` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `Post_Description` text COLLATE utf8_unicode_ci NOT NULL,
  `Post_Tags` text COLLATE utf8_unicode_ci NOT NULL,
  `Post_Date` date NOT NULL,
  `Post_File` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `Post_Like` int(11) NOT NULL DEFAULT 0,
  `User_ID` int(11) NOT NULL,
  `Cat_ID` int(11) NOT NULL,
  `Post_Approve` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`PostID`, `Post_Title`, `Post_Description`, `Post_Tags`, `Post_Date`, `Post_File`, `Post_Like`, `User_ID`, `Cat_ID`, `Post_Approve`) VALUES
(1, 'This IS Title', 'This IS Description \" Lorem ipsum dolor sit, amet consectetur adipisicing elit. Quos, natus molestiae? Soluta necessitatibus quam quasi dolore sunt accusamus, hic sint explicabo, modi illum molestiae facilis, natus cumque amet iste praesentium. \"', 'php,css,js', '2019-04-16', 'files/images-posts/profile.png', 13, 1, 1, 1),
(9, 'asf  sdf as f asdf asf adsf asdf asdf dsa f', 'asf  sdf as f asdf asf adsf asdf asdf dsa f', 'adsf,asdf,asdfasd', '2019-04-18', 'files/images-posts/profile.png', 0, 1, 1, 1),
(10, 'koko koko koko koko koko koko koko koko koko koko koko koko ', 'koko koko koko koko koko koko koko koko koko koko koko koko koko koko koko koko koko koko koko koko koko koko koko koko ', 'koko,koky', '2019-04-18', 'files/images-posts/profile.png', 1, 1, 1, 1),
(15, 'This IS First Post To Me ', 'This IS First Post To Me This IS First Post To Me This IS First Post To Me This IS First Post To Me This IS First Post To Me This IS First Post To Me This IS First Post To Me This IS First Post To Me This IS First Post To Me This IS First Post To Me This IS First Post To Me This IS First Post To Me This IS First Post To Me This IS First Post To Me This IS First Post To Me This IS First Post To Me This IS First Post To Me This IS First Post To Me This IS First Post To Me ', 'Hello', '2019-04-19', 'files/images-posts/profile.png', 0, 1, 2, 1),
(16, 'Cuting a String in PHP ??!!!', 'i have a string . Sometimes it is longer than 50 chars, Sometimes shorter. IF it is longer i want to cut it, if possible??', 'FAQS', '2019-04-21', '', 1, 1, 1, 1),
(36, 'Ajax - Sending input file and additional variable to php file through ajax', '\n\nI&#39;m trying to send input file and input text through ajax. Because I&#39;ll add this feature to my existing function that has plenty of other variables I cannot simply use sending the entire Form like the one used here ', 'ajax', '2019-05-03', 'images/blog_single.jpg', 0, 1, 1, 1),
(37, 'Test Post', 'This Is Test Description', 'TagName', '2019-06-18', '', 0, 1, 5, 1),
(55, 'Admin', 'Admin Text', 'Admin', '2019-06-19', '', 0, 1, 4, 1),
(56, 'Dolore deserunt illo ', 'Dolore deserunt illo Dolore deserunt illo Dolore deserunt illo Dolore deserunt illo Dolore deserunt illo ', 'test', '2021-04-06', NULL, 0, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `post_comments`
--

CREATE TABLE `post_comments` (
  `Post_ComentsID` int(11) NOT NULL,
  `Post_Comment_Desc` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `Post_Comment_Date` date NOT NULL,
  `User_ID` int(11) DEFAULT NULL,
  `Post_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `post_comments`
--

INSERT INTO `post_comments` (`Post_ComentsID`, `Post_Comment_Desc`, `Post_Comment_Date`, `User_ID`, `Post_ID`) VALUES
(1, 'what\'s????', '2019-04-17', 1, 1),
(2, 'go to hell', '2019-04-17', 1, 1),
(7, 'test', '2019-04-18', 1, 10),
(19, 'add comment', '2019-05-03', 1, 36),
(20, ' good', '2019-05-03', 1, 36),
(21, 'thanks for this post', '2019-05-04', 1, 36),
(22, 'w0w\n', '2019-06-18', 1, 36),
(23, 'Good', '2019-06-18', 1, 37),
(24, 'hello', '2019-06-18', 20, 1),
(26, 'fgdfg', '2021-03-03', 1, 36);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL,
  `UserName` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `NickName` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `Password` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `FullName` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `Email` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `Gender` varchar(255) COLLATE utf8_unicode_ci DEFAULT 'male',
  `Country` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Phone` int(255) NOT NULL,
  `Admin` int(11) DEFAULT 0,
  `Date` date DEFAULT NULL,
  `Regstatus` varchar(255) COLLATE utf8_unicode_ci DEFAULT '0',
  `UserImage` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `UserName`, `NickName`, `Password`, `FullName`, `Email`, `Gender`, `Country`, `Phone`, `Admin`, `Date`, `Regstatus`, `UserImage`) VALUES
(1, 'Mahmoud', 'Mahmoud', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'Mahmoud Mohammed', 'M_M@yahoo.com', 'male', 'Egypt', 1156455369, 1, '2019-03-21', '1', 'files/images-users/banner.jpg'),
(3, 'Abanoub', NULL, '96C9EA1E0E0F29479FC4B97D9CFBB79B382DAE5E', 'Abanub Magdi', 'Abanoub_Magdi@yahoo.com', 'male', 'Egypt', 12312344, 1, '2019-03-24', '1', ''),
(4, 'hello', NULL, 'aaf4c61ddcc5e8a2dabede0f3b482cd9aea9434d', 'Abanub Magdi', 'mahmoud_mohammed0123@yahoo.com', 'male', '', 0, 0, '2019-03-26', '1', ''),
(7, 'mostafa', NULL, '4755bfab4052cc27342fd251db714407b842eef3', 'Mahmou', 'mahmoud1_mohammed050@yahoo.com', 'male', '', 0, 0, '2019-03-26', '1', ''),
(8, 'mohammed', NULL, '4abf9d4e9fb909a6b0c1689ab80ea0e519567492', 'mohammed Aowud', 'mohammed_mohammed@yahoo.com', 'male', 'Egypt', 123456789, 0, '2019-03-29', '1', 'images/blog_2.jpg'),
(12, 'Magdi', NULL, '0f3f9e35cd5fa9795f1c02f6979c7ef6834360bd', 'Magdi Mohammed', 'magdi_famous@yahoo.com', 'male', 'Egypt', 123456789, 0, '2019-04-10', '1', 'files/images-users/about_1.jpg'),
(14, 'sasaa', NULL, '0f3f9e35cd5fa9795f1c02f6979c7ef6834360bd', 'sasaa sasaa', 'sasaa_sasaa@yahoo.com', 'male', 'Egypt', 123123132, 1, '2019-04-28', '1', 'files/images-users/team_4.jpg'),
(15, 'hhhhhhh', NULL, '70b90b85b9ed58940f34338b0816c877153e67e6', 'mahmoud mohamed', 'mahmoud_mohammed050@yahoo.com', 'female', 'Egypt', 32, 1, '2019-04-28', '1', 'files/images-users/gallery_2.jpg'),
(16, 'hhhhhhhhhhh', NULL, '0F3F9E35CD5FA9795F1C02F6979C7EF6834360BD', 'mahmoud mohamed', 'mahmoud_mohammed050@yahoo.com', 'male', 'Egypt', 2134124, 1, '2019-04-28', '1', 'files/images-users/me7.jpg'),
(17, 'sososo', 'adfasfsdf', '745f9202e2b7a5f6a3abca909746d615092bc215', 'sososo', 'sdfads@sdgfasdf', 'male', 'Egypt', 30, 0, '2019-05-01', '1', 'files/images-users/carousel_1.jpg'),
(18, 'testt', 'Mahmoud123', '453cf2486f88c411f9ad608b563aef965cedb15d', 'mahmoud', 'mahmoud_mohammed050@yahoo.com', 'male', 'Egypt', 2147483647, 0, '2019-05-03', '1', 'files/images-users/blog_1.jpg'),
(20, 'UserTest', 'HeroForEver', '601f1889667efaebb33b8c12572835da3f027f78', 'mahmoud', 'mo_Salah@yahoo.com', 'male', 'Egypt', 2147483612, 0, '2019-06-18', '1', 'files/images-users/banner_1.jpg'),
(21, 'asdfasdf', 'asdfasdf', 'f4542db9ba30f7958ae42c113dd87ad21fb2eddb', 'qweqew', 'mahmoud_mohammed050@yahoo.com', 'male', 'adadsa', 132123123, 1, '2019-06-19', '1', 'files/images-users/blog_1.jpg'),
(23, 'action', 'action', '34eb4c4ef005207e8b8f916b9f1fffacccd6945e', 'sdfasdfads', 'mahmoud_mohammed050@yahoo.com', 'female', 'Egypt', 123123123, 1, '2019-06-19', '1', 'files/images-users/banner_1.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `video_list`
--

CREATE TABLE `video_list` (
  `Video_ID` int(11) NOT NULL,
  `Video_Name` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `Video_Src` text COLLATE utf8_unicode_ci NOT NULL,
  `Video_Desc` text COLLATE utf8_unicode_ci NOT NULL,
  `Video_Date` date NOT NULL,
  `User_ID` int(11) NOT NULL,
  `Course_ID` int(11) NOT NULL,
  `Cat_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `video_list`
--

INSERT INTO `video_list` (`Video_ID`, `Video_Name`, `Video_Src`, `Video_Desc`, `Video_Date`, `User_ID`, `Course_ID`, `Cat_ID`) VALUES
(20, 'mony', 'files/videos/chapter2.mp4', 'anytext', '2019-04-30', 1, 42, 2),
(22, 'DeltaLearning', 'files/videos/chapter3.mp4', 'You Will Be a Good Teacher', '2019-04-30', 1, 42, 2),
(24, 'asdfasdf', 'files/videos/chapter4.mp4', 'asdfasdf', '2019-04-30', 1, 42, 2),
(33, 'any text', 'files/videos/chapter3.mp4', 'I&#39;m Forgot The Name of This Anime', '2019-05-04', 1, 48, 2),
(35, 'ant title', 'files/videos/chapter2.mp4', 'sfsdfsdf', '2019-06-18', 1, 41, 1),
(36, 'asdasd', 'files/videos/chapter2.mp4', 'asdasd', '2019-06-18', 1, 42, 6),
(47, 'Registered', 'files/videos/2db7abbadb0447709b8d49640c62011a.mp4', 'Registered Registered ', '2021-03-03', 1, 41, 1),
(48, 'title test', 'files/videos/Pexels Videos 1437396.mp4', 'description test', '2021-04-06', 1, 56, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`CartID`),
  ADD KEY `CourseWithCard` (`CourseID`),
  ADD KEY `UserWithCard` (`User_ID`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `Name` (`Name`),
  ADD UNIQUE KEY `Ordering` (`Ordering`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`Comment_ID`),
  ADD KEY `Course_Comment` (`Course_ID`),
  ADD KEY `Comment_User` (`User_ID`),
  ADD KEY `Video-Comments` (`Video_List_ID`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`Course_ID`);

--
-- Indexes for table `course_comment`
--
ALTER TABLE `course_comment`
  ADD PRIMARY KEY (`CommentID`),
  ADD KEY `Comm-Course` (`Course_ID`),
  ADD KEY `Comm-User` (`User_ID`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`PostID`),
  ADD KEY `PostWithCat` (`Cat_ID`),
  ADD KEY `User_ID` (`User_ID`);

--
-- Indexes for table `post_comments`
--
ALTER TABLE `post_comments`
  ADD PRIMARY KEY (`Post_ComentsID`),
  ADD KEY `Post_ID` (`Post_ID`),
  ADD KEY `User_ID` (`User_ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`,`Phone`),
  ADD UNIQUE KEY `UserName` (`UserName`);

--
-- Indexes for table `video_list`
--
ALTER TABLE `video_list`
  ADD PRIMARY KEY (`Video_ID`),
  ADD KEY `Cat_ID-To-Categories-ID` (`Cat_ID`),
  ADD KEY `Course_ID-Relation` (`Course_ID`),
  ADD KEY `User_ID-Relation-USERID` (`User_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `CartID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `Comment_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `Course_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `course_comment`
--
ALTER TABLE `course_comment`
  MODIFY `CommentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `PostID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `post_comments`
--
ALTER TABLE `post_comments`
  MODIFY `Post_ComentsID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `video_list`
--
ALTER TABLE `video_list`
  MODIFY `Video_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `CourseWithCard` FOREIGN KEY (`CourseID`) REFERENCES `courses` (`Course_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `Comment_User` FOREIGN KEY (`User_ID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Course_Comment` FOREIGN KEY (`Course_ID`) REFERENCES `courses` (`Course_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Video-Comments` FOREIGN KEY (`Video_List_ID`) REFERENCES `video_list` (`Video_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `course_comment`
--
ALTER TABLE `course_comment`
  ADD CONSTRAINT `Comm-Course` FOREIGN KEY (`Course_ID`) REFERENCES `courses` (`Course_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Comm-User` FOREIGN KEY (`User_ID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `PostWithCat` FOREIGN KEY (`Cat_ID`) REFERENCES `categories` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `post_comments`
--
ALTER TABLE `post_comments`
  ADD CONSTRAINT `post_comments_ibfk_1` FOREIGN KEY (`Post_ID`) REFERENCES `posts` (`PostID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `post_comments_ibfk_2` FOREIGN KEY (`User_ID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `video_list`
--
ALTER TABLE `video_list`
  ADD CONSTRAINT `Cat_ID-To-Categories-ID` FOREIGN KEY (`Cat_ID`) REFERENCES `categories` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Course_ID-Relation` FOREIGN KEY (`Course_ID`) REFERENCES `courses` (`Course_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `User_ID-Relation-USERID` FOREIGN KEY (`User_ID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
