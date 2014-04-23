-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 20, 2013 at 01:49 PM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `evaluation_sys`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `getCourseEval`(IN `eval` INT)
Begin
truncate table total_course_eval;
IF (ceval(eval)) THEN
SELECT * FROM `total_course_eval`;
END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getInstructorEval`(IN `eval` INT)
Begin
truncate table total_course_eval;
IF (ieval(eval)) THEN
SELECT * FROM `total_course_eval`;
END IF;
END$$

--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `ceval`(`var1` INT) RETURNS int(11)
BEGIN

insert into total_course_eval values(var1,(select COUNT(e1)
from course_eval
where e1=1 and eval_id=var1) ,(select COUNT(e1)
from course_eval
where e1=2 and eval_id=var1) ,(select COUNT(e1)
from course_eval
where e1=3 and eval_id=var1) ,(select COUNT(e1)
from course_eval
where e1=4 and eval_id=var1),(select COUNT(e1)
from course_eval
where e1=5 and eval_id=var1));


insert into total_course_eval values(var1,(select COUNT(e2)
from course_eval
where e2=1 and eval_id=var1) ,(select COUNT(e2)
from course_eval
where e2=2 and eval_id=var1) ,(select COUNT(e2)
from course_eval
where e2=3 and eval_id=var1) ,(select COUNT(e2)
from course_eval
where e2=4 and eval_id=var1),(select COUNT(e2)
from course_eval
where e2=5 and eval_id=var1));


insert into total_course_eval values(var1,(select COUNT(e3)
from course_eval
where e3=1 and eval_id=var1) ,(select COUNT(e3)
from course_eval
where e3=2 and eval_id=var1) ,(select COUNT(e3)
from course_eval
where e3=3 and eval_id=var1) ,(select COUNT(e3)
from course_eval
where e3=4 and eval_id=var1),(select COUNT(e3)
from course_eval
where e3=5 and eval_id=var1));


insert into total_course_eval values(var1,(select COUNT(e4)
from course_eval
where e4=1 and eval_id=var1) ,(select COUNT(e4)
from course_eval
where e4=2 and eval_id=var1) ,(select COUNT(e4)
from course_eval
where e4=3 and eval_id=var1) ,(select COUNT(e4)
from course_eval
where e4=4 and eval_id=var1),(select COUNT(e4)
from course_eval
where e4=5 and eval_id=var1));


insert into total_course_eval values(var1,(select COUNT(e5)
from course_eval
where e5=1 and eval_id=var1) ,(select COUNT(e5)
from course_eval
where e5=2 and eval_id=var1) ,(select COUNT(e5)
from course_eval
where e5=3 and eval_id=var1) ,(select COUNT(e5)
from course_eval
where e5=4 and eval_id=var1),(select COUNT(e5)
from course_eval
where e5=5 and eval_id=var1));
return(1);
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `ieval`(`var1` INT) RETURNS int(11)
BEGIN

insert into total_course_eval values(var1,(select COUNT(e1)
from instructor_eval
where e1=1 and eval_id=var1) ,(select COUNT(e1)
from instructor_eval
where e1=2 and eval_id=var1) ,(select COUNT(e1)
from instructor_eval
where e1=3 and eval_id=var1) ,(select COUNT(e1)
from instructor_eval
where e1=4 and eval_id=var1),(select COUNT(e1)
from instructor_eval
where e1=5 and eval_id=var1));

insert into total_course_eval values(var1,(select COUNT(e2)
from instructor_eval
where e2=1 and eval_id=var1) ,(select COUNT(e2)
from instructor_eval
where e2=2 and eval_id=var1) ,(select COUNT(e2)
from instructor_eval
where e2=3 and eval_id=var1) ,(select COUNT(e2)
from instructor_eval
where e2=4 and eval_id=var1),(select COUNT(e2)
from instructor_eval
where e2=5 and eval_id=var1));

insert into total_course_eval values(var1,(select COUNT(e3)
from instructor_eval
where e3=1 and eval_id=var1) ,(select COUNT(e3)
from instructor_eval
where e3=2 and eval_id=var1) ,(select COUNT(e3)
from instructor_eval
where e3=3 and eval_id=var1) ,(select COUNT(e3)
from instructor_eval
where e3=4 and eval_id=var1),(select COUNT(e3)
from instructor_eval
where e3=5 and eval_id=var1));

insert into total_course_eval values(var1,(select COUNT(e4)
from instructor_eval
where e4=1 and eval_id=var1) ,(select COUNT(e4)
from instructor_eval
where e4=2 and eval_id=var1) ,(select COUNT(e4)
from instructor_eval
where e4=3 and eval_id=var1) ,(select COUNT(e4)
from instructor_eval
where e4=4 and eval_id=var1),(select COUNT(e4)
from instructor_eval
where e4=5 and eval_id=var1));

insert into total_course_eval values(var1,(select COUNT(e5)
from instructor_eval
where e5=1 and eval_id=var1) ,(select COUNT(e5)
from instructor_eval
where e5=2 and eval_id=var1) ,(select COUNT(e5)
from instructor_eval
where e5=3 and eval_id=var1) ,(select COUNT(e5)
from instructor_eval
where e5=4 and eval_id=var1),(select COUNT(e5)
from instructor_eval
where e5=5 and eval_id=var1));
return(1);
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(40) NOT NULL,
  `password` varchar(40) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'admin', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE IF NOT EXISTS `course` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL,
  `code` varchar(10) NOT NULL,
  `isdeleted` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`),
  KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`id`, `name`, `code`, `isdeleted`) VALUES
