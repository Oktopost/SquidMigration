CREATE DATABASE IF NOT EXISTS `squids` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `squids`;

CREATE TABLE IF NOT EXISTS `_SquidMigration_Metadata_` 
(
	`ID`		int(11) NOT NULL AUTO_INCREMENT,
	`ActionID`	char(32) NOT NULL,
	`Name`		varchar(128) NOT NULL,
	`FullName`	varchar(128) NOT NULL,
	`StartDate`	datetime NOT NULL,
	`EndDate`	datetime NOT NULL,
	
	PRIMARY KEY (`ID`),
	UNIQUE KEY `u_ActionID` (`ActionID`),
	UNIQUE KEY `u_FullName` (`FullName`)
)
ENGINE=InnoDB DEFAULT CHARSET=utf8;