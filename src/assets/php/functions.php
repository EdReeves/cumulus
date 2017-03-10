<?php

/**
 * @param mixed $key
 * @param array $a
 * @param mixed $default
 * @return mixed
 */
function array_value_default($key, array $a, $default = null)
{
    if (array_key_exists($key, $a))
    {
        return $a[$key];
    }
    else
    {
        return $default;
    }
}

/**
 * Converts a PostgreSQL timestamp without fractional seconds to the Highcharts time
 * format (unixtime * 1000)
 *
 * @param string $psqltime
 * @return int
 */
function psql_to_highcharts_timestamp($psqltime)
{
    // Assume (for now) no data with fractional seconds
    $datetime = DateTime::createFromFormat('Y-m-d H:i:se', $psqltime);
    $unixtime = $datetime->getTimestamp();

    return $unixtime * 1000;
}