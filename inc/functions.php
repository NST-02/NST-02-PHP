<?php

use Extensions\Mi\FrontEnd\MainFrontEnd;
use Extensions\Mi\FrontEnd\Template404;

if($_SERVER['PHP_SELF'] != '/index.php')
    header('Location: /');

// Main Class

class Mi
{
    public $baseDir;
    public $s;
    public $site;
    public $domain;

    public $config;
    private $prefix;
    private $wwwNecessity;

    function __construct($config)
    {
        $this->baseDir = $config["baseDir"];
        $this->s = $this->pageDetect();
        $this->config = $config;
        $this->prefix = $config['prefix'];
        $this->wwwNecessity = $config['wwwNecessity'];
        $this->site = $this->prefix . '://' . $_SERVER["SERVER_NAME"];
        $this->domain = $_SERVER["SERVER_NAME"];
    }

    public function pageDetect()
    {
        $s = ltrim($_SERVER['REQUEST_URI'], '/');
        $s = explode('?', $s);
        $s = $s[0];
        $s = array_filter(explode('/', $s));
        return $s;
    }

    public function includeExtensions($folders)
    {
        foreach($folders as $folder) {
            foreach(glob("{$folder}/*.php") as $filename) {
                include($filename);
            }
            foreach(glob("{$folder}/*") as $dirname) {
                foreach(glob("{$dirname}/*.php") as $filename) {
                    include($filename);
                }
            }
        }
    }

    public function start()
    {
        if(!stristr($_SERVER["SERVER_NAME"], "www.") and $this->wwwNecessity == 1) {
            header('Location: ' . $this->prefix . '://www.' . $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"]);
        }

        if(stristr($_SERVER["SERVER_NAME"], "www.") and $this->wwwNecessity != 1) {
            header('Location: ' . $this->prefix . '://' . ltrim($_SERVER["SERVER_NAME"], 'www.') . $_SERVER["REQUEST_URI"]);
        }

        if(!$_SERVER['HTTPS'] and $this->prefix == 'https') {

            $url = $this->prefix . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
            header("Location: $url");
        }

        /* Front End Start */

        if(class_exists("\Extensions\Mi\FrontEnd\MainFrontEnd")) {
            $frontend = new MainFrontEnd();
            $frontend->start();
        } else {
            $this->errorPage(array('<b>\Extensions\Mi\FrontEnd\MainFrontEnd</b> Extension is Not Found'));
        }
    }

    public function errorPage($error)
    {
        if(class_exists("\Extensions\Mi\FrontEnd\Template404")) {
            new Template404($error);
        } else {
            print_r($error);
        }
    }

    public function baseUrl($file = '')
    {
        return $this->site . '/' . $file;
    }

    public function currentUrl()
    {
        return $this->prefix . '://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
    }
}