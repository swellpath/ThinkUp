CREATE TABLE IF NOT EXISTS tu_domains (
  `id` BIGINT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `domain` VARCHAR(255) NULL ,
  INDEX domain (domain)
);

CREATE TABLE IF NOT EXISTS tu_referrals (
  `instance_id`  INT(11) NOT NULL,
  `domain_id` BIGINT UNSIGNED NOT NULL ,
  `date` DATE NOT NULL ,
  `referrals` INT UNSIGNED NOT NULL ,
  UNIQUE INDEX (instance_id, domain_id, `date`)
);
