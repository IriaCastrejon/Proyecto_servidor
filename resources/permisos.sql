CREATE DATABASE hipets;
CREATE USER 'admin'@'localhost' IDENTIFIED BY '1234';
GRANT ALL PRIVILEGES ON hipets.* TO 'admin'@'localhost';
