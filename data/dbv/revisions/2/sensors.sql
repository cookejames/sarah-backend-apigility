ALTER TABLE `sensors`
	ADD COLUMN `isWateringSensor` TINYINT NULL AFTER `isEnabled`,
	ADD COLUMN `wateringThresholdLower` FLOAT NULL AFTER `isWateringSensor`,
	ADD COLUMN `wateringThresholdUpper` FLOAT NULL AFTER `wateringThresholdLower`;