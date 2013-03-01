# --------------------------------------------------------
# Host:                         127.0.0.1
# Server version:               5.5.16
# Server OS:                    Win32
# HeidiSQL version:             6.0.0.3603
# Date/time:                    2013-02-26 10:03:59
# --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


# Dumping structure for table app___zsystem_db_info
CREATE TABLE IF NOT EXISTS `app___zsystem_db_info` (
  `id` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `database_version` smallint(5) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

# Data exporting was unselected.
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;


insert into app___zsystem_db_info set id=1, database_version = 1;

-- ---------------------------------------------------------------------------------------------------------------------------










# Dumping structure for table app___hello_world
CREATE TABLE IF NOT EXISTS `app___hello_world` (
  `id` int(10) unsigned NOT NULL,
  `string_to_display` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

# Data exporting was unselected.


# Dumping structure for table app___user_community
CREATE TABLE IF NOT EXISTS `app___user_community` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` text,
  `is_active` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `record_creation_timestamp` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `app___user_community__uk_001` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


# Dumping structure for table app___users
CREATE TABLE IF NOT EXISTS `app___users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(64) NOT NULL,
  `password` varchar(32) NOT NULL,
  `is_active` tinyint(4) NOT NULL DEFAULT '1',
  `record_creation_timestamp` datetime NOT NULL,
  `record_update_timestamp` datetime NOT NULL,
  `fk__user_community__id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `app___users__uk_001` (`fk__user_community__id`,`email`),
  CONSTRAINT `app___users__fk_001` FOREIGN KEY (`fk__user_community__id`) REFERENCES `app___user_community` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

# Data exporting was unselected.


# Data exporting was unselected.


update app___zsystem_db_info set database_version = 2;

-- ---------------------------------------------------------------------------------------------------------------------------


CREATE TABLE IF NOT EXISTS `systemSettings` (
	`parameter` VARCHAR(30) NOT NULL COMMENT 'System parameter',
    `value` VARCHAR(255) NOT NULL COMMENT 'System paramtere value',
    `timestamp` TIMESTAMP NOT NULL COMMENT 'Timestamp of the last time te parameter was updated',
    PRIMARY KEY (`parameter`)
)  COMMENT 'System settings' ENGINE=InnoDB DEFAULT CHARACTER SET=utf8 COLLATE = utf8_general_ci;

CREATE TABLE IF NOT EXISTS `systemAuditLog` (
    `auditTimestamp` TIMESTAMP NOT NULL COMMENT 'Audit timestamp ',
    `auditUser` VARCHAR(25) NOT NULL COMMENT 'Audit user',
    `operation` VARCHAR(255) NOT NULL COMMENT 'Operation',
	`details` TEXT NULL DEFAULT NULL COMMENT 'Operation details',
    PRIMARY KEY (`auditTimestamp` , `auditUser`)
)  COMMENT 'Audit log' ENGINE=InnoDB DEFAULT CHARACTER SET=utf8 COLLATE = utf8_general_ci;


CREATE TABLE IF NOT EXISTS `msisdnExcluded` (
    `msisdn` VARCHAR(20) NOT NULL COMMENT 'MSISDN that must be excluded',
    PRIMARY KEY (`msisdn`)
)  COMMENT 'Excluded MSISDN' ENGINE=InnoDB DEFAULT CHARACTER SET=utf8 COLLATE = utf8_general_ci;


CREATE TABLE IF NOT EXISTS `country` (
    `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Country Identifier',
    `name` VARCHAR(35) NULL DEFAULT NULL COMMENT 'Country name',
    PRIMARY KEY (`id`)
)  COMMENT 'Countries' ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARACTER SET=utf8 COLLATE = utf8_general_ci;

CREATE TABLE IF NOT EXISTS `account` (
    `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Account Identifier',
    `name` VARCHAR(100) NOT NULL COMMENT 'Account name',
    `logo` VARCHAR(255) NOT NULL COMMENT 'Path for logo file',
    `phone` VARCHAR(20) NULL DEFAULT NULL COMMENT 'Contact telephone',
    `fax` VARCHAR(20) NULL DEFAULT NULL COMMENT 'Contact fax',
    `email` VARCHAR(200) NULL DEFAULT NULL COMMENT 'Contact email',
    `address` VARCHAR(255) NULL DEFAULT NULL COMMENT 'Address',
    `zip` VARCHAR(255) NULL DEFAULT NULL COMMENT 'Zip code',
    `city` VARCHAR(255) NULL DEFAULT NULL COMMENT 'City name',
    `idCountry` INT(10) UNSIGNED NOT NULL COMMENT 'Identifier for Country',
    `notes` TEXT  NULL DEFAULT NULL COMMENT 'Notes',
    `status` BOOLEAN NOT NULL DEFAULT TRUE COMMENT 'Account state (active/inactive)',
	`deleted` BOOLEAN NOT NULL DEFAULT FALSE COMMENT 'Account deletion state (false/true)',
    `createUser` VARCHAR(25) NOT NULL COMMENT 'User responsible for the original data creation',
    `createTimestamp` TIMESTAMP NOT NULL COMMENT 'Timestamp for the original data creation',
    `updateUser` VARCHAR(25) NOT NULL COMMENT 'User responsible for the current data',
    `updateTimestamp` TIMESTAMP NOT NULL COMMENT 'Timestamp of the current data',	
    PRIMARY KEY (`id`),
    CONSTRAINT `fk_account_country_id` FOREIGN KEY (`idCountry`)
        REFERENCES `country` (`id`)
        ON DELETE NO ACTION ON UPDATE NO ACTION
)  COMMENT 'Accounts' ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARACTER SET=utf8 COLLATE = utf8_general_ci;

CREATE TABLE IF NOT EXISTS `alias` (
    `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Alias Indentifier',
    `alias` VARCHAR(50) NOT NULL DEFAULT '' COMMENT 'Telephone number',
    `la` INT UNSIGNED NOT NULL COMMENT 'Telephone number prefix',
	`deleted` BOOLEAN NOT NULL DEFAULT FALSE COMMENT 'Alias deletion state (false/true)',
    `createUser` VARCHAR(25) NOT NULL COMMENT 'User responsible for the original data creation',
    `createTimestamp` TIMESTAMP NOT NULL COMMENT 'Timestamp for the original data creation',
    `updateUser` VARCHAR(25) NOT NULL COMMENT 'User responsible for the current data',
    `updateTimestamp` TIMESTAMP NOT NULL COMMENT 'Timestamp of the current data',
    PRIMARY KEY (`id`)
)  COMMENT 'Alias (Real Numbers)' ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARACTER SET=utf8 COLLATE = utf8_general_ci;

CREATE TABLE IF NOT EXISTS `accountAliases` (
    `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Account Alias Indentifier',
    `idAlias`  INT(10) UNSIGNED NOT NULL COMMENT 'Alias Identifier',    
    `idAccount` INT(10) UNSIGNED NULL DEFAULT NULL COMMENT 'Account to which the number belongs to',
    `createUser` VARCHAR(25) NOT NULL COMMENT 'User responsible for the original data creation',
    `createTimestamp` TIMESTAMP NOT NULL COMMENT 'Timestamp for the original data creation',
    `updateUser` VARCHAR(25) NOT NULL COMMENT 'User responsible for the current data',
    `updateTimestamp` TIMESTAMP NOT NULL COMMENT 'Timestamp of the current data',
    PRIMARY KEY (`id`),
	UNIQUE INDEX `unique_accountAliases` (`idAccount` ASC, `idAlias` ASC) ,
    CONSTRAINT `fk_accountAliases_account_id` FOREIGN KEY (`idAccount`)
        REFERENCES `account` (`id`)
        ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_accountAliases_alias_id` FOREIGN KEY (`idAlias`)
        REFERENCES `alias` (`id`)
        ON DELETE NO ACTION ON UPDATE NO ACTION
)  COMMENT 'Alias that Belong to an Account' ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARACTER SET=utf8 COLLATE = utf8_general_ci;


CREATE TABLE IF NOT EXISTS `promptType` (
    `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Prompt Type Identifier',
    `type` VARCHAR(25) NOT NULL COMMENT 'Type of prompt',
    `description` VARCHAR(255) NOT NULL COMMENT 'Prompt description',
    `createUser` VARCHAR(25) NOT NULL COMMENT 'User responsible for the original data creation',
    `createTimestamp` TIMESTAMP NOT NULL COMMENT 'Timestamp for the original data creation',
    `updateUser` VARCHAR(25) NOT NULL COMMENT 'User responsible for the current data',
    `updateTimestamp` TIMESTAMP NOT NULL COMMENT 'Timestamp of the current data',
    PRIMARY KEY (`id`)
)  COMMENT 'Types of  Prompt (associate with the campaign mechanism)' ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARACTER SET=utf8 COLLATE = utf8_general_ci;

CREATE TABLE IF NOT EXISTS `campaignType` (
    `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Campaign Type Identifier',
    `name` VARCHAR(20) NOT NULL COMMENT 'Capaign type name',
    `description` VARCHAR(255) NULL DEFAULT NULL COMMENT 'Capaign type description',
    PRIMARY KEY (`id`)
)  COMMENT 'Types of Campaigns' ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARACTER SET=utf8 COLLATE = utf8_general_ci;

CREATE TABLE IF NOT EXISTS `promptTypeByCampaignType` (
	`id` INT(10) UNSIGNED NOT NULL COMMENT 'Prompt Type by Campaign Type Identifier',
    `idCampaignType` INT(10) UNSIGNED NOT NULL COMMENT 'Identifier for Type of Campaign',
    `idPromptType` INT(10) UNSIGNED NOT NULL COMMENT 'Identifier for Type of Prompt',
    `mandatory` BOOLEAN NOT NULL COMMENT 'States if the prompt type is mandatory for the campaign type',
    `createUser` VARCHAR(25) NOT NULL COMMENT 'User responsible for the original data creation',
    `createTimestamp` TIMESTAMP NOT NULL COMMENT 'Timestamp for the original data creation',
    `updateUser` VARCHAR(25) NOT NULL COMMENT 'User responsible for the current data',
    `updateTimestamp` TIMESTAMP NOT NULL COMMENT 'Timestamp of the current data',
    PRIMARY KEY (`id`),
    UNIQUE INDEX `unique_campaignType_promptType` (`idCampaignType` ASC, `idPromptType` ASC) ,
    CONSTRAINT `fk_PromptCampaign_campaignType_id` FOREIGN KEY (`idCampaignType`)
        REFERENCES `campaignType` (`id`)
        ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_PromptCampaign_promptType_id` FOREIGN KEY (`idPromptType`)
        REFERENCES `promptType` (`id`)
        ON DELETE NO ACTION ON UPDATE NO ACTION
)  COMMENT 'Prompt Types by Campaign Types' ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARACTER SET=utf8 COLLATE = utf8_general_ci;


CREATE TABLE IF NOT EXISTS `campaign` (
    `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Campaign Identifier',
    `name` VARCHAR(100) NOT NULL COMMENT 'Campaign name',
    `idCampaignType` INT(10) UNSIGNED NOT NULL COMMENT 'Type of campaign',
    `logo` VARCHAR(255) NULL DEFAULT NULL COMMENT 'Path for the logo file',
    `rules` VARCHAR(255) NULL DEFAULT NULL COMMENT 'Path for the campaign rules document',
    `startDate` DATETIME NOT NULL COMMENT 'Campaign start date',
    `endDate` DATETIME NULL DEFAULT NULL COMMENT 'Campaign end date',
    `status` BOOLEAN NOT NULL DEFAULT TRUE COMMENT 'Account status (active/inactive)',
	`deleted` BOOLEAN NOT NULL DEFAULT FALSE COMMENT 'Campaign deletion state (false/true)',
    `createUser` VARCHAR(25) NOT NULL COMMENT 'User responsible for the original data creation',
    `createTimestamp` TIMESTAMP NOT NULL COMMENT 'Timestamp for the original data creation',
    `updateUser` VARCHAR(25) NOT NULL COMMENT 'User responsible for the current data',
    `updateTimestamp` TIMESTAMP NOT NULL COMMENT 'Timestamp of the current data',
    PRIMARY KEY (`id`),
	UNIQUE INDEX `unique_campaign_name` (`name` ASC), 
    CONSTRAINT `fk_campaign_campaignType_id` FOREIGN KEY (`idCampaignType`)
        REFERENCES `campaignType` (`id`)
        ON DELETE NO ACTION ON UPDATE NO ACTION
)  COMMENT 'Campaigns' ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARACTER SET=utf8 COLLATE = utf8_general_ci;


CREATE TABLE IF NOT EXISTS `prompt` (
    `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Prompt Identifier',
    `name` VARCHAR(50) NOT NULL COMMENT 'Prompt name',
    `prompt` VARCHAR(255) NOT NULL COMMENT 'Path for prompt audio file',
    `description` VARCHAR(255) NULL DEFAULT NULL COMMENT 'Prompt description',
    `idCampaign` INT(10) UNSIGNED NOT NULL COMMENT 'Identifier for Campaign',
	`deleted` BOOLEAN NOT NULL DEFAULT FALSE COMMENT 'Prompt deletion state (false/true)',
    `createUser` VARCHAR(25) NOT NULL COMMENT 'User responsible for the original data creation',
    `createTimestamp` TIMESTAMP NOT NULL COMMENT 'Timestamp for the original data creation',
    `updateUser` VARCHAR(25) NOT NULL COMMENT 'User responsible for the current data',
    `updateTimestamp` TIMESTAMP NOT NULL COMMENT 'Timestamp of the current data',
    PRIMARY KEY (`id`),
    CONSTRAINT `fk_prompt_campaign_id` FOREIGN KEY (`idCampaign`)
        REFERENCES `campaign` (`id`)
        ON DELETE NO ACTION ON UPDATE NO ACTION
)  COMMENT 'Prompts' ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARACTER SET=utf8 COLLATE = utf8_general_ci;

CREATE TABLE IF NOT EXISTS `campaignAliases` (
	`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Numbers Identifier',
    `idCampaign` INT(10) UNSIGNED NOT NULL COMMENT 'Identifier for Campaign',
    `idPrompt` INT(10) UNSIGNED NOT NULL COMMENT 'Identifier for Prompt',
    `idPromptType` INT(10) UNSIGNED NOT NULL COMMENT 'Identifier for Prompt Type',
    `alias` VARCHAR(50) NOT NULL COMMENT 'Alias (Telephone number)',
    `createUser` VARCHAR(25) NOT NULL COMMENT 'User responsible for the original data creation',
    `createTimestamp` TIMESTAMP NOT NULL COMMENT 'Timestamp for the original data creation',
    `updateUser` VARCHAR(25) NOT NULL COMMENT 'User responsible for the current data',
    `updateTimestamp` TIMESTAMP NOT NULL COMMENT 'Timestamp of the current data',
    PRIMARY KEY (`id`),
	UNIQUE INDEX `unique_numbers` (`idCampaign` ASC, `alias` ASC,  `idPrompt` ASC, `idPromptType` ASC) ,
    CONSTRAINT `fk_number_campaign_id` FOREIGN KEY (`idCampaign`)
        REFERENCES `campaign` (`id`)
        ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_number_prompt_id` FOREIGN KEY (`idPrompt`)
        REFERENCES `prompt` (`id`)
        ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_number_promptType_id` FOREIGN KEY (`idPromptType`)
        REFERENCES `promptType` (`id`)
        ON DELETE NO ACTION ON UPDATE NO ACTION
)  COMMENT 'Campaign Telephone Numbers, the aliases used on the campaign' ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARACTER SET=utf8 COLLATE = utf8_general_ci;




CREATE TABLE IF NOT EXISTS `user` (
    `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'User Identifier',
    `name` VARCHAR(100) NOT NULL COMMENT 'User name',
    `surname` VARCHAR(100) NOT NULL COMMENT 'User surname',
    `initiais` VARCHAR(100) NOT NULL COMMENT 'User initials',
    `photo` VARCHAR(255) NULL DEFAULT NULL COMMENT 'Path to user photo file',
    `email` VARCHAR(200) NOT NULL COMMENT 'User email',
    `telephone` VARCHAR(20) NULL DEFAULT NULL COMMENT 'Contact telephone',
    `password` VARCHAR(32) NOT NULL COMMENT 'User encrypted password',
    `status` BOOLEAN NOT NULL DEFAULT TRUE COMMENT 'User status (active/inactive)',
	`deleted` BOOLEAN NOT NULL DEFAULT FALSE COMMENT 'User deletion state (false/true)',
    `createUser` VARCHAR(25) NOT NULL COMMENT 'User responsible for the original data creation',
    `createTimestamp` TIMESTAMP NOT NULL COMMENT 'Timestamp for the original data creation',
    `updateUser` VARCHAR(25) NOT NULL COMMENT 'User responsible for the current data',
    `updateTimestamp` TIMESTAMP NOT NULL COMMENT 'Timestamp of the current data',	
    PRIMARY KEY (`id`)
)  COMMENT 'Users' ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARACTER SET=utf8 COLLATE = utf8_general_ci;


CREATE TABLE IF NOT EXISTS `accountRole` (
    `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Account Role Identifier',
    `name` VARCHAR(100) NOT NULL COMMENT 'Role name',
    `description` VARCHAR(100) NOT NULL COMMENT 'Role description',
    PRIMARY KEY (`id`)
)  COMMENT 'Account Roles' ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARACTER SET=utf8 COLLATE = utf8_general_ci;


CREATE TABLE IF NOT EXISTS `userAccountRole` (
	`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'User Account Role Identifier',
	`idAccount` INT(10) UNSIGNED NOT NULL COMMENT 'Identifier for Account',
    `idAccountRole` INT(10) UNSIGNED NOT NULL COMMENT 'Identifier for Account Role',
    `idUser` INT(10) UNSIGNED NOT NULL COMMENT 'Identifier for User',
	`isInvited` BOOLEAN NOT NULL COMMENT 'User is invited for this account',
    `createUser` VARCHAR(25) NOT NULL COMMENT 'User responsible for the original data creation',
    `createTimestamp` TIMESTAMP NOT NULL COMMENT 'Timestamp for the original data creation',
    `updateUser` VARCHAR(25) NOT NULL COMMENT 'User responsible for the current data',
    `updateTimestamp` TIMESTAMP NOT NULL COMMENT 'Timestamp of the current data',
    PRIMARY KEY (`id`),
	UNIQUE INDEX `unique_userAccountRole` (`idAccount` ASC, `idAccountRole` ASC, `idUser` ASC) ,
    CONSTRAINT `fk_userAccountRole_account_id` FOREIGN KEY (`idAccount`)
        REFERENCES `account` (`id`)
        ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_userAccountRole_accountRole_id` FOREIGN KEY (`idAccountRole`)
        REFERENCES `accountRole` (`id`)
        ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_userAccountRole_user_id` FOREIGN KEY (`idUser`)
        REFERENCES `user` (`id`)
        ON DELETE NO ACTION ON UPDATE NO ACTION
)  COMMENT 'Roles of the Users on the Account' ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARACTER SET=utf8 COLLATE = utf8_general_ci;

CREATE TABLE IF NOT EXISTS `action` (
    `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Action Identifier',
    `name` VARCHAR(100) NOT NULL COMMENT 'Action name',
    `description` VARCHAR(100) NOT NULL COMMENT 'Action description',
    `hasRead` BOOLEAN NOT NULL DEFAULT TRUE COMMENT 'Action has read option',
    `hasWrite` BOOLEAN NOT NULL DEFAULT TRUE COMMENT 'Action has write option',
    PRIMARY KEY (`id`)
)  COMMENT 'Actions available for the users' ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARACTER SET=utf8 COLLATE = utf8_general_ci;

CREATE TABLE IF NOT EXISTS `userCampaignAction` (
	`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'User Campaign Action Identifier',
    `idAction` INT(10) UNSIGNED NOT NULL COMMENT 'Identifier for Action',
    `idUser` INT(10) UNSIGNED NOT NULL COMMENT 'Identifier for User',
	`idCampaign` INT(10) UNSIGNED NOT NULL COMMENT 'Identifier for Campaign',
	`canRead` BOOLEAN NOT NULL COMMENT 'Has read permissions for the action on the campaign',
	`canWrite` BOOLEAN NOT NULL DEFAULT FALSE COMMENT 'Has write permissions for the action on the campaign',
    `createUser` VARCHAR(25) NOT NULL COMMENT 'User responsible for the original data creation',
    `createTimestamp` TIMESTAMP NOT NULL COMMENT 'Timestamp for the original data creation',
    `updateUser` VARCHAR(25) NOT NULL COMMENT 'User responsible for the current data',
    `updateTimestamp` TIMESTAMP NOT NULL COMMENT 'Timestamp of the current data',
    PRIMARY KEY (`id`),
	UNIQUE INDEX `unique_userCampaignAction` (`idCampaign` ASC, `idUser` ASC, `idAction` ASC) ,
    CONSTRAINT `fk_userCampaignAction_accountRole_id` FOREIGN KEY (`idAction`)
        REFERENCES `action` (`id`)
        ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_userCampaignAction_user_id` FOREIGN KEY (`idUser`)
        REFERENCES `user` (`id`)
        ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_userCampaignAction_campaign_id` FOREIGN KEY (`idCampaign`)
        REFERENCES `campaign` (`id`)
        ON DELETE NO ACTION ON UPDATE NO ACTION
)  COMMENT 'Actions that Users can Perform on Campaigns' ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARACTER SET=utf8 COLLATE = utf8_general_ci;


CREATE TABLE IF NOT EXISTS `contestType` (
    `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Contest Type Identifier',
    `name` VARCHAR(50) NOT NULL COMMENT 'Contest type name',
    `description` VARCHAR(100) NOT NULL COMMENT 'Contest type description',
    PRIMARY KEY (`id`)
)  COMMENT 'Types of Contests' ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARACTER SET=utf8 COLLATE = utf8_general_ci;


CREATE TABLE IF NOT EXISTS `contest` (
    `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Contest Identifier',
    `name` VARCHAR(50) NOT NULL COMMENT 'Contest name',
    `idContestType` INT(10) UNSIGNED NOT NULL COMMENT 'Identifier for Type of Contest',
    `idCampaign` INT(10) UNSIGNED NOT NULL COMMENT 'Identifier for Campaign (to which the contest belongs to)',
    `startDate` DATETIME NOT NULL COMMENT 'Contest start date',
    `endDate` DATETIME NOT NULL COMMENT 'Contest end date',
    `date` VARCHAR(100) NOT NULL COMMENT 'Contest date',
    `totalCalls` INT(10) UNSIGNED NOT NULL COMMENT 'Total calls that entered in the contest',
    `createUser` VARCHAR(25) NOT NULL COMMENT 'User responsible for the original data creation',
    `createTimestamp` TIMESTAMP NOT NULL COMMENT 'Timestamp for the original data creation',
    `updateUser` VARCHAR(25) NOT NULL COMMENT 'User responsible for the current data',
    `updateTimestamp` TIMESTAMP NOT NULL COMMENT 'Timestamp of the current data',
    PRIMARY KEY (`id`),
    CONSTRAINT `fk_contest_contestType_id` FOREIGN KEY (`idContestType`)
        REFERENCES `contestType` (`id`)
        ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_contest_campaign_id` FOREIGN KEY (`idCampaign`)
        REFERENCES `campaign` (`id`)
)  COMMENT 'Contests' ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARACTER SET=utf8 COLLATE = utf8_general_ci;


CREATE TABLE IF NOT EXISTS `contestControlParameters` (
    `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Contest Control Parameter Identifier',
	`idContest` INT(10) UNSIGNED NOT NULL COMMENT 'Contest Identifier',
	`idCampaign` INT(10) UNSIGNED NOT NULL COMMENT 'Campaign Identifier',
    `parameter` VARCHAR(50) NOT NULL COMMENT 'Parameter name',
	`valueStr` VARCHAR(50) NULL DEFAULT NULL COMMENT 'Value when string',
	`valueInt` INTEGER NULL DEFAULT NULL COMMENT 'Value when integer',
	PRIMARY KEY (`id`),
	UNIQUE INDEX (`idCampaign` ASC, `parameter` ASC, `idContest` ASC),
    CONSTRAINT `fk_contestControlParameters_contest_id` FOREIGN KEY (`idContest`)
        REFERENCES `contest` (`id`)
        ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_contestControlParameters_campaign_id` FOREIGN KEY (`idCampaign`)
        REFERENCES `campaign` (`id`)
)  COMMENT 'Parameters for contests mechanisms' ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARACTER SET=utf8 COLLATE = utf8_general_ci;


CREATE TABLE IF NOT EXISTS `campaignContest` (
	`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Campaign Contest Identifier',
    `idCampaign` INT(10) UNSIGNED NOT NULL COMMENT 'Identifier for Campaing',
    `idContest` INT(10) UNSIGNED NOT NULL COMMENT 'Identifier for Contest',
    `masterCampaign` BOOLEAN NOT NULL COMMENT 'Identifies if the campaign is the master of the contest (for contests over multiple campaigns)',
    `createUser` VARCHAR(25) NOT NULL COMMENT 'User responsible for the original data creation',
    `createTimestamp` TIMESTAMP NOT NULL COMMENT 'Timestamp for the original data creation',
    `updateUser` VARCHAR(25) NOT NULL COMMENT 'User responsible for the current data',
    `updateTimestamp` TIMESTAMP NOT NULL COMMENT 'Timestamp of the current data',
    PRIMARY KEY (`id`),
	UNIQUE INDEX `unique_campaignContest` (`idCampaign` ASC, `idContest` ASC) ,
    CONSTRAINT `fk_campaignContests_contest_id` FOREIGN KEY (`idContest`)
        REFERENCES `contest` (`id`)
        ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_campaignContests_campaign_id` FOREIGN KEY (`idCampaign`)
        REFERENCES `campaign` (`id`)
        ON DELETE NO ACTION ON UPDATE NO ACTION
)  COMMENT 'Contests of the Campaign' ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARACTER SET=utf8 COLLATE = utf8_general_ci;



CREATE TABLE IF NOT EXISTS `winnerType` (
    `id` INT(10) UNSIGNED NOT NULL COMMENT 'Winner Type Identifier',
    `name` VARCHAR(50) NOT NULL COMMENT 'Winner type name',
    `description` VARCHAR(100) NOT NULL COMMENT 'Winner type description',
    PRIMARY KEY (`id`)
)  COMMENT 'Types of winners' ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARACTER SET=utf8 COLLATE = utf8_general_ci;

CREATE TABLE IF NOT EXISTS `winner` (
	`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Winner Identifier',
    `idContest` INT(10) UNSIGNED NOT NULL COMMENT 'Identifier for Contest',
    `idWinnerType` INT(10) UNSIGNED NOT NULL COMMENT 'Identifier for Type of Winner',
    `msisdn` VARCHAR(20) NOT NULL DEFAULT '0' COMMENT 'Winner, telephone number of the person that called',
    `idCampaignAlias` INT(10) UNSIGNED NOT NULL COMMENT 'Identifier for the Alias (telephone number) to where the winner called',
    `atempts` TINYINT UNSIGNED NOT NULL COMMENT 'Attempts to contact the winner',
    `drawOrder` TINYINT UNSIGNED NOT NULL COMMENT 'The draw order of the winner in the contest',
    `callNumber` INT(10) UNSIGNED NOT NULL COMMENT 'The number of the call in the contest',
    `callDate` DATETIME NOT NULL COMMENT 'Winner call date and time',
	`notes` TEXT NULL DEFAULT NULL COMMENT 'Notes about the winner',
    `idIncoming` INT(10) UNSIGNED NOT NULL COMMENT 'Incoming identifier | Fake FK (not enforced to allow the Incoming table to be moved into an historical database)',
    `createUser` VARCHAR(25) NOT NULL COMMENT 'User responsible for the original data creation',
    `createTimestamp` TIMESTAMP NOT NULL COMMENT 'Timestamp for the original data creation',
    `updateUser` VARCHAR(25) NOT NULL COMMENT 'User responsible for the current data',
    `updateTimestamp` TIMESTAMP NOT NULL COMMENT 'Timestamp of the current data',
    PRIMARY KEY (`id`),
	INDEX `idx_winner_msisdn_alias` (`msisdn` ASC, `idCampaignAlias` ASC) ,
    CONSTRAINT `fk_winner_contest_id` FOREIGN KEY (`idContest`)
        REFERENCES `contest` (`id`)
        ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_winner_winnerType_id` FOREIGN KEY (`idWinnerType`)
        REFERENCES `winnerType` (`id`)
        ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_winner_campaignAliases_id` FOREIGN KEY (`idCampaignAlias`)
        REFERENCES `campaignAliases` (`id`)
        ON DELETE NO ACTION ON UPDATE NO ACTION
)  COMMENT 'Winners' ENGINE=InnoDB DEFAULT CHARACTER SET=utf8 COLLATE = utf8_general_ci;
-- END BACKOFFICE





-- TRIGGERS
delimiter //

CREATE TRIGGER `systemSettings_updateTimestamp` BEFORE UPDATE ON `systemSettings`
    FOR EACH ROW
    BEGIN
         SET NEW.timestamp = now();
END;//

delimiter ;
-- END TRIGGERS




update app___zsystem_db_info set database_version = 3;


-- ---------------------------------------------------------------------------------------------------------------------------

INSERT INTO country(id, name) values (1, 'Afeganistão');
INSERT INTO country(id, name) values (2, 'África do Sul');
INSERT INTO country(id, name) values (3, 'Akrotiri');
INSERT INTO country(id, name) values (4, 'Albânia');
INSERT INTO country(id, name) values (5, 'Alemanha');
INSERT INTO country(id, name) values (6, 'Andorra');
INSERT INTO country(id, name) values (7, 'Angola');
INSERT INTO country(id, name) values (8, 'Anguila');
INSERT INTO country(id, name) values (9, 'Antárctida');
INSERT INTO country(id, name) values (10, 'Antígua e Barbuda');
INSERT INTO country(id, name) values (11, 'Antilhas Neerlandesas');
INSERT INTO country(id, name) values (12, 'Arábia Saudita');
INSERT INTO country(id, name) values (13, 'Arctic Ocean');
INSERT INTO country(id, name) values (14, 'Argélia');
INSERT INTO country(id, name) values (15, 'Argentina');
INSERT INTO country(id, name) values (16, 'Arménia');
INSERT INTO country(id, name) values (17, 'Aruba');
INSERT INTO country(id, name) values (18, 'Ashmore and Cartier Islands');
INSERT INTO country(id, name) values (19, 'Atlantic Ocean');
INSERT INTO country(id, name) values (20, 'Austrália');
INSERT INTO country(id, name) values (21, 'Áustria');
INSERT INTO country(id, name) values (22, 'Azerbaijão');
INSERT INTO country(id, name) values (23, 'Bahamas');
INSERT INTO country(id, name) values (24, 'Bangladeche');
INSERT INTO country(id, name) values (25, 'Barbados');
INSERT INTO country(id, name) values (26, 'Barém');
INSERT INTO country(id, name) values (27, 'Bélgica');
INSERT INTO country(id, name) values (28, 'Belize');
INSERT INTO country(id, name) values (29, 'Benim');
INSERT INTO country(id, name) values (30, 'Bermudas');
INSERT INTO country(id, name) values (31, 'Bielorrússia');
INSERT INTO country(id, name) values (32, 'Birmânia');
INSERT INTO country(id, name) values (33, 'Bolívia');
INSERT INTO country(id, name) values (34, 'Bósnia e Herzegovina');
INSERT INTO country(id, name) values (35, 'Botsuana');
INSERT INTO country(id, name) values (36, 'Brasil');
INSERT INTO country(id, name) values (37, 'Brunei');
INSERT INTO country(id, name) values (38, 'Bulgária');
INSERT INTO country(id, name) values (39, 'Burquina Faso');
INSERT INTO country(id, name) values (40, 'Burúndi');
INSERT INTO country(id, name) values (41, 'Butão');
INSERT INTO country(id, name) values (42, 'Cabo Verde');
INSERT INTO country(id, name) values (43, 'Camarões');
INSERT INTO country(id, name) values (44, 'Camboja');
INSERT INTO country(id, name) values (45, 'Canadá');
INSERT INTO country(id, name) values (46, 'Catar');
INSERT INTO country(id, name) values (47, 'Cazaquistão');
INSERT INTO country(id, name) values (48, 'Chade');
INSERT INTO country(id, name) values (49, 'Chile');
INSERT INTO country(id, name) values (50, 'China');
INSERT INTO country(id, name) values (51, 'Chipre');
INSERT INTO country(id, name) values (52, 'Clipperton Island');
INSERT INTO country(id, name) values (53, 'Colômbia');
INSERT INTO country(id, name) values (54, 'Comores');
INSERT INTO country(id, name) values (55, 'Congo-Brazzaville');
INSERT INTO country(id, name) values (56, 'Congo-Kinshasa');
INSERT INTO country(id, name) values (57, 'Coral Sea Islands');
INSERT INTO country(id, name) values (58, 'Coreia do Norte');
INSERT INTO country(id, name) values (59, 'Coreia do Sul');
INSERT INTO country(id, name) values (60, 'Costa do Marfim');
INSERT INTO country(id, name) values (61, 'Costa Rica');
INSERT INTO country(id, name) values (62, 'Croácia');
INSERT INTO country(id, name) values (63, 'Cuba');
INSERT INTO country(id, name) values (64, 'Dhekelia');
INSERT INTO country(id, name) values (65, 'Dinamarca');
INSERT INTO country(id, name) values (66, 'Domínica');
INSERT INTO country(id, name) values (67, 'Egipto');
INSERT INTO country(id, name) values (68, 'Emiratos Árabes Unidos');
INSERT INTO country(id, name) values (69, 'Equador');
INSERT INTO country(id, name) values (70, 'Eritreia');
INSERT INTO country(id, name) values (71, 'Eslováquia');
INSERT INTO country(id, name) values (72, 'Eslovénia');
INSERT INTO country(id, name) values (73, 'Espanha');
INSERT INTO country(id, name) values (74, 'Estados Unidos');
INSERT INTO country(id, name) values (75, 'Estónia');
INSERT INTO country(id, name) values (76, 'Etiópia');
INSERT INTO country(id, name) values (77, 'Faroé');
INSERT INTO country(id, name) values (78, 'Fiji');
INSERT INTO country(id, name) values (79, 'Filipinas');
INSERT INTO country(id, name) values (80, 'Finlândia');
INSERT INTO country(id, name) values (81, 'França');
INSERT INTO country(id, name) values (82, 'Gabão');
INSERT INTO country(id, name) values (83, 'Gâmbia');
INSERT INTO country(id, name) values (84, 'Gana');
INSERT INTO country(id, name) values (85, 'Gaza Strip');
INSERT INTO country(id, name) values (86, 'Geórgia');
INSERT INTO country(id, name) values (87, 'Geórgia do Sul e Sandwich do Sul');
INSERT INTO country(id, name) values (88, 'Gibraltar');
INSERT INTO country(id, name) values (89, 'Granada');
INSERT INTO country(id, name) values (90, 'Grécia');
INSERT INTO country(id, name) values (91, 'Gronelândia');
INSERT INTO country(id, name) values (92, 'Guame');
INSERT INTO country(id, name) values (93, 'Guatemala');
INSERT INTO country(id, name) values (94, 'Guernsey');
INSERT INTO country(id, name) values (95, 'Guiana');
INSERT INTO country(id, name) values (96, 'Guiné');
INSERT INTO country(id, name) values (97, 'Guiné Equatorial');
INSERT INTO country(id, name) values (98, 'Guiné-Bissau');
INSERT INTO country(id, name) values (99, 'Haiti');
INSERT INTO country(id, name) values (100, 'Honduras');
INSERT INTO country(id, name) values (101, 'Hong Kong');
INSERT INTO country(id, name) values (102, 'Hungria');
INSERT INTO country(id, name) values (103, 'Iémen');
INSERT INTO country(id, name) values (104, 'Ilha Bouvet');
INSERT INTO country(id, name) values (105, 'Ilha do Natal');
INSERT INTO country(id, name) values (106, 'Ilha Norfolk');
INSERT INTO country(id, name) values (107, 'Ilhas Caimão');
INSERT INTO country(id, name) values (108, 'Ilhas Cook');
INSERT INTO country(id, name) values (109, 'Ilhas dos Cocos');
INSERT INTO country(id, name) values (110, 'Ilhas Falkland');
INSERT INTO country(id, name) values (111, 'Ilhas Heard e McDonald');
INSERT INTO country(id, name) values (112, 'Ilhas Marshall');
INSERT INTO country(id, name) values (113, 'Ilhas Salomão');
INSERT INTO country(id, name) values (114, 'Ilhas Turcas e Caicos');
INSERT INTO country(id, name) values (115, 'Ilhas Virgens Americanas');
INSERT INTO country(id, name) values (116, 'Ilhas Virgens Britânicas');
INSERT INTO country(id, name) values (117, 'Índia');
INSERT INTO country(id, name) values (118, 'Indian Ocean');
INSERT INTO country(id, name) values (119, 'Indonésia');
INSERT INTO country(id, name) values (120, 'Irão');
INSERT INTO country(id, name) values (121, 'Iraque');
INSERT INTO country(id, name) values (122, 'Irlanda');
INSERT INTO country(id, name) values (123, 'Islândia');
INSERT INTO country(id, name) values (124, 'Israel');
INSERT INTO country(id, name) values (125, 'Itália');
INSERT INTO country(id, name) values (126, 'Jamaica');
INSERT INTO country(id, name) values (127, 'Jan Mayen');
INSERT INTO country(id, name) values (128, 'Japão');
INSERT INTO country(id, name) values (129, 'Jersey');
INSERT INTO country(id, name) values (130, 'Jibuti');
INSERT INTO country(id, name) values (131, 'Jordânia');
INSERT INTO country(id, name) values (132, 'Kuwait');
INSERT INTO country(id, name) values (133, 'Laos');
INSERT INTO country(id, name) values (134, 'Lesoto');
INSERT INTO country(id, name) values (135, 'Letónia');
INSERT INTO country(id, name) values (136, 'Líbano');
INSERT INTO country(id, name) values (137, 'Libéria');
INSERT INTO country(id, name) values (138, 'Líbia');
INSERT INTO country(id, name) values (139, 'Listenstaine');
INSERT INTO country(id, name) values (140, 'Lituânia');
INSERT INTO country(id, name) values (141, 'Luxemburgo');
INSERT INTO country(id, name) values (142, 'Macau');
INSERT INTO country(id, name) values (143, 'Macedónia');
INSERT INTO country(id, name) values (144, 'Madagáscar');
INSERT INTO country(id, name) values (145, 'Malásia');
INSERT INTO country(id, name) values (146, 'Malávi');
INSERT INTO country(id, name) values (147, 'Maldivas');
INSERT INTO country(id, name) values (148, 'Mali');
INSERT INTO country(id, name) values (149, 'Malta');
INSERT INTO country(id, name) values (150, 'Man, Isle of');
INSERT INTO country(id, name) values (151, 'Marianas do Norte');
INSERT INTO country(id, name) values (152, 'Marrocos');
INSERT INTO country(id, name) values (153, 'Maurícia');
INSERT INTO country(id, name) values (154, 'Mauritânia');
INSERT INTO country(id, name) values (155, 'Mayotte');
INSERT INTO country(id, name) values (156, 'México');
INSERT INTO country(id, name) values (157, 'Micronésia');
INSERT INTO country(id, name) values (158, 'Moçambique');
INSERT INTO country(id, name) values (159, 'Moldávia');
INSERT INTO country(id, name) values (160, 'Mónaco');
INSERT INTO country(id, name) values (161, 'Mongólia');
INSERT INTO country(id, name) values (162, 'Monserrate');
INSERT INTO country(id, name) values (163, 'Montenegro');
INSERT INTO country(id, name) values (164, 'Mundo');
INSERT INTO country(id, name) values (165, 'Namíbia');
INSERT INTO country(id, name) values (166, 'Nauru');
INSERT INTO country(id, name) values (167, 'Navassa Island');
INSERT INTO country(id, name) values (168, 'Nepal');
INSERT INTO country(id, name) values (169, 'Nicarágua');
INSERT INTO country(id, name) values (170, 'Níger');
INSERT INTO country(id, name) values (171, 'Nigéria');
INSERT INTO country(id, name) values (172, 'Niue');
INSERT INTO country(id, name) values (173, 'Noruega');
INSERT INTO country(id, name) values (174, 'Nova Caledónia');
INSERT INTO country(id, name) values (175, 'Nova Zelândia');
INSERT INTO country(id, name) values (176, 'Omã');
INSERT INTO country(id, name) values (177, 'Pacific Ocean');
INSERT INTO country(id, name) values (178, 'Países Baixos');
INSERT INTO country(id, name) values (179, 'Palau');
INSERT INTO country(id, name) values (180, 'Panamá');
INSERT INTO country(id, name) values (181, 'Papua-Nova Guiné');
INSERT INTO country(id, name) values (182, 'Paquistão');
INSERT INTO country(id, name) values (183, 'Paracel Islands');
INSERT INTO country(id, name) values (184, 'Paraguai');
INSERT INTO country(id, name) values (185, 'Peru');
INSERT INTO country(id, name) values (186, 'Pitcairn');
INSERT INTO country(id, name) values (187, 'Polinésia Francesa');
INSERT INTO country(id, name) values (188, 'Polónia');
INSERT INTO country(id, name) values (189, 'Porto Rico');
INSERT INTO country(id, name) values (190, 'Portugal');
INSERT INTO country(id, name) values (191, 'Quénia');
INSERT INTO country(id, name) values (192, 'Quirguizistão');
INSERT INTO country(id, name) values (193, 'Quiribáti');
INSERT INTO country(id, name) values (194, 'Reino Unido');
INSERT INTO country(id, name) values (195, 'República Centro-Africana');
INSERT INTO country(id, name) values (196, 'República Checa');
INSERT INTO country(id, name) values (197, 'República Dominicana');
INSERT INTO country(id, name) values (198, 'Roménia');
INSERT INTO country(id, name) values (199, 'Ruanda');
INSERT INTO country(id, name) values (200, 'Rússia');
INSERT INTO country(id, name) values (201, 'Salvador');
INSERT INTO country(id, name) values (202, 'Samoa');
INSERT INTO country(id, name) values (203, 'Samoa Americana');
INSERT INTO country(id, name) values (204, 'Santa Helena');
INSERT INTO country(id, name) values (205, 'Santa Lúcia');
INSERT INTO country(id, name) values (206, 'São Cristóvão e Neves');
INSERT INTO country(id, name) values (207, 'São Marinho');
INSERT INTO country(id, name) values (208, 'São Pedro e Miquelon');
INSERT INTO country(id, name) values (209, 'São Tomé e Príncipe');
INSERT INTO country(id, name) values (210, 'São Vicente e Granadinas');
INSERT INTO country(id, name) values (211, 'Sara Ocidental');
INSERT INTO country(id, name) values (212, 'Seicheles');
INSERT INTO country(id, name) values (213, 'Senegal');
INSERT INTO country(id, name) values (214, 'Serra Leoa');
INSERT INTO country(id, name) values (215, 'Sérvia');
INSERT INTO country(id, name) values (216, 'Singapura');
INSERT INTO country(id, name) values (217, 'Síria');
INSERT INTO country(id, name) values (218, 'Somália');
INSERT INTO country(id, name) values (219, 'Southern Ocean');
INSERT INTO country(id, name) values (220, 'Spratly Islands');
INSERT INTO country(id, name) values (221, 'Sri Lanca');
INSERT INTO country(id, name) values (222, 'Suazilândia');
INSERT INTO country(id, name) values (223, 'Sudão');
INSERT INTO country(id, name) values (224, 'Suécia');
INSERT INTO country(id, name) values (225, 'Suíça');
INSERT INTO country(id, name) values (226, 'Suriname');
INSERT INTO country(id, name) values (227, 'Svalbard e Jan Mayen');
INSERT INTO country(id, name) values (228, 'Tailândia');
INSERT INTO country(id, name) values (229, 'Taiwan');
INSERT INTO country(id, name) values (230, 'Tajiquistão');
INSERT INTO country(id, name) values (231, 'Tanzânia');
INSERT INTO country(id, name) values (232, 'Território Britânico do Oceano Índico');
INSERT INTO country(id, name) values (233, 'Territórios Austrais Franceses');
INSERT INTO country(id, name) values (234, 'Timor Leste');
INSERT INTO country(id, name) values (235, 'Togo');
INSERT INTO country(id, name) values (236, 'Tokelau');
INSERT INTO country(id, name) values (237, 'Tonga');
INSERT INTO country(id, name) values (238, 'Trindade e Tobago');
INSERT INTO country(id, name) values (239, 'Tunísia');
INSERT INTO country(id, name) values (240, 'Turquemenistão');
INSERT INTO country(id, name) values (241, 'Turquia');
INSERT INTO country(id, name) values (242, 'Tuvalu');
INSERT INTO country(id, name) values (243, 'Ucrânia');
INSERT INTO country(id, name) values (244, 'Uganda');
INSERT INTO country(id, name) values (245, 'União Europeia');
INSERT INTO country(id, name) values (246, 'Uruguai');
INSERT INTO country(id, name) values (247, 'Usbequistão');
INSERT INTO country(id, name) values (248, 'Vanuatu');
INSERT INTO country(id, name) values (249, 'Vaticano');
INSERT INTO country(id, name) values (250, 'Venezuela');
INSERT INTO country(id, name) values (251, 'Vietname');
INSERT INTO country(id, name) values (252, 'Wake Island');
INSERT INTO country(id, name) values (253, 'Wallis e Futuna');
INSERT INTO country(id, name) values (254, 'West Bank');
INSERT INTO country(id, name) values (255, 'Zâmbia');
INSERT INTO country(id, name) values (256, 'Zimbabué');

-- Tipos de Campanha
insert into campaignType (id, name, description) values (1, 'Votação', 'Sorteio de chama vencedora numa votação.');
insert into campaignType (id, name, description) values (2, 'Chamada Dourada', 'Chamada vencedora a cada X chamadas recebidas.');
insert into campaignType (id, name, description) values (3, 'Seleção de Vencedor', 'Chamadas vencedoras selecionadas manualmente.');

-- Tipos de Prompt
insert into promptType (id, type, description, createUser, createTimestamp, updateUser, updateTimestamp) values (1, 'Entrada', 'Prompt usada na entrada da chamada.', 'SYSTEM', now(), 'SYSTEM', now());
insert into promptType (id, type, description, createUser, createTimestamp, updateUser, updateTimestamp) values (2, 'Saída', 'Prompt usada na saída da chamada.', 'SYSTEM', now(), 'SYSTEM', now());
insert into promptType (id, type, description, createUser, createTimestamp, updateUser, updateTimestamp) values (3, 'Vencedor', 'Prompt usada no anúncio de chamada vencedora.', 'SYSTEM', now(), 'SYSTEM', now());


-- Tipos de Prompt por Tipos de Campanha
insert into promptTypeByCampaignType (id, idCampaignType, idPromptType, mandatory, createUser, createTimestamp, updateUser, updateTimestamp) values (1, 1,1, True, 'SYSTEM', now(), 'SYSTEM', now());
insert into promptTypeByCampaignType (id, idCampaignType, idPromptType, mandatory, createUser, createTimestamp, updateUser, updateTimestamp) values (2, 1,2, False, 'SYSTEM', now(), 'SYSTEM', now());
insert into promptTypeByCampaignType (id, idCampaignType, idPromptType, mandatory, createUser, createTimestamp, updateUser, updateTimestamp) values (3, 2,1, True, 'SYSTEM', now(), 'SYSTEM', now());
insert into promptTypeByCampaignType (id, idCampaignType, idPromptType, mandatory, createUser, createTimestamp, updateUser, updateTimestamp) values (4, 2,2, True, 'SYSTEM', now(), 'SYSTEM', now());
insert into promptTypeByCampaignType (id, idCampaignType, idPromptType, mandatory, createUser, createTimestamp, updateUser, updateTimestamp) values (5, 2,3, True, 'SYSTEM', now(), 'SYSTEM', now());
insert into promptTypeByCampaignType (id, idCampaignType, idPromptType, mandatory, createUser, createTimestamp, updateUser, updateTimestamp) values (6, 3,1, True, 'SYSTEM', now(), 'SYSTEM', now());
insert into promptTypeByCampaignType (id, idCampaignType, idPromptType, mandatory, createUser, createTimestamp, updateUser, updateTimestamp) values (7, 3,2, False, 'SYSTEM', now(), 'SYSTEM', now());

-- Tipos de Sorteios
insert into contestType (id, name, description) values (1, 'Campanha', 'Sorteio sobre uma campanha especifica.');
insert into contestType (id, name, description) values (2, 'Multiplas Campanhas', 'Sorteio sobre um conjunto de campanhas.');

-- Tipos de Vencedores
insert into winnerType (id, name, description) values (1, 'Vencedor', 'Vencedor do sorteio.');
insert into winnerType (id, name, description) values (2, '1º Prémio', 'Vencedor do primeiro prémio do sorteio.');
insert into winnerType (id, name, description) values (3, '2º Prémio', 'Vencedor do segundo prémio do sorteio.');
insert into winnerType (id, name, description) values (4, '3º Prémio', 'Vencedor do terceiro prémio do sorteio.');
insert into winnerType (id, name, description) values (5, '1º Suplente', 'Primeiro suplente do sorteio.');
insert into winnerType (id, name, description) values (6, '2º Suplente', 'Segundo suplente do sorteio.');
insert into winnerType (id, name, description) values (7, '3º Suplente', 'Terceiro suplente do sorteio.');
insert into winnerType (id, name, description) values (8, '4º Suplente', 'Quarto suplente do sorteio.');
insert into winnerType (id, name, description) values (9, '5º Suplente', 'Quinto suplente do sorteio.');
insert into winnerType (id, name, description) values (10, '6º Suplente', 'Sexto suplente do sorteio.');
insert into winnerType (id, name, description) values (11, '7º Suplente', 'Setimo suplente do sorteio.');
insert into winnerType (id, name, description) values (12, '8º Suplente', 'Oitavo suplente do sorteio.');
insert into winnerType (id, name, description) values (13, '9º Suplente', 'Nono suplente do sorteio.');
insert into winnerType (id, name, description) values (14, '10º Suplente', 'Décimo suplente do sorteio.');
insert into winnerType (id, name, description) values (15, 'Suplente', 'Suplente do sorteio.');


-- Tipos de Perfis de Contas
insert into accountRole(id, name, description) values (1, 'Master Administrator', 'Time2Change full administrator');
insert into accountRole(id, name, description) values (2, 'Administrador', 'Administrador da conta');
insert into accountRole(id, name, description) values (3, 'Básico', 'Utilizador apenas pertencente à conta');


-- Ações de Users sobre Campanhas
insert into action(id, name, description, hasWrite, hasRead) values (1, 'Campanha', 'Permissões sobre a campanha', True, True);
insert into action(id, name, description, hasWrite, hasRead) values (2, 'Estatísticas e Relatórios', 'Permissões sobre as estatísticas e relatórios', False, True);
insert into action(id, name, description, hasWrite, hasRead) values (3, 'Concursos', 'Permissões sobre os concursos', True, True);


-- Excluded MSISDN
insert into msisdnExcluded (msisdn) values ('911041271');
insert into msisdnExcluded (msisdn) values ('912416923');


/* 
	Dados de Arranque
 */
-- System Settings
insert into systemSettings(parameter, value) values ('VERSION', '1.0');

-- Master User
INSERT INTO user (id, name, surname, initiais, email, status, createUser, createTimestamp, updateUser, updateTimestamp, password) VALUES ('1', 'Nelson', 'Silva', 'NS', 'nsl@t2change.com', TRUE, 'SYSTEM', now(), 'SYSTEM', now(), md5('nsl'));

-- Kickoff Log
insert into systemAuditLog(auditTimestamp, auditUser, operation, details) values (now(), 'SYSTEM', 'T2C System installed.', 'T2C System version 1.0 deployed.');



update app___zsystem_db_info set database_version = 4;



-- ---------------------------------------------------------------------------------------------------------------------------
