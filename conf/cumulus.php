<?php

use edreeves\cumulus\DateInterval;

$selectors = [
    'temperature' => [
        'raw' => [
            'lt' => new DateInterval('PT0S'),
            'from' => 'tbltemperature',
        ],
        '15m' => [
            'gte' => new DateInterval('PT15M'),
            'lt' => new DateInterval('PT1H'),
            'from' => 'tbltemperature_15m',
        ],
        '1h' => [
            'gte' => new DateInterval('PT1H'),
            'from' => 'tbltemperature_1h',
        ],
    ],
];

$formatters = [
    'highcharts' => [
        'timestamp' => 'psql_to_highcharts_timestamp',
    ],
];