/*
Population script
Populates DB2 with at least 10 figures in each thing
*/
/*
 Navicat MySQL Data Transfer

 Source Server         : localhost_3306
 Source Server Type    : MySQL
 Source Server Version : 100137
 Source Host           : localhost:3306
 Source Schema         : db2

 Target Server Type    : MySQL
 Target Server Version : 100137
 File Encoding         : 65001

 Date: 2/17/2020 10:20:16
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;


DROP TABLE IF EXISTS `enroll`;
DROP TABLE IF EXISTS `enroll2`;
DROP TABLE IF EXISTS `assign`;
DROP TABLE IF EXISTS `mentors`;
DROP TABLE IF EXISTS `mentees`;
DROP TABLE IF EXISTS `material`;
DROP TABLE IF EXISTS `meetings`;
DROP TABLE IF EXISTS `time_slot`;
DROP TABLE IF EXISTS `groups`;
DROP TABLE IF EXISTS `admins`;
DROP TABLE IF EXISTS `students`;
DROP TABLE IF EXISTS `parents`;
DROP TABLE IF EXISTS `users`;

-- ----------------------------
-- Table structure for users
-- ----------------------------

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Data for users
-- ----------------------------

DELETE FROM `users`;
INSERT INTO `users` VALUES ('001', 'admin@gmail.com', 'admin', 'Admin', '1-800-ADMIN');
INSERT INTO `users` VALUES (NULL, 'parent1@Gmail.com', 'pass', 'Parent-Adam', '978-333-9333');
INSERT INTO `users` VALUES (NULL, 'parent2@Gmail.com', 'pass', 'Parent-Sam', '978-444-8333');
INSERT INTO `users` VALUES (NULL, 'parent3@Gmail.com', 'pass', 'Parent-Johnson', '978-555-7333');
INSERT INTO `users` VALUES (NULL, 'parent4@Gmail.com', 'pass', 'Parent-Tim', '978-555-7333');
INSERT INTO `users` VALUES (NULL, 'parent5@Gmail.com', 'pass', 'Parent-Felix', '978-555-7333');
INSERT INTO `users` VALUES (NULL, 'parent6@Gmail.com', 'pass', 'Parent-Victor', '978-555-7333');
INSERT INTO `users` VALUES (NULL, 'parent7@Gmail.com', 'pass', 'Parent-Hayden', '978-555-7333');
INSERT INTO `users` VALUES (NULL, 'parent8@Gmail.com', 'pass', 'Parent-Patrick', '978-555-7333');
INSERT INTO `users` VALUES (NULL, 'parent9@Gmail.com', 'pass', 'Parent-Duncan', '978-555-7333');
INSERT INTO `users` VALUES (NULL, 'parent10@Gmail.com', 'pass', 'Parent-Nicholas', '978-555-7333');
INSERT INTO `users` VALUES (NULL, 'student1@Gmail.com', 'pass', 'John', '978-555-7333');
INSERT INTO `users` VALUES (NULL, 'student2@Gmail.com', 'pass', 'Mike', '978-555-7333');
INSERT INTO `users` VALUES (NULL, 'student3@Gmail.com', 'pass', 'Connor', '978-555-7333');
INSERT INTO `users` VALUES (NULL, 'student4@Gmail.com', 'pass', 'Brian', '978-555-7333');
INSERT INTO `users` VALUES (NULL, 'student5@Gmail.com', 'pass', 'Tzur', '978-555-7333');
INSERT INTO `users` VALUES (NULL, 'student6@Gmail.com', 'pass', 'Kerry', '978-555-7333');
INSERT INTO `users` VALUES (NULL, 'student7@Gmail.com', 'pass', 'Kevin', '978-555-7333');
INSERT INTO `users` VALUES (NULL, 'student8@Gmail.com', 'pass', 'Armando', '978-555-7333');
INSERT INTO `users` VALUES (NULL, 'student9@Gmail.com', 'pass', 'Jack', '978-555-7333');
INSERT INTO `users` VALUES (NULL, 'student10@Gmail.com', 'pass', 'Cindy', '978-555-7333');

-- ----------------------------
-- Table structure for parents
-- ----------------------------

CREATE TABLE `parents` (
  `parent_id` int(11) NOT NULL,
  PRIMARY KEY (`parent_id`),
  CONSTRAINT `parent_user` FOREIGN KEY (`parent_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Data for parents
-- ----------------------------

INSERT INTO `parents` (`parent_id`) VALUES ('16');
INSERT INTO `parents`  VALUES ('17');
INSERT INTO `parents`  VALUES ('18');
INSERT INTO `parents`  VALUES ('19');
INSERT INTO `parents`  VALUES ('20');
INSERT INTO `parents`  VALUES ('21');
INSERT INTO `parents`  VALUES ('22');
INSERT INTO `parents`  VALUES ('23');
INSERT INTO `parents`  VALUES ('24');
INSERT INTO `parents`  VALUES ('25');

-- ----------------------------
-- Table structure for students
-- ----------------------------

CREATE TABLE `students` (
  `student_id` int(11) NOT NULL,
  `grade` int(11) DEFAULT NULL,
  `parent_id` int(11) NOT NULL,
  PRIMARY KEY (`student_id`),
  KEY `student_parent` (`parent_id`),
  CONSTRAINT `student_user` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `student_parent` FOREIGN KEY (`parent_id`) REFERENCES `parents` (`parent_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Data for students
-- ----------------------------

INSERT INTO `students` (`student_id`, `grade`, `parent_id`) VALUES ('26', '6', '16');
INSERT INTO `students`  VALUES ('27', '6', '16');
INSERT INTO `students`  VALUES ('28', '8', '18');
INSERT INTO `students`  VALUES ('29', '8', '19');
INSERT INTO `students`  VALUES ('30', '8', '20');
INSERT INTO `students`  VALUES ('31', '8', '21');
INSERT INTO `students`  VALUES ('32', '9', '22');
INSERT INTO `students`  VALUES ('33', '10', '23');
INSERT INTO `students`  VALUES ('34', '11', '24');
INSERT INTO `students`  VALUES ('35', '12', '25');


-- ----------------------------
-- Table structure for admins
-- ----------------------------

CREATE TABLE `admins` (
  `admin_id` int(11) NOT NULL,
  PRIMARY KEY (`admin_id`),
  CONSTRAINT `admins_user` FOREIGN KEY (`admin_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Data for admins
-- ----------------------------

INSERT INTO `admins` VALUES ('1');

-- ----------------------------
-- Table structure for groups
-- ----------------------------

CREATE TABLE `groups` (
  `group_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `mentor_grade_req` int(11) NOT NULL,
  `mentee_grade_req` int(11) NOT NULL,
  PRIMARY KEY (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Data for groups
-- ----------------------------

INSERT INTO `groups` VALUES ('006', 'Group6', 'Group2', '7', '6');
INSERT INTO `groups` VALUES ('007', 'Group7', 'Group3', '8', '7');
INSERT INTO `groups` VALUES ('008', 'Group8', 'Group4', '9', '8');
INSERT INTO `groups` VALUES ('009', 'Group9', 'Group5', '10', '9');
INSERT INTO `groups` VALUES ('010', 'Group10', 'Group6', '11', '10');
INSERT INTO `groups` VALUES ('011', 'Group11', 'Group7', '12', '11');
INSERT INTO `groups` VALUES ('012', 'Group12', 'Group8', '12', '12');


-- ----------------------------
-- Table structure for time_slot
-- ----------------------------

CREATE TABLE `time_slot` (
  `time_slot_id` int(11) NOT NULL AUTO_INCREMENT,
  `day_of_the_week` varchar(255) NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  PRIMARY KEY (`time_slot_id`),
  CONSTRAINT `TimeConstraint` CHECK (day_of_the_week = 'Saturday' OR day_of_the_week = 'Sunday')
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Data for time_slot
-- ----------------------------

INSERT INTO `time_slot` (`time_slot_id`, `day_of_the_week`, `start_time`, `end_time`)
VALUES (NULL, 'Saturday', '01:00:0', '02:00:00');
INSERT INTO `time_slot` VALUES (8, 'Saturday', '01:00:0', '02:00:00');
INSERT INTO `time_slot` VALUES (9, 'Saturday', '02:00:0', '03:00:00');
INSERT INTO `time_slot` VALUES (10, 'Saturday', '03:00:0', '04:00:00');
INSERT INTO `time_slot` VALUES (11, 'Saturday', '04:00:0', '05:00:00');
INSERT INTO `time_slot` VALUES (12, 'Saturday', '05:00:0', '06:00:00');
INSERT INTO `time_slot` VALUES (13, 'Saturday', '06:00:0', '07:00:00');
INSERT INTO `time_slot` VALUES (14, 'Saturday', '07:00:0', '08:00:00');
INSERT INTO `time_slot` VALUES (15, 'Saturday', '08:00:0', '09:00:00');
INSERT INTO `time_slot` VALUES (16, 'Sunday', '01:00:0', '02:00:00');
INSERT INTO `time_slot` VALUES (17, 'Sunday', '02:00:0', '03:00:00');
INSERT INTO `time_slot` VALUES (18, 'Sunday', '03:00:0', '04:00:00');
INSERT INTO `time_slot` VALUES (19, 'Sunday', '04:00:0', '05:00:00');
INSERT INTO `time_slot` VALUES (20, 'Sunday', '05:00:0', '06:00:00');
INSERT INTO `time_slot` VALUES (21, 'Sunday', '06:00:0', '07:00:00');
INSERT INTO `time_slot` VALUES (22, 'Sunday', '07:00:0', '08:00:00');
INSERT INTO `time_slot` VALUES (23, 'Sunday', '08:00:0', '09:00:00');


-- ----------------------------
-- Table structure for meetings
-- ----------------------------

CREATE TABLE `meetings` (
  `meet_id` int(11) NOT NULL AUTO_INCREMENT,
  `meet_name` varchar(255) NOT NULL,
  `date` date DEFAULT NULL,
  `time_slot_id` int(11) NOT NULL,
  `capacity` int(11) NOT NULL,
  `announcement` varchar(255) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`meet_id`),
  KEY `meeting_group` (`group_id`),
  KEY `meeting_time_slot` (`time_slot_id`),
  CONSTRAINT `meeting_group` FOREIGN KEY (`group_id`) REFERENCES `groups` (`group_id`) ON DELETE CASCADE,
  CONSTRAINT `meeting_time_slot` FOREIGN KEY (`time_slot_id`) REFERENCES `time_slot` (`time_slot_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=100 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Data for meetings
-- ----------------------------

/*INSERT INTO `meetings` (`meet_id`, `meet_name`, `date`, `time_slot_id`, `capacity`, `announcement`, `group_id`)
VALUES (NULL, 'Wack', '2021-03-01', '7', '8', 'Welcome', '1');*/
INSERT INTO `meetings` VALUES (NULL, 'English', '2021-03-02', '8', '8', 'Welcome to english', '006');
INSERT INTO `meetings` VALUES (NULL, 'Math', '2021-03-02', '8', '8', 'Welcome to math', '006');
INSERT INTO `meetings` VALUES (NULL, 'Science', '2021-03-02', '8', '8', 'Welcome to science', '006');
INSERT INTO `meetings` VALUES (NULL, 'Math', '2021-03-03', '9', '8', 'Welcome to math', '007');
INSERT INTO `meetings` VALUES (NULL, 'Science', '2021-03-03', '9', '8', 'Welcome to science', '007');
INSERT INTO `meetings` VALUES (NULL, 'Language Arts', '2021-03-04', '10', '8', 'Welcome to LA', '008');
INSERT INTO `meetings` VALUES (NULL, 'Math-8Algebra', '2021-03-04', '10', '8', 'Welcome to Algebra', '008');
INSERT INTO `meetings` VALUES (NULL, 'Math-8Algebra', '2021-03-11', '10', '8', 'Welcome to Algebra', '008');
INSERT INTO `meetings` VALUES (NULL, 'Biology', '2021-03-05', '11', '8', 'Welcome to Bio', '009');
INSERT INTO `meetings` VALUES (NULL, 'Geometry', '2021-03-05', '11', '8', 'Welcome to Geometry', '009');


