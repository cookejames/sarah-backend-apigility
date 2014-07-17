ALTER TABLE `sensors`
	DROP COLUMN `scalingFactor`;
ALTER TABLE `sensors`
	ADD COLUMN `graphStart` FLOAT NULL DEFAULT '0' AFTER `calibration`;