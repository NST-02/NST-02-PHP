<?php
/*
Extension Name: MiPHP FrontEnd
Extension URI: https://mehmetizmirlioglu.com.tr
Description: -
Version: 1.0
Author: Mehmet İzmirlioğlu
Author URI: mehmetizmirlioglu.com.tr
*/

namespace Extensions\Mi\FrontEnd;

use Extensions\Prepare;

if($_SERVER['PHP_SELF'] != '/index.php')
    header('Location: /');

class MainFrontEnd extends Prepare
{
    private $prefix;
    private $wwwNecessity;

    public function __construct()
    {
        parent::__construct();
        $this->wwwNecessity = $this->mi->config['wwwNecessity'];
        $this->prefix = $this->mi->config['prefix'];
    }

    public function start()
    {
        if(!stristr($_SERVER["SERVER_NAME"], "www.") and $this->wwwNecessity == 1) {
            header('Location: ' . $this->prefix . '://www.' . $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"]);
        }

        if(stristr($_SERVER["SERVER_NAME"], "www.") and $this->wwwNecessity != 1) {
            header('Location: ' . $this->prefix . '://' . ltrim($_SERVER["SERVER_NAME"], 'www.') . $_SERVER["REQUEST_URI"]);
        }

        define("PROTOCOL", isset($_SERVER['HTTP_X_FORWARDED_PROTO']) ? $_SERVER['HTTP_X_FORWARDED_PROTO'] : ((isset( $_SERVER["HTTPS"] ) && strtolower( $_SERVER["HTTPS"] ) == "on" ) ? 'https' : 'http'));

        define("PROTOCOL2", isset($_SERVER['HTTP_SEC_FETCH_MODE']) ? 'https' : 'http');

        if(!(PROTOCOL == 'https' or PROTOCOL2 == 'https') and $this->prefix == 'https') {
            $url = $this->prefix . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
            header("Location: $url");
        }

        $dir = $this->mi->baseDir . '/templates/nst/';
        $file = $dir . 'functions.php';

        if(file_exists($file)) {
            include($file);
        }
    }

    public function getTemplateClasses($folder)
    {
        foreach(glob("{$folder}/*.php") as $filename) {
            include($filename);
        }
    }
}