DROP TABLE IF EXISTS tbltemperature;

CREATE TABLE tbltemperature
(
  timestamp TIMESTAMP PRIMARY KEY NOT NULL,
  temperature DOUBLE PRECISION NOT NULL
);

CREATE UNIQUE INDEX tbltemperature_timestamp_uindex ON tbltemperature (timestamp);