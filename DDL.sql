-- create  database
CREATE DATABASE IF NOT EXISTS AMDB;

-- use current database
USE AMDB;

-- create the VIEWER table
CREATE TABLE IF NOT EXISTS VIEWER (
    ViewerId INT NOT NULL AUTO_INCREMENT,
    Name VARCHAR(15) NOT NULL,
    Sex CHAR(1) NOT NULL,
    MailId VARCHAR(30) NOT NULL,
    Age INT NOT NULL,
    City VARCHAR(20) NOT NULL,
    StateAb VARCHAR(5) NOT NULL,
    PRIMARY KEY (ViewerId)
);
