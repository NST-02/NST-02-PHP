<?php
/*
 * Title: MiPHP
 * Author: Mehmet İzmirlioğlu
 * E-Mail: mehmet@izmirlioglu.com
 */

ob_start();

session_start();

$Mi = 'mehmetizmirlioglu.com.tr';

include('inc/functions.php');

$Mi->start();

ob_flush();