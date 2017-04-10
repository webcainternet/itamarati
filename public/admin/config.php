<?php
// HTTP
define('HTTP_SERVER', 'http://'.$_SERVER["HTTP_HOST"].'/admin/');
define('HTTP_CATALOG', 'http://'.$_SERVER["HTTP_HOST"].'/');

// HTTPS
define('HTTPS_SERVER', 'http://'.$_SERVER["HTTP_HOST"].'/admin/');
define('HTTPS_CATALOG', 'http://'.$_SERVER["HTTP_HOST"].'/');

// DIR
define('DIR_APPLICATION', '/var/www/html/public/admin/');
define('DIR_SYSTEM', '/var/www/html/public/system/');
define('DIR_IMAGE', '/var/www/html/public/image/');
define('DIR_LANGUAGE', '/var/www/html/public/admin/language/');
define('DIR_TEMPLATE', '/var/www/html/public/admin/view/template/');
define('DIR_CONFIG', '/var/www/html/public/system/config/');
define('DIR_CACHE', '/var/www/html/public/system/storage/cache/');
define('DIR_DOWNLOAD', '/var/www/html/public/system/storage/download/');
define('DIR_LOGS', '/var/www/html/public/system/storage/logs/');
define('DIR_MODIFICATION', '/var/www/html/public/system/storage/modification/');
define('DIR_UPLOAD', '/var/www/html/public/system/storage/upload/');
define('DIR_CATALOG', '/var/www/html/public/catalog/');

// DB
define('DB_DRIVER', 'mysqli');
define('DB_HOSTNAME', '172.17.0.1');
define('DB_USERNAME', 'itamarati');
define('DB_PASSWORD', 'hdqwu6GWr3fd');
define('DB_DATABASE', 'itamarati');
define('DB_PORT', '3306');
define('DB_PREFIX', 'oc_');
