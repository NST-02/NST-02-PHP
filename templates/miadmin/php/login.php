<?php
/*
Page Name: Admin Login
*/

namespace Templates\MiAdmin\Page;

class Login extends \Templates\MiAdmin\Template
{
    public function __construct()
    {
        parent::__construct();
        $this->phpfunc();
        $this->content();
    }

    public function phpfunc()
    {
        if(isset($_POST['ajax']))
        {
            $ajax = $_POST['ajax'];

            if($ajax == 'login')
            {
                $username = trim($_POST['username']);
                $password = trim($_POST['password']);

                if($username == '' || $password == '')
                {
                    $this->alert('danger', 'Hata!', 'Giriş Bilgilerinizi Kontrol Ediniz!');
                }
                else
                {
                    $loginn = $this->userC->signInForm($username, $password);
                    if ($loginn == false) {
                        $this->alert('danger', 'Hata!', 'Giriş Bilgilerinizi Kontrol Ediniz!');
                    } else {
                        $this->userC->signIn($loginn);
                        $this->alert('success', 'Giriş Başarılı!', 'Yönlendiriliyorsunuz...', false);
                        $this->mi->jsRedirect($this->mi->baseUrl('miadmin'),2000);
                    }
                }
            }

            die;
        }
    }

    public function content()
    {
        ?>
        <!DOCTYPE html>
        <html>
    <head>
        <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
        <meta charset="utf-8" />
        <title>MiPHP Admin Panel</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, shrink-to-fit=no" />
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-touch-fullscreen" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="default">
        <meta name="robots" content="noindex, nofollow">
        <meta content="MiPHP Admin Panel" name="description" />
        <meta content="Mehmet İzmirlioğlu, mehmet@izmirlioglu.com" name="author" />
        <link href="<?php echo $this->assetsDir; ?>assets/plugins/pace/pace-theme-flash.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo $this->assetsDir; ?>assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo $this->assetsDir; ?>assets/plugins/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo $this->assetsDir; ?>assets/plugins/jquery-scrollbar/jquery.scrollbar.css" rel="stylesheet" type="text/css" media="screen" />
        <link href="<?php echo $this->assetsDir; ?>assets/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" media="screen" />
        <link href="<?php echo $this->assetsDir; ?>assets/plugins/switchery/css/switchery.min.css" rel="stylesheet" type="text/css" media="screen" />
        <link href="<?php echo $this->assetsDir; ?>pages/css/pages-icons.css" rel="stylesheet" type="text/css">
        <link class="main-stylesheet" href="<?php echo $this->assetsDir; ?>pages/css/themes/corporate.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript">
            window.onload = function()
            {
                // fix for windows 8
                if (navigator.appVersion.indexOf("Windows NT 6.2") != -1)
                    document.head.innerHTML += '<link rel="stylesheet" type="text/css" href="<?php echo $this->assetsDir; ?>pages/css/windows.chrome.fix.css" />'
            }
        </script>
    </head>
    <body class="fixed-header menu-pin menu-behind">
    <div class="login-wrapper ">
        <!-- START Login Background Pic Wrapper-->
        <div class="bg-pic">
            <!-- START Background Pic-->
            <img src="<?php echo $this->assetsDir; ?>assets/img/miphp.png" data-src="<?php echo $this->assetsDir; ?>assets/img/miphp.png" data-src-retina="<?php echo $this->assetsDir; ?>assets/img/miphp.png" alt="" class="lazy">
            <!-- END Background Pic-->
            <!-- START Background Caption-->
            <div class="bg-caption pull-bottom sm-pull-bottom text-white p-l-20 m-b-20">
                <h2 class="semi-bold text-white">
                    Admin Panel
                </h2>
                <p class="small">
                    MiPHP ile Güçlendirildi!
                </p>
            </div>
            <!-- END Background Caption-->
        </div>
        <!-- END Login Background Pic Wrapper-->
        <!-- START Login Right Container-->
        <div class="login-container bg-white">
            <div class="p-l-50 m-l-20 p-r-50 m-r-20 p-t-50 m-t-30 sm-p-l-15 sm-p-r-15 sm-p-t-40">
                <img src="<?php echo $this->assetsDir; ?>assets/img/miphp-logo.png" alt="logo" data-src="<?php echo $this->assetsDir; ?>assets/img/miphp-logo.png" data-src-retina="<?php echo $this->assetsDir; ?>assets/img/miphp-logo.png" width="78" height="40">
                <p class="p-t-35">Hesabınızın giriş detaylarını yazınız.</p>
                <!-- START Login Form -->
                <form id="form-login" class="p-t-15" role="form">
                    <input type="hidden" name="ajax" value="login">
                    <div class="form-group" id="ajaxreturn"></div>
                    <!-- START Form Control-->
                    <div class="form-group form-group-default">
                        <label>Kullanıcı Adı / E-Mail</label>
                        <div class="controls">
                            <input type="text" name="username" class="form-control" required>
                        </div>
                    </div>
                    <!-- END Form Control-->
                    <!-- START Form Control-->
                    <div class="form-group form-group-default">
                        <label>Şifre</label>
                        <div class="controls">
                            <input type="password" class="form-control" name="password" required>
                        </div>
                    </div>
                    <!-- START Form Control-->
                    <div class="row">
                        <div class="col-md-6 no-padding sm-p-l-10">
                            <div class="checkbox ">
                                <input type="checkbox" value="1" id="checkbox1">
                                <label for="checkbox1">Beni Unutma!</label>
                            </div>
                        </div>
                    </div>
                    <!-- END Form Control-->
                    <button class="btn btn-primary btn-cons m-t-10" type="submit">Giriş Yap</button>
                </form>
                <!--END Login Form-->
                <div class="pull-bottom sm-pull-bottom">
                    <div class="m-b-30 p-r-80 sm-m-t-20 sm-p-r-15 sm-p-b-20 clearfix">
                        <div class="col-sm-3 col-md-2 no-padding">
                            <img alt="" class="m-t-5" data-src="<?php echo $this->assetsDir; ?>assets/img/demo/pages_icon.png" data-src-retina="<?php echo $this->assetsDir; ?>assets/img/demo/pages_icon_2x.png" height="60" src="<?php echo $this->assetsDir; ?>assets/img/demo/pages_icon.png" width="60">
                        </div>
                        <div class="col-sm-9 no-padding m-t-10">
                            <p>
                                <small>
                                    Start: 26.02.2019
                                </small>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END Login Right Container-->
    </div>
    <!-- BEGIN VENDOR JS -->
    <script src="<?php echo $this->assetsDir; ?>assets/plugins/pace/pace.min.js" type="text/javascript"></script>
    <script src="<?php echo $this->assetsDir; ?>assets/plugins/jquery/jquery-3.2.1.min.js" type="text/javascript"></script>
    <script src="<?php echo $this->assetsDir; ?>assets/plugins/modernizr.custom.js" type="text/javascript"></script>
    <script src="<?php echo $this->assetsDir; ?>assets/plugins/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
    <script src="<?php echo $this->assetsDir; ?>assets/plugins/popper/umd/popper.min.js" type="text/javascript"></script>
    <script src="<?php echo $this->assetsDir; ?>assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="<?php echo $this->assetsDir; ?>assets/plugins/jquery/jquery-easy.js" type="text/javascript"></script>
    <script src="<?php echo $this->assetsDir; ?>assets/plugins/jquery-unveil/jquery.unveil.min.js" type="text/javascript"></script>
    <script src="<?php echo $this->assetsDir; ?>assets/plugins/jquery-ios-list/jquery.ioslist.min.js" type="text/javascript"></script>
    <script src="<?php echo $this->assetsDir; ?>assets/plugins/jquery-actual/jquery.actual.min.js"></script>
    <script src="<?php echo $this->assetsDir; ?>assets/plugins/jquery-scrollbar/jquery.scrollbar.min.js"></script>
    <script type="text/javascript" src="<?php echo $this->assetsDir; ?>assets/plugins/select2/js/select2.full.min.js"></script>
    <script type="text/javascript" src="<?php echo $this->assetsDir; ?>assets/plugins/classie/classie.js"></script>
    <script src="<?php echo $this->assetsDir; ?>assets/plugins/switchery/js/switchery.min.js" type="text/javascript"></script>
    <script src="<?php echo $this->assetsDir; ?>assets/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
    <!-- END VENDOR JS -->
    <script src="<?php echo $this->assetsDir; ?>pages/js/pages.min.js"></script>
    <script>
        $(function()
        {
            $('#form-login').validate();
            $('#form-login').on("submit", function (event)
            {
                event.preventDefault();
                $('#form-login').validate();
                if($(this).valid() == true)
                {
                    var form = $(this)[0];
                    var data = new FormData(form);

                    $.ajax({
                        type: 'POST',
                        url: '',
                        processData: false,
                        contentType: false,
                        data: data,
                        enctype: "multipart/form-data",
                        success: function (jsonResult) {
                            $('#ajaxreturn').html(jsonResult);
                            $("#ajaxreturn").fadeIn(400);
                        }
                    });
                }
            });
        });
    </script>
    </body>
        </html><?php
    }
}