(1, 'C++', 'cpp/100', '0'),
(2, 'PHP', 'php/300', '0'),
(3, 'shell scripting', 'shc/100', '0'),
(4, 'javascript', 'js/200', '0'),
(5, 'usablility', 'usab/300', '0'),
(6, 'design patterns', 'dp/500', '0'),
(7, 'JSP', 'jsp/200', '0'),
(8, 'java', 'java/600', '0'),
(9, 'usablility_alex', '        us', '0');

-- --------------------------------------------------------

--
-- Table structure for table `course_eval`
--

CREATE TABLE IF NOT EXISTS `course_eval` (
  `student_id` int(11) NOT NULL,
  `eval_id` int(11) NOT NULL,
  `e1` enum('1','2','3','4','5') NOT NULL,
  `e2` enum('1','2','3','4','5') NOT NULL,
  `e3` enum('1','2','3','4','5') NOT NULL,
  `e4` enum('1','2','3','4','5') NOT NULL,
  `e5` enum('1','2','3','4','5') NOT NULL,
  `comment` varchar(200) DEFAULT NULL,
  `late` int(1) unsigned NOT NULL DEFAULT '0' COMMENT 'field indicates if the student fill evaluation late(1) or on time(0)',
  PRIMARY KEY (`student_id`,`eval_id`),
  KEY `eval_id` (`eval_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `course_eval`
--

INSERT INTO `course_eval` (`student_id`, `eval_id`, `e1`, `e2`, `e3`, `e4`, `e5`, `comment`, `late`) VALUES
(4, 45, '2', '2', '2', '3', '3', NULL, 1),
(19, 46, '4', '3', '1', '3', '2', NULL, 1),
(28, 46, '1', '1', '2', '2', '2', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `evaluation`
--

CREATE TABLE IF NOT EXISTS `evaluation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `intake_id` int(10) NOT NULL,
  `track_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `due_date` text NOT NULL,
  `active` enum('activated','deactivated') NOT NULL DEFAULT 'activated',
  PRIMARY KEY (`id`),
  KEY `track_id` (`track_id`),
  KEY `course_id` (`course_id`),
  KEY `intake_id` (`intake_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=50 ;

--
-- Dumping data for table `evaluation`
--

INSERT INTO `evaluation` (`id`, `intake_id`, `track_id`, `course_id`, `due_date`, `active`) VALUES
(45, 1, 1, 7, '25-03-2013', 'activated'),
(46, 1, 1, 2, '24-04-2013', 'activated'),
(48, 1, 1, 8, '18-03-2013', 'activated'),
(49, 1, 1, 8, '18-03-2013', 'activated');

-- --------------------------------------------------------

--
-- Table structure for table `eval_inst_evtable`
--

CREATE TABLE IF NOT EXISTS `eval_inst_evtable` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `eval_id` int(11) NOT NULL,
  `inst_id` int(11) NOT NULL,
  `scope` enum('lec','lab') NOT NULL,
  PRIMARY KEY (`id`),
  KEY `eval_id` (`eval_id`),
  KEY `eval_id_2` (`eval_id`),
  KEY `inst_id` (`inst_id`),
  KEY `scope` (`scope`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=46 ;

--
-- Dumping data for table `eval_inst_evtable`
--

INSERT INTO `eval_inst_evtable` (`id`, `eval_id`, `inst_id`, `scope`) VALUES
(38, 45, 9, 'lec'),
(39, 45, 8, 'lab'),
(40, 46, 5, 'lec'),
(41, 46, 1, 'lab'),
(42, 48, 3, 'lec'),
(43, 48, 1, 'lab'),
(44, 49, 3, 'lec'),
(45, 49, 1, 'lab');

-- --------------------------------------------------------

--
-- Table structure for table `instructor`
--

CREATE TABLE IF NOT EXISTS `instructor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL,
  `title` enum('eng','dr') NOT NULL DEFAULT 'eng',
  `work` enum('0','1') NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `instructor`
--

INSERT INTO `instructor` (`id`, `name`, `title`, `work`) VALUES
(1, 'mahmoud ouf', 'eng', '1'),
(2, 'nuha amer', 'eng', '1'),
(3, 'ahmed salem', 'eng', '1'),
(4, 'Ahmed Lotfy', 'dr', '0'),
(5, 'Ahmed Gnidy', 'eng', '1'),
(6, 'Marwa', 'dr', '1'),
(7, 'Shaimaa', 'eng', '1'),
(8, 'Joliee Iskandar', 'eng', '1'),
(9, 'Mohsen Diab', 'eng', '1');

-- --------------------------------------------------------

--
-- Table structure for table `instructor_eval`
--

CREATE TABLE IF NOT EXISTS `instructor_eval` (
  `student_id` int(11) NOT NULL,
  `eval_id` int(11) NOT NULL,
  `e1` enum('1','2','3','4','5') NOT NULL,
  `e2` enum('1','2','3','4','5') NOT NULL,
  `e3` enum('1','2','3','4','5') NOT NULL,
  `e4` enum('1','2','3','4','5') NOT NULL,
  `e5` enum('1','2','3','4','5') NOT NULL,
  `comment` varchar(200) DEFAULT NULL,
  `late` int(1) unsigned NOT NULL DEFAULT '0' COMMENT 'late=0 for evaluation before due date, =1 for late evaluations',
  PRIMARY KEY (`student_id`,`eval_id`),
  KEY `eval_id` (`eval_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `instructor_eval`
--

INSERT INTO `instructor_eval` (`student_id`, `eval_id`, `e1`, `e2`, `e3`, `e4`, `e5`, `comment`, `late`) VALUES
(20, 38, '3', '4', '1', '3', '3', NULL, 0),
(23, 38, '5', '2', '2', '2', '3', NULL, 1),
(23, 39, '3', '3', '3', '2', '3', NULL, 1),
(24, 38, '2', '1', '2', '3', '4', NULL, 0),
(28, 40, '4', '5', '2', '2', '2', NULL, 0),
(28, 41, '4', '4', '1', '1', '2', NULL, 0),
(33, 39, '4', '2', '2', '1', '2', NULL, 0),
(36, 38, '4', '1', '4', '1', '1', NULL, 0),
(36, 39, '1', '2', '3', '3', '4', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `intake`
--

CREATE TABLE IF NOT EXISTS `intake` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `intake_no` varchar(40) NOT NULL,
  `year` year(4) NOT NULL DEFAULT '2000',
  `current` enum('0','1') NOT NULL COMMENT 'current = 1 for current intake(set by the admin), else current=0',
  `isdeleted` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'field indicates if the intake is deleted by the admin or not',
  PRIMARY KEY (`id`),
  UNIQUE KEY `intake_no` (`intake_no`),
  UNIQUE KEY `year` (`year`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `intake`
--

INSERT INTO `intake` (`id`, `intake_no`, `year`, `current`, `isdeleted`) VALUES
(1, '33', 2013, '1', '0'),
(2, '32', 2012, '0', '0'),
(3, '31', 2011, '0', '0'),
(9, '35', 2000, '0', '1'),
(12, '28', 2009, '0', '0'),
(13, '36', 2016, '0', '0'),
(14, '40', 2022, '0', '0');

-- --------------------------------------------------------

--
-- Stand-in structure for view `myview`
--
CREATE TABLE IF NOT EXISTS `myview` (
`e1` bigint(21)
,`e2` bigint(21)
,`e3` bigint(21)
,`e4` bigint(21)
,`e5` bigint(21)
,`total` double
);
-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE IF NOT EXISTS `student` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL,
  `username` varchar(25) NOT NULL COMMENT 'username of student',
  `password` varchar(40) NOT NULL DEFAULT '123',
  `track_id` int(11) NOT NULL DEFAULT '0',
  `intake_id` int(11) NOT NULL DEFAULT '0',
  `isdeleted` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  KEY `track_id` (`track_id`),
  KEY `intake_id` (`intake_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=38 ;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`id`, `name`, `username`, `password`, `track_id`, `intake_id`, `isdeleted`) VALUES
(3, 'Ahmed Habib', 'ahmedhabib', '456', 2, 1, '0'),
(4, 'FaragShokry', 'farag', '123', 1, 12, '0'),
(13, 'Mohammed Ibrahim', 'mohammedibrahim', '123', 2, 1, '0'),
(17, 'nehal', 'nehal', '123', 3, 1, '0'),
(19, 'Mohammed Abdelsalam', 'abdelsalam', '123', 1, 1, '0'),
(20, 'Heba Tarek', 'hebatarek', '123', 1, 1, '0'),
(23, 'Baragash', 'baragash', '123', 1, 1, '0'),
(24, 'Mohammed Abdo', 'mohammedabdo', '123', 1, 1, '0'),
(25, 'Ahmed Eid', 'ahmedeid', '123', 2, 1, '0'),
(28, 'Kareem Kamal', 'kemo', '123', 1, 1, '0'),
(29, 'Sara', 'sara', '123', 1, 1, '0'),
(31, 'Sara Adel', 'saraadel', '123', 1, 1, '0'),
(33, 'Mina Atef', 'mina', '123', 1, 1, '0'),
(34, 'Ahmed Yehia', 'ahmedyehia', '123', 1, 1, '0'),
(35, 'Khaled Ali', 'khaled', '123', 1, 1, '0'),
(36, 'Hassan', 'hassan', '123', 1, 1, '0'),
(37, 'Hamdy', 'hamdy', '123', 13, 1, '0');

-- --------------------------------------------------------

--
-- Table structure for table `total_course_eval`
--

CREATE TABLE IF NOT EXISTS `total_course_eval` (
  `eval_id` int(11) NOT NULL,
  `1` enum('1','2','3','4','5') NOT NULL,
  `2` enum('1','2','3','4','5') NOT NULL,
  `3` enum('1','2','3','4','5') NOT NULL,
  `4` enum('1','2','3','4','5') NOT NULL,
  `5` enum('1','2','3','4','5') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `total_course_eval`
--

INSERT INTO `total_course_eval` (`eval_id`, `1`, `2`, `3`, `4`, `5`) VALUES
(39, '1', '', '1', '1', ''),
(39, '', '2', '1', '', ''),
(39, '', '1', '2', '', ''),
(39, '1', '1', '1', '', ''),
(39, '', '1', '1', '1', '');

-- --------------------------------------------------------

--
-- Table structure for table `track`
--

CREATE TABLE IF NOT EXISTS `track` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL,
  `supervisor_id` int(11) DEFAULT NULL COMMENT 'id of track supervisor',
  `isdeleted` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `track`
--

INSERT INTO `track` (`id`, `name`, `supervisor_id`, `isdeleted`) VALUES
(1, 'open source', 2, '0'),
(2, 'unix administration', 3, '1'),
(3, 'user interface alex branch', 7, '0'),
(13, 'Embeded', 1, '0');

--
-- Triggers `track`
--
DROP TRIGGER IF EXISTS `trackIntakeLink`;
DELIMITER //
CREATE TRIGGER `trackIntakeLink` AFTER INSERT ON `track`
 FOR EACH ROW BEGIN
    INSERT INTO track_intake SET track_id = NEW.id,
    intake_id=(select id from intake where current='1');   
  END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `track_intake`
--

CREATE TABLE IF NOT EXISTS `track_intake` (
  `track_id` int(11) NOT NULL,
  `intake_id` int(11) NOT NULL,
  PRIMARY KEY (`track_id`,`intake_id`),
  KEY `intake_id` (`intake_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `track_intake`
--

INSERT INTO `track_intake` (`track_id`, `intake_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(13, 1);

-- --------------------------------------------------------

--
-- Structure for view `myview`
--
DROP TABLE IF EXISTS `myview`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `myview` AS select count(`instructor_eval`.`e1`) AS `e1`,count(`instructor_eval`.`e2`) AS `e2`,count(`instructor_eval`.`e3`) AS `e3`,count(`instructor_eval`.`e4`) AS `e4`,count(`instructor_eval`.`e5`) AS `e5`,(((((`instructor_eval`.`e1` * 1) + (`instructor_eval`.`e2` * 2)) + (`instructor_eval`.`e3` * 3)) + (`instructor_eval`.`e4` * 4)) + (`instructor_eval`.`e5` * 5)) AS `total` from `instructor_eval`;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `course_eval`
--
ALTER TABLE `course_eval`
  ADD CONSTRAINT `course_eval_ibfk_5` FOREIGN KEY (`eval_id`) REFERENCES `evaluation` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `course_eval_ibfk_7` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `evaluation`
--
ALTER TABLE `evaluation`
  ADD CONSTRAINT `evaluation_ibfk_4` FOREIGN KEY (`track_id`) REFERENCES `track` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `evaluation_ibfk_8` FOREIGN KEY (`course_id`) REFERENCES `course` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `evaluation_ibfk_9` FOREIGN KEY (`intake_id`) REFERENCES `intake` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `eval_inst_evtable`
--
ALTER TABLE `eval_inst_evtable`
  ADD CONSTRAINT `eval_inst_evtable_ibfk_1` FOREIGN KEY (`eval_id`) REFERENCES `evaluation` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `eval_inst_evtable_ibfk_2` FOREIGN KEY (`inst_id`) REFERENCES `instructor` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `instructor_eval`
--
ALTER TABLE `instructor_eval`
  ADD CONSTRAINT `instructor_eval_ibfk_7` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `instructor_eval_ibfk_8` FOREIGN KEY (`eval_id`) REFERENCES `eval_inst_evtable` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `student_ibfk_7` FOREIGN KEY (`track_id`) REFERENCES `track` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `student_ibfk_8` FOREIGN KEY (`intake_id`) REFERENCES `intake` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `track_intake`
--
ALTER TABLE `track_intake`
  ADD CONSTRAINT `track_intake_ibfk_4` FOREIGN KEY (`track_id`) REFERENCES `track` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `track_intake_ibfk_6` FOREIGN KEY (`intake_id`) REFERENCES `intake` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
