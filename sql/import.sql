-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema supertex_lehm
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema supertex_lehm
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `supertex_lehm` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ;
USE `supertex_lehm` ;

-- -----------------------------------------------------
-- Table `supertex_lehm`.`users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `supertex_lehm`.`users` (
  `user_id` BIGINT NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(100) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `first_name` VARCHAR(25) NOT NULL,
  `last_name` VARCHAR(25) NOT NULL,
  `tel_number` VARCHAR(45) NULL,
  `last_seen` DATETIME NULL,
  `create_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
  `is_active` TINYINT NULL DEFAULT 1,
  PRIMARY KEY (`user_id`),
  UNIQUE INDEX `correo_UNIQUE` (`email` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `supertex_lehm`.`roles`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `supertex_lehm`.`roles` (
  `role_id` BIGINT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `update_own_content` TINYINT NULL DEFAULT 0,
  `delete_own_content` TINYINT NULL DEFAULT 0,
  `read_own_content` TINYINT NULL DEFAULT 0,
  `read_users` TINYINT NULL DEFAULT 0,
  `create_uers` TINYINT NULL DEFAULT 0,
  `update_users` TINYINT NULL DEFAULT 0,
  `delete_users` TINYINT NULL DEFAULT 0,
  `read_users_roles` TINYINT NULL DEFAULT 0,
  `update_users_roles` TINYINT NULL DEFAULT 0,
  `delete_users_roles` TINYINT NULL DEFAULT 0,
  `update_own_roles` TINYINT NULL DEFAULT 0,
  PRIMARY KEY (`role_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `supertex_lehm`.`users_roles`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `supertex_lehm`.`users_roles` (
  `user_id` BIGINT NOT NULL,
  `role_id` BIGINT NOT NULL,
  PRIMARY KEY (`user_id`, `role_id`),
  INDEX `fk_Users_has_Roles_Roles1_idx` (`role_id` ASC) ,
  INDEX `fk_Users_has_Roles_Users_idx` (`user_id` ASC) ,
  CONSTRAINT `fk_Users_has_Roles_Users`
    FOREIGN KEY (`user_id`)
    REFERENCES `supertex_lehm`.`users` (`user_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_Users_has_Roles_Roles1`
    FOREIGN KEY (`role_id`)
    REFERENCES `supertex_lehm`.`roles` (`role_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;





INSERT INTO `supertex_lehm`.`users`
VALUES
('1', 'luis@correo.com', '$2y$10$uO.yY2tnGtElJcs/B2zaO.0DfCeoYU8IqLIUdjB//khW/InZpfZhm', 'Luis E', 'Hernandez', '8888-66666', '2020-10-11 20:04:45', '2020-10-11 07:09:13', '1');

INSERT INTO `supertex_lehm`.`users`
VALUES
('3', 'super@correo.com', '$2y$10$uO.yY2tnGtElJcs/B2zaO.0DfCeoYU8IqLIUdjB//khW/InZpfZhm', 'Super', 'User', '5555-5555', '2020-10-11 20:09:58', '2020-10-11 07:09:13', '1'
);

INSERT INTO `supertex_lehm`.`users`
VALUES
('4', 'joe@correo.com', '$2y$10$uO.yY2tnGtElJcs/B2zaO.0DfCeoYU8IqLIUdjB//khW/InZpfZhm', 'joe', 'doe', '8888-8888', '2020-10-11 20:11:08', '2020-10-11 20:07:15', '1'
);
INSERT INTO `supertex_lehm`.`users`
VALUES
('5', 'kathy@correo.com', '$2y$10$uO.yY2tnGtElJcs/B2zaO.0DfCeoYU8IqLIUdjB//khW/InZpfZhm', 'Kathy', 'Herrera', '5555-8888', '2020-10-11 20:11:08', '2020-10-11 20:07:15', '1'
);
INSERT INTO `supertex_lehm`.`roles` VALUES('1', 'ROLE_SUPER_ADMIN', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1');
INSERT INTO `supertex_lehm`.`roles` VALUES('2', 'ROLE_ADMIN', '1', '1', '1', '1', '1', '1', '1', '1', '0', '0', '0');
INSERT INTO `supertex_lehm`.`roles` VALUES('3', 'ROLE_USER', '1', '1', '1', '1', '0', '0', '0', '0', '0', '0', '0');

INSERT INTO `supertex_lehm`.`users_roles` VALUES('1', '1');
INSERT INTO `supertex_lehm`.`users_roles` VALUES('3', '1');
INSERT INTO `supertex_lehm`.`users_roles` VALUES('3', '2');
INSERT INTO `supertex_lehm`.`users_roles` VALUES('4', '2');
INSERT INTO `supertex_lehm`.`users_roles` VALUES('1', '3');

INSERT INTO `supertex_lehm`.`users_roles` VALUES('3', '3');
INSERT INTO `supertex_lehm`.`users_roles` VALUES('4', '3');
INSERT INTO `supertex_lehm`.`users_roles` VALUES('5', '3');
/**Todos los usuarios tienen como contraseña "contra" **/
