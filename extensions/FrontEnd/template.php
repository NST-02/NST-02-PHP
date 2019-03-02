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

if($_SERVER['PHP_SELF'] != '/index.php') header('Location: /');

class Template extends \Extensions\Prepare
{
    public $dir;
    public $phpdir;
    public $assetsdir;

    protected $data;

    public function __construct()
    {
        parent::__construct();
        $this->data = array();
    }

    public function dataChange($data)
    {
        $this->data = $data;
    }

    public function header()
    {
        $Mi = $this->mi;
        $Template = $this;
        $s = $this->mi->s;
        $data = $this->data;

        include($this->phpdir.'inc/header.php');
    }

    public function footer()
    {
        $Mi = $this->mi;
        $Template = $this;
        $s = $this->mi->s;
        $data = $this->data;

        include($this->phpdir.'inc/footer.php');
    }
}