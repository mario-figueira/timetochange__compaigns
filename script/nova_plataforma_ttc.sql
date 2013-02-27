/*
drop database `ttc`;
create database `ttc`;
*/
USE `ttc`;


CREATE TABLE IF NOT EXISTS `auditLog` (
    `auditTimestamp` TIMESTAMP NOT NULL COMMENT 'Timestamp de auditoria',
    `auditUser` VARCHAR(25) NOT NULL COMMENT 'Utilizador de auditoria',
    `operation` VARCHAR(255) NOT NULL COMMENT 'Operação efetuada',
    PRIMARY KEY (`auditTimestamp` , `auditUser`)
)  COMMENT 'Tabela de auditoria' ENGINE=InnoDB DEFAULT CHARACTER SET=latin1 COLLATE = latin1_general_ci;


CREATE TABLE IF NOT EXISTS `pais` (
    `idPais` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Identificador',
    `pais` VARCHAR(35) NULL DEFAULT NULL COMMENT 'País',
    PRIMARY KEY (`idPais`)
)  COMMENT 'Países' ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARACTER SET=latin1 COLLATE = latin1_general_ci;

CREATE TABLE IF NOT EXISTS `conta` (
    `idConta` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Indentificador',
    `nome` VARCHAR(100) NOT NULL COMMENT 'Nome da conta',
    `logo` VARCHAR(255) NOT NULL COMMENT 'Caminho para a localização do ficheiro de logotipo',
    `telefone` BIGINT(20) NULL DEFAULT NULL COMMENT 'Telefone de contacto',
    `fax` BIGINT(20) NULL DEFAULT NULL COMMENT 'Fax de contacto',
    `email` VARCHAR(200) NULL DEFAULT NULL COMMENT 'Email de contacto',
    `morada` VARCHAR(255) NULL DEFAULT NULL COMMENT 'Morada',
    `cp` VARCHAR(255) NULL DEFAULT NULL COMMENT 'Código Postal',
    `cidade` VARCHAR(255) NULL DEFAULT NULL COMMENT 'Cidade',
    `idPais` INT(10) UNSIGNED NOT NULL COMMENT 'País',
    `notas` VARCHAR(255) NULL DEFAULT NULL COMMENT 'Notas',
    `status` BOOLEAN NOT NULL DEFAULT TRUE COMMENT 'Estado da conta (ativa/inativa)',
    `auditUser` VARCHAR(25) NOT NULL COMMENT 'Utilizador responsável pela informação atual',
    `auditTimestamp` TIMESTAMP NOT NULL COMMENT 'Timestamp da informação atual',
    PRIMARY KEY (`idConta`),
    CONSTRAINT `fk_conta_pais_id` FOREIGN KEY (`idPais`)
        REFERENCES `pais` (`idPais`)
        ON DELETE NO ACTION ON UPDATE NO ACTION
)  COMMENT 'Contas' ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARACTER SET=latin1 COLLATE = latin1_general_ci;



CREATE TABLE IF NOT EXISTS `alias` (
    `idAlias` VARCHAR(20) NOT NULL COMMENT 'Indentificador',
    `alias` VARCHAR(45) NOT NULL DEFAULT '' COMMENT 'Número de telefone',
    `la` INT UNSIGNED NOT NULL COMMENT 'Indicativo do número',
    `idConta` INT UNSIGNED NULL DEFAULT NULL COMMENT 'Qual a conta a que pertence este número',
    `auditUser` VARCHAR(25) NOT NULL COMMENT 'Utilizador responsável pela informação atual',
    `auditTimestamp` TIMESTAMP NOT NULL COMMENT 'Timestamp da informação atual',
    PRIMARY KEY (`idAlias`),
    INDEX `idx_alias` (`alias` ASC),
    CONSTRAINT `fk_alias_conta_id` FOREIGN KEY (`idConta`)
        REFERENCES `conta` (`idConta`)
        ON DELETE NO ACTION ON UPDATE NO ACTION
)  COMMENT 'Números de Telefone' ENGINE=InnoDB DEFAULT CHARACTER SET=latin1 COLLATE = latin1_general_ci;


CREATE TABLE IF NOT EXISTS `tipoPrompt` (
    `idTipoPrompt` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Identificador', 
    `tipo` VARCHAR(25) NOT NULL COMMENT 'Tipo de prompt', 
    `descricao` VARCHAR(255) NOT NULL COMMENT 'Descrção do tipo de prompt', 
    `auditUser` VARCHAR(25) NOT NULL COMMENT 'Utilizador responsável pela informação atual',
	`auditTimestamp` TIMESTAMP NOT NULL COMMENT 'Timestamp da informação atual',
	PRIMARY KEY (`idTipoPrompt`)
)  COMMENT 'Tipos de prompt (associado à mecanica da campanha)' ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARACTER SET=latin1 COLLATE = latin1_general_ci;

CREATE TABLE IF NOT EXISTS `tipoCampanha` (
    `idTipoCampanha` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT  COMMENT 'Identificador',
    `nome` VARCHAR(20) NOT NULL  COMMENT 'Nome do tipo de campanha',
    `descricao` VARCHAR(255) NULL DEFAULT NULL COMMENT 'Descrição do tipo de campanha',
    PRIMARY KEY (`idTipoCampanha`)
)   COMMENT 'Tipos de Campanhas' ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARACTER SET=latin1 COLLATE = latin1_general_ci;

CREATE TABLE IF NOT EXISTS `tipoPromptPorTipoCampanha` (
	`idTipoCampanha` INT(10) UNSIGNED NOT NULL COMMENT 'Tipo de campanha',
	`idTipoPrompt` INT(10) UNSIGNED NOT NULL COMMENT 'Tipo de prompt',
	`obrigatorio` BOOLEAN NOT NULL  COMMENT 'Indicação se o tipo de prompt é obrigatório para o tipo de campanha',
	PRIMARY KEY (`idTipoCampanha`, `idTipoPrompt`),
    CONSTRAINT `fk_PromptCampanha_tipoCampanha_id` FOREIGN KEY (`idTipoCampanha`)
        REFERENCES `tipoCampanha` (`idTipoCampanha`)
        ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_PromptCampanha_tipoPrompt_id` FOREIGN KEY (`idTipoPrompt`)
        REFERENCES `tipoPrompt` (`idTipoPrompt`)
        ON DELETE NO ACTION ON UPDATE NO ACTION
)  COMMENT 'Campanhas' ENGINE=InnoDB DEFAULT CHARACTER SET=latin1 COLLATE = latin1_general_ci;


CREATE TABLE IF NOT EXISTS `campanha` (
    `idCampanha` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Identificador', 
    `nome` VARCHAR(100) NOT NULL COMMENT 'Nome da campanha',
    `idTipoCampanha` INT(10) UNSIGNED NOT NULL COMMENT 'Tipo de campanha',
    `logo` VARCHAR(255) NULL DEFAULT NULL COMMENT 'Caminho para a localização do ficheiro de logotigo',
    `regulamento` VARCHAR(100) NULL DEFAULT NULL COMMENT 'Caminho para a localização do ficheiro de regulamento',
    `dataInicio` DATETIME NULL DEFAULT NULL COMMENT 'Data de inicio da campanha',
    `dataFim` DATETIME NULL DEFAULT NULL COMMENT 'Data de fim da campanha',
    `status` BOOLEAN NOT NULL DEFAULT TRUE COMMENT 'Estado da conta (ativa/inativa)',
    `auditUser` VARCHAR(25) NOT NULL COMMENT 'Utilizador responsável pela informação atual',
    `auditTimestamp` TIMESTAMP NOT NULL COMMENT 'Timestamp da informação atual',
    PRIMARY KEY (`idCampanha`),
    CONSTRAINT `fk_campanha_tipoCampanha_id` FOREIGN KEY (`idTipoCampanha`)
        REFERENCES `tipoCampanha` (`idTipoCampanha`)
        ON DELETE NO ACTION ON UPDATE NO ACTION
)  COMMENT 'Campanhas' ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARACTER SET=latin1 COLLATE = latin1_general_ci;

CREATE TABLE IF NOT EXISTS `prompt` (
    `idPrompt` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Identificador', 
    `nome` VARCHAR(50) NOT NULL COMMENT 'Nome da prompt',
    `prompt` VARCHAR(255) NOT NULL COMMENT 'Caminho para a localização do ficheiro da prompt',
    `descricao` VARCHAR(255) NULL DEFAULT NULL COMMENT 'Descrição da prompt',
	`idCampanha` INT(10) UNSIGNED NOT NULL COMMENT 'Campanha',
    `auditUser` VARCHAR(25) NOT NULL COMMENT 'Utilizador responsável pela informação atual',
    `auditTimestamp` TIMESTAMP NOT NULL COMMENT 'Timestamp da informação atual',
    PRIMARY KEY (`idPrompt`),
    CONSTRAINT `fk_prompts_campanha_id` FOREIGN KEY (`idCampanha`)
        REFERENCES `campanha` (`idCampanha`)
        ON DELETE NO ACTION ON UPDATE NO ACTION
)  COMMENT 'Prompts' ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARACTER SET=latin1 COLLATE = latin1_general_ci;

CREATE TABLE IF NOT EXISTS `numeros` (
    `idCampanha` INT(10) UNSIGNED NOT NULL COMMENT 'Identificador da campanha', 
    `idAlias` VARCHAR(20) NOT NULL COMMENT 'Identificador do alias', 
    `idPrompt` INT(10) UNSIGNED NOT NULL COMMENT 'Identificador da prompt', 
    `idTipoPrompt` INT(10) UNSIGNED NOT NULL COMMENT 'Tipo de prompt (associado à mecanica da campanha)', 
    `auditUser` VARCHAR(25) NOT NULL COMMENT 'Utilizador responsável pela informação atual',
    `auditTimestamp` TIMESTAMP NOT NULL COMMENT 'Timestamp da informação atual',
    PRIMARY KEY (`idCampanha`, `idAlias`, `idPrompt`, `idTipoPrompt`),
    CONSTRAINT `fk_numero_campanha_id` FOREIGN KEY (`idCampanha`)
        REFERENCES `campanha` (`idCampanha`)
        ON DELETE NO ACTION ON UPDATE NO ACTION,
	CONSTRAINT `fk_numero_alias_id` FOREIGN KEY (`idAlias`)
        REFERENCES `alias` (`idAlias`)
        ON DELETE NO ACTION ON UPDATE NO ACTION,
	CONSTRAINT `fk_numero_prompt_id` FOREIGN KEY (`idPrompt`)
        REFERENCES `prompt` (`idPrompt`)
        ON DELETE NO ACTION ON UPDATE NO ACTION,
	CONSTRAINT `fk_numero_tipoPrompt_id` FOREIGN KEY (`idTipoPrompt`)
        REFERENCES `tipoPrompt` (`idTipoPrompt`)
        ON DELETE NO ACTION ON UPDATE NO ACTION
)  COMMENT 'Números da Campanha' ENGINE=InnoDB DEFAULT CHARACTER SET=latin1 COLLATE = latin1_general_ci;





CREATE TABLE IF NOT EXISTS `incoming` (
    `idIncoming` INT(9) NOT NULL AUTO_INCREMENT COMMENT 'Identificador',
    `idAlias` VARCHAR(20) NOT NULL DEFAULT '0' COMMENT 'Número de telefone para o qual foi feita a chamada',
    `msisdn` BIGINT(20) NOT NULL DEFAULT '0' COMMENT 'Número de telefone de quem ligou',
    `callDate` DATETIME NULL DEFAULT NULL COMMENT 'Timestamp da chamada (serve para auditoria e sincronização)',
    `callDuration` BIGINT(10) NULL DEFAULT NULL COMMENT 'Duração da chamada',
    `idSinc` bigint(20) unsigned DEFAULT NULL COMMENT 'Identificador de sincronização',
    PRIMARY KEY (`idIncoming`),
    INDEX `idx_data_alias` (`callDate` ASC , `idAlias` ASC),
    INDEX `idx_alias` (`idAlias` ASC),
    CONSTRAINT `fk_incoming_alias_id` FOREIGN KEY (`idAlias`)
        REFERENCES `alias` (`idAlias`)
        ON DELETE NO ACTION ON UPDATE NO ACTION
)  COMMENT 'Registo de chamadas - principal' ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARACTER SET=latin1 COLLATE = latin1_general_ci;

CREATE TABLE IF NOT EXISTS `incomingExtended` (
    `idIncoming` INT(9) NOT NULL COMMENT 'Chave',
    `messageReceived` VARCHAR(255) NULL DEFAULT NULL COMMENT 'Mensagem recebida',
    `lida` TINYINT(1) NULL DEFAULT '0' COMMENT 'Lida',
    `deleted` TINYINT(1) NULL DEFAULT '0' COMMENT 'Apagada',
    `audioFile` VARCHAR(40) NULL DEFAULT NULL COMMENT 'Ficheiro de audio',
    `connectRadius` VARCHAR(80) NULL DEFAULT NULL COMMENT 'Inicio de ligação Radius',
    `disconnectRadius` VARCHAR(80) NULL DEFAULT NULL COMMENT 'Fim de ligação Radius',
    `idSinc` bigint(20) unsigned DEFAULT NULL COMMENT 'Identificador de sincronização',
    PRIMARY KEY (`idIncoming`),
    CONSTRAINT `fk_incomingExtended_incoming_id` FOREIGN KEY (`idIncoming`)
        REFERENCES `incoming` (`idIncoming`)
        ON DELETE NO ACTION ON UPDATE NO ACTION
)  COMMENT 'Registo de chamadas - campos adicionais' ENGINE=InnoDB DEFAULT CHARACTER SET=latin1 COLLATE = latin1_general_ci;



CREATE TABLE IF NOT EXISTS `utilizadores` (
    `idUtilizador` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Identificador', 
    `nome` VARCHAR(100) NOT NULL COMMENT 'Nome do utilizador',
	`apelido` VARCHAR(100) NOT NULL COMMENT 'Apelido do utilizador',
	`iniciais` VARCHAR(100) NOT NULL COMMENT 'Iniciais do utilizador',
	`foto` VARCHAR(255) NULL DEFAULT NULL COMMENT 'Caminho para a localização do ficheiro de foto do utilizador',
    `email` VARCHAR(200) NOT NULL COMMENT 'Email do utilizador',
    `telefone` BIGINT(20) NULL DEFAULT NULL COMMENT 'Telefone de contacto',
    `senha` VARCHAR(32) NOT NULL COMMENT 'Código de acesso do utilizador',
    `status` BOOLEAN NOT NULL DEFAULT TRUE COMMENT 'Estado do utilizador (ativo/inativo)',
    `auditUser` VARCHAR(25) NOT NULL COMMENT 'Utilizador responsável pela informação atual',
    `auditTimestamp` TIMESTAMP NOT NULL COMMENT 'Timestamp da informação atual',
    PRIMARY KEY (`idUtilizador`)
)  COMMENT 'Utilizadores' ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARACTER SET=latin1 COLLATE = latin1_general_ci;

