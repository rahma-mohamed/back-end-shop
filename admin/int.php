<?php
include "connecte.php";

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
//include navbar on all pages expet the one with $noNavbar varebals
if(! isset($noNavbar)){
    include $tpl . 'navbar.php';
}
