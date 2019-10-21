<?php
/**
 * Example Templates - MiPHP Admin
 */

namespace Templates\MiAdmin;

use Extensions\Mi\Account;
use Extensions\Mi\DatabasePDO;

if($_SERVER['PHP_SELF'] != '/index.php')
    header('Location: /');

class Template extends \Extensions\Mi\FrontEnd\Template
{
    public $userC;

    public function __construct()
    {
        $this->dir = __DIR__ . '/';
        parent::__construct();
        $this->database();
        $this->userC = new Account();
    }

    public function database()
    {
        $db = new DatabasePDO();
        $db = $db->connectDatabase();
        $this->db = $db[0];
    }

    public function baseUrl($file = '')
    {
        return $this->assetsUri . $file;
    }

    public function alert($type = 'info', $title = '', $desc = '', $dismiss = true)
    {
        ?>
    <div class="alert alert-<?php echo $type; ?>" role="alert">
        <?php if($dismiss == true) { ?>
        <button class="close" data-dismiss="alert"></button><?php } ?>
        <strong><?php echo $title; ?> </strong><?php echo $desc; ?>
        </div><?php
    }

    public function jsRedirect($location, $time = 1)
    {
        ?>
        <script type="text/javascript">
            function js_redirect_location() {
                window.location.href = '<?php echo $location; ?>';
            }

            setTimeout("js_redirect_location();",<?php echo $time; ?>);
        </script><?php
    }
}

$Template = new Template();

// Pages System

$s = $this->mi->s;

// User Information

$user = $Template->userC->start();

$this->getTemplateClasses($Template->phpDir);

if($user != false) {
    $pages = array(
        '' => '\Home',
        'buton' => '\Buton',
        'api' => '\Api',
        'cronjob' => '\CronJob',
        '404' => '\ThreeZeroThree'
    );
} else {
    $pages = array(
        '' => '\Home',
        'buton' => '\Buton',
        'api' => '\Api',
        'cronjob' => '\CronJob',
        '404' => '\ThreeZeroThree'
    );
}

$pageClassName = '\Templates\MiAdmin\Page' . $pages[@$s[0]];

if(@$pages[@$s[0]] == '')
    $pageClassName = '';

if(@$s[0] == 'sign-out') {
    $Template->userC->signOut();
    header('Location: ' . $this->mi->baseUrl(''));
    die;
}

if(class_exists($pageClassName) and $pageClassName != '') {
    new $pageClassName();
} elseif($pageClassName != '') {
    $this->mi->errorPage(array('FrontEnd Error', '<em>' . $pageClassName . '</em> Not Found'));
} else {
    $this->mi->errorPage(array('404', 'Not Found'));
}