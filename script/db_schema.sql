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








CREATE TABLE IF NOT EXISTS `auditLog` (
    `auditTimestamp` TIMESTAMP NOT NULL COMMENT 'Audit timestamp ',
    `auditUser` VARCHAR(25) NOT NULL COMMENT 'Audit user',
    `operation` VARCHAR(255) NOT NULL COMMENT 'Operation',
    PRIMARY KEY (`auditTimestamp` , `auditUser`)
)  COMMENT 'Audit log' ENGINE=InnoDB DEFAULT CHARACTER SET=utf8 COLLATE = utf8_general_ci;


CREATE TABLE IF NOT EXISTS `country` (
    `idCountry` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Identifier',
    `country` VARCHAR(35) NULL DEFAULT NULL COMMENT 'Country',
    PRIMARY KEY (`idCountry`)
)  COMMENT 'Countries' ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARACTER SET=utf8 COLLATE = utf8_general_ci;

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
)  COMMENT 'Accounts' ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARACTER SET=utf8 COLLATE = utf8_general_ci;



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
)  COMMENT 'Telephone Numbers' ENGINE=InnoDB DEFAULT CHARACTER SET=utf8 COLLATE = utf8_general_ci;


CREATE TABLE IF NOT EXISTS `promptType` (
    `idPromptType` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Identifier', 
    `type` VARCHAR(25) NOT NULL COMMENT 'Type of prompt', 
    `description` VARCHAR(255) NOT NULL COMMENT 'Prompt description', 
    `auditUser` VARCHAR(25) NOT NULL COMMENT 'User responsible for the current data',
    `auditTimestamp` TIMESTAMP NOT NULL COMMENT 'Timestamp of the current data',
	PRIMARY KEY (`idPromptType`)
)  COMMENT 'Types of  prompt (associate with the campaign mechanism)' ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARACTER SET=utf8 COLLATE = utf8_general_ci;

CREATE TABLE IF NOT EXISTS `campaignType` (
    `idCampaignType` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT  COMMENT 'Identifier',
    `name` VARCHAR(20) NOT NULL  COMMENT 'Capaign type name',
    `description` VARCHAR(255) NULL DEFAULT NULL COMMENT 'Capaign type description',
    PRIMARY KEY (`idCampaignType`)
)   COMMENT 'Typs of Campaigns' ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARACTER SET=utf8 COLLATE = utf8_general_ci;

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
)  COMMENT 'Prompt Types by Campaign Types' ENGINE=InnoDB DEFAULT CHARACTER SET=utf8 COLLATE = utf8_general_ci;


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
)  COMMENT 'Campaigns' ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARACTER SET=utf8 COLLATE = utf8_general_ci;

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
)  COMMENT 'Prompts' ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARACTER SET=utf8 COLLATE = utf8_general_ci;

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
)  COMMENT 'Campaign Telephone Numbers' ENGINE=InnoDB DEFAULT CHARACTER SET=utf8 COLLATE = utf8_general_ci;





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
)  COMMENT 'Incoming Calls - Main' ENGINE=InnoDB DEFAULT CHARACTER SET=utf8 COLLATE = utf8_general_ci;

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
)  COMMENT 'Incoming Calls - Main' ENGINE=InnoDB DEFAULT CHARACTER SET=utf8 COLLATE = utf8_general_ci;



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
)  COMMENT 'Users' ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARACTER SET=utf8 COLLATE = utf8_general_ci;


update app___zsystem_db_info set database_version = 3;


-- ---------------------------------------------------------------------------------------------------------------------------


