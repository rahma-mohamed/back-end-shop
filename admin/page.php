<?php
/**
 * categories => [manage | edit | update | add | insert | delete | stse]
 */
$do = isset ($_GET['do']) ? $_GET['do'] : 'manage';
// if the page is main page 
if ($do == 'manage'){
    echo 'welcome you are in category page';
    echo '<a href="page.php?do=edit">edit category +</a>';
    echo '<a href="page.php?do=update">update category +</a>';
    echo '<a href="page.php?do=add">add category +</a>';
    echo '<a href="page.php?do=insert">insert category +</a>';
    echo '<a href="page.php?do=delete">delete category +</a>';
    echo '<a href="page.php?do=state">state category +</a>';
}elseif ($do = 'edit'){
    echo 'welcome you are in edit category page';
}elseif ($do = 'update'){
    echo 'welcome you are in update category page';
}elseif ($do = 'add'){
    echo 'welcome you are in add category page';
}elseif ($do = 'insert'){
    echo 'welcome you are in insert category page';
}elseif ($do = 'delete'){
    echo 'welcome you are in deletecategory page';
}elseif ($do = 'state'){
    echo 'welcome you are in state category page';
}else{
    echo 'error there \' no page with this name ';
}