<?php
/*
Extension Name: MiPHP FrontEnd Template
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

class Template extends Prepare
{
    public $dir;
    public $phpDir;
    public $assetsDir;
    public $assetsUri;

    protected $data;

    public function __construct()
    {
        parent::__construct();
        $this->data = array();
        $this->phpDir = $this->dir . 'php/';
        $this->assetsDir = $this->dir . 'assets/';
        $this->assetsUri = $this->mi->site . str_replace($this->mi->baseDir, '', $this->assetsDir);
    }

    public function dataChange($data)
    {
        $this->data = $data;
    }

    public function header()
    {
        include($this->phpDir . 'inc/header.php');
    }

    public function footer()
    {
        include($this->phpDir . 'inc/footer.php');
    }
}