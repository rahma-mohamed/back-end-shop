<?php
/**
 * templeat page
 */
ob_start();
session_start();
$pageTitele = '' ;
if(isset($_SESSION['username'])){
    include 'int.php';
    $do = isset($_GET['do']) ? $_GET['do'] : 'manage';
    if ($do == 'manage'){

    }elseif($do == 'add'){
        
    }elseif($do == 'insert'){
        
    }elseif($do == 'edit'){
        
    }elseif($do == 'update'){
        
    }elseif($do == 'delete'){
        
    }elseif($do == 'activate'){
        
    }
    include $tpl . 'footer.php';
}else{
    header('location: index.php');
    exit();
}
ob_end_flush();
?>