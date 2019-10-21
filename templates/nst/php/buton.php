<?php
/*
Page Name: Admin Home
*/

namespace Templates\MiAdmin\Page;

use Extensions\Mi\DatabasePDO;
use Extensions\Mi\Helper;
use PDO;

class Buton extends \Templates\MiAdmin\Template
{

    public function __construct()
    {
        parent::__construct();
        $this->helper = new Helper();
        if(isset($_POST['buton'])) $this->buton();
        if(isset($_POST['yesil'])) $this->yesil();
        $this->html();
    }

    public function buton()
    {
        for($i=1;$i<20;$i++) {
            sleep(1);
            $this->helper->curl('https://nst.crmmi.com/api/device', "id=1&token=NST-02-01&duration={$i}&temperature=26.5");
        }
    }

    public function yesil()
    {
        $this->db->query("UPDATE `devices` SET current_status=1 WHERE id=1");
    }

    public function html()
    {
        ?><meta name="viewport" content="width=device-width, initial-scale=1"><form action="" method="POST"><input type="hidden" name="buton" value="1"> <button type="submit">Test Data</button> </form><form action="" method="POST"><input type="hidden" name="yesil" value="1"> <button type="submit">#1 için Yeşil Yap</button> </form> <?php
    }

}