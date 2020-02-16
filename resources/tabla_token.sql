CREATE TABLE `hipets`.`usuario_token` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `usuario_id` INT UNSIGNED NOT NULL,
  `token` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_usuario_token_idx` (`usuario_id` ASC),
  CONSTRAINT `fk_usuario_token`
    FOREIGN KEY (`usuario_id`)
    REFERENCES `hipets`.`usuario` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);