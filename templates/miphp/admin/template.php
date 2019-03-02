<?php
/*
Page Name: Admin Template
*/

namespace Templates\MiPHP\Admin;

class Template extends \Templates\MiPHP\Template
{
    public $user;

    public function __construct()
    {
        parent::__construct();
        $this->database();
        $this->assetsdir = $this->mi->site.'/templates/miphp/admin/assets/';
        $this->phpdir = $this->phpdir.'../admin/php/';

        $user = new \Extensions\Mi\Account\Index();
        $this->user = $user->start();
    }

    public function header()
    {
        $Mi = $this->mi;
        $Template = $this;
        $s = $this->mi->s;
        $data = $this->data;

        include($this->phpdir.'header.php');
    }

    public function footer()
    {
        $Mi = $this->mi;
        $Template = $this;
        $s = $this->mi->s;
        $data = $this->data;

        include($this->phpdir.'footer.php');
    }

    public function alert($type = 'info', $title = '', $desc = '', $dismiss = true)
    {
        ?><div class="alert alert-<?php echo $type; ?>" role="alert">
        <?php if($dismiss == true) { ?><button class="close" data-dismiss="alert"></button><?php } ?>
        <strong><?php echo $title; ?> </strong><?php echo $desc; ?>
        </div><?php
    }
}