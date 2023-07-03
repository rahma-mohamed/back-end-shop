<?php

function lang($phrase){

    static $lang = array(

        'MASSAGE'=> 'welcome in arabic' ,

        'ADMIN'=> 'admin arabic'
    );

    return $lang[$phrase];
};