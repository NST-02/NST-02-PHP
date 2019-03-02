<?php
/**
 * Example Templates - MiPHP
 */

namespace Templates\MiPHP;

if($_SERVER['PHP_SELF'] != '/index.php') header('Location: /');

class Template extends \Extensions\Mi\FrontEnd\Template
{
    public function __construct()
    {
        parent::__construct();
        $this->dir = __DIR__.'/';
        $this->phpdir = $this->dir.'php/';
        $this->assetsdir = $this->dir.'assets/';
    }

    public function database()
    {
        $db = new \Extensions\Mi\DatabasePDO\Index();
        $db = $db->connectDatabase();
        $this->db = $db[0];
    }

    public function baseUrl($file = '')
    {
        return $this->mi->site.'/templates/miphp/assets/'.$file;
    }
}

$Template = new Template();

// Pages System

$s = $this->mi->s;

$this->getTemplateClasses($Template->phpdir);

$pages = array(
    '' => '\Home',
    $this->mi->config['adminslug'] => '\Admin',
    '404' => '\ThreeZeroThree'
);

$pageClassName = '\Templates\MiPHP\Page'.$pages[@$s[0]];

if(@$pages[@$s[0]] == '') $pageClassName = '';

if(class_exists($pageClassName) and $pageClassName != '')
{
    new $pageClassName();
} else {
    $this->mi->errorPage(array('404','Not Found'));
}