-- ----------------------------
-- Table structure for material
-- ----------------------------

CREATE TABLE `material` (
  `material_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `author` varchar(255) DEFAULT NULL,
  `type` varchar(255) NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  `assigned_date` date NOT NULL,
  `notes` text,
  PRIMARY KEY (`material_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Data for material
-- ----------------------------

INSERT INTO `material` (`material_id`, `title`, `author`, `type`, `url`, `assigned_date`, `notes`) VALUES
(NULL, 'How to dance', 'Proffesor', 'Video', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', '2021-03-01', "NULL");
INSERT INTO `material` VALUES (NULL, 'How to dance1', 'Proffesor', 'Video', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', '2021-03-02', NULL);
INSERT INTO `material` VALUES (NULL, 'How to dance2', 'Proffesor', 'Video', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', '2021-03-03', NULL);
INSERT INTO `material` VALUES (NULL, 'How to dance3', 'Proffesor', 'Video', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', '2021-03-04', NULL);
INSERT INTO `material` VALUES (NULL, 'How to dance4', 'Proffesor', 'Video', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', '2021-03-05', NULL);
INSERT INTO `material` VALUES (NULL, 'How to dance5', 'Proffesor', 'Video', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', '2021-03-01', NULL);
INSERT INTO `material` VALUES (NULL, 'How to dance6', 'Proffesor', 'Video', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', '2021-03-02', NULL);
INSERT INTO `material` VALUES (NULL, 'How to dance7', 'Proffesor', 'Video', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', '2021-03-03', NULL);
INSERT INTO `material` VALUES (NULL, 'How to dance8', 'Proffesor', 'Video', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', '2021-03-04', NULL);
INSERT INTO `material` VALUES (NULL, 'How to dance9', 'Proffesor', 'Video', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', '2021-03-05', NULL);


-- ----------------------------
-- Table structure for mentees
-- ----------------------------

CREATE TABLE `mentees` (
  `mentee_id` int(11) NOT NULL,
  PRIMARY KEY (`mentee_id`),
  CONSTRAINT `mentee_student` FOREIGN KEY (`mentee_id`) REFERENCES `students` (`student_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Data for mentees
-- ----------------------------

INSERT INTO `mentees` (`mentee_id`) VALUES ('26');
INSERT INTO `mentees` VALUES ('27');
INSERT INTO `mentees` VALUES ('28');
INSERT INTO `mentees` VALUES ('29');
INSERT INTO `mentees` VALUES ('30');
INSERT INTO `mentees` VALUES ('31');
/*
INSERT INTO `mentees` VALUES ('33');
INSERT INTO `mentees` VALUES ('34');
INSERT INTO `mentees` VALUES ('35');
INSERT INTO `mentees` VALUES ('36');
*/


-- ----------------------------
-- Table structure for mentors
-- ----------------------------

CREATE TABLE `mentors` (
  `mentor_id` int(11) NOT NULL,
  PRIMARY KEY (`mentor_id`),
  CONSTRAINT `mentor_student` FOREIGN KEY (`mentor_id`) REFERENCES `students` (`student_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Data for mentors
-- ----------------------------
/*
INSERT INTO `mentors` (`mentor_id`) VALUES ('26');
INSERT INTO `mentors` VALUES ('28');
INSERT INTO `mentors` VALUES ('29');
INSERT INTO `mentors` VALUES ('30');
INSERT INTO `mentors` VALUES ('31');
*/
INSERT INTO `mentors` VALUES ('32');
INSERT INTO `mentors` VALUES ('33');
INSERT INTO `mentors` VALUES ('34');
INSERT INTO `mentors` VALUES ('35');

-- ----------------------------
-- Table structure for enroll
-- ----------------------------

CREATE TABLE `enroll` (
  `meet_id` int(11) NOT NULL,
  `mentee_id` int(11) NOT NULL,
  PRIMARY KEY (`meet_id`,`mentee_id`),
  KEY `enroll_mentee` (`mentee_id`),
  CONSTRAINT `enroll_mentee` FOREIGN KEY (`mentee_id`) REFERENCES `mentees` (`mentee_id`) ON DELETE CASCADE,
  CONSTRAINT `enroll_meetings` FOREIGN KEY (`meet_id`) REFERENCES `meetings` (`meet_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Data for enroll
-- ----------------------------

INSERT INTO `enroll` (`meet_id`, `mentee_id`) VALUES ('100', '26');
INSERT INTO `enroll`  VALUES ('101', '27');
/*INSERT INTO `enroll`  VALUES ('102', '28');*/
/*INSERT INTO `enroll`  VALUES ('103', '29');*/
INSERT INTO `enroll`  VALUES ('105', '30');
INSERT INTO `enroll`  VALUES ('106', '31');
/*INSERT INTO `enroll`  VALUES ('106', '32');*/
/*INSERT INTO `enroll`  VALUES ('107', '33');
INSERT INTO `enroll`  VALUES ('108', '34');
INSERT INTO `enroll`  VALUES ('109', '35');*/

-- ----------------------------
-- Table structure for enroll2
-- ----------------------------

CREATE TABLE `enroll2` (
  `meet_id` int(11) NOT NULL,
  `mentor_id` int(11) NOT NULL,
  PRIMARY KEY (`meet_id`,`mentor_id`),
  KEY `enroll2_mentor` (`mentor_id`),
  CONSTRAINT `enroll2_mentor` FOREIGN KEY (`mentor_id`) REFERENCES `mentors` (`mentor_id`) ON DELETE CASCADE,
  CONSTRAINT `enroll2_meetings` FOREIGN KEY (`meet_id`) REFERENCES `meetings` (`meet_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Data for enroll2
-- ----------------------------

/*INSERT INTO `enroll2` (`meet_id`, `mentor_id`) VALUES ('100', '26');*/
/*INSERT INTO `enroll2`  VALUES ('101', '27');
INSERT INTO `enroll2`  VALUES ('102', '28');
INSERT INTO `enroll2`  VALUES ('103', '29');
INSERT INTO `enroll2`  VALUES ('104', '30');
INSERT INTO `enroll2`  VALUES ('105', '31');
*/
INSERT INTO `enroll2`  VALUES ('100', '32');
INSERT INTO `enroll2`  VALUES ('101', '33');
INSERT INTO `enroll2`  VALUES ('102', '34');
INSERT INTO `enroll2`  VALUES ('103', '35');

-- ----------------------------
-- Table structure for assign
-- ----------------------------

CREATE TABLE `assign` (
  `meet_id` int(11) NOT NULL,
  `material_id` int(11) NOT NULL,
  PRIMARY KEY (`meet_id`,`material_id`),
  KEY `assign_material` (`material_id`),
  KEY `assign_meetings` (`meet_id`),
  CONSTRAINT `assign_material` FOREIGN KEY (`material_id`) REFERENCES `material` (`material_id`) ON DELETE CASCADE,
  CONSTRAINT `assign_meetings` FOREIGN KEY (`meet_id`) REFERENCES `meetings` (`meet_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Data for assign
-- ----------------------------

INSERT INTO `assign` (`meet_id`, `material_id`) VALUES ('100', '12');
INSERT INTO `assign`  VALUES ('101', '13');
INSERT INTO `assign`  VALUES ('102', '14');
INSERT INTO `assign`  VALUES ('103', '15');
INSERT INTO `assign`  VALUES ('104', '16');
INSERT INTO `assign`  VALUES ('105', '17');
INSERT INTO `assign`  VALUES ('106', '18');
INSERT INTO `assign`  VALUES ('107', '19');
INSERT INTO `assign`  VALUES ('108', '20');
INSERT INTO `assign`  VALUES ('109', '21');



SET FOREIGN_KEY_CHECKS = 1;