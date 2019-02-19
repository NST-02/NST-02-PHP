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

if($_SERVER['PHP_SELF'] != '/index.php') header('Location: /');

class Index extends \Extensions\Prepare
{
    public function __construct($Mi)
    {
        parent::__construct($Mi);
    }

    public function start()
    {
        $Mi = $this->mi;

        $dir = __DIR__.'/../../templates/miphp/';
        $file = $dir.'functions.php';

        if(file_exists($file))
        {
            include($file);
        }
    }

    public function getTemplateClasses($folder)
    {
        foreach (glob("{$folder}/*.php") as $filename)
        {
            include($filename);
        }
    }
}