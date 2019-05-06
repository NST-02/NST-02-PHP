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

if($_SERVER['PHP_SELF'] != '/index.php') header('Location: /');

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
?><html>
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
        <?php foreach ($this->error as $note) { ?>
            <p class="output"><?php echo $note; ?></p>
        <?php } ?>

    </div>
    </body>
</html>
<?php
    }
}