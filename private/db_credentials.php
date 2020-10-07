<?php

// Keep database credentials in a separate file
// 1. Easy to exclude this file from source code managers
// 2. Unique credentials on development and production servers
// 3. Unique credentials if working with multiple developers

define("DB_SERVER", "localhost");
define("DB_USER", "root");
define("DB_PASS", "");
define("DB_NAME", "stock");

// //online db credentials
// define("DB_SERVER", "127.0.0.1");
// define("DB_USER", "ifexex5");
// define("DB_PASS", "Ifex@2018");
// define("DB_NAME", "ifexex5_app");



?>
