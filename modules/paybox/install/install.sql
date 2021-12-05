CREATE TABLE IF NOT EXISTS `PREFIX_up2pay_transaction` (
	`id_up2pay_transaction` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`id_order` INT(10) UNSIGNED NOT NULL,
	`amount` FLOAT(12,2) NOT NULL,
	`amount_captured` FLOAT(12,2) NULL DEFAULT NULL,
	`auth_numtrans` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
	`numtrans` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
	`numappel` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
	`guarantee_3ds` TINYINT(1) NULL DEFAULT NULL,
	`card_type` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
	`captured` TINYINT(3) UNSIGNED NOT NULL DEFAULT '1',
	`date_capture` DATETIME NULL DEFAULT NULL,
	`date_add` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id_up2pay_transaction`) USING BTREE,
	INDEX `id_order` (`id_order`) USING BTREE
)
COLLATE='utf8mb4_general_ci'
ENGINE=InnoDB
;

CREATE TABLE IF NOT EXISTS `PREFIX_up2pay_refund` (
	`id_up2pay_refund` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`id_up2pay_transaction` INT(10) UNSIGNED NOT NULL,
	`amount` FLOAT(12,2) NOT NULL DEFAULT '0',
	`numtrans` VARCHAR(50) NOT NULL DEFAULT '0' COLLATE 'utf8mb4_general_ci',
	`numappel` VARCHAR(50) NOT NULL DEFAULT '0' COLLATE 'utf8mb4_general_ci',
	`date_add` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id_up2pay_refund`) USING BTREE
)
COLLATE='utf8mb4_general_ci'
ENGINE=InnoDB
;

CREATE TABLE IF NOT EXISTS `PREFIX_up2pay_subscriber` (
	`id_up2pay_subscriber` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	`id_customer` INT(11) UNSIGNED NOT NULL,
	`id_shop` INT(11) UNSIGNED NOT NULL,
	`token` VARCHAR(50) NOT NULL COLLATE 'utf8mb4_general_ci',
	`refabonne` VARCHAR(256) NOT NULL COLLATE 'utf8mb4_general_ci',
	`pan` VARCHAR(50) NOT NULL COLLATE 'utf8mb4_general_ci',
	`bin6` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
	`dateval` VARCHAR(50) NOT NULL COLLATE 'utf8mb4_general_ci',
	`card_type` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
	PRIMARY KEY (`id_up2pay_subscriber`) USING BTREE,
	INDEX `id_customer` (`id_customer`) USING BTREE,
	INDEX `id_shop` (`id_shop`) USING BTREE
)
COLLATE='utf8mb4_general_ci'
ENGINE=InnoDB
;

CREATE TABLE IF NOT EXISTS `PREFIX_up2pay_subscription` (
	`id_up2pay_subscription` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`id_customer` INT(10) UNSIGNED NOT NULL,
	`id_order` INT(10) UNSIGNED NOT NULL,
	`unsubscribed` TINYINT(3) UNSIGNED NOT NULL DEFAULT '0',
	`abonnement` VARCHAR(254) NULL DEFAULT NULL COLLATE 'utf8_general_ci',
	PRIMARY KEY (`id_up2pay_subscription`) USING BTREE,
	INDEX `id_customer` (`id_customer`) USING BTREE,
	INDEX `id_order` (`id_order`) USING BTREE
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;
