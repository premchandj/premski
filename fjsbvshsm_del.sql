DROP DATABASE IF EXISTS premjayamohanDB;
CREATE DATABASE premjayamohanDB;
use premjayamohanDB;

CREATE TABLE Application
(
     application_id TINYINT NOT NULL AUTO_INCREMENT
   , application_name VARCHAR(128) NOT NULL
   , application_title VARCHAR(128) NOT NULL
   , application_description blob NOT NULL
   , rating DOUBLE NOT NULL DEFAULT 0.0
   , mod_time TIMESTAMP
   , no_boards INT NOT NULL DEFAULT 0
   , no_messages INT NOT NULL DEFAULT 0
   , PRIMARY KEY (application_id)
   , INDEX owner_idx (application_name)
) TYPE=INNODB;

CREATE TABLE Board
(
     application_id TINYINT NOT NULL
   , board_id varchar(128) NOT NULL
   , board_name VARCHAR(128) NOT NULL
   , board_title VARCHAR(128) NOT NULL
   , board_description blob NOT NULL
   , creator_id INT NOT NULL
   , is_approved ENUM('NOTAPPROVED', 'APPROVED') NOT NULL
   , rating DOUBLE NOT NULL DEFAULT 0.0
   , no_ratings INT NOT NULL DEFAULT 0
   , no_messages INT NOT NULL DEFAULT 0
   , create_time DATETIME NOT NULL
   , mod_time DATETIME NOT NULL
   , create_ip INT NOT NULL
   , PRIMARY KEY (application_id, board_id)
   , FOREIGN KEY (application_id) REFERENCES Application(application_id)
   , INDEX application_idx (application_id)
) TYPE=INNODB;

/*************************************************************
****  There can be only 128 messages under a board.       ****
****  If you need bigger range, use SMALLINT, MEDIUMINT   ****
****  or INT for message_id                               ****
*************************************************************/
CREATE TABLE Message
(
     application_id  TINYINT NOT NULL
   , board_id VARCHAR(128) NOT NULL
   , message_id MEDIUMINT NOT NULL
   , create_date DATETIME NOT NULL
   , update_date DATETIME NOT NULL
   , title VARCHAR(128) NOT NULL
   , link VARCHAR(128) NOT NULL
   , description blob NOT NULL
   , creator_id INT NOT NULL
   , is_approved ENUM('NOTAPPROVED', 'APPROVED') NOT NULL
   , rating DOUBLE NOT NULL DEFAULT 0.0
   , no_ratings INT NOT NULL DEFAULT 0
   , create_ip INT NOT NULL
   , PRIMARY KEY (application_id, board_id, message_id)
   , FOREIGN KEY (application_id, board_id) REFERENCES Board(application_id, board_id)
/*   , INDEX board_idx (board_id)*/
/*   , INDEX application_idx (board_id,message_id)*/
/*   , INDEX modtime_idx (board_id, mod_time, message_id)*/
) TYPE=INNODB;

/*************************************************************
****  The max length of a tag is 30 characters    .       ****
****                                                      ****
****                                                      ****
*************************************************************/
CREATE TABLE Tag
(
     application_id TINYINT NOT NULL
   , tag_id INT NOT NULL
   , tag_name VARCHAR(30) NOT NULL
   , tag_count INT NOT NULL DEFAULT 0
   , is_approved ENUM('NOTAPPROVED', 'APPROVED') NOT NULL
   , PRIMARY KEY (application_id, tag_id)
   , FOREIGN KEY (application_id) REFERENCES Board(application_id)
   , INDEX tag_idx (tag_id)
) TYPE=INNODB;

CREATE TABLE TagBoardMap
(
     application_id TINYINT NOT NULL
   , board_id VARCHAR(128) NOT NULL
   , tag_id INT NOT NULL
   , tag_count INT NOT NULL DEFAULT 1
   , PRIMARY KEY (application_id, board_id, tag_id)
   , FOREIGN KEY (application_id, board_id) REFERENCES Board(application_id, board_id)
   , FOREIGN KEY (tag_id) REFERENCES  Tag(tag_id)
   , INDEX tag_idx (tag_id)
) TYPE=INNODB;

CREATE TABLE UserTable
(
     user_id INT NOT NULL AUTO_INCREMENT
   , user_name VARCHAR(50) NOT NULL
   , user_email VARCHAR(50) NOT NULL
   , user_password VARCHAR(50) NOT NULL
   , user_verification_key VARCHAR(128) NOT NULL
   , is_verified ENUM('NOTVERIFIED', 'VERIFIED') NOT NULL
   , user_type ENUM('NORMAL','TAGGER', 'ADMIN') NOT NULL
   , PRIMARY KEY (user_id)
   , INDEX user_idx (user_id)
   , INDEX user_namex (user_name)
) TYPE=INNODB;
