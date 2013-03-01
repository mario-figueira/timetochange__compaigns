/**
 * Time2Change 
 * Databases Model
 */

-- BACKOFFICE DATABASE 
DROP DATABASE `ttcbo`;
CREATE DATABASE `ttcbo` CHARACTER SET=utf8 COLLATE = utf8_general_ci;

-- CALL REGISTRATION DATABASE 
DROP DATABASE `ttccr`;
CREATE DATABASE `ttccr` CHARACTER SET=utf8 COLLATE = utf8_general_ci;


-- TABLES

-- BACKOFFICE
USE `ttcbo`;

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


-- CALL REGISTRATION
USE `ttccr`;

CREATE TABLE IF NOT EXISTS `incoming` (
    `id` BIGINT(20) UNSIGNED NOT NULL COMMENT 'Incoming Identifier (Synchronized with Incoming Extended Identifier)',
    `idAlias` VARCHAR(50) NOT NULL DEFAULT '0' COMMENT 'Identifier for Campaing Alias (campaignAliases.alias) telephone number to where the call was made)',
    `msisdn` VARCHAR(20) NOT NULL DEFAULT '0' COMMENT 'Telephone number of the person that called',
    `callDate` DATETIME NULL DEFAULT NULL COMMENT 'Call timestamp (also used for audit and synchronization)',
    `callDuration` BIGINT(10) NULL DEFAULT NULL COMMENT 'Call duration',
    PRIMARY KEY (`id`),
    INDEX `idx_data_alias` (`callDate` ASC , `idAlias` ASC),
    INDEX `idx_alias` (`idAlias` ASC)/*,
    CONSTRAINT `fk_incoming_alias_id` FOREIGN KEY (`idAlias`)
        REFERENCES `alias` (`id`)
        ON DELETE NO ACTION ON UPDATE NO ACTION*/
)  COMMENT 'Incoming Calls - Main' ENGINE=MyISAM DEFAULT CHARACTER SET=utf8 COLLATE = utf8_general_ci;

CREATE TABLE IF NOT EXISTS `incomingExtended` (
    `id` BIGINT(20) UNSIGNED NOT NULL COMMENT 'Incoming Extended Indentifier (Synchronized with Incoming Identifier)',
    `messageReceived` VARCHAR(255) NULL DEFAULT NULL COMMENT 'Message received',
    `lida` TINYINT(1) NULL DEFAULT '0' COMMENT 'Read',
    `deleted` TINYINT(1) NULL DEFAULT '0' COMMENT 'Deleted',
    `audioFile` VARCHAR(40) NULL DEFAULT NULL COMMENT 'Audio file',
    `connectRadius` VARCHAR(80) NULL DEFAULT NULL COMMENT 'Radius connect string',
    `disconnectRadius` VARCHAR(80) NULL DEFAULT NULL COMMENT 'Radius disconnect string',
    PRIMARY KEY (`id`)/*,
    CONSTRAINT `fk_incomingExtended_incoming_id` FOREIGN KEY (`id`)
        REFERENCES `incoming` (`id`)
        ON DELETE NO ACTION ON UPDATE NO ACTION*/
)  COMMENT 'Incoming Calls - Main' ENGINE=MyISAM DEFAULT CHARACTER SET=utf8 COLLATE = utf8_general_ci;
-- END CALL REGISTRATION

-- END TABLES



-- TRIGGERS
delimiter //
use `ttcbo`//

CREATE TRIGGER `systemSettings_updateTimestamp` BEFORE UPDATE ON `systemSettings`
    FOR EACH ROW
    BEGIN
         SET NEW.timestamp = now();
END;//

delimiter ;
-- END TRIGGERS


-- VIEWS
use `ttcbo`;

-- Basic view over contest users
CREATE OR REPLACE VIEW `contestUsers` AS
    select 
        i.id as idIncoming,
        i.idAlias,
        i.msisdn,
        i.callDate,	
        ca.idCampaign
    from
        `ttccr`.`Incoming` as i
            inner join
        `ttcbo`.`msisdnExcluded` ex ON i.msisdn <> ex.msisdn
            inner join
        `ttcbo`.`campaignAliases` as ca ON i.idAlias = ca.alias
-- END VIEWS