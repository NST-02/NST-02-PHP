<?php
/*
Plugin Name: Mi Account
Plugin URI: https://mehmetizmirlioglu.com.tr
Description: Sitede hesap açılmasını sağlar.
Version: 1.0
Author: Mehmet İzmirlioğlu
Author URI: mehmetizmirlioglu.com.tr
*/

namespace Extensions\Mi\Account;

class Index extends \Extensions\Prepare
{
    public $db;

    public function __construct()
    {
        parent::__construct();
        $db = new \Extensions\Mi\DatabasePDO\Index();
        $this->db = $db->connectDatabase();
    }

    public function start()
    {
        if($_SESSION['sessioncode'] != '')
        {
            $session = $this->sessionControl();
            if($session != false)
            {
                $user = $this->db->prepare("SELECT * FROM `users` WHERE id=?");
                $user->execute(array($session->user));
                $user = $user->fetch(\PDO::FETCH_OBJ);
                return $user;
            } else {
                $_SESSION['sessioncode'] = '';
                return false;
            }
        }
    }

    public function currentControl($email,$phone)
    {
        $control = $this->db->prepare('SELECT * FROM `users` WHERE email=? or phone=?');
        $control->execute(array($email,$phone));
        $control = $control->fetch(\PDO::FETCH_OBJ);

        if($control->id == '') return true; else return false;
    }

    public function sessionControl()
    {
        $query = $this->db->prepare('SELECT * FROM sessionRecords WHERE ip=? and sessioncode=?');
        $query->execute(array($this->mi->ipDetect(),$_SESSION['sessioncode']));
        $query = $query->fetch(\PDO::FETCH_OBJ);

        if($query->id != '') { return $query; } else { return false; }
    }

    public function signInForm($username,$password)
    {
        $query = $this->db->prepare("SELECT * FROM `users` WHERE (username=:username or email=:username) and password=:password");
        $query->execute(array('username' => $username, 'password' => $password));
        $query = $query->fetch(\PDO::FETCH_OBJ);

        if($query->id != '')
            return $query->id;
        else
            return false;
    }

    public function signIn($id)
    {
        $scode = $this->mi->random(200);

        $query = $this->db->prepare("INSERT INTO `sessionRecords`(`user`, `os`, `browser`, `ip`, `date`, `sessioncode`) VALUES (?,?,?,?,?,?)");
        $query->execute(array($id,$this->mi->osDetect(),$this->mi->browserDetect(),$this->mi->ipDetect(),$this->mi->dateTime(),$scode));

        $update = $this->db->prepare("UPDATE `users` SET last_login=?, last_login_ip=? WHERE id=?");
        $update->execute(array($this->mi->dateTime(),$this->mi->ipDetect(),$id));

        $_SESSION['sessioncode'] = $scode;
        return true;
    }

    public function signOut()
    {
        $scode = $_SESSION['sessioncode'];

        $query = $this->db->prepare('UPDATE `sessionRecords` SET status=0 WHERE sessioncode=?');
        $query->execute(array($scode));

        session_destroy();
    }
}