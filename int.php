<?php
ini_set('desplay_errors', 'on');
error_reporting(E_ALL);
include "admin/connecte.php";
$sessionUser = '';
if(isset($_SESSION['user'])){
    $sessionUser = $_SESSION['user'];
}

// routes
$tpl = 'include/templets/'; //tebplet dirctory
$lang = 'include/languages/'; //languages dirctory
$func = 'include/functions/'; //function dirctory
$css = 'layout/css/'; //css dirctory
$js = 'layout/js/'; //js dirctory


//include the important files "include/languages/en.php"
include $lang. 'en.php' ;
include $func. 'functions.php';
include $tpl . 'header.php';

