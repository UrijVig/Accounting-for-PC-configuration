<?php
define("DIR_TMPL", __DIR__ . "//../../public/templates/");
define("MAIN_LAYOUT", "main");
define("DB_TABLE_NAMES", [
    "system_units", 
    "monitors",
    "peripheries", 
    "ups", 
    "locations", 
    "users", 
    "roles"
]);
define("DB_HOST", "localhost");

define("DB_NAME", "pcdb");
define("STORAGE", "storagedb");
define("OFFICE", "officedb");

define("DB_USER", "admin");
define("DB_PASS", "adminpass");

define("DB_CHRS", "utf8mb4");

define("DB_DSN", "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHRS);

define("DB_OPTS", [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
]);

define("OFFICE_CONFIG", [
    'dsn' => "mysql:host=" . DB_HOST . ";dbname=" . OFFICE . ";charset=" . DB_CHRS,
    'tables' => ['system_units', 'peripheries','ups','monitors','locations'],
    'dbname' => OFFICE
]);
define("STORAGE_CONFIG", [
    'dsn' => "mysql:host=" . DB_HOST . ";dbname=" . STORAGE . ";charset=" . DB_CHRS,
    'tables' => ['system_units', 'peripheries','ups','monitors'],
    'dbname' => STORAGE
]);