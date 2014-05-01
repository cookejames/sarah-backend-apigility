ALTER TABLE `sensors`
	ADD COLUMN `calibration` FLOAT NULL AFTER `scalingFactor`;
UPDATE `sensors` SET `calibration`=-3 WHERE  `name`='t1';