<?php

use edreeves\cumulus\DateInterval;

define('PDO_CONNECT','pgsql:dbname=database');
define('PDO_USER', 'user');
define('PDO_PASS', 'password');

$views = [
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