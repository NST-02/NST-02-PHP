<?php
/*
Page Name: Admin Home
*/

namespace Templates\MiAdmin\Page;

use Extensions\Mi\DatabasePDO;
use Extensions\Mi\Helper;
use PDO;

class CronJob extends \Templates\MiAdmin\Template
{

    public function __construct()
    {
        parent::__construct();
        $this->helper = new Helper();
        $this->cron();
    }

    public function cron()
    {
        $db = new DatabasePDO();
        $db = $db->connectDatabase();
        $db = $db[0];
        $add = $db->prepare("UPDATE `devices` SET last_update=?");
        $add->execute(array($this->helper->dateTime()));
    }
}