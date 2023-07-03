<?php
/**
 * items page
 */
ob_start();
session_start();
$pageTitele = 'items' ;
if(isset($_SESSION['username'])){
    include 'int.php';
    $do = isset($_GET['do']) ? $_GET['do'] : 'manage';
    if ($do == 'manage'){
    //select all items from data base 
    $stmt = $con->prepare("SELECT 
                                items.* ,categories.name AS cat_name, users.username
                            FROM 
                                items
                            INNER JOIN 
                                categories
                            ON 
                                categories.id = items.cat_ID
                            INNER JOIN 
                                users 
                            ON 
                                users.UserID = items.member_ID 
                                ORDER BY
                                                item_ID
                                            DESC");
    //execute the statement
    $stmt->execute();
    //assign to varibal
    $items = $stmt->fetchAll();
    if(!empty($items)){
    ?>  
   <!-- manage page -->
     <h1 class="text-center"><?php echo lang('MANAGE_ITEMS') ?></h1>
     <div class="container ">
        <div class="table-responsive">
            <table class="main-table text-center table table-bordered">
                <tr>
                    <td><?php echo lang('ID') ?></td>
                    <td><?php echo lang('NAME') ?></td>
                    <td>descreption</td>
                    <td><?php echo lang('PRICE') ?></td>
                    <td><?php echo lang('ADDING_DATE') ?></td>
                    <td>category</td>
                    <td>username</td>
                    <td><?php echo lang('CONTROL') ?></td>
                </tr>
                <?php
                foreach($items as $item){
                    echo "<tr>";
                        echo "<td>" . $item['item_ID']. "</td>";
                        echo "<td>" . $item['name']. "</td>";
                        echo "<td>" . $item['description']. "</td>";
                        echo "<td>" . $item['price']. "</td>";
                        echo "<td>" . $item['add_date'] . "</td>";
                        echo "<td>" . $item['cat_name'] . "</td>";
                        echo "<td>" . $item['username'] . "</td>";
                        echo " <td>
                                 <a href='members.php?do=edit&itemid=".$item['item_ID']."' class='btn btn-sm btn-success'><i class='fa-solid fa-pen-to-square'></i>Edit</a>
                                 <a href='members.php?do=delete&itemid=".$item['item_ID']."' class='confirm btn btn-sm btn-danger '><i class='fa-solid fa-xmark'></i>Delete</a>"; 
                                 if($item['approve'] == 0){
                                    echo "<a href='items.php?do=approve&itemid=".$item['item_ID']."' class='btn btn-info activate'>approve</a>";
                                  }
                        echo "</td>";
                    echo "</tr>";       
                }
                ?>
            </table>
        </div>
        <a href="items.php?do=add" class="btn add btn-sm btn-primary"><i class="fa-solid fa-plus"></i><?php echo lang('ADD_ITEM') ?></a>
     </div>   
   <?php }else{
    echo '<div class="container">';
        echo '<div class="nice-masage">there\'s no items to show</div>';
       echo' <a href="items.php?do=add" class="btn add btn-sm btn-primary">
                 <i class="fa-solid fa-plus"></i>new item
            </a>';
    echo '</div>';
   } ?>
   <?php
    }elseif($do == 'add'){?>
        <!-- add items page -->
        <h1 class="text-center"><?php echo lang('ADD_ITEM') ?></h1>
        <div class="container ">
            <form class="form-horizontal" action="?do=insert" method="POST">
                <!-- start name field -->
                <div class="form-group  form-group-lg">
                    <label class="col-sm-2 control-label" for=""><?php echo lang('NAME') ?></label>
                    <div class="col-sm-10 col-md-4">
                        <input type="text" name="name"  class="form-control " required="requierd" placeholder="name of the item">
                    </div>
                </div>
                <!-- end name field -->
                  <!-- start description field -->
                  <div class="form-group  form-group-lg">
                    <label class="col-sm-2 control-label" for="">description</label>
                    <div class="col-sm-10 col-md-4">
                        <input type="text" name="description"  class="form-control " required="requierd" placeholder="description of the item">
                    </div>
                </div>
                <!-- end description field -->
                      <!-- start price field -->
                      <div class="form-group  form-group-lg">
                    <label class="col-sm-2 control-label" for=""><?php echo lang('PRICE') ?></label>
                    <div class="col-sm-10 col-md-4">
                        <input type="text" name="price"  class="form-control " required="requierd" placeholder="price of the item">
                    </div>
                </div>
                <!-- end price field -->
                <!-- start cuntry field -->
                <div class="form-group  form-group-lg">
                    <label class="col-sm-2 control-label" for=""><?php echo lang('CUNTRY') ?></label>
                    <div class="col-sm-10 col-md-4">
                        <input type="text" name="country"  class="form-control " required="requierd" placeholder="country of made">
                    </div>
                </div>
                <!-- end cuntry field -->
                <!-- start status field -->
                <div class="form-group  form-group-lg">
                    <label class="col-sm-2 control-label" for=""><?php echo lang('STATUS') ?></label>
                    <div class="col-sm-10 col-md-4">
                      <select name="status" class="form-control form-select " id="">
                        <option value="0">...</option>
                        <option value="1">new</option>
                        <option value="2">like new</option>
                        <option value="3">used</option>
                        <option value="4">old</option>
                      </select>
                    </div>
                </div>
                <!-- end status field -->
                <!-- start members field -->
                <div class="form-group  form-group-lg">
                    <label class="col-sm-2 control-label" for=""><?php echo lang('MEMBER' ) ?></label>
                    <div class="col-sm-10 col-md-4">
                      <select name="member" class="form-control form-select " id="">
                        <option value="0">...</option>
                        <?php
                        $stmt = $con->prepare("SELECT * FROM users");
                        $stmt->execute();
                        $users = $stmt->fetchAll();
                        foreach($users as $user){
                            echo "<option value='".$user['UserID']."'>".$user['username']."</option>";
                        }
                        ?>
                      </select>
                    </div>
                </div>
                <!-- end members field -->
                 <!-- start category field -->
                 <div class="form-group  form-group-lg">
                    <label class="col-sm-2 control-label" for=""><?php echo lang('CATEGORY' ) ?></label>
                    <div class="col-sm-10 col-md-4">
                      <select name="category" class="form-control form-select " id="">
                        <option value="0">...</option>
                        <?php
                        $stmt2 = $con->prepare("SELECT * FROM categories");
                        $stmt2->execute();
                        $cats = $stmt2->fetchAll();
                        foreach($cats as $cat){
                            echo "<option value='".$cat['ID']."'>".$cat['name']."</option>";
                        }
                        ?>
                      </select>
                    </div>
                </div>
                <!-- end category field -->
                <!-- start submit field -->
                <div class="form-group form-group-lg">
                    <div class="col-sm-offset-2 col-sm-10">
                        <input type="submit" value="add item" class="btn btn-primary btn-sm">
                    </div>
                </div>
                <!-- end submit field -->
            </form>
        </div>
        
        <?php
    }elseif($do == 'insert'){
        //insert item page
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            echo "<h1 class='text-center'>insert item page</h1>";
            echo "<div class='container'>";
            // get varibal from the form
            $name    = $_POST['name'];
            $desc  = $_POST['description'];
            $price      = $_POST['price'];
            $country      = $_POST['country'];
            $status = $_POST['status'];
            $member = $_POST['member'];
            $cat = $_POST['category'];
            //valedate the form 
            $formErrors = array();
            if (empty($name)){
                $formErrors[] = 'name can\'t be <strong>empty</strong>';
            }
            if (empty($desc)){
                $formErrors[] = 'description can\'t be <strong>empty</strong>';
            }
            if (empty($price)){
                $formErrors[] = 'price can\'t be <strong>empty</strong>';
            }
            if (empty($country)){
                $formErrors[] = 'country can\'t be <strong>empty</strong>';
            }
            if ($status == 0){
                $formErrors[] = 'you mast choose the  <strong>status</strong>';
            }
          
            //loop info errors array and echo it  
            foreach ( $formErrors as $error){
                echo '<div class="alert alert-danger">'. $error . '</div>' ;
            }
                    //insert user info in database
                    $stmt = $con->prepare("INSERT INTO
                                            items(name, description, price, add_date, country_made, status,member_ID, cat_ID)
                                            VALUES(:zname, :zdesc, :zprice,now(), :zcountry, :zstatus,:zmember, :zcat ) ");
                    $stmt->execute(array(
                        'zname' => $name,
                        'zdesc' => $desc,
                        'zprice' => $price,
                        'zcountry' => $country,
                        'zstatus' => $status,
                        'zmember' => $member,
                        'zcat' => $cat
                       
                    ));                     
                    // echo success massage
                    echo "<div class='container'>";
        
                    $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' record inserted</div>';
                    redirectHome($theMsg, 'back');
                    echo "</div>";
                 
                
           
          }else{
            $theMsg = '<div class= "alert alert-danger"sory you can not browse this page directly</div>';
                redirectHome($theMsg);
          }
          echo "</div>";
    }elseif($do == 'edit'){
        echo 'welcom to edit page';
        //check if get requst userid is numeric & get the integer value of it 
        $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;
        // select all data depend on this id  
        $stmt = $con->prepare("SELECT * FROM items WHERE item_ID = ?");
        //execute query 
        $stmt->execute(array($itemid));
       //fetch the data 
        $item = $stmt->fetch();
        //the row count 
        $count = $stmt->rowCount();
        // if theres  sush id show the form 
        if ($count > 0){ ?>
            <!-- edit items page -->
            <h1 class="text-center"><?php echo lang('EDIT_ITEM') ?></h1>
            <div class="container ">
                <form class="form-horizontal" action="?do=update" method="POST">
                    <input type="hidden" name="itemid" value="<?php echo $itemid ?>">
                    <!-- start name field -->
                    <div class="form-group  form-group-lg">
                        <label class="col-sm-2 control-label" for=""><?php echo lang('NAME') ?></label>
                        <div class="col-sm-10 col-md-4">
                            <input type="text" name="name"  class="form-control " required="requierd" placeholder="name of the item" value="<?php echo $item['name'] ?>">
                        </div>
                    </div>
                    <!-- end name field -->
                    <!-- start description field -->
                    <div class="form-group  form-group-lg">
                        <label class="col-sm-2 control-label" for=""><?php echo lang('DESCRIPTION') ?></label>
                        <div class="col-sm-10 col-md-4">
                            <input type="text" name="description"  class="form-control " required="requierd" placeholder="description of the item"  value="<?php echo $item['description'] ?>">
                        </div>
                    </div>
                    <!-- end description field -->
                        <!-- start price field -->
                        <div class="form-group  form-group-lg">
                        <label class="col-sm-2 control-label" for=""><?php echo lang('PRICE') ?></label>
                        <div class="col-sm-10 col-md-4">
                            <input type="text" name="price"  class="form-control " required="requierd" placeholder="price of the item" value="<?php echo $item['price'] ?>">
                        </div>
                    </div>
                    <!-- end price field -->
                    <!-- start cuntry field -->
                    <div class="form-group  form-group-lg">
                        <label class="col-sm-2 control-label" for=""><?php echo lang('CUNTRY') ?></label>
                        <div class="col-sm-10 col-md-4">
                            <input type="text" name="cuntry"  class="form-control " required="requierd" placeholder="country of made" value="<?php echo $item['cuntry'] ?>">
                        </div>
                    </div>
                    <!-- end cuntry field -->
                    <!-- start status field -->
                    <div class="form-group  form-group-lg">
                        <label class="col-sm-2 control-label" for=""><?php echo lang('STATUS') ?></label>
                        <div class="col-sm-10 col-md-4">
                        <select name="status" class="form-control form-select " id="">
                            <option value="0">...</option>
                            <option value="1"<?php if($item['status']== 1){echo 'selected';}?>>new</option>
                            <option value="2"<?php if($item['status']== 2){echo 'selected';}?>>like new</option>
                            <option value="3"<?php if($item['status']== 3){echo 'selected';}?>>used</option>
                            <option value="4"<?php if($item['status']== 4){echo 'selected';}?>>old</option>
                        </select>
                        </div>
                    </div>
                    <!-- end status field -->
                    <!-- start members field -->
                    <div class="form-group  form-group-lg">
                        <label class="col-sm-2 control-label" for=""><?php echo lang('MEMBER' ) ?></label>
                        <div class="col-sm-10 col-md-4">
                        <select name="member" class="form-control form-select " id="">
                            <option value="0">...</option>
                            <?php
                            $stmt = $con->prepare("SELECT * FROM users");
                            $stmt->execute();
                            $users = $stmt->fetchAll();
                            foreach($users as $user){
                                echo "<option value='".$user['UserID']."'"; 
                                if($item['member_ID']== $user['UserID']){echo 'selected';}
                                 echo">".$user['username']."</option>";
                            }
                            ?>
                        </select>
                        </div>
                    </div>
                    <!-- end members field -->
                    <!-- start category field -->
                    <div class="form-group  form-group-lg">
                        <label class="col-sm-2 control-label" for=""><?php echo lang('CATEGORY' ) ?></label>
                        <div class="col-sm-10 col-md-4">
                        <select name="category" class="form-control form-select " id="">
                            <option value="0">...</option>
                            <?php
                            $stmt2 = $con->prepare("SELECT * FROM categories");
                            $stmt2->execute();
                            $cats = $stmt2->fetchAll();
                            foreach($cats as $cat){
                                echo "<option value='".$cat['ID']."'";
                                if($item['cat_ID']== $cat['id']){echo 'selected';}
                               echo" >".$cat['name']."</option>";
                            }
                            ?>
                        </select>
                        </div>
                    </div>
                    <!-- end category field -->
                    <!-- start submit field -->
                    <div class="form-group form-group-lg">
                        <div class="col-sm-offset-2 col-sm-10">
                            <input type="submit" value="save item" class="btn btn-primary btn-sm">
                        </div>
                    </div>
                    <!-- end submit field -->
                </form><?php
                $stmt = $con->prepare("SELECT 
                                comments.*, users.username
                             FROM
                                comments
                            INNER JOIN
                                users
                            ON
                                users.UserID = comments.user_id
                            WHERE item_id = ?");
                //execute the statement
                $stmt->execute(array($itemid));
                //assign to varibal
                $rows = $stmt->fetchAll();
                if(! empty($rows)){
                ?>  
            <!-- manage page -->
                <h1 class="text-center">manage [<?php echo $item['name'] ?>] comments</h1>
                
                <div class="table-responsive">
                    <table class="main-table text-center table table-bordered">
                        <tr>
                            
                            <td>comment</td>
                            
                            <td>user name</td>
                            <td>added date</td>
                            <td><?php echo lang('CONTROL') ?></td>
                        </tr>
                        <?php
                        foreach($rows as $row){
                            echo "<tr>";
                           
                                echo "<td>" . $row['comment']. "</td>";
                                
                                echo "<td>" . $row['user_id']. "</td>";
                                echo "<td>" . $row['comment_date'] . "</td>";
                                echo " <td>
                                        <a href='comments.php?do=edit&comid=".$row['c_id']."'
                                        class='btn btn-success'><i class='fa-solid fa-pen-to-square'></i>Edit</a>
                                        <a href='comments.php?do=delete&comid=".$row['c_id']."'
                                        class='confirm btn btn-danger '><i class='fa-solid fa-xmark'></i>Delete</a>";
                                if($row['regStauts'] == 0){
                                echo "<a href='comments.php?do=approve&comid="
                                .$row['c_id']."' class='btn btn-info activate'>approve</a>";
                                }
                                echo "</td>";
                            echo "</tr>";       
                        }
                        ?>
                    </table>
                </div>
                <?php } ?>
                  
            </div>
           
            <?php 
            // else show error masseg
                } else{
                    echo "<div class='container'>";
    
                    $theMsg = '<div class="alert alert-danger"> theres no sush id</div>';
                    redirectHome($theMsg);
                    echo "</div>";
                }
    
    }elseif($do == 'update'){
        echo "<h1 class='text-center'>update item page</h1>";
        echo "<div class='container'>";
      if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        // get varibal from the form
        $name    = $_POST['name'];
        $desc  = $_POST['description'];
        $price      = $_POST['price'];
        $country      = $_POST['country'];
        $status = $_POST['status'];
        $member = $_POST['member'];
        $cat = $_POST['category'];
        //valedate the form 
        $formErrors = array();
        if (empty($name)){
            $formErrors[] = 'name can\'t be <strong>empty</strong>';
        }
        if (empty($desc)){
            $formErrors[] = 'description can\'t be <strong>empty</strong>';
        }
        if (empty($price)){
            $formErrors[] = 'price can\'t be <strong>empty</strong>';
        }
        if (empty($country)){
            $formErrors[] = 'country can\'t be <strong>empty</strong>';
        }
        if ($status == 0){
            $formErrors[] = 'you mast choose the  <strong>status</strong>';
        }
      
        //loop info errors array and echo it  
        foreach ( $formErrors as $error){
            echo '<div class="alert alert-danger">'. $error . '</div>' ;
        }
        //check if ther's no error proceed the update operation
        if (empty($formErrors)){
             //update the data base with this info 
            $stmt = $con->prepare("UPDATE
                                         items
                                   SET 
                                        name = ?, 
                                        description = ?,
                                         price = ?,
                                          country_made = ? ,
                                        status = ?,
                                        cat_ID =?,
                                        member_ID =?
                                    WHERE
                                     item_ID = ?"); 
            $stmt->execute(array($name, $desc,$price, $country,$status, $cat, $member, $id)); 
            // echo success massage
           $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' record update</div>';
           redirectHome($theMsg, 'back');
        }
       
      }else{
        $theMsg = '<div class= "alert alert-danger"sory you can not browse this page directly</div>';
        redirectHome($theMsg);
      }
      echo "</div>";
    }elseif($do == 'delete'){
        echo "<h1 class='text-center'>delete item page</h1>";
        echo "<div class='container'>";
                //check if get requst itemid is numeric & get the integer value of it 
                $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;
                // select all data depend on this id  
                //check if user exist in database
                $check = checkItem("item_ID", "items", $itemid);
                // if theres  sush id show the form 
                if ($check > 0){
                    $stmt = $con->prepare("DELETE FROM items WHERE item_ID = :zid");
                    $stmt->bindparam(":zid", $itemid);
                    $stmt->execute();
                    // echo success massage
                    $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' record deleted</div>';
                    redirectHome($theMsg, 'bake');
                }else{
                    $theMsg = '<div class="alert alert-danger">this id is not exist </div>';
                    redirectHome($theMsg);
                    
                }
                echo "</div>";
    }elseif($do == 'approve'){
        echo "<h1 class='text-center'>approve item page</h1>";
        echo "<div class='container'>";
                //check if get requst userid is numeric & get the integer value of it 
                $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;
                // select all data depend on this id  
                //check if user exist in database
                $check = checkItem("item_ID", "items", $itemid);
                // if theres  sush id show the form 
                if ($check > 0){
                    $stmt = $con->prepare("UPDATE items SET approve WHERE item_ID = ?");
                    $stmt->execute(array($itemid));
                    // echo success massage
                    $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' record deleted</div>';
                    redirectHome($theMsg , 'back');
                } else{
                    $theMsg = '<div class="alert alert-danger">this id is not exist </div>';
                    redirectHome($theMsg);
                    
                }
                echo "</div>";
    }
    include $tpl . 'footer.php';
}else{
    header('location: index.php');
    exit();
}
ob_end_flush();
?>