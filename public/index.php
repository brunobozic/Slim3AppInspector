<?php
error_reporting(1);
session_cache_limiter(false);
session_start();
date_default_timezone_set("UTC");

require __DIR__ . '/../src/bootstrap.php';

// Run!
$app->run();
