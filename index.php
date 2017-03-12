<?php
define('ALLOW_ACCESS', 1);

require_once (__DIR__ . '/config.php');

function classAutoloader($class) { require_once (__DIR__ . '/classes/class.' . $class . '.php'); }
spl_autoload_register('classAutoloader');

//echo memory_get_usage() . "\n";
$database = new Database($config);
$user = new User($database);
$core = new Core($config, $database, $user);
//echo memory_get_usage() . "\n";