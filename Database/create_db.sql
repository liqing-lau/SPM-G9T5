SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";
--
drop database if exists `LJMS`;
CREATE DATABASE IF NOT EXISTS `LJMS` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `LJMS`;

DROP TABLE IF EXISTS `role`;
CREATE TABLE IF NOT EXISTS `role` (
  `Role_ID` int not null primary key,
  `Role_Name` varchar(20) NOT NULL,
  `Role_Status` varchar(15) default "active"
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `staff`;
CREATE TABLE IF NOT EXISTS `staff` (
  `Staff_ID` int not null primary key,
  `Staff_FName` varchar(50) NOT NULL,
  `Staff_LName` varchar(50) NOT NULL,
  `Dept` varchar(50) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Role` int not null,
  constraint staff_fk1 foreign key(Role) references role(Role_ID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `course`;
CREATE TABLE IF NOT EXISTS `course` (
  `Course_ID` varchar(20) not null primary key,
  `Course_Name` varchar(50) not null,
  `Course_Desc` varchar(255) not NULL default "Currently no description for this course",
  `Course_Status` varchar(15) default null,
  `Course_Type` varchar(10) default NULL,
  `Course_Category` varchar(50) not null
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `registration`;
CREATE TABLE IF NOT EXISTS `registration` (
  `Reg_ID` int not null primary key auto_increment,
  `Course_ID` varchar(20) NOT NULL,
  `Staff_ID` int NOT NULL,
  `Reg_Status` varchar(20) NOT NULL,
  `Completion_Status` varchar(20) NULL,
  constraint registration_fk1 foreign key(Course_ID) references course(Course_ID),
  constraint registration_fk2 foreign key(Staff_ID) references staff(Staff_ID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `jobrole`;
CREATE TABLE IF NOT EXISTS `jobrole` (
  `JRole_ID` int not null primary key auto_increment,
  `JRole_Name` varchar(50) NOT NULL,
  `JRole_Desc` varchar(500) NOT NULL,
  `JRole_Status` varchar(15) default "active" 
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `skill`;
CREATE TABLE IF NOT EXISTS `skill` (
  `Skill_ID` int not null primary key auto_increment,
  `Skill_Name` varchar(50) NOT NULL,
  `Skill_Status` varchar(15) default "active" 
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `courseskill`;
CREATE TABLE IF NOT EXISTS `courseskill` (
  `Course_ID` varchar(20) NOT NULL,
  `Skill_ID` int NOT NULL,
  constraint courseskill_fk1 foreign key(Course_ID) references course(Course_ID),
  constraint courseskill_fk2 foreign key(Skill_ID) references skill(Skill_ID),
  constraint courseskill_pk primary key(Course_ID, Skill_ID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `jobskill`;
CREATE TABLE IF NOT EXISTS `jobskill` (
  `JRole_ID` int not null,
  `Skill_ID` int NOT NULL,
  constraint jobskill_fk1 foreign key(JRole_ID) references jobrole(JRole_ID),
  constraint jobskill_fk2 foreign key(Skill_ID) references skill(Skill_ID),
  constraint jobskill_pk primary key(JRole_ID, Skill_ID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `lj`;
CREATE TABLE IF NOT EXISTS `lj` (
  `LJ_ID` int NOT NULL primary key auto_increment,
  `Staff_ID` int not null,
  `JRole_ID` int not null,
  constraint LJ_fk1 foreign key(Staff_ID) references staff(Staff_ID),
  constraint LJ_fk2 foreign key(JRole_ID) references jobrole(JRole_ID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ljcourse`;
CREATE TABLE IF NOT EXISTS `ljcourse`(
	`LJ_ID` int not NULL,
    `Course_ID` varchar(20) NOT NULL,
    constraint LC_fk1 foreign key(LJ_ID) references lj(LJ_ID),
    constraint LC_pk primary key (LJ_ID, Course_ID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

