ALTER TABLE `sensors`
	ADD COLUMN `conversionFactor` FLOAT NOT NULL DEFAULT '1' AFTER `units`;