<?php
/*
 * MiPHP
 * Author: Mehmet İzmirlioğlu
 * E-Mail: mehmet@izmirlioglu.com
 */

ob_start();

session_start();

require __DIR__ . '/inc/functions.php';

// Error Reporting Level

error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
ini_set('error_reporting',1);

// Timezone Istanbul

date_default_timezone_set('Europe/Istanbul');

// Include Extensions

$classesDir = array(
    __DIR__ . '/extensions/'
);

// new Mi();

include(__DIR__ . '/inc/config.php');

$config['baseDir'] = __DIR__;

$Mi = new Mi($config);

$Mi->includeExtensions($classesDir);

$Mi->start();

ob_flush();