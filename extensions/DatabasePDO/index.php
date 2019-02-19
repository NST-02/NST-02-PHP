<?php
/*
Extension Name: MiPHP PDO
Extension URI: https://mehmetizmirlioglu.com.tr
Description: -
Version: 1.0
Author: Mehmet İzmirlioğlu
Author URI: mehmetizmirlioglu.com.tr
*/

namespace Extensions\Mi\DatabasePDO;

class Index extends \Extensions\Prepare
{
    public function __construct($Mi)
    {
        parent::__construct($Mi);
        $this->connectDatabase();
    }

    public function connectDatabase()
    {
        $database = (object)$this->mi->config['pdo'];
        try {
            $db = new \PDO('mysql:host='.$database->host.';dbname='.$database->dbname.';charset=utf8', $database->username, $database->password);
        } catch ( \PDOException $e ){
            die($this->mi->errorPage(array("Error Extensions\Mi\DatabasePDO\Index",$e->getMessage())));
        }

        @$db->query("SET NAMES utf8");
        @$db->query("SET NAMES 'UTF8'");
        @$db->query("SET character_set_connection = 'UTF8'");
        @$db->query("SET character_set_client = 'UTF8'");
        @$db->query("SET character_set_results = 'UTF8'");

        return $db;
    }
}