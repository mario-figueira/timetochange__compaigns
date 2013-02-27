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


-- Carregamento de países
insert into country (idCountry, country) values (1, 'Afeganistão');
insert into country (idCountry, country) values (2, 'África do Sul');
insert into country (idCountry, country) values (3, 'Albânia');
insert into country (idCountry, country) values (4, 'Alemanha');
insert into country (idCountry, country) values (5, 'Andorra');
insert into country (idCountry, country) values (6, 'Angola');
insert into country (idCountry, country) values (7, 'Argélia');
insert into country (idCountry, country) values (8, 'Argentina');
insert into country (idCountry, country) values (9, 'Arménia');
insert into country (idCountry, country) values (10, 'Austrália');
insert into country (idCountry, country) values (11, 'Áustria');
insert into country (idCountry, country) values (12, 'Azerbaijão');
insert into country (idCountry, country) values (13, 'Bangladesh');
insert into country (idCountry, country) values (14, 'Bélgica');
insert into country (idCountry, country) values (15, 'Benim');
insert into country (idCountry, country) values (16, 'Bermudas');
insert into country (idCountry, country) values (17, 'Bielorrússia');
insert into country (idCountry, country) values (18, 'Bolívia');
insert into country (idCountry, country) values (19, 'Bósnia e Herzegovina');
insert into country (idCountry, country) values (20, 'Brasil');
insert into country (idCountry, country) values (21, 'Brunei');
insert into country (idCountry, country) values (22, 'Bulgária');
insert into country (idCountry, country) values (23, 'Burquina Faso');
insert into country (idCountry, country) values (24, 'Burúndi');
insert into country (idCountry, country) values (25, 'Butão');
insert into country (idCountry, country) values (26, 'Cabo Verde');
insert into country (idCountry, country) values (27, 'Camarões');
insert into country (idCountry, country) values (28, 'Camboja');
insert into country (idCountry, country) values (29, 'Canadá');
insert into country (idCountry, country) values (30, 'Cazaquistão');
insert into country (idCountry, country) values (31, 'Chade');
insert into country (idCountry, country) values (32, 'Chile');
insert into country (idCountry, country) values (33, 'China');
insert into country (idCountry, country) values (34, 'Chipre');
insert into country (idCountry, country) values (35, 'Colômbia');
insert into country (idCountry, country) values (36, 'Coreia do Sul');
insert into country (idCountry, country) values (37, 'Costa do Marfim');
insert into country (idCountry, country) values (38, 'Costa Rica');
insert into country (idCountry, country) values (39, 'Croácia');
insert into country (idCountry, country) values (40, 'Cuba');
insert into country (idCountry, country) values (41, 'Dinamarca');
insert into country (idCountry, country) values (42, 'Equador');
insert into country (idCountry, country) values (43, 'Eslováquia');
insert into country (idCountry, country) values (44, 'Eslovénia');
insert into country (idCountry, country) values (45, 'Espanha');
insert into country (idCountry, country) values (46, 'Estados Unidos');
insert into country (idCountry, country) values (47, 'Estónia');
insert into country (idCountry, country) values (48, 'Etiópia');
insert into country (idCountry, country) values (49, 'Filipinas');
insert into country (idCountry, country) values (50, 'Finlândia');
insert into country (idCountry, country) values (51, 'França');
insert into country (idCountry, country) values (52, 'Grécia');
insert into country (idCountry, country) values (53, 'Guatemala');
insert into country (idCountry, country) values (54, 'Haiti');
insert into country (idCountry, country) values (55, 'Honduras');
insert into country (idCountry, country) values (56, 'Hungria');
insert into country (idCountry, country) values (57, 'Iémen');
insert into country (idCountry, country) values (58, 'Índia');
insert into country (idCountry, country) values (59, 'Indonésia');
insert into country (idCountry, country) values (60, 'Irão');
insert into country (idCountry, country) values (61, 'Iraque');
insert into country (idCountry, country) values (62, 'Irlanda');
insert into country (idCountry, country) values (63, 'Islândia');
insert into country (idCountry, country) values (64, 'Israel');
insert into country (idCountry, country) values (65, 'Itália');
insert into country (idCountry, country) values (66, 'Jamaica');
insert into country (idCountry, country) values (67, 'Japão');
insert into country (idCountry, country) values (68, 'Letónia');
insert into country (idCountry, country) values (69, 'Líbano');
insert into country (idCountry, country) values (70, 'Libéria');
insert into country (idCountry, country) values (71, 'Líbia');
insert into country (idCountry, country) values (72, 'Listenstaine');
insert into country (idCountry, country) values (73, 'Lituânia');
insert into country (idCountry, country) values (74, 'Luxemburgo');
insert into country (idCountry, country) values (75, 'Macedónia');
insert into country (idCountry, country) values (76, 'Madagáscar');
insert into country (idCountry, country) values (77, 'Malásia');
insert into country (idCountry, country) values (78, 'Maldivas');
insert into country (idCountry, country) values (79, 'Mali');
insert into country (idCountry, country) values (80, 'Malta');
insert into country (idCountry, country) values (81, 'Marrocos');
insert into country (idCountry, country) values (82, 'México');
insert into country (idCountry, country) values (83, 'Moçambique');
insert into country (idCountry, country) values (84, 'Moldávia');
insert into country (idCountry, country) values (85, 'Mónaco');
insert into country (idCountry, country) values (86, 'Mongólia');
insert into country (idCountry, country) values (87, 'Montenegro');
insert into country (idCountry, country) values (88, 'Myanmar');
insert into country (idCountry, country) values (89, 'Nepal');
insert into country (idCountry, country) values (90, 'Nicarágua');
insert into country (idCountry, country) values (91, 'Níger');
insert into country (idCountry, country) values (92, 'Nigéria');
insert into country (idCountry, country) values (93, 'Noruega');
insert into country (idCountry, country) values (94, 'Nova Zelândia');
insert into country (idCountry, country) values (95, 'Países Baixos');
insert into country (idCountry, country) values (96, 'Panamá');
insert into country (idCountry, country) values (97, 'Papua-Nova Guiné');
insert into country (idCountry, country) values (98, 'Paquistão');
insert into country (idCountry, country) values (99, 'Paraguai');
insert into country (idCountry, country) values (100, 'Peru');
insert into country (idCountry, country) values (101, 'Polónia');
insert into country (idCountry, country) values (102, 'Portugal');
insert into country (idCountry, country) values (103, 'Quénia');
insert into country (idCountry, country) values (104, 'Quirguizistão');
insert into country (idCountry, country) values (105, 'Reino Unido');
insert into country (idCountry, country) values (106, 'República Centro-Africana');
insert into country (idCountry, country) values (107, 'República Checa');
insert into country (idCountry, country) values (108, 'República Dominicana');
insert into country (idCountry, country) values (109, 'Roménia');
insert into country (idCountry, country) values (110, 'Rússia');
insert into country (idCountry, country) values (111, 'Salvador');
insert into country (idCountry, country) values (112, 'São Marinho');
insert into country (idCountry, country) values (113, 'Senegal');
insert into country (idCountry, country) values (114, 'Sérvia');
insert into country (idCountry, country) values (115, 'Singapura');
insert into country (idCountry, country) values (116, 'Somália');
insert into country (idCountry, country) values (117, 'Sri Lanca');
insert into country (idCountry, country) values (118, 'Suazilândia');
insert into country (idCountry, country) values (119, 'Suécia');
insert into country (idCountry, country) values (120, 'Suíça');
insert into country (idCountry, country) values (121, 'Tailândia');
insert into country (idCountry, country) values (122, 'Taiwan');
insert into country (idCountry, country) values (123, 'Tanzânia');
insert into country (idCountry, country) values (124, 'Timor Leste');
insert into country (idCountry, country) values (125, 'Tunísia');
insert into country (idCountry, country) values (126, 'Turquia');
insert into country (idCountry, country) values (127, 'Ucrânia');
insert into country (idCountry, country) values (128, 'Uganda');
insert into country (idCountry, country) values (129, 'Uruguai');
insert into country (idCountry, country) values (130, 'Usbequistão');
insert into country (idCountry, country) values (131, 'Vaticano');
insert into country (idCountry, country) values (132, 'Venezuela');
insert into country (idCountry, country) values (133, 'Vietname');
insert into country (idCountry, country) values (134, 'Zimbabué');

-- Tipos de Campanha
insert into campaignType (idCampaignType, name, description) values (1, 'Votação', 'Sorteio de chama vencedora numa votação.');
insert into campaignType (idCampaignType, name, description) values (2, 'Chamada Dourada', 'Chamada vencedora a cada X chamadas recebidas.');

-- Tipos de Prompt
insert into promptType (idPromptType, type, description, auditUser, auditTimestamp) values (1, 'Entrada', 'Prompt usada na entrada da chamada.', 'SYSTEM', now());
insert into promptType (idPromptType, type, description, auditUser, auditTimestamp) values (2, 'Saída', 'Prompt usada na saída da chamada.', 'SYSTEM', now());
insert into promptType (idPromptType, type, description, auditUser, auditTimestamp) values (3, 'Vencedor', 'Prompt usada no anúncio de chamada vencedora.', 'SYSTEM', now());


-- Tipos de Prompt por Tipos de Campanha
insert into promptTypeByCampaignType (idCampaignType, idPromptType, mandatory) values (1,1, True);
insert into promptTypeByCampaignType (idCampaignType, idPromptType, mandatory) values (1,2, False);
insert into promptTypeByCampaignType (idCampaignType, idPromptType, mandatory) values (2,1, True);
insert into promptTypeByCampaignType (idCampaignType, idPromptType, mandatory) values (2,2, True);
insert into promptTypeByCampaignType (idCampaignType, idPromptType, mandatory) values (2,3, True);




update app___zsystem_db_info set database_version = 4;

-- ---------------------------------------------------------------------------------------------------------------------------








