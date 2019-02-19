<?php
/*
Page Name: Home
*/

namespace Templates\MiPHP\Page;

if($_SERVER['PHP_SELF'] != '/index.php') header('Location: /');

class Home extends \Templates\MiPHP\Template
{
    public function __construct($Mi)
    {
        parent::__construct($Mi);
        $this->header();
        $this->content();
        $this->footer();
    }

    public function content()
    {
        ?><br>Test<br><?php
    }
}