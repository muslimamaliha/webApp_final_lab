<?php
// EDIT ONLY THESE DATABASE VALUES when you deploy to hosting.
define('DB_HOST', 'localhost');
define('DB_NAME', 'scholarhub');
define('DB_USER', 'root');
define('DB_PASS', 'itbatch20');
date_default_timezone_set('Asia/Dhaka');
if (session_status() === PHP_SESSION_NONE) session_start();
?>