-- Carregamento de pa�ses
insert into country (idCountry, country) values (1, 'Afeganist�o');
insert into country (idCountry, country) values (2, '�frica do Sul');
insert into country (idCountry, country) values (3, 'Alb�nia');
insert into country (idCountry, country) values (4, 'Alemanha');
insert into country (idCountry, country) values (5, 'Andorra');
insert into country (idCountry, country) values (6, 'Angola');
insert into country (idCountry, country) values (7, 'Arg�lia');
insert into country (idCountry, country) values (8, 'Argentina');
insert into country (idCountry, country) values (9, 'Arm�nia');
insert into country (idCountry, country) values (10, 'Austr�lia');
insert into country (idCountry, country) values (11, '�ustria');
insert into country (idCountry, country) values (12, 'Azerbaij�o');
insert into country (idCountry, country) values (13, 'Bangladesh');
insert into country (idCountry, country) values (14, 'B�lgica');
insert into country (idCountry, country) values (15, 'Benim');
insert into country (idCountry, country) values (16, 'Bermudas');
insert into country (idCountry, country) values (17, 'Bielorr�ssia');
insert into country (idCountry, country) values (18, 'Bol�via');
insert into country (idCountry, country) values (19, 'B�snia e Herzegovina');
insert into country (idCountry, country) values (20, 'Brasil');
insert into country (idCountry, country) values (21, 'Brunei');
insert into country (idCountry, country) values (22, 'Bulg�ria');
insert into country (idCountry, country) values (23, 'Burquina Faso');
insert into country (idCountry, country) values (24, 'Bur�ndi');
insert into country (idCountry, country) values (25, 'But�o');
insert into country (idCountry, country) values (26, 'Cabo Verde');
insert into country (idCountry, country) values (27, 'Camar�es');
insert into country (idCountry, country) values (28, 'Camboja');
insert into country (idCountry, country) values (29, 'Canad�');
insert into country (idCountry, country) values (30, 'Cazaquist�o');
insert into country (idCountry, country) values (31, 'Chade');
insert into country (idCountry, country) values (32, 'Chile');
insert into country (idCountry, country) values (33, 'China');
insert into country (idCountry, country) values (34, 'Chipre');
insert into country (idCountry, country) values (35, 'Col�mbia');
insert into country (idCountry, country) values (36, 'Coreia do Sul');
insert into country (idCountry, country) values (37, 'Costa do Marfim');
insert into country (idCountry, country) values (38, 'Costa Rica');
insert into country (idCountry, country) values (39, 'Cro�cia');
insert into country (idCountry, country) values (40, 'Cuba');
insert into country (idCountry, country) values (41, 'Dinamarca');
insert into country (idCountry, country) values (42, 'Equador');
insert into country (idCountry, country) values (43, 'Eslov�quia');
insert into country (idCountry, country) values (44, 'Eslov�nia');
insert into country (idCountry, country) values (45, 'Espanha');
insert into country (idCountry, country) values (46, 'Estados Unidos');
insert into country (idCountry, country) values (47, 'Est�nia');
insert into country (idCountry, country) values (48, 'Eti�pia');
insert into country (idCountry, country) values (49, 'Filipinas');
insert into country (idCountry, country) values (50, 'Finl�ndia');
insert into country (idCountry, country) values (51, 'Fran�a');
insert into country (idCountry, country) values (52, 'Gr�cia');
insert into country (idCountry, country) values (53, 'Guatemala');
insert into country (idCountry, country) values (54, 'Haiti');
insert into country (idCountry, country) values (55, 'Honduras');
insert into country (idCountry, country) values (56, 'Hungria');
insert into country (idCountry, country) values (57, 'I�men');
insert into country (idCountry, country) values (58, '�ndia');
insert into country (idCountry, country) values (59, 'Indon�sia');
insert into country (idCountry, country) values (60, 'Ir�o');
insert into country (idCountry, country) values (61, 'Iraque');
insert into country (idCountry, country) values (62, 'Irlanda');
insert into country (idCountry, country) values (63, 'Isl�ndia');
insert into country (idCountry, country) values (64, 'Israel');
insert into country (idCountry, country) values (65, 'It�lia');
insert into country (idCountry, country) values (66, 'Jamaica');
insert into country (idCountry, country) values (67, 'Jap�o');
insert into country (idCountry, country) values (68, 'Let�nia');
insert into country (idCountry, country) values (69, 'L�bano');
insert into country (idCountry, country) values (70, 'Lib�ria');
insert into country (idCountry, country) values (71, 'L�bia');
insert into country (idCountry, country) values (72, 'Listenstaine');
insert into country (idCountry, country) values (73, 'Litu�nia');
insert into country (idCountry, country) values (74, 'Luxemburgo');
insert into country (idCountry, country) values (75, 'Maced�nia');
insert into country (idCountry, country) values (76, 'Madag�scar');
insert into country (idCountry, country) values (77, 'Mal�sia');
insert into country (idCountry, country) values (78, 'Maldivas');
insert into country (idCountry, country) values (79, 'Mali');
insert into country (idCountry, country) values (80, 'Malta');
insert into country (idCountry, country) values (81, 'Marrocos');
insert into country (idCountry, country) values (82, 'M�xico');
insert into country (idCountry, country) values (83, 'Mo�ambique');
insert into country (idCountry, country) values (84, 'Mold�via');
insert into country (idCountry, country) values (85, 'M�naco');
insert into country (idCountry, country) values (86, 'Mong�lia');
insert into country (idCountry, country) values (87, 'Montenegro');
insert into country (idCountry, country) values (88, 'Myanmar');
insert into country (idCountry, country) values (89, 'Nepal');
insert into country (idCountry, country) values (90, 'Nicar�gua');
insert into country (idCountry, country) values (91, 'N�ger');
insert into country (idCountry, country) values (92, 'Nig�ria');
insert into country (idCountry, country) values (93, 'Noruega');
insert into country (idCountry, country) values (94, 'Nova Zel�ndia');
insert into country (idCountry, country) values (95, 'Pa�ses Baixos');
insert into country (idCountry, country) values (96, 'Panam�');
insert into country (idCountry, country) values (97, 'Papua-Nova Guin�');
insert into country (idCountry, country) values (98, 'Paquist�o');
insert into country (idCountry, country) values (99, 'Paraguai');
insert into country (idCountry, country) values (100, 'Peru');
insert into country (idCountry, country) values (101, 'Pol�nia');
insert into country (idCountry, country) values (102, 'Portugal');
insert into country (idCountry, country) values (103, 'Qu�nia');
insert into country (idCountry, country) values (104, 'Quirguizist�o');
insert into country (idCountry, country) values (105, 'Reino Unido');
insert into country (idCountry, country) values (106, 'Rep�blica Centro-Africana');
insert into country (idCountry, country) values (107, 'Rep�blica Checa');
insert into country (idCountry, country) values (108, 'Rep�blica Dominicana');
insert into country (idCountry, country) values (109, 'Rom�nia');
insert into country (idCountry, country) values (110, 'R�ssia');
insert into country (idCountry, country) values (111, 'Salvador');
insert into country (idCountry, country) values (112, 'S�o Marinho');
insert into country (idCountry, country) values (113, 'Senegal');
insert into country (idCountry, country) values (114, 'S�rvia');
insert into country (idCountry, country) values (115, 'Singapura');
insert into country (idCountry, country) values (116, 'Som�lia');
insert into country (idCountry, country) values (117, 'Sri Lanca');
insert into country (idCountry, country) values (118, 'Suazil�ndia');
insert into country (idCountry, country) values (119, 'Su�cia');
insert into country (idCountry, country) values (120, 'Su��a');
insert into country (idCountry, country) values (121, 'Tail�ndia');
insert into country (idCountry, country) values (122, 'Taiwan');
insert into country (idCountry, country) values (123, 'Tanz�nia');
insert into country (idCountry, country) values (124, 'Timor Leste');
insert into country (idCountry, country) values (125, 'Tun�sia');
insert into country (idCountry, country) values (126, 'Turquia');
insert into country (idCountry, country) values (127, 'Ucr�nia');
insert into country (idCountry, country) values (128, 'Uganda');
insert into country (idCountry, country) values (129, 'Uruguai');
insert into country (idCountry, country) values (130, 'Usbequist�o');
insert into country (idCountry, country) values (131, 'Vaticano');
insert into country (idCountry, country) values (132, 'Venezuela');
insert into country (idCountry, country) values (133, 'Vietname');
insert into country (idCountry, country) values (134, 'Zimbabu�');

