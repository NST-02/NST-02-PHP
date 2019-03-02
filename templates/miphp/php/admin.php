<?php
/*
Page Name: Home
*/

namespace Templates\MiPHP\Page;

if($_SERVER['PHP_SELF'] != '/index.php') header('Location: /');

class Admin extends \Templates\MiPHP\Template
{
    public function __construct()
    {
        parent::__construct();
        $this->adminStart();
    }

    private function adminStart()
    {
        global $Template;

        $Mi = $this->mi;
        $s = $this->mi->s;

        $userc = new \Extensions\Mi\Account\Index();
        $user = $userc->start();

        if($user != false)
        {
            $pages = array(
                '' => '\Home',
                '404' => '\ThreeZeroThree'
            );
        } else {
            $pages = array(
                '' => '\Login',
                '404' => '\ThreeZeroThree'
            );
        }

        $pageClassName = '\Templates\MiPHP\Admin\Page'.$pages[@$s[1]];

        if(@$pages[@$s[1]] == '') $pageClassName = '';

        if(@$s[1] == 'sign-out') {
            $userc->signOut();
            header('Location: '.$Mi->baseUrl('admin'));
            die;
        }

        $frontend = new \Extensions\Mi\FrontEnd\Index();
        $frontend->getTemplateClasses($Template->phpdir.'../admin/');
        $frontend->getTemplateClasses($Template->phpdir.'../admin/php/');

        if(class_exists($pageClassName) and $pageClassName != '')
        {
            new $pageClassName($Mi);
        } else {
            header('Location: '.$Mi->baseUrl('admin/404'));
        }
    }
}