<?php

if($_SERVER['PHP_SELF'] != '/index.php') header('Location: /');

error_reporting(E_ALL ^ E_NOTICE ^E_WARNING);

date_default_timezone_set('Europe/Istanbul');

// Include Extensions

$classesDir = array (
    __DIR__.'/../extensions/'
);

function includeExtensions($folder)
{
    foreach (glob("{$folder}/*.php") as $filename)
    {
        include($filename);
    }
    foreach (glob("{$folder}/*") as $dirname)
    {
        foreach (glob("{$dirname}/*.php") as $filename) {
            include($filename);
        }
    }
}

includeExtensions(__DIR__.'/../extensions');

// Main Class

class Mi
{
    public $s;
    public $site;

    protected $config;
    private $prefix;
    private $wwwNecessity;

    function __construct($config)
    {
        $this->s = $this->pageDetect();
        $this->config = $config;
        $this->prefix = $config['prefix'];
        $this->wwwNecessity = $config['wwwNecessity'];
        $this->site = $this->prefix.'://'.$_SERVER["SERVER_NAME"];
    }

    public function start()
    {
        if(!stristr($_SERVER["SERVER_NAME"],"www.") and $this->wwwNecessity == 1){
            header('Location: '.$this->prefix.'://www.'.$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"]);
        }

        if(stristr($_SERVER["SERVER_NAME"],"www.") and $this->wwwNecessity != 1){
            header('Location: '.$this->prefix.'://'.ltrim($_SERVER["SERVER_NAME"],'www.').$_SERVER["REQUEST_URI"]);
        }

        if(!$_SERVER['HTTPS'] and $this->prefix == 'https') {

            $url = $this->prefix.'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
            header("Location: $url");
        }

        /* Front End Start */

        if(class_exists("\Extensions\Mi\FrontEnd\Index"))
        {
            $frontend = new Extensions\Mi\FrontEnd\Index($this);
            $frontend->start();
        } else {
            $this->errorPage(array('<b>\Extensions\Mi\FrontEnd\Index</b> Extension is Not Found'));
        }
    }

    public function errorPage($error)
    {
        ?>
        <html>
        <head>
            <title>MiPHP ERROR</title>
            <meta charset="utf-8">
            <style>
                @import "https://fonts.googleapis.com/css?family=Inconsolata";
                html {
                    min-height: 100%;
                }

                body {
                    box-sizing: border-box;
                    height: 100vh;
                    background-color: #000000;
                    background-image: radial-gradient(#145758, #675fe0);
                    font-family: 'Inconsolata', Helvetica, sans-serif;
                    font-size: 1.5rem;
                    color: rgba(0, 0, 0, 0.8);
                    text-shadow: 0 0 1ex #f7f3ff, 0 0 2px rgba(255, 255, 255, 0.8);
                }

                .overlay {
                    pointer-events: none;
                    position: absolute;
                    width: 100%;
                    height: 100%;
                    background: repeating-linear-gradient(180deg, rgba(0, 0, 0, 0) 0, rgba(0, 0, 0, 0.3) 50%, rgba(0, 0, 0, 0) 100%);
                    background-size: auto 4px;
                    z-index: 99;
                }

                .overlay::before {
                    content: "";
                    pointer-events: none;
                    position: absolute;
                    display: block;
                    top: 0;
                    left: 0;
                    right: 0;
                    bottom: 0;
                    width: 100%;
                    height: 100%;
                    background-image: linear-gradient(0deg, transparent 0%, rgba(33, 89, 128, 0.2) 2%, rgba(28, 64, 128, 0.8) 3%, rgba(3, 45, 128, 0.2) 3%, transparent 100%);
                    background-repeat: no-repeat;
                    -webkit-animation: scan 7.5s linear 0s infinite;
                    animation: scan 7.5s linear 0s infinite;
                }

                @-webkit-keyframes scan {
                    0% {
                        background-position: 0 -100vh;
                    }
                    35%, 100% {
                        background-position: 0 100vh;
                    }
                }

                @keyframes scan {
                    0% {
                        background-position: 0 -100vh;
                    }
                    35%, 100% {
                        background-position: 0 100vh;
                    }
                }
                .terminal {
                    box-sizing: inherit;
                    position: absolute;
                    height: 100%;
                    width: 1000px;
                    max-width: 100%;
                    padding: 4rem;
                    text-transform: uppercase;
                }

                .output {
                    color: rgba(0, 0, 0, 0.8);
                    text-shadow: 0 0 1ex #f7f3ff, 0 0 2px rgba(255, 255, 255, 0.8);
                }

                .output::before {
                    content: "> ";
                }

                /*
                .input {
                  color: rgba(192, 255, 192, 0.8);
                  text-shadow:
                      0 0 1px rgba(51, 255, 51, 0.4),
                      0 0 2px rgba(255, 255, 255, 0.8);
                }

                .input::before {
                  content: "$ ";
                }
                */
                a {
                    color: #fff;
                    text-decoration: none;
                }

                a::before {
                    content: "[";
                }

                a::after {
                    content: "]";
                }

                .errorcode {
                    color: white;
                }
            </style>
        </head>
        <body>
            <div class="overlay"></div>
            <div class="terminal">
                <h1>MiPHP <span class="errorcode">ERROR</span></h1>
                <?php foreach ($error as $note) { ?>
                <p class="output"><?php echo $note; ?></p>
                <?php } ?>

            </div>
        </body>
        </html>
        <?php
    }

    public function pageDetect()
    {
        $s = ltrim($_SERVER['REQUEST_URI'], '/');
        $s = explode('?',$s);
        $s = $s[0];
        $s = array_filter(explode('/',$s));
        return $s;
    }

    public function baseUrl($file = '')
    {
        return $this->site.'/'.$file;
    }

    public function ipDetect()
    {
        if(getenv("HTTP_CLIENT_IP")) {
            $ip = getenv("HTTP_CLIENT_IP");
        } elseif(getenv("HTTP_X_FORWARDED_FOR")) {
            $ip = getenv("HTTP_X_FORWARDED_FOR");
            if (strstr($ip, ',')) {
                $tmp = explode (',', $ip);
                $ip = trim($tmp[0]);
            }
        } else {
            $ip = getenv("REMOTE_ADDR");
        }

        return $ip;
    }

    public function date() {

        return date('Y-m-d');

    }

    public function dateTime() {

        return date('Y-m-d H:i:s');

    }

    public function dateFormatTR($date, $version = '1')
    {
        $eng_monthnames = array("January","February","March","May","April","June","July","August","September","October","November","December");
        $tr_monthnames = array("Ocak","Şubat","Mart","Nisan","Mayıs","Haziran","Temmuz","Ağustos","Eylül","Ekim","Kasım","Aralık");
        $eng_daynames = array("Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday");
        $tr_daynames = array("Pazartesi","Salı","Çarşamba","Perşembe","Cuma","Cumartesi","Pazar");

        if($version == 1) return date("d.m.Y",strtotime($date));
        if($version == 2) return date("d.m.Y H:i",strtotime($date));
        if($version == 3)
        {
            $date = date("d F Y H:i",strtotime($date));

            $date = str_replace($eng_monthnames,$tr_monthnames,$date);
            $date = str_replace($eng_daynames,$tr_daynames,$date);

            return $date;
        }
    }

    public function currentUrl()
    {
        return $this->prefix.'://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
    }

    public function random($length)
    {
        $random = "";

        for($i=0;$i<$length;$i++) {
            switch(rand(1,3)) {
                case 1: $random.=chr(rand(48,57));  break;
                case 2: $random.=chr(rand(65,90));  break;
                case 3: $random.=chr(rand(97,122)); break;
            }
        }

        return $random;
    }

    public function osDetect()
    {
        $user_agent=$_SERVER['HTTP_USER_AGENT'];

        if(stristr($user_agent,"Windows 95")) { $os="Windows 95"; }
        elseif(stristr($user_agent,"Windows 98")) { $os="Windows 98"; }
        elseif(stristr($user_agent,"Windows NT 5.0")) { $os="Windows 2000"; }
        elseif(stristr($user_agent,"Windows NT 5.1")) { $os="Windows XP"; }
        elseif(stristr($user_agent,"Windows NT 6.0")) { $os="Windows Vista"; }
        elseif(stristr($user_agent,"Windows NT 6.1")) { $os="Windows 7"; }
        elseif(stristr($user_agent,"Windows NT 6.2")) { $os="Windows 8"; }
        elseif(stristr($user_agent,"Windows NT 6.3")) { $os="Windows 8.1"; }
        elseif(stristr($user_agent,"Windows NT 10")) { $os="Windows 10"; }
        elseif(stristr($user_agent,"Mac")) { $os="Mac"; }
        elseif(stristr($user_agent,"Linux")) { $os="Linux"; }
        else { $os = "Not Found"; }

        return $os;
    }

    public function browserDetect()
    {
        $user_agent=$_SERVER['HTTP_USER_AGENT'];
        if(stristr($user_agent,"MSIE")) { $browser="Internet Explorer"; }
        elseif(stristr($user_agent,"Opera")) { $browser="Opera"; }
        elseif(stristr($user_agent,"Firefox")) { $browser="Mozilla Firefox"; }
        elseif(stristr($user_agent,"YaBrowser")) { $browser="Yandex Browser"; }
        elseif(stristr($user_agent,"Chrome")) { $browser="Google Chrome"; }
        elseif(stristr($user_agent,"Safari")) { $browser="Safari"; }
        else { $browser = "Not Found"; }
        return $browser;
    }

    function firstLetterUppercaseLetterTR($str)
    {
        $str = str_replace(array('i', 'ı', 'ü', 'ğ', 'ş', 'ö', 'ç'), array('İ', 'I', 'Ü', 'Ğ', 'Ş', 'Ö', 'Ç'), $str);

        return mb_strtoupper($str,"utf-8");
    }

    function firstLetterUppercaseLetter($str)
    {
        return strtoupper($str);
    }

    function upperCase($str)
    {
        return mb_convert_case($str, MB_CASE_TITLE, "UTF-8");
    }

    public function lowerCase($str)
    {
        $str = str_replace(array('İ', 'I', 'Ü', 'Ğ', 'Ş', 'Ö', 'Ç'), array('i', 'ı', 'ü', 'ğ', 'ş', 'ö', 'ç'), $str);
        return mb_strtolower($str,"utf-8");;
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
        $tr = array('ş','Ş','ı','I','İ','ğ','Ğ','ü','Ü','ö','Ö','Ç','ç','(',')','/',':',',','+');
        $eng = array('s','s','i','i','i','g','g','u','u','o','o','c','c','','','-','-','','-');
        $s = str_replace($tr,$eng,$s);
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

// new Mi();

include(__DIR__.'/config.php');

$Mi = new Mi($config);

?>