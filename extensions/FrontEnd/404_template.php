<?php
/*
Extension Name: MiPHP FrontEnd Template
Extension URI: https://mehmetizmirlioglu.com.tr
Description: -
Version: 1.0
Author: Mehmet İzmirlioğlu
Author URI: mehmetizmirlioglu.com.tr
*/

namespace Extensions\Mi\FrontEnd;

if($_SERVER['PHP_SELF'] != '/index.php')
    header('Location: /');

class Template404
{
    private $error;

    public function __construct($error)
    {
        $this->error = $error;
        $this->response();
    }

    public function response()
    {
        ?>
        <html lang="en">
        <head>
            <title>MiPHP ERROR</title>
            <meta charset="utf-8">
            <style>
                @import url("https://fonts.googleapis.com/css?family=Bevan");

                * {
                    padding: 0;
                    margin: 0;
                    box-sizing: border-box;
                    font-size: 25px;
                }

                body {
                    background: #317bb4;
                    overflow: hidden;
                }

                p {
                    font-family: "Bevan", cursive;
                    font-size: 130px;
                    margin: 10vh 0 0;
                    text-align: center;
                    letter-spacing: 5px;
                    background-color: #580f29;
                    color: transparent;
                    text-shadow: 2px 2px 3px rgba(255, 255, 255, 0.1);
                    -webkit-background-clip: text;
                    -moz-background-clip: text;
                    background-clip: text;
                }

                p span {
                    font-size: 1.2em;
                }

                code {
                    color: #bdbdbd;
                    text-align: center;
                    display: block;
                    font-size: 16px;
                    margin: 0 30px 25px;
                }

                code span {
                    color: #f0c674;
                }

                code i {
                    color: #b5bd68;
                }

                code em {
                    color: #b294bb;
                    font-style: unset;
                }

                code b {
                    color: #81a2be;
                    font-weight: 500;
                }

                a {
                    color: #8abeb7;
                    font-family: monospace;
                    font-size: 20px;
                    text-decoration: underline;
                    margin-top: 10px;
                    display: inline-block;
                }

                @media screen and (max-width: 880px) {
                    p {
                        font-size: 14vw;
                    }
                }

            </style>
        </head>
        <body>
            <p>MiPHP: <span>ERROR</span></p>
            <?php foreach($this->error as $note) { ?>
                <code><span><?php echo $note; ?></span></code>
            <?php } ?>
            <script>
                function type(n, t) {
                    var str = document.getElementsByTagName("code")[n].innerHTML.toString();
                    var i = 0;
                    document.getElementsByTagName("code")[n].innerHTML = "";

                    setTimeout(function () {
                        var se = setInterval(function () {
                            i++;
                            document.getElementsByTagName("code")[n].innerHTML =
                                str.slice(0, i) + "|";
                            if (i == str.length) {
                                clearInterval(se);
                                document.getElementsByTagName("code")[n].innerHTML = str;
                            }
                        }, 10);
                    }, t);
                }

                type(0, 0);
                type(1, 600);
                type(2, 1300);
            </script>
        </body>
        </html>
        <?php
    }
}