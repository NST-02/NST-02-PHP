<?php
/*
Page Name: Home
*/

namespace Templates\MiPHP\Page;

if($_SERVER['PHP_SELF'] != '/index.php') header('Location: /');

class Home extends \Templates\MiPHP\Template
{
    public function __construct()
    {
        parent::__construct();
        $this->header();
        $this->content();
        $this->footer();
    }

    public function content()
    {
        ?><br>Test<br><?php
    }
}