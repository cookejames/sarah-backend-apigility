ALTER TABLE `sensors`
	ADD COLUMN `node` INT(10) UNSIGNED NOT NULL AFTER `description`;
UPDATE `sensors` SET `node` = 1;
ALTER TABLE `sensors`
	ADD INDEX `Index 4` (`node`);
ALTER TABLE `sensors`
	ADD CONSTRAINT `fk_node` FOREIGN KEY (`node`) REFERENCES `nodes` (`id`);