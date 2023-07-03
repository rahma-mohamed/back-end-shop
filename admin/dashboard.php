<?php
ob_start();
session_start();
if (isset($_SESSION['username'])){
    $pageTitele = 'dashboard';
    include 'int.php';
    $numUsers = 5 ;//number of latest users
    $theLatestUsers = getLatest("*", "users" , "UserID",  $numUsers );//latest user array
    $numItems = 5 ;
    $theLatestItems = getLatest("*", "items" , "item_ID", $numItems);
    $numComments = 5;
   /**start dashbord page */
   ?>
   <div class=" home-stats">
        <div class="container text-center">
            <h1>dashboard page</h1>
            <div class="row">
                <div class="col-md-3">
                    <div class="stat st-members">
                        <i class="fa fa-users"></i>
                        <div class="info">
                        Total Members
                        <span><a href="members.php"><?php echo countItems('UserID', 'users')?></a></span>
                        </div>
                        
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat st-pending">
                    <i class="fa-solid fa-user-plus"></i>
                    <div class="info">
                    Pending Members
                        <span><a href="members.php?do=manage&page=pending"><?php echo checkItem('regStauts', 'users' ,0) ?></a></span>
                    </div>
                        
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat st-items">
                    <i class="fa-solid fa-tag"></i>
                      <div class="info">
                      Total Items
                        <span><a href="items.php"><?php echo countItems('item_ID', 'items')?></a></span>
                      </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat st-comments">
                    <i class="fa-sharp fa-regular fa-comments"></i>
                    <div class="info">
                    total comments
                    <span><a href="comments.php"><?php echo countItems('c_id', 'comments')?></a></span>
                    </div>
                          
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="latest">
        <div class="container ">
            <div class="row">
                <div class="col-sm-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa-solid fa-users"></i>latest <?php echo $numUsers ?> registerd users
                            <span class="toggle-info pull-right">
                                <i class="fa fa-plus fa-lg"></i>
                            </span>
                        </div>
                        <div class="panel-body">
                            <ul class="list-unstyled latest-users">
                                <?php 
                                  if(! empty($theLatestUsers)){
                                  foreach($theLatestUsers as $user){
                                  echo '<li>';
                                    echo $user['username'];
                                    echo '<a href="members.php?do=edit&userid=' . $user['UserID']. '">';
                                        echo '<span class="btn btn-success pull-right">' ;
                                            echo '<i class="fa fa-edit"></i> Edit' ;
                                            if($user['regStauts'] == 0){
                                                echo "<a  href='members.php?do=activate&userid=".$user['UserID']."' class='btn btn-info pull-right activate'>activate</a>";
                                              }
                                        echo '</span>';
                                    echo '</a>' ;
                                  echo '</li>' ;
                                  }
                                }else{
                                    echo 'there\'s no user to show';
                                }
                                ?>
                            </ul>
                          
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa-solid fa-tag"></i>latest <?php echo $numItems ?> items
                            <span class="toggle-info pull-right">
                                <i class="fa fa-plus fa-lg"></i>
                            </span>
                        </div>
                        <div class="panel-body">
                        <ul class="list-unstyled latest-users">
                                <?php 
                                  if(!empty($theLatestItems)){
                                  foreach($theLatestItems as $item){
                                  echo '<li>';
                                    echo $item['name'];
                                    echo '<a href="items.php?do=edit&itemid=' . $item['item_ID']. '">';
                                        echo '<span class="btn btn-success pull-right">' ;
                                            echo '<i class="fa fa-edit"></i> Edit' ;
                                            if($item['approve'] == 0){
                                                echo "<a  href='item.php?do=approve&itemid=".$item['item_ID']."' class='btn btn-info pull-right activate'>approve</a>";
                                              }
                                        echo '</span>';
                                    echo '</a>' ;
                                  echo '</li>' ;
                                  }
                                }else{
                                    echo 'there\'s no items to show';
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- start comment -->
            <div class="row">
                <div class="col-sm-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                        <i class="fa-sharp fa-regular fa-comments"></i>latest <?php echo $numComments ?>  comments
                            <span class="toggle-info pull-right">
                                <i class="fa fa-plus fa-lg"></i>
                            </span>
                        </div>
                        <div class="panel-body">
                            <?php
                                                $stmt = $con->prepare("SELECT 
                                                comments.*, users.username
                                            FROM
                                                comments
                                            INNER JOIN
                                                users
                                            ON
                                                users.UserID = comments.user_id
                                            ORDER BY
                                                c_id
                                            DESC
                                            LIMIT $numComments");
                                //execute the statement
                                $stmt->execute();
                                //assign to varibal
                                $comments = $stmt->fetchAll();
                                if(!empty($comments)){
                                foreach($comments as $comment){
                                    echo '<div class="comment-box">';
                                    echo '<span class="member-n">
                                          <a href="members.php?do=edit&userid='.$comment['user_id'].'">
                                          '.$comment['username'].'</a></span>';
                                        echo '<p class="member-c">' . $comment['comment'] . '</p>';
                                    echo '</div>';
                                }
                            }else{
                                echo 'there\'s no comment to show';
                            }
                            ?>
                       
                        </div>
                    </div>
                </div>
            </div>
            <!-- end comment -->
        </div>
    </div>    
   <?php
   /**end dashbord page */
    include $tpl.'footer.php';
}else{
    
    header('Location:index.php'); //redirect to login page
    exit();
}
ob_end_flush();
