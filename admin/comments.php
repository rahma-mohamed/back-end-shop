<?php 
ob_start();
/**
 * manage comment page
 * you can  | edit | delete | approved comments from here
 */
session_start();
$pageTitele = 'comments';
if (isset($_SESSION['username'])){
    include 'int.php';
   $do = isset ($_GET['do']) ? $_GET['do'] : 'manage';
   // start manage page
   if ($do == 'manage') {
  
    //select all users from data base except admin
    $stmt = $con->prepare("SELECT 
                                comments.*, items.name AS item_name, users.username
                             FROM
                                comments
                            INNER JOIN
                                items
                            ON
                                items.item_ID = comments.item_id
                            INNER JOIN
                                users
                            ON
                                users.UserID = comments.user_id
                            ORDER BY
                                c_id
                            DESC");
    //execute the statement
    $stmt->execute();
    //assign to varibal
    $comments = $stmt->fetchAll();
    if(!empty($comments)){
    ?>  
   <!-- manage page -->
     <h1 class="text-center"><?php echo lang('MANAGE_COMMENTS') ?></h1>
     <div class="container ">
        <div class="table-responsive">
            <table class="main-table text-center table table-bordered">
                <tr>
                    <td><?php echo lang('ID') ?></td>
                    <td>comment</td>
                    <td>item name</td>
                    <td>user name</td>
                    <td>added date</td>
                    <td><?php echo lang('CONTROL') ?></td>
                </tr>
                <?php
                foreach($comments as $comment){
                    echo "<tr>";
                        echo "<td>" . $comment['c_id']. "</td>";
                        echo "<td>" . $comment['comment']. "</td>";
                        echo "<td>" . $comment['item_name']. "</td>";
                        echo "<td>" . $comment['user_id']. "</td>";
                        echo "<td>" . $comment['comment_date'] . "</td>";
                        echo " <td>
                                 <a href='comments.php?do=edit&comid=".$comment['c_id']."'
                                  class='btn btn-success'><i class='fa-solid fa-pen-to-square'></i>Edit</a>
                                 <a href='comments.php?do=delete&comid=".$comment['c_id']."'
                                  class='confirm btn btn-danger '><i class='fa-solid fa-xmark'></i>Delete</a>";
                        if($comment['status'] == 1){
                          echo "<a href='comments.php?do=approve&comid="
                          .$comment['c_id']."' class='btn btn-info activate'>approve</a>";
                        }
                         echo "</td>";
                    echo "</tr>";       
                }
                ?>
            </table>
        </div>
       
     </div>   
     <?php }else{
    echo '<div class="container">';
        echo '<div class="nice-masage">there\'s no comments to show</div>';
    echo '</div>';
   } ?>
 <?php  } elseif($do == 'edit'){ // edit page 
    echo 'welcom to edit page';
    //check if get requst userid is numeric & get the integer value of it 
    $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0;
    // select all data depend on this id  
    $stmt = $con->prepare("SELECT * FROM comments WHERE  c_id = ? ");
    //execute query 
    $stmt->execute(array($comid));
   //fetch the data 
    $row = $stmt->fetch();
    //the row count 
    $count = $stmt->rowCount();
    // if theres  sush id show the form 
    if ($count > 0){ ?>
       
        <h1 class="text-center">edit comment</h1>
        <div class="container ">
            <form class="form-horizontal" action="?do=Update" method="POST">
                <input type="hidden" name="comid" value="<?php echo $comid ?>">
                <!-- start username field -->
                <div class="form-group  form-group-lg">
                    <label class="col-sm-2 control-label" for="">comment</label>
                    <div class="col-sm-10 col-md-4">
                        <textarea class="form_control" name="comment" ><?php echo $row['comment'] ?></textarea>
                    </div>
                </div>
                <!-- end username field -->
                <!-- start submit field -->
                <div class="form-group form-group-lg">
                    <div class="col-sm-offset-2 col-sm-10">
                        <input type="submit" value="save" class="btn btn-primary ">
                    </div>
                </div>
                <!-- end submit field -->
            </form>
        </div>
        <?php 
        // else show error masseg
            } else{
                echo "<div class='container'>";

                $theMsg = '<div class="alert alert-danger"> theres no sush id</div>';
                redirectHome($theMsg);
                echo "</div>";
            }
    }elseif ($do =='update'){  //update page 
        echo "<h1 class='text-center'>update page</h1>";
        echo "<div class='container'>";
      if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        // get varibal from the form
        $comid      = $_POST['comid'];
        $comment    = $_POST['comment'];
             //update the data base with this info 
            $stmt = $con->prepare("UPDATE comments SET comment = ? WHERE c_ID = ?"); 
            $stmt->execute(array($comment, $comid)); 
            // echo success massage
           $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' record update</div>';
           redirectHome($theMsg, 'back');

       
      }else{
        $theMsg = '<div class= "alert alert-danger"sory you can not browse this page directly</div>';
        redirectHome($theMsg);
      }
      echo "</div>";
    }elseif($do == 'approve'){
        echo "<h1 class='text-center'>approve comment page</h1>";
        echo "<div class='container'>";
                //check if get requst userid is numeric & get the integer value of it 
                $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0;
                // select all data depend on this id  
                //check if user exist in database
                $check = checkItem("c_id", "comments", $comid);
                // if theres  sush id show the form 
                if ($check > 0){
                    $stmt = $con->prepare("UPDATE comments SET status = 1 WHERE c_id = ?");
                    $stmt->execute(array($comid));
                    // echo success massage
                    $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' record approve</div>';
                    redirectHome($theMsg , 'back');
                } else{
                    $theMsg = '<div class="alert alert-danger">this id is not exist </div>';
                    redirectHome($theMsg);
                    
                }
                echo "</div>";
    }elseif($do == 'delete'){ //delete member page
        echo "<h1 class='text-center'>delete page</h1>";
        echo "<div class='container'>";
                //check if get requst userid is numeric & get the integer value of it 
                $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0;
                // select all data depend on this id  
                //check if user exist in database
                $check = checkItem("c_id", "comments", $comid);
                // if theres  sush id show the form 
                if ($check > 0){
                    $stmt = $con->prepare("DELETE FROM comments WHERE c_id = :zid");
                    $stmt->bindparam(":zid", $comid);
                    $stmt->execute();
                    // echo success massage
                    $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' record deleted</div>';
                    redirectHome($theMsg, 'back');
                }
    }else{
                    $theMsg = '<div class="alert alert-danger">this id is not exist </div>';
                    redirectHome($theMsg);
                    
                }
                echo "</div>";
    include $tpl.'footer.php';
}else{
    header('Location:index.php'); //redirect to login page
    exit();
}
ob_end_flush();



