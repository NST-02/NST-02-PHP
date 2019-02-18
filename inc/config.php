<?php
/*
 * Config File
 */

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