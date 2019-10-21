<?php
/*
Page Name: Admin Home
*/

namespace Templates\MiAdmin\Page;

use Extensions\Mi\DatabasePDO;
use Extensions\Mi\Helper;
use PDO;

class Api extends \Templates\MiAdmin\Template
{

    public function __construct()
    {
        parent::__construct();
        $this->helper = new Helper();
        $this->api();
    }

    public function api()
    {
        if($this->mi->s[1] == 'device' or $this->mi->s[1] == 'device2') {
            $id = intval($_POST['id']);
            $token = $_POST['token'];
            $data = $_POST['data'];

            $db = new DatabasePDO();
            $db = $db->connectDatabase();
            $db = $db[0];
            $add = $db->prepare("INSERT INTO `devicedata`(`data`) VALUES (?)");
            $add->execute(array(json_encode($_POST)));

            $device = $db->prepare("SELECT * FROM `devices` WHERE id=? and token=?");
            $device->execute(array($id,$token));
            $device = $device->fetch(PDO::FETCH_OBJ);

            if($device->id != '') {
                $duration = $_POST['duration'];
                $temperature = $_POST['temperature'];

                if($_POST['data'] != '')
                {
                    preg_match("/Duration = (.*?) - Temperature = (.*?)C/i",$_POST['data'],$data);
                    $duration = $data[1];
                    $temperature = $data[2];
                }

                $query = $db->prepare("SELECT * FROM `records` WHERE device_id=? and (date<? and date>?)");
                $query->execute(array($device->id,date('Y-m-d H:i:s'),date('Y-m-d H:i:s',strtotime('-1 minute'))));
                $query = $query->fetch(PDO::FETCH_OBJ);

                if($query->id != '') {
                    $update = $db->prepare("UPDATE `records` SET `duration`=?,`temperature`=?,`date`=?,`end_date`=? WHERE id=?");
                    $update->execute(array($duration,$temperature,$this->helper->dateTime(),$this->helper->dateTime(),$query->id));
                } else {
                    $add = $db->prepare("INSERT INTO `records`(`device_id`, `duration`, `temperature`, `date`,`start_date`) VALUES (?,?,?,?,?)");
                    $add->execute(array($device->id,$duration,$temperature,$this->helper->dateTime(),$this->helper->dateTime()));
                }
                $up = $db->prepare("UPDATE `devices` SET current_status=3 WHERE id=?");
                $up->execute(array($device->id));
                echo json_encode(array('type' => 'success','message'=>''));
            } else {
                echo json_encode(array('type' => 'error','message'=>''));
            }
        }
    }
}