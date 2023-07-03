<?php
// $lang = array(
//     'rahma' =>'ro'
// );
// echo $lang['rahma'];
function lang($phrase){
    static $lang = array(
        //navbar links
        
        'HOME_ADMIN'    => 'thiqaha' ,
        'CATEGORIES'    => 'categories',
        'ITEMS'         => 'items',
        'MEMBERS'       => 'members',
        'STATISTICS'    => 'statistics',
        'COMMENTS'      => 'comments',
        'LOGS'          => 'logs',
        'NAME'          => 'rahma',
        'EDIT'          => 'edit profile',
        'SET'           => 'setting',
        'OUT'           => 'logout',
        // Edit member page form
        'EDIT_MEMBER'   => 'Edit Member',
        'USERNAME'      => 'Username',
        'PASSWORD'      => 'Password',
        'EMAIL'         => 'Email',
        'FULLNAME'      => 'Fullname',
        // update member page form
        'UPDATE_MEMBER' => 'Update Member',
        //add member page form
        'ADD_MEMBER'    => 'Add New Member',
        'MANAGE_MEMBER' => 'manage Members',
        //manage  member page form
        'ID'            => '#ID',
        'REGISTERD_DATE'=> 'registerd date',
        'CONTROL'       => 'control',
        // add categories page
        'ADD_CATEGORIES'=> 'Add New Category',
        'NAME'          => 'name',
        'DESCRIPTION'   => 'description',
        'ORDERING'      => 'ordering',
        'VISIBEL'       => 'visibel',
        'ALLOW_COMMENTING'=> 'allow commenting',
        'ALLOW_ADS'     => 'allow ads',
        'MANAGE_CATEGORIES'=> 'manage categories', 
        //edit categories page
        'EDIT_CATEGORIES'=> ' Edit Category',
        //add items page
        'ADD_ITEM'      => 'add new item',
        'PRICE'  =>'price',
        'CUNTRY' => 'country',
        'STATUS' => 'status',
        'RATING' => 'rating',
        'MEMBER' => 'member',
        'CATEGORY'=> 'category',
        //manage item page
        'MANAGE_ITEMS' => 'manage items',
        'ADDING_DATE' => 'adding date',
        'ADD_ITEM' => 'add item',
        //edit item page
        'EDIT_ITEM'=>'edit item',
        'MANAGE_COMMENTS' => 'manage comments'
        


    );
    return $lang[$phrase];
};