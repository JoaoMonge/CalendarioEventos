CREATE DATABASE Eventos_21181;
USE Eventos_21181;

CREATE TABLE Evento(
                       id int PRIMARY KEY auto_increment,
                       occasion varchar(100),
                       invited_count int,
                       year int,
                       month int,
                       day int,
                       cancelled boolean
);