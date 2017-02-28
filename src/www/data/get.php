<?php

$root = __DIR__.'/../../..';
require_once($root.'/vendor/autoload.php');
require_once($root.'/src/config.php');

use edreeves\cumulus\DateTime;
use edreeves\cumulus\Selector;

$table = $_GET['table'];
if (!preg_match('/^[a-zA-Z0-9_]+$/', $table)) {
    die('Invalid table name');
}
$start = @$_GET['start'];
if ($start && !preg_match('/^[0-9]+$/', $start)) {
    die("Invalid start parameter: $start");
}
$end = @$_GET['end'];
if ($end && !preg_match('/^[0-9]+$/', $end)) {
    die("Invalid end parameter: $end");
}
$level = @$_GET['level'];
if (!preg_match('/^[a-zA-Z0-9_]*$/', $level)) {
    die('Invalid level name');
}

if (!$table)
{
    die('No table specified');
}
$start = $start ? new DateTime("@$start") : null;
$end = $end ? new DateTime("@$end") : null;
if (!$level) $level = null;

$selector = new Selector($views[$table]);
$json = $selector->getData($start, $end, $level);

header('Content-Type: text/javascript');
echo $json;
