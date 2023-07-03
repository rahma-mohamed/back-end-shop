<?php 
ob_start();
/**
 * manage member page
 * you can add | edit | delete members from here
 */
session_start();
$pageTitele = 'members';
if (isset($_SESSION['username'])){
    include 'int.php';
   $do = isset ($_GET['do']) ? $_GET['do'] : 'manage';
   // start manage page
   if ($do == 'manage') {
    $query = '' ;
    if(isset($_GET['page']) && $_GET['page'] == 'pending'){
        $query = 'ADD regStatus = 0';
    }
    //select all users from data base except admin
    $stmt = $con->prepare("SELECT * FROM users WHERE GroupID != 1 $query  ORDER BY
    UserID
DESC");
    //execute the statement
    $stmt->execute();
    //assign to varibal
    $rows = $stmt->fetchAll();
    if(! empty($rows)){
    ?>  
   <!-- manage page -->
     <h1 class="text-center"><?php echo lang('MANAGE_MEMBER') ?></h1>
     <div class="container ">
        <div class="table-responsive">
            <table class="main-table text-center table table-bordered">
                <tr>
                    <td><?php echo lang('ID') ?></td>
                    <td><?php echo lang('USERNAME') ?></td>
                    <td><?php echo lang('EMAIL') ?></td>
                    <td><?php echo lang('FULLNAME') ?></td>
                    <td><?php echo lang('REGISTERD_DATE') ?></td>
                    <td><?php echo lang('CONTROL') ?></td>
                </tr>
                <?php
                foreach($rows as $row){
                    echo "<tr>";
                        echo "<td>" . $row['UserID']. "</td>";
                        echo "<td>" . $row['username']. "</td>";
                        echo "<td>" . $row['Email']. "</td>";
                        echo "<td>" . $row['Fullname']. "</td>";
                        echo "<td>" . $row['Date'] . "</td>";
                        echo " <td>
                                 <a href='members.php?do=edit&userid=".$row['UserID']."' class='btn btn-success'><i class='fa-solid fa-pen-to-square'></i>Edit</a>
                                 <a href='members.php?do=delete&userid=".$row['UserID']."' class='confirm btn btn-danger '><i class='fa-solid fa-xmark'></i>Delete</a>";
                        if($row['regStauts'] == 0){
                          echo "<a href='members.php?do=activate&userid=".$row['UserID']."' class='btn btn-info activate'>activate</a>";
                        }
                         echo "</td>";
                    echo "</tr>";       
                }
                ?>
            </table>
        </div>
        <a href="members.php?do=add" class="btn add btn-primary"><i class="fa-solid fa-plus"></i><?php echo lang('ADD_MEMBER') ?></a>
     </div>   
   <?php }else{
    echo '<div class="container">';
        echo '<div class="nice-masage">there\'s no member to show</div>';
        echo' <a href="items.php?do=add" class="btn add btn-sm btn-primary">
                  <i class="fa-solid fa-plus"></i>new member
              </a>';
    echo '</div>';
   } ?>
 <?php  }elseif($do == 'add'){ ?>
    <!-- add member page -->
     <h1 class="text-center"><?php echo lang('ADD_MEMBER') ?></h1>
     <div class="container ">
         <form class="form-horizontal" action="?do=insert" method="POST">
             <!-- start username field -->
             <div class="form-group  form-group-lg">
                 <label class="col-sm-2 control-label" for=""><?php echo lang('USERNAME') ?></label>
                 <div class="col-sm-10 col-md-4">
                     <input type="text" name="username"  class="form-control " autocomplete="off" required="requierd" placeholder="username to login into thiqaha">
                 </div>
             </div>
             <!-- end username field -->
             <!-- start password field -->
             <div class="form-group form-group-lg">
                 <label class="col-sm-2 control-label" for=""><?php echo lang('PASSWORD') ?></label>
                 <div class="col-sm-10 col-md-4">
                     <input type="password" name="password" class="password form-control" autocomplete="new-password" required="requierd"  placeholder="password must be hard & complex" > 
                     <!-- <i class="fa fa-eye" aria-hidden="true"></i> -->
                 </div>
             </div>
             <!-- end password field -->
             <!-- start email field -->
             <div class="form-group form-group-lg">
                 <label class="col-sm-2 control-label" for=""><?php echo lang('EMAIL') ?></label>
                 <div class="col-sm-10 col-md-4">
                     <input type="email" name="email" class="form-control" required="requierd" placeholder="email must be valid">
                 </div>
             </div>
             <!-- end email field -->
             <!-- start full name field -->
             <div class="form-group form-group-lg">
                 <label class="col-sm-2 control-label" for=""><?php echo lang('FULLNAME') ?></label>
                 <div class="col-sm-10 col-md-4">
                     <input type="text" name="full" class="form-control" required="requierd" placeholder="full name appear in your profile page">
                 </div>
             </div>
             <!-- end full name field -->
             <!-- start submit field -->
             <div class="form-group form-group-lg">
                 <div class="col-sm-offset-2 col-sm-10">
                     <input type="submit" value="add member" class="btn btn-primary ">
                 </div>
             </div>
             <!-- end submit field -->
         </form>
     </div>
     <?php
   }elseif($do == 'insert'){
    //insert member page
  if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    echo "<h1 class='text-center'>insert page</h1>";
    echo "<div class='container'>";
    // get varibal from the form
    $user    = $_POST['username'];
    $email   = $_POST['email'];
    $name      = $_POST['full'];
    $pass      = $_POST['password'];
    $shaPass = sha1($_POST['password']);
    //valedate the form 
    $formErrors = array();
    if (strlen($user) < 4){
        $formErrors[] = 'username cant be lse than <strong>4 characters</strong>';
    }
    if (strlen($user) > 20){
        $formErrors[] = ' username cant be more than <strong> 20 characters</strong>';
    }
    if (empty($user)){
        $formErrors[] = ' username cant be <strong> empty</strong>';
    }
    if (empty($pass)){
        $formErrors[] = ' password cant be <strong> empty</strong>';
    }
    if (empty($name)){
        $formErrors[] = 'full name cant be <strong> empty</strong>';
    }
    if (empty($email)){
        $formErrors[] = 'email cant be <strong> empty</strong>';
    }
    //loop info errors array and echo it  
    foreach ( $formErrors as $error){
        echo '<div class="alert alert-danger">'. $error . '</div>' ;
    }
    //check if ther's no error proceed the update operation
    if (empty($formErrors)){
        //check if user exist in database
        $check = checkItem("username", "users", $user);
              
       if ($check == 1) {
        $theMsg = '<div class="alert alert-danger">sorry this user is exist</div>';
        redirectHome($theMsg, 'back');
       }else{
            //insert user info in database
            $stmt = $con->prepare("INSERT INTO
                                    users(username, password, Email, Fullname, regStauts, Date)
                                    VALUES(:zuser, :zpass, :zmail, :zname, 1, now()) ");
            $stmt->execute(array(
                'zuser' => $user,
                'zpass' => $shaPass,
                'zmail' => $email,
                'zname' => $name
            ));                     
            // echo success massage
            echo "<div class='container'>";

            $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' record inserted</div>';
            redirectHome($theMsg, 'back');
            echo "</div>";
         }
    }
   
  }else{
    $theMsg = '<div class= "alert alert-danger"sory you can not browse this page directly</div>';
        redirectHome($theMsg);
  }
  echo "</div>";
   }elseif($do == 'edit'){ // edit page 
    echo 'welcom to edit page';
    //check if get requst userid is numeric & get the integer value of it 
    $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;
    // select all data depend on this id  
    $stmt = $con->prepare("SELECT * FROM users WHERE  UserID = ? LIMIT 1");
    //execute query 
    $stmt->execute(array($userid));
   //fetch the data 
    $row = $stmt->fetch();
    //the row count 
    $count = $stmt->rowCount();
    // if theres  sush id show the form 
    if ($count > 0){ ?>
       
        <h1 class="text-center"><?php echo lang('EDIT_MEMBER') ?></h1>
        <div class="container ">
            <form class="form-horizontal" action="?do=Update" method="POST">
                <input type="hidden" name="userid" value="<?php echo $userid ?>">
                <!-- start username field -->
                <div class="form-group  form-group-lg">
                    <label class="col-sm-2 control-label" for=""><?php echo lang('USERNAME') ?></label>
                    <div class="col-sm-10 col-md-4">
                        <input type="text" name="username" value="<?php echo $row['username'] ?>" class="form-control " autocomplete="off" required="requierd" >
                    </div>
                </div>
                <!-- end username field -->
                <!-- start password field -->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label" for=""><?php echo lang('PASSWORD') ?></label>
                    <div class="col-sm-10 col-md-4">
                        <input type="hidden" name="oldpassword"  value="<?php echo $row['password'] ?>">
                        <input type="password" name="newpassword"  class="form-control" autocomplete="new-password" placeholder="leve blank if tou dont want to change" > 
                    </div>
                </div>
                <!-- end password field -->
                <!-- start email field -->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label" for=""><?php echo lang('EMAIL') ?></label>
                    <div class="col-sm-10 col-md-4">
                        <input type="email" name="email" value="<?php echo $row['Email'] ?>" class="form-control" required="requierd">
                    </div>
                </div>
                <!-- end email field -->
                <!-- start full name field -->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label" for=""><?php echo lang('FULLNAME') ?></label>
                    <div class="col-sm-10 col-md-4">
                        <input type="text" name="full" value="<?php echo $row['Fullname'] ?>" class="form-control" required="requierd">
                    </div>
                </div>
                <!-- end full name field -->
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
        $id      = $_POST['userid'];
        $user    = $_POST['username'];
        $email   = $_POST['email'];
        //password trike
        $pass = empty($_POST['newpassword']) ?$_POST['oldpassword']:sha1($_POST['newpassword']);
        //valedate the form 
        $formErrors = array();
        if (strlen($user) < 4){
            $formErrors[] = 'username cant be lse than <strong>4 characters</strong>';
        }
        if (strlen($user) > 20){
            $formErrors[] = ' username cant be more than <strong> 20 characters</strong>';
        }
        if (empty($user)){
            $formErrors[] = ' username cant be <strong> empty</strong>';
        }
        if (empty($name)){
            $formErrors[] = 'full name cant be <strong> empty</strong>';
        }
        if (empty($email)){
            $formErrors[] = 'email cant be <strong> empty</strong>';
        }
        //loop info errors array and echo it  
        foreach ( $formErrors as $error){
            echo '<div class="alert alert-danger">'. $error . '</div>' ;
        }
        //check if ther's no error proceed the update operation
        if (empty($formErrors)){
            $stmt2 = $con->prepare("SELECT * FROM users WHERE username = ? AND UserID != ?");
            $stmt2->execute(array($user, $id));
            $count = $stmt2->rowCount();
            if($count == 1){
                echo '<div class="alert alert-danger">sorry this user is exest</div>';
                redirectHome($theMsg, 'back');
            }else{
                          //update the data base with this info 
                    $stmt = $con->prepare("UPDATE users SET username = ?, Email = ?, Fullname = ?, password = ? WHERE UserID = ?"); 
                    $stmt->execute(array($user, $email,$name, $pass, $id)); 
                    // echo success massage
                $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' record update</div>';
                redirectHome($theMsg, 'back');
            }
   
        }
       
      }else{
        $theMsg = '<div class= "alert alert-danger"sory you can not browse this page directly</div>';
        redirectHome($theMsg);
      }
      echo "</div>";
    }elseif($do == 'activate'){
        echo "<h1 class='text-center'>activate page</h1>";
        echo "<div class='container'>";
                //check if get requst userid is numeric & get the integer value of it 
                $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;
                // select all data depend on this id  
                //check if user exist in database
                $check = checkItem("userid", "users", $userid);
                // if theres  sush id show the form 
                if ($check > 0){
                    $stmt = $con->prepare("UPDATE users SET regStatus = 1 WHERE UserID = ?");
                    $stmt->execute(array($userid));
                    // echo success massage
                    $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' record activate</div>';
                    redirectHome($theMsg);
                } else{
                    $theMsg = '<div class="alert alert-danger">this id is not exist </div>';
                    redirectHome($theMsg);
                    
                }
                echo "</div>";
    }elseif($do == 'delete'){ //delete member page
        echo "<h1 class='text-center'>delete page</h1>";
        echo "<div class='container'>";
                //check if get requst userid is numeric & get the integer value of it 
                $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;
                // select all data depend on this id  
                //check if user exist in database
                $check = checkItem("userid", "users", $userid);
                // if theres  sush id show the form 
                if ($check > 0){
                    $stmt = $con->prepare("DELETE FROM users WHERE UserID = :zuser");
                    $stmt->bindparam(":zuser", $userid);
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



