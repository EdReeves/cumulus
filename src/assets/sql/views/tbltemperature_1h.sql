DROP MATERIALIZED VIEW IF EXISTS tbltemperature_1h;

CREATE MATERIALIZED VIEW tbltemperature_1h AS
  SELECT
    MAX(a.timestamp) AS timestamp,
    MIN(a.temperature) AS temperature_min,
    MAX(a.temperature) AS temperature_max,
    AVG(a.temperature) AS temperature_mean
  FROM (
         SELECT
           date_trunc('hour', tbltemperature.timestamp) AS hour,
           tbltemperature.timestamp,
           tbltemperature.temperature
         FROM tbltemperature
       ) AS a
  GROUP BY hour
  ORDER BY hour;

CREATE UNIQUE INDEX tbltemperature_1h_timestamp_uindex ON tbltemperature_1h (timestamp);