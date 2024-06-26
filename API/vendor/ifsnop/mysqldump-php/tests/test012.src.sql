DROP DATABASE IF EXISTS `test012`;
CREATE DATABASE `test012`;
USE `test012`;

DROP TABLE IF EXISTS test;
CREATE TABLE test
(
    col INT
);


DROP VIEW IF EXISTS `test012_view`;
CREATE VIEW `test012_view` AS SELECT 1 as `a VIEW a`;

CREATE TRIGGER `test012_trigger`
  BEFORE insert ON `test`
  FOR EACH ROW set NEW.col = NEW.col + 1;

DELIMITER ;;
CREATE FUNCTION `test012_function`(i INT) RETURNS INT
  DETERMINISTIC
BEGIN
  RETURN (i);
END ;;
DELIMITER ;

DELIMITER ;;
CREATE PROCEDURE test012_procedure()
BEGIN
  SELECT * FROM test012;
END ;;
DELIMITER ;
