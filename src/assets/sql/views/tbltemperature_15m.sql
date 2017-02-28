DROP MATERIALIZED VIEW IF EXISTS tbltemperature_15m;

CREATE MATERIALIZED VIEW tbltemperature_15m AS
  SELECT
    MAX(a.timestamp) AS timestamp,
    MIN(a.temperature) AS temperature_min,
    MAX(a.temperature) AS temperature_max,
    AVG(a.temperature) AS temperature_mean
  FROM (
         SELECT
           date_trunc('hour', tbltemperature.timestamp) AS hour,
           (extract(minute FROM tbltemperature.timestamp)::int / 15) AS _15m,
           tbltemperature.timestamp,
           tbltemperature.temperature
         FROM tbltemperature
       ) AS a
  GROUP BY hour, _15m
  ORDER BY hour, _15m;

CREATE UNIQUE INDEX tbltemperature_15m_timestamp_uindex ON tbltemperature_15m (timestamp);