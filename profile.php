<?php
session_start();
$pageTitele = 'profile';
include "int.php";
if(isset($_SESSION['user'])){
    $getUser = $con->prepare("SELECT * FROM users WHERE username = ?");
    $getUser->execute(array($sessionUser));
    $info = $getUser->fetch();
?>
<h1 class="text-center">my profile</h1>
<div class="information block">
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">my Information</div>
            <div class="panel-body">
                <ul class="list-unstyled">
               <li><span> name</span>: <?php echo $info['username'] ?> </li>
               <li><span> email</span>: <?php echo $info['Email'] ?> </li>
               <li><span>  fullname</span>: <?php echo $info['Fullname'] ?> </li>
               <li><span> regster date</span>: <?php echo $info['Date'] ?> </li>
                <li> <span>fav category</span>:</li>
                </ul>
            </div>

        </div>

    </div>
</div>
<div class="my-ads block">
    <div class="container">
        <div class="panel panel-primary">
            <div class="panel-heading">my ads</div>
            <div class="panel-body">
                    <?php 
                    if(! empty(getItems('member_ID',$info['UserID'] ))){
                        echo '<div class="row">';
                            foreach(getItems('member_ID',$info['UserID']) as $item){
                                echo '<div class="col-sm-6 col-md-3">';
                                    echo '<div class="thumbnail item-box">';
                                         echo '<span class="price-tag">'.$item['price'] .'</span>';
                                        echo '<img class="img-responsive" src="layout/imgs/img1.jpg" alt=""/>';
                                        echo '<div class="caption">';
                                            echo '<h3><a href="items.php?itemid='.$item['item_ID'].'">'. $item['name'] . '</a></h3>';
                                            echo '<p>'. $item['description'] . '</p>';
                                            echo '<div class="date">'. $item['add_date'] . '</div>';
                                        echo '</div>';
                                    echo '</div>';
                                echo '</div>';
                            }
                            echo'</div>';
                }else{
                    echo 'sorry there\'no ads to show, cerate <a href="newad.php">new ad</a>'; 
                }
                    ?>
            </div>

        </div>

    </div>
</div>
<div class="my-comments block">
    <div class="container">
        <div class="panel panel-primary">
            <div class="panel-heading">latest comments</div>
            <div class="panel-body">
                <?php
                $stmt = $con->prepare("SELECT comment FROM comments WHERE user_id = ?");
                $stmt->execute(array($info['UserID']));
                $rows = $stmt->fetchAll();
                ?>
                 <?php 
                    if(! empty(getItems('member_ID',$info['UserID'] ))){
                        echo '<div class="row">';
                            foreach(getItems('member_ID',$info['UserID']) as $item){
                                echo '<div class="col-sm-6 col-md-3">';
                                    echo '<div class="thumbnail item-box">';
                                         echo '<span class="price-tag">'.$item['price'] .'</span>';
                                        echo '<img class="img-responsive" src="layout/imgs/img1.jpg" alt=""/>';
                                        echo '<div class="caption">';
                                            echo '<h3>'. $item['name'] . '</h3>';
                                            echo '<p>'. $item['description'] . '</p>';
                                            echo '<div class="date">'. $item['add_date'] . '</div>';
                                        echo '</div>';
                                    echo '</div>';
                                echo '</div>';
                            }
                            echo'</div>';
                }else{
                    echo 'sorry there\'no ads to show, cerate <a href="newad.php">new ad</a>'; 
                }
                    ?>
            </div>

        </div>

    </div>
</div>
<?php
}else{
    header('Location: login.php');
    exit();
}
include $tpl .'footer.php';
?>

