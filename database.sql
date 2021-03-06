CREATE USER 'admin_TEST_PHP_8_CI3'@'localhost' IDENTIFIED BY 'password';
DROP DATABASE IF EXISTS TEST_CI3_PHP_8;
DROP DATABASE IF EXISTS TEST_PHP_8_CI3;

CREATE DATABASE  IF NOT EXISTS TEST_PHP_8_CI3 CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

GRANT ALL PRIVILEGES ON TEST_PHP_8_CI3.* TO 'admin_TEST_PHP_8_CI3'@'localhost';
USE TEST_PHP_8_CI3;

DROP TABLE IF EXISTS roles;
CREATE TABLE IF NOT EXISTS roles (
    id          TINYINT         UNSIGNED NOT NULL AUTO_INCREMENT,
    role        VARCHAR(32)     NOT NULL UNIQUE,
    active      ENUM('0', '1')  NOT NULL DEFAULT '1',
    created     DATETIME        NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated     DATETIME        DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
);
