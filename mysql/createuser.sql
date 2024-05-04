CREATE USER 'gymOrg'@'%' IDENTIFIED BY 'gymOrg';
GRANT ALL PRIVILEGES ON `gymOrg`.* TO 'gymOrg'@'%';

CREATE USER 'gymOrg'@'localhost' IDENTIFIED BY 'gymOrg';
GRANT ALL PRIVILEGES ON `gymOrg`.* TO 'gymOrg'@'localhost';