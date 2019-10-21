<?php

namespace Extensions\Mi;

use Extensions\Prepare;

if($_SERVER['PHP_SELF'] != '/index.php')
    header('Location: /');

class Helper extends Prepare
{
    public function __construct()
    {
        parent::__construct();
    }

    public function ipDetect()
    {
        if(getenv("HTTP_CLIENT_IP")) {
            $ip = getenv("HTTP_CLIENT_IP");
        } elseif(getenv("HTTP_X_FORWARDED_FOR")) {
            $ip = getenv("HTTP_X_FORWARDED_FOR");
            if(strstr($ip, ',')) {
                $tmp = explode(',', $ip);
                $ip = trim($tmp[0]);
            }
        } else {
            $ip = getenv("REMOTE_ADDR");
        }

        return $ip;
    }

    public function date()
    {
        return date('Y-m-d');
    }

    public function dateTime()
    {
        return date('Y-m-d H:i:s');
    }

    public function dateFormat($date, $version = 1)
    {
        if($version == 1)
            $date = date("d.m.Y", strtotime($date));
        if($version == 2)
            $date = date("d.m.Y H:i", strtotime($date));
        if($version == 3) {
            $eng_monthnames = array("January", "February", "March", "May", "April", "June", "July", "August", "September", "October", "November", "December");
            $tr_monthnames = array("Ocak", "Şubat", "Mart", "Nisan", "Mayıs", "Haziran", "Temmuz", "Ağustos", "Eylül", "Ekim", "Kasım", "Aralık");
            $eng_daynames = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
            $tr_daynames = array("Pazartesi", "Salı", "Çarşamba", "Perşembe", "Cuma", "Cumartesi", "Pazar");

            $date = date("d F Y H:i", strtotime($date));
            $date = str_replace($eng_monthnames, $tr_monthnames, $date);
            $date = str_replace($eng_daynames, $tr_daynames, $date);
        }

        return $date;
    }

    public function random($length)
    {
        $random = "";

        for($i = 0; $i < $length; $i++) {
            switch(rand(1, 3)) {
                case 1:
                    $random .= chr(rand(48, 57));
                    break;
                case 2:
                    $random .= chr(rand(65, 90));
                    break;
                case 3:
                    $random .= chr(rand(97, 122));
                    break;
            }
        }

        return $random;
    }

    public function osDetect()
    {
        $user_agent = $_SERVER['HTTP_USER_AGENT'];

        if(stristr($user_agent, "Windows 95")) {
            $os = "Windows 95";
        } elseif(stristr($user_agent, "Windows 98")) {
            $os = "Windows 98";
        } elseif(stristr($user_agent, "Windows NT 5.0")) {
            $os = "Windows 2000";
        } elseif(stristr($user_agent, "Windows NT 5.1")) {
            $os = "Windows XP";
        } elseif(stristr($user_agent, "Windows NT 6.0")) {
            $os = "Windows Vista";
        } elseif(stristr($user_agent, "Windows NT 6.1")) {
            $os = "Windows 7";
        } elseif(stristr($user_agent, "Windows NT 6.2")) {
            $os = "Windows 8";
        } elseif(stristr($user_agent, "Windows NT 6.3")) {
            $os = "Windows 8.1";
        } elseif(stristr($user_agent, "Windows NT 10")) {
            $os = "Windows 10";
        } elseif(stristr($user_agent, "Mac")) {
            $os = "Mac";
        } elseif(stristr($user_agent, "Linux")) {
            $os = "Linux";
        } else {
            $os = "Not Found";
        }

        return $os;
    }

    public function browserDetect()
    {
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        if(stristr($user_agent, "MSIE")) {
            $browser = "Internet Explorer";
        } elseif(stristr($user_agent, "Opera")) {
            $browser = "Opera";
        } elseif(stristr($user_agent, "Firefox")) {
            $browser = "Mozilla Firefox";
        } elseif(stristr($user_agent, "YaBrowser")) {
            $browser = "Yandex Browser";
        } elseif(stristr($user_agent, "Chrome")) {
            $browser = "Google Chrome";
        } elseif(stristr($user_agent, "Safari")) {
            $browser = "Safari";
        } else {
            $browser = "Not Found";
        }
        return $browser;
    }

    public function upperCase($str, $type = 1)
    {
        if($type == 1)
            $return = mb_convert_case($str, MB_CASE_TITLE, "UTF-8");
        elseif($type == 2) {
            $return = strtoupper($str);
        } elseif($type == 3) {
            $str = str_replace(array('i', 'ı', 'ü', 'ğ', 'ş', 'ö', 'ç'), array('İ', 'I', 'Ü', 'Ğ', 'Ş', 'Ö', 'Ç'), $str);
            $return = mb_strtoupper($str, "utf-8");
        }

        return $return;
    }

    public function lowerCase($str)
    {
        $str = str_replace(array('İ', 'I', 'Ü', 'Ğ', 'Ş', 'Ö', 'Ç'), array('i', 'ı', 'ü', 'ğ', 'ş', 'ö', 'ç'), $str);
        return mb_strtolower($str, "utf-8");
    }

    public function emailController($email)
    {
        if(filter_var($email, FILTER_VALIDATE_EMAIL) != '')
            return true;
        else
            return false;
    }

    public function slugGenerator($s)
    {
        $tr = array('ş', 'Ş', 'ı', 'I', 'İ', 'ğ', 'Ğ', 'ü', 'Ü', 'ö', 'Ö', 'Ç', 'ç', '(', ')', '/', ':', ',', '+');
        $eng = array('s', 's', 'i', 'i', 'i', 'g', 'g', 'u', 'u', 'o', 'o', 'c', 'c', '', '', '-', '-', '', '-');
        $s = str_replace($tr, $eng, $s);
        $s = strtolower($s);
        $s = preg_replace('/&amp;amp;amp;amp;amp;amp;amp;amp;amp;.+?;/', '', $s);
        $s = preg_replace('/\s+/', '-', $s);
        $s = preg_replace('|-+|', '-', $s);
        $s = preg_replace('/#/', '', $s);
        $s = str_replace('.', '', $s);
        $s = str_replace('?', '', $s);
        $s = str_replace('!', '', $s);
        $s = str_replace('\'', '', $s);
        $s = trim($s, '-');
        return $s;
    }
}