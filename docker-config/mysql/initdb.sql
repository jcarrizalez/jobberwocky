-- create the databases
-- CREATE DATABASE IF NOT EXISTS avature;

-- create the users for each database
-- CREATE USER IF NOT EXISTS 'develop'@'%' IDENTIFIED BY '123456';
GRANT ALL PRIVILEGES ON * . * TO 'develop'@'%';

FLUSH PRIVILEGES;