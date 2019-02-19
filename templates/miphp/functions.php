<?php
/**
 * Example Templates - MiPHP
 */

namespace Templates\MiPHP;
global $Mi;

if($_SERVER['PHP_SELF'] != '/index.php') header('Location: /');

class Template extends \Extensions\Mi\FrontEnd\Template
{
    public function __construct($Mi)
    {
        parent::__construct($Mi);
        $this->dir = __DIR__.'/';
        $this->phpdir = $this->dir.'php/';
        $this->assetsdir = $this->dir.'assets/';
    }
}

$Template = new Template($Mi);

// Pages System

$s = $Mi->s;

$this->getTemplateClasses($Template->phpdir);

$pages = array(
    '' => '\Home',
    '404' => '\ThreeZeroThree'
);

$pageClassName = '\Templates\MiPHP\Page'.$pages[@$s[0]];

if(@$pages[@$s[0]] == '') $pageClassName = '';

if(class_exists($pageClassName) and $pageClassName != '')
{
    new $pageClassName($Mi);
} else {
    $Mi->errorPage(array('404','Not Found'));
}