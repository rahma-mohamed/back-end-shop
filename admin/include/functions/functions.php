<?php
/**
 * titel function v1.0
 * titel function that echo the page titel in case the page
 * has the varibale $pageTitele and echo defualt titel for other page
 */
function getTitele(){
    global $pageTitele;
    if (isset($pageTitele)){
        echo $pageTitele;
    }else{
        echo 'default';
    }
}
/**
 * home redirect function v2.0
 * [this function accept parameters]
 * $theMas = echo the masage [error \ success \ warning]
 * $url = the link you want to redirct to
 * $seconds = seconds before redirecting
 */
function redirectHome($theMsg,$url = null, $seconds = 3){
    if ($url === null){
        $url = 'index.php';
    }else{
        if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== ''){
            $url = $_SERVER['HTTP_REFERER'];
            $link = 'previous page';
        }else{
            $url = 'index.php';
            $link = 'homepage';
        }
       
    }
    echo $theMsg;
    echo "<div class = 'alert alert-info'>you will be redirect to $url after $seconds seconds.</div>";
    header("refresh:$seconds;url=$url");
    exit();
}
/**
 * check items function v1.0
 * function to check item in database [function accept parameters ]
 * $select = the item to select
 * $from = the table to select from 
 * $value = the value of selected
 */
function checkItem($select, $from, $value){
    global $con;
    $statement = $con->prepare("SELECT $select FROM $from WHERE $select = ?");
    $statement->execute(array($value));
    $count = $statement->rowCount();
    echo $count;
}
/**
 * count nember of items v1.0 
 * function to count number of items rows
 * $item = the item to count
 * $tabel = the tabel to choose from
 */
function countItems($item, $tabel){
    global $con;
    $stmt2 = $con->prepare("SELECT COUNT($item) FROM $tabel");
    $stmt2->execute();
    echo $stmt2->fetchColumn();
}
/**
 * get latest records function v1.0  
 * function to get latest items from database [users, items, comments]
 * $select = field to select
 * $tabel = the tabel to choose from
 * $order = the DESC ordering
 * $limit = number fo recordes to get
 */
function getLatest($select, $tabel,$order, $limit = 5){
    global $con;
    $getStmt = $con->prepare("SELECT $select FROM $tabel ORDER BY $order DESC LIMIT $limit");
    $getStmt->execute();
    $rows = $getStmt->fetchAll();
    return $rows;
}