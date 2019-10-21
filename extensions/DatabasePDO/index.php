<?php
/*
Extension Name: MiPHP PDO
Extension URI: https://mehmetizmirlioglu.com.tr
Description: -
Version: 1.0
Author: Mehmet İzmirlioğlu
Author URI: mehmetizmirlioglu.com.tr
*/

namespace Extensions\Mi;

use Extensions\Prepare;
use PDO;
use PDOException;

if($_SERVER['PHP_SELF'] != '/index.php')
    header('Location: /');

class DatabasePDO extends Prepare
{
    public function __construct()
    {
        parent::__construct();
        $this->connectDatabase();
    }

    public function connectDatabase()
    {
        $databases = (object)$this->mi->config['pdo'];
        $db = array();

        foreach($databases as $i => $database) {
            $database = (object)$database;
            try {
                $db[$i] = new PDO('mysql:host=' . $database->host . ';dbname=' . $database->dbname . ';charset=utf8', $database->username, $database->password);
            } catch(PDOException $e) {
                die($this->mi->errorPage(array("Error Extensions\Mi\DatabasePDO", $e->getMessage())));
            }

            @$db[$i]->query("SET NAMES utf8");
            @$db[$i]->query("SET NAMES 'UTF8'");
            @$db[$i]->query("SET character_set_connection = 'UTF8'");
            @$db[$i]->query("SET character_set_client = 'UTF8'");
            @$db[$i]->query("SET character_set_results = 'UTF8'");
        }

        return $db;
    }
}