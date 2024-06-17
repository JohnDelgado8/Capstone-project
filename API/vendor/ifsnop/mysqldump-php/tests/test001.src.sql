DROP DATABASE IF EXISTS `test001`;
CREATE DATABASE `test001`;
USE `test001`;

DROP TABLE IF EXISTS `test000`;
CREATE TABLE `test000` (
  `id` int,
  `col01` bit(6) DEFAULT NULL,
  `col02` tinyint(4) DEFAULT NULL,
  `col03` tinyint(4) UNSIGNED DEFAULT NULL,
  `col10` bigint DEFAULT NULL,
  `col11` bigint UNSIGNED DEFAULT NULL,
  `col15` double DEFAULT NULL,
  `col27` varchar(6) DEFAULT NULL
);
INSERT INTO `test000` VALUES (1,0x21,-128,255,-9223372036854775808,18446744073709551615,-2.2250738585072014e-308,'0abcde');

DROP TABLE IF EXISTS `test001`;
CREATE TABLE `test001` (
  `id` int,
  `col` bit(1) DEFAULT NULL
);
INSERT INTO `test001` VALUES (1,NULL);
INSERT INTO `test001` VALUES (2,0x00);
INSERT INTO `test001` VALUES (3,0x01);

DROP TABLE IF EXISTS `test002`;
CREATE TABLE `test002` (
  `id` int,
  `col` tinyint(4) DEFAULT NULL
);
INSERT INTO `test002` VALUES (1,NULL);
INSERT INTO `test002` VALUES (2,-128);
INSERT INTO `test002` VALUES (3,0);
INSERT INTO `test002` VALUES (4,127);

DROP TABLE IF EXISTS `test003`;
CREATE TABLE `test003` (
  `id` int,
  `col` tinyint(4) UNSIGNED DEFAULT NULL
);
INSERT INTO `test003` VALUES (1,NULL);
INSERT INTO `test003` VALUES (2,0);
INSERT INTO `test003` VALUES (3,255);

DROP TABLE IF EXISTS `test010`;
CREATE TABLE `test010` (
  `id` int,
  `col` bigint DEFAULT NULL
);
INSERT INTO `test010` VALUES (1,NULL);
INSERT INTO `test010` VALUES (2,-9223372036854775808);
INSERT INTO `test010` VALUES (3,0);
INSERT INTO `test010` VALUES (4,9223372036854775807);

DROP TABLE IF EXISTS `test011`;
CREATE TABLE `test011` (
  `id` int,
  `col` bigint UNSIGNED DEFAULT NULL
);
INSERT INTO `test011` VALUES (1,NULL);
INSERT INTO `test011` VALUES (3,0);
INSERT INTO `test011` VALUES (4,18446744073709551615);


DROP TABLE IF EXISTS `test015`;
CREATE TABLE `test015` (
  `id` int,
  `col` double DEFAULT NULL
);
INSERT INTO `test015` VALUES (1,NULL);
INSERT INTO `test015` VALUES (2,-1.7976931348623157e308);
INSERT INTO `test015` VALUES (3,-2.2250738585072014e-308);
INSERT INTO `test015` VALUES (4,0);
INSERT INTO `test015` VALUES (5,2.2250738585072014e-308);
INSERT INTO `test015` VALUES (6,1.7976931348623157e308);


DROP TABLE IF EXISTS `test027`;
CREATE TABLE `test027` (
  `id` int,
  `col` varchar(6) DEFAULT NULL
);
INSERT INTO `test027` VALUES (1,NULL);
INSERT INTO `test027` VALUES (2,'');
INSERT INTO `test027` VALUES (3,'0');
INSERT INTO `test027` VALUES (4,'2e308');
INSERT INTO `test027` VALUES (5,'999.99');
INSERT INTO `test027` VALUES (6,'-2e-30');
INSERT INTO `test027` VALUES (7,'-99.99');
INSERT INTO `test027` VALUES (8,'0');
INSERT INTO `test027` VALUES (9,'0abcde');
INSERT INTO `test027` VALUES (10,'123');

DROP TABLE IF EXISTS `test029`;
CREATE TABLE `test029` (
  `id` int,
  `col` blob NOT NULL
);
INSERT INTO `test029` VALUES (1,0x00010203040506070809909192939495969798A9);
-- mysqldump 5.7.23 has a bug, an appends _binary to empty blob data, which is incorrect.
-- mysqldump 5.7.17 is ok
-- lets skip this test an implement it in some near future
-- https://bugs.mysql.com/bug.php?id=80150
INSERT INTO `test029` VALUES (2,0x99AAFF);

DROP TABLE IF EXISTS `test033`;
CREATE TABLE `test033` (
  `id` int,
  `col` text NOT NULL
);
INSERT INTO `test033` VALUES (1,'test test test');


DROP VIEW IF EXISTS `test100`;
CREATE ALGORITHM=UNDEFINED DEFINER=`travis`@`localhost` SQL SECURITY DEFINER VIEW `test100` AS select `test000`.`id` AS `id`,`test000`.`col01` AS `col01`,`test000`.`col02` AS `col02`,`test000`.`col03` AS `col03`,`test000`.`col10` AS `col10`,`test000`.`col11` AS `col11`,`test000`.`col15` AS `col15`,`test000`.`col27` AS `col27` from `test000`;

DROP VIEW IF EXISTS `test127`;
CREATE ALGORITHM=UNDEFINED DEFINER=`travis`@`localhost` SQL SECURITY DEFINER VIEW `test127` AS select `test027`.`id` AS `id`,`test027`.`col` AS `col` from `test027`;


DROP TABLE IF EXISTS `test200`;
CREATE TABLE `test200` (
  `id` int,
  `col` tinyint(4) DEFAULT NULL
);

CREATE TRIGGER before_test200_insert
  BEFORE insert ON `test200`
  FOR EACH ROW set NEW.col = NEW.col + 1;

-- INSERT INTO `test200` VALUES (1,1); -- trigger tests

/*!50003 DROP PROCEDURE IF EXISTS `GetAllFromTest000` */;
DELIMITER //
CREATE PROCEDURE GetAllFromTest000()
BEGIN
SELECT * FROM test000;
END //
DELIMITER ;
