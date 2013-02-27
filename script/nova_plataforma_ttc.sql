/**
 * Time2Change Database Model
 */

/*
drop database `ttc`;
create database `ttc`;
*/

USE `ttc`;


CREATE TABLE IF NOT EXISTS `auditLog` (
    `auditTimestamp` TIMESTAMP NOT NULL COMMENT 'Audit timestamp ',
    `auditUser` VARCHAR(25) NOT NULL COMMENT 'Audit user',
    `operation` VARCHAR(255) NOT NULL COMMENT 'Operation',
    PRIMARY KEY (`auditTimestamp` , `auditUser`)
)  COMMENT 'Audit log' ENGINE=InnoDB DEFAULT CHARACTER SET=latin1 COLLATE = latin1_general_ci;


CREATE TABLE IF NOT EXISTS `country` (
    `idCountry` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Identifier',
    `country` VARCHAR(35) NULL DEFAULT NULL COMMENT 'Country',
    PRIMARY KEY (`idCountry`)
)  COMMENT 'Countries' ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARACTER SET=latin1 COLLATE = latin1_general_ci;

CREATE TABLE IF NOT EXISTS `account` (
    `idAccount` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Identifier',
    `name` VARCHAR(100) NOT NULL COMMENT 'Account name',
    `logo` VARCHAR(255) NOT NULL COMMENT 'Path for logo file',
    `phone` BIGINT(20) NULL DEFAULT NULL COMMENT 'Contact telephone',
    `fax` BIGINT(20) NULL DEFAULT NULL COMMENT 'Contact fax',
    `email` VARCHAR(200) NULL DEFAULT NULL COMMENT 'Contact email',
    `address` VARCHAR(255) NULL DEFAULT NULL COMMENT 'Address',
    `zip` VARCHAR(255) NULL DEFAULT NULL COMMENT 'Zip code',
    `city` VARCHAR(255) NULL DEFAULT NULL COMMENT 'City',
    `idCountry` INT(10) UNSIGNED NOT NULL COMMENT 'Country',
    `notes` VARCHAR(255) NULL DEFAULT NULL COMMENT 'Notes',
    `status` BOOLEAN NOT NULL DEFAULT TRUE COMMENT 'Account state (active/inactive)',
    `auditUser` VARCHAR(25) NOT NULL COMMENT 'User responsible for the current data',
    `auditTimestamp` TIMESTAMP NOT NULL COMMENT 'Timestamp of the current data',
    PRIMARY KEY (`idAccount`),
    CONSTRAINT `fk_account_country_id` FOREIGN KEY (`idCountry`)
        REFERENCES `country` (`idCountry`)
        ON DELETE NO ACTION ON UPDATE NO ACTION
)  COMMENT 'Accounts' ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARACTER SET=latin1 COLLATE = latin1_general_ci;



CREATE TABLE IF NOT EXISTS `alias` (
    `idAlias` VARCHAR(20) NOT NULL COMMENT 'Indentifier',
    `alias` VARCHAR(45) NOT NULL DEFAULT '' COMMENT 'Telephone number',
    `la` INT UNSIGNED NOT NULL COMMENT 'Telephone number prefix',
    `idAccount` INT UNSIGNED NULL DEFAULT NULL COMMENT 'Account to which the number belongs to',
    `auditUser` VARCHAR(25) NOT NULL COMMENT 'User responsible for the current data',
    `auditTimestamp` TIMESTAMP NOT NULL COMMENT 'Timestamp of the current data',
    PRIMARY KEY (`idAlias`),
    INDEX `idx_alias` (`alias` ASC),
    CONSTRAINT `fk_alias_account_id` FOREIGN KEY (`idAccount`)
        REFERENCES `account` (`idAccount`)
        ON DELETE NO ACTION ON UPDATE NO ACTION
)  COMMENT 'Telephone Numbers' ENGINE=InnoDB DEFAULT CHARACTER SET=latin1 COLLATE = latin1_general_ci;


CREATE TABLE IF NOT EXISTS `promptType` (
    `idPromptType` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Identifier', 
    `type` VARCHAR(25) NOT NULL COMMENT 'Type of prompt', 
    `description` VARCHAR(255) NOT NULL COMMENT 'Prompt description', 
    `auditUser` VARCHAR(25) NOT NULL COMMENT 'User responsible for the current data',
    `auditTimestamp` TIMESTAMP NOT NULL COMMENT 'Timestamp of the current data',
	PRIMARY KEY (`idPromptType`)
)  COMMENT 'Types of  prompt (associate with the campaign mechanism)' ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARACTER SET=latin1 COLLATE = latin1_general_ci;

CREATE TABLE IF NOT EXISTS `campaignType` (
    `idCampaignType` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT  COMMENT 'Identifier',
    `name` VARCHAR(20) NOT NULL  COMMENT 'Capaign type name',
    `description` VARCHAR(255) NULL DEFAULT NULL COMMENT 'Capaign type description',
    PRIMARY KEY (`idCampaignType`)
)   COMMENT 'Typs of Campaigns' ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARACTER SET=latin1 COLLATE = latin1_general_ci;

CREATE TABLE IF NOT EXISTS `promptTypeByCampaignType` (
	`idCampaignType` INT(10) UNSIGNED NOT NULL COMMENT 'Type of campaign',
	`idPromptType` INT(10) UNSIGNED NOT NULL COMMENT 'Type of prompt',
	`mandatory` BOOLEAN NOT NULL  COMMENT 'States if the prompt type is mandatory for the campaign type',
	PRIMARY KEY (`idCampaignType`, `idPromptType`),
    CONSTRAINT `fk_PromptCampaign_campaignType_id` FOREIGN KEY (`idCampaignType`)
        REFERENCES `campaignType` (`idCampaignType`)
        ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_PromptCampaign_promptType_id` FOREIGN KEY (`idPromptType`)
        REFERENCES `promptType` (`idPromptType`)
        ON DELETE NO ACTION ON UPDATE NO ACTION
)  COMMENT 'Prompt Types by Campaign Types' ENGINE=InnoDB DEFAULT CHARACTER SET=latin1 COLLATE = latin1_general_ci;


CREATE TABLE IF NOT EXISTS `campaign` (
    `idCampaign` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Identifier', 
    `name` VARCHAR(100) NOT NULL COMMENT 'Campaign name',
    `idCampaignType` INT(10) UNSIGNED NOT NULL COMMENT 'Type of campaign',
    `logo` VARCHAR(255) NULL DEFAULT NULL COMMENT 'Path for the logo file',
    `rules` VARCHAR(255) NULL DEFAULT NULL COMMENT 'Path for the rules document',
    `startDate` DATETIME NOT NULL COMMENT 'Campaign start date',
    `endDate` DATETIME NULL DEFAULT NULL COMMENT 'Campaign end date',
    `status` BOOLEAN NOT NULL DEFAULT TRUE COMMENT 'Account status (active/inactive)',
    `auditUser` VARCHAR(25) NOT NULL COMMENT 'User responsible for the current data',
    `auditTimestamp` TIMESTAMP NOT NULL COMMENT 'Timestamp of the current data',
    PRIMARY KEY (`idCampaign`),
    CONSTRAINT `fk_campaign_campaignType_id` FOREIGN KEY (`idCampaignType`)
        REFERENCES `campaignType` (`idCampaignType`)
        ON DELETE NO ACTION ON UPDATE NO ACTION
)  COMMENT 'Campaigns' ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARACTER SET=latin1 COLLATE = latin1_general_ci;

CREATE TABLE IF NOT EXISTS `prompt` (
    `idPrompt` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Identifier', 
    `name` VARCHAR(50) NOT NULL COMMENT 'Prompt name',
    `prompt` VARCHAR(255) NOT NULL COMMENT 'Path for prompt audio file',
    `description` VARCHAR(255) NULL DEFAULT NULL COMMENT 'Prompt description',
	`idCampaign` INT(10) UNSIGNED NOT NULL COMMENT 'Campaign',
    `auditUser` VARCHAR(25) NOT NULL COMMENT 'User responsible for the current data',
    `auditTimestamp` TIMESTAMP NOT NULL COMMENT 'Timestamp of the current data',
    PRIMARY KEY (`idPrompt`),
    CONSTRAINT `fk_prompt_campaign_id` FOREIGN KEY (`idCampaign`)
        REFERENCES `campaign` (`idCampaign`)
        ON DELETE NO ACTION ON UPDATE NO ACTION
)  COMMENT 'Prompts' ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARACTER SET=latin1 COLLATE = latin1_general_ci;

CREATE TABLE IF NOT EXISTS `numbers` (
    `idCampaign` INT(10) UNSIGNED NOT NULL COMMENT 'Campaign identifier', 
    `idAlias` VARCHAR(20) NOT NULL COMMENT 'Alias identifier', 
    `idPrompt` INT(10) UNSIGNED NOT NULL COMMENT 'Prompt identifier', 
    `idPromptType` INT(10) UNSIGNED NOT NULL COMMENT 'Prompt type (associated with the campaign mechanism)', 
    `auditUser` VARCHAR(25) NOT NULL COMMENT 'User responsible for the current data',
    `auditTimestamp` TIMESTAMP NOT NULL COMMENT 'Timestamp of the current data',
    PRIMARY KEY (`idCampaign`, `idAlias`, `idPrompt`, `idPromptType`),
    CONSTRAINT `fk_number_campaign_id` FOREIGN KEY (`idCampaign`)
        REFERENCES `campaign` (`idCampaign`)
        ON DELETE NO ACTION ON UPDATE NO ACTION,
	CONSTRAINT `fk_number_alias_id` FOREIGN KEY (`idAlias`)
        REFERENCES `alias` (`idAlias`)
        ON DELETE NO ACTION ON UPDATE NO ACTION,
	CONSTRAINT `fk_number_prompt_id` FOREIGN KEY (`idPrompt`)
        REFERENCES `prompt` (`idPrompt`)
        ON DELETE NO ACTION ON UPDATE NO ACTION,
	CONSTRAINT `fk_number_promptType_id` FOREIGN KEY (`idPromptType`)
        REFERENCES `promptType` (`idPromptType`)
        ON DELETE NO ACTION ON UPDATE NO ACTION
)  COMMENT 'Campaign Telephone Numbers' ENGINE=InnoDB DEFAULT CHARACTER SET=latin1 COLLATE = latin1_general_ci;





CREATE TABLE IF NOT EXISTS `incoming` (
    `idIncoming` BIGINT(20) UNSIGNED NOT NULL COMMENT 'Identifier',
    `idAlias` VARCHAR(20) NOT NULL DEFAULT '0' COMMENT 'Telephone number to where the call was made',
    `msisdn` BIGINT(20) NOT NULL DEFAULT '0' COMMENT 'Telephone number of the person that called',
    `callDate` DATETIME NULL DEFAULT NULL COMMENT 'Call timestamp (also used for audit and synchronization)',
    `callDuration` BIGINT(10) NULL DEFAULT NULL COMMENT 'Call duration',
    `idSync`BIGINT(20) UNSIGNED NOT NULL COMMENT 'Synchronization identifier',
    PRIMARY KEY (`idIncoming`),
    INDEX `idx_data_alias` (`callDate` ASC , `idAlias` ASC),
    INDEX `idx_alias` (`idAlias` ASC),
    CONSTRAINT `fk_incoming_alias_id` FOREIGN KEY (`idAlias`)
        REFERENCES `alias` (`idAlias`)
        ON DELETE NO ACTION ON UPDATE NO ACTION
)  COMMENT 'Incoming Calls - Main' ENGINE=InnoDB DEFAULT CHARACTER SET=latin1 COLLATE = latin1_general_ci;

CREATE TABLE IF NOT EXISTS `incomingExtended` (
    `idIncoming` BIGINT(20) UNSIGNED NOT NULL  COMMENT 'Indentifier',
    `messageReceived` VARCHAR(255) NULL DEFAULT NULL COMMENT 'Message received',
    `lida` TINYINT(1) NULL DEFAULT '0' COMMENT 'Read',
    `deleted` TINYINT(1) NULL DEFAULT '0' COMMENT 'Deleted',
    `audioFile` VARCHAR(40) NULL DEFAULT NULL COMMENT 'Audio file',
    `connectRadius` VARCHAR(80) NULL DEFAULT NULL COMMENT 'Radius connect string',
    `disconnectRadius` VARCHAR(80) NULL DEFAULT NULL COMMENT 'Radius disconnect string',
    PRIMARY KEY (`idIncoming`),
    CONSTRAINT `fk_incomingExtended_incoming_id` FOREIGN KEY (`idIncoming`)
        REFERENCES `incoming` (`idIncoming`)
        ON DELETE NO ACTION ON UPDATE NO ACTION
)  COMMENT 'Incoming Calls - Main' ENGINE=InnoDB DEFAULT CHARACTER SET=latin1 COLLATE = latin1_general_ci;



CREATE TABLE IF NOT EXISTS `user` (
    `idUser` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Identifier', 
    `name` VARCHAR(100) NOT NULL COMMENT 'User name',
	`surname` VARCHAR(100) NOT NULL COMMENT 'User last name',
	`initiais` VARCHAR(100) NOT NULL COMMENT 'User initials',
	`photo` VARCHAR(255) NULL DEFAULT NULL COMMENT 'Path to user photo file',
    `email` VARCHAR(200) NOT NULL COMMENT 'User email',
    `telephone` BIGINT(20) NULL DEFAULT NULL COMMENT 'Contact telephone',
    `password` VARCHAR(32) NOT NULL COMMENT 'User password',
    `status` BOOLEAN NOT NULL DEFAULT TRUE COMMENT 'User status (active/inactive)',
    `auditUser` VARCHAR(25) NOT NULL COMMENT 'User responsible for the current data',
    `auditTimestamp` TIMESTAMP NOT NULL COMMENT 'Timestamp of the current data',
    PRIMARY KEY (`idUser`)
)  COMMENT 'Users' ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARACTER SET=latin1 COLLATE = latin1_general_ci;