-- Tipos de Campanha
insert into campaignType (idCampaignType, name, description) values (1, 'Vota��o', 'Sorteio de chama vencedora numa vota��o.');
insert into campaignType (idCampaignType, name, description) values (2, 'Chamada Dourada', 'Chamada vencedora a cada X chamadas recebidas.');

-- Tipos de Prompt
insert into promptType (idPromptType, type, description, auditUser, auditTimestamp) values (1, 'Entrada', 'Prompt usada na entrada da chamada.', 'SYSTEM', now());
insert into promptType (idPromptType, type, description, auditUser, auditTimestamp) values (2, 'Sa�da', 'Prompt usada na sa�da da chamada.', 'SYSTEM', now());
insert into promptType (idPromptType, type, description, auditUser, auditTimestamp) values (3, 'Vencedor', 'Prompt usada no an�ncio de chamada vencedora.', 'SYSTEM', now());


-- Tipos de Prompt por Tipos de Campanha
insert into promptTypeByCampaignType (idCampaignType, idPromptType, mandatory) values (1,1, True);
insert into promptTypeByCampaignType (idCampaignType, idPromptType, mandatory) values (1,2, False);
insert into promptTypeByCampaignType (idCampaignType, idPromptType, mandatory) values (2,1, True);
insert into promptTypeByCampaignType (idCampaignType, idPromptType, mandatory) values (2,2, True);
insert into promptTypeByCampaignType (idCampaignType, idPromptType, mandatory) values (2,3, True);




update app___zsystem_db_info set database_version = 4;

-- ---------------------------------------------------------------------------------------------------------------------------








