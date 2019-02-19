<?php
/*
Page Name: 404
*/

namespace Templates\MiPHP\Page;

class ThreeZeroThree extends \Templates\MiPHP\Template
{
    public function __construct($Mi)
    {
        parent::__construct($Mi);
        $this->mi->errorPage(array('404','Not Found'));
    }
}