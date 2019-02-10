<?php
error_reporting(1);
error_reporting(E_ALL ^ E_WARNING);
session_cache_limiter(false);
session_start();
date_default_timezone_set('Europe/Zagreb');
#ini_set('date.timezone', 'America/Chicago');
#date_default_timezone_set(date_default_timezone_get());
require __DIR__ . '/../src/bootstrap.php';

// Run!
$app->run();
