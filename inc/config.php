<?php
/*
 * Config File
 */

if($_SERVER['PHP_SELF'] != '/index.php') header('Location: /');

$config = array(
    'prefix' => 'https', /* https or http */
    'wwwNecessity' => 0
);

if(class_exists("\Extensions\Mi\DatabasePDO\Index"))
{
    $config['pdo'] = array(
        'host' => 'localhost',
        'dbname' => '',
        'username' => 'root',
        'password' => ''
    );
}