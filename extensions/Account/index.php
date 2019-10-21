<?php
/*
Plugin Name: Mi Account
Plugin URI: https://mehmetizmirlioglu.com.tr
Description: Sitede hesap açılmasını sağlar.
Version: 1.0
Author: Mehmet İzmirlioğlu
Author URI: mehmetizmirlioglu.com.tr
*/

namespace Extensions\Mi;

use Extensions\Prepare;
use PDO;

class Account extends Prepare
{
    public $db;

    public function __construct()
    {
        parent::__construct();
        $db = new DatabasePDO();
        $this->helper = new Helper();
        $this->db = $db->connectDatabase();
        $this->db = $this->db[0];
    }

    public function start()
    {
        if($_SESSION['sessioncode'] != '' or ($_COOKIE['sessioncode'] != '' and $_COOKIE['sessionid'] != '')) {
            if($_COOKIE['sessioncode'] != '' and $_COOKIE['sessionid'] != '' and $this->sessionControl() == false)
                $this->signInCookie($_COOKIE['sessionid'], $_COOKIE['sessioncode']);

            $session = $this->sessionControl();
            if($session != false) {
                $user = $this->db->prepare("SELECT * FROM `users` WHERE id=?");
                $user->execute(array($session->user));
                $user = $user->fetch(PDO::FETCH_OBJ);
                return $user;
            } else {
                $_SESSION['sessioncode'] = '';
                setcookie("sessincode", "", time() - 3600);
                setcookie("sessionid", "", time() - 3600);
                return false;
            }
        }
    }

    public function sessionControl()
    {
        $query = $this->db->prepare('SELECT * FROM sessionRecords WHERE ip=? and sessioncode=?');
        $query->execute(array($this->helper->ipDetect(), $_SESSION['sessioncode']));
        $query = $query->fetch(PDO::FETCH_OBJ);

        if($query->id != '') {
            return $query;
        } else {
            return false;
        }
    }

    public function signInCookie($id, $code)
    {
        $query = $this->db->prepare("SELECT * FROM `sessionRecords` WHERE sessioncode=? and user=? and status='1'");
        $query->execute(array($code, $id));
        $query = $query->fetch(PDO::FETCH_OBJ);

        if($query->os == $this->helper->osDetect() and $query->browser == $this->helper->browserDetect()) {

            $this->db->query("UPDATE `sessionRecords` SET status='0' WHERE id='$query->id'");
            $scode = $code;

            $query = $this->db->prepare("INSERT INTO `sessionRecords`(`user`, `os`, `browser`, `ip`, `date`, `sessioncode`) VALUES (?,?,?,?,?,?)");
            $query->execute(array($id, $this->helper->osDetect(), $this->helper->browserDetect(), $this->helper->ipDetect(), $this->helper->dateTime(), $scode));

            $update = $this->db->prepare("UPDATE `users` SET last_login=?, last_login_ip=? WHERE id=?");
            $update->execute(array($this->helper->dateTime(), $this->helper->ipDetect(), $id));

            $_SESSION['sessioncode'] = $scode;

        } else return false;
    }

    public function currentControl($email, $phone)
    {
        $control = $this->db->prepare('SELECT * FROM `users` WHERE email=? or phone=?');
        $control->execute(array($email, $phone));
        $control = $control->fetch(PDO::FETCH_OBJ);

        if($control->id == '')
            return true; else return false;
    }

    public function signInForm($username, $password)
    {
        $query = $this->db->prepare("SELECT * FROM `users` WHERE (username=:username or email=:username) and password=:password");
        $query->execute(array('username' => $username, 'password' => $password));
        $query = $query->fetch(PDO::FETCH_OBJ);

        if($query->id != '')
            return $query->id;
        else
            return false;
    }

    public function signIn($id, $rememberMe = 0)
    {
        $scode = $this->helper->random(200);

        $query = $this->db->prepare("INSERT INTO `sessionRecords`(`user`, `os`, `browser`, `ip`, `date`, `sessioncode`) VALUES (?,?,?,?,?,?)");
        $query->execute(array($id, $this->helper->osDetect(), $this->helper->browserDetect(), $this->helper->ipDetect(), $this->helper->dateTime(), $scode));

        $update = $this->db->prepare("UPDATE `users` SET last_login=?, last_login_ip=? WHERE id=?");
        $update->execute(array($this->helper->dateTime(), $this->helper->ipDetect(), $id));

        $_SESSION['sessioncode'] = $scode;

        if($rememberMe == '1') {
            // 30 Days Cookie
            setcookie("sessioncode", $scode, time() + (60 * 60 * 24 * 30));
            setcookie("sessionid", $id, time() + (60 * 60 * 24 * 30));
        }

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