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
    public function __construct()
    {
        parent::__construct();
    }

    public function start()
    {
        if($this->mi->s[0] == $this->mi->config['adminslug']) {
            $dir = $this->mi->baseDir . '/templates/miadmin/';
            $file = $dir . 'functions.php';

            if(file_exists($file)) {
                include($file);
            }
        } else {
            $dir = $this->mi->baseDir . '/templates/miphp/';
            $file = $dir . 'functions.php';

            if(file_exists($file)) {
                include($file);
            }
        }
    }

    public function getTemplateClasses($folder)
    {
        foreach(glob("{$folder}/*.php") as $filename) {
            include($filename);
        }
    }
}