<?php
/**
 * categories page
 */
ob_start();
session_start();
$pageTitele = '' ;
if(isset($_SESSION['username'])){
    include 'int.php';
    $do = isset($_GET['do']) ? $_GET['do'] : 'manage';
    if ($do == 'manage'){
        $sort = 'ASC';
        $sort_array = array('ASC', 'DESC');
        if(isset($_GET['sort']) && in_array($_GET['sort'], $sort_array)){
            $sort = $_GET['sort'];
        }

        $stmt2 = $con->prepare("SELECT * FROM categories ORDER BY ordering $sort");
        $stmt2->execute();
        $cats = $stmt2->fetchAll(); ?>
        <h1 class="text-center"><?php echo lang('MANAGE_CATEGORIES') ?></h1>
        <div class="container categories ">
            <div class="panel panel-default">
                <div class="panel panel-heading">
                    <i class="fa fa-edit"></i>manage category
                    <div class="option pull-right">
                        <i class="fa fa-sort"></i>ordering:[
                        <a class="<?php if($sort == 'ASC'){echo 'active';} ?>" href="?sort=ASC">asc</a>|
                        <a class="<?php if($sort == 'DESC'){echo 'active';} ?>" href="?sort=DESC">desc</a>]
                        <i class="fa fa-eye"></i>view:[
                        <span class="active" data-view='full'>full</span>|
                        <span data-view='classic'>classic</span>]
                    </div>
                </div>
                <div class="panel panel-body">
                    <?php 
                    foreach($cats as $cat){
                        echo "<div class='cat'>";
                            echo "<div class='hidden-buttons'>";
                                echo"<a href='categories.php?do=edit&catid=".$cat['id']."' class='btn btn-x5 btn-primary'><i class='fa fa-edit'></i> edit</a>";
                                echo"<a href='categories.php?do=delete&catid=".$cat['id']."' class='confirm btn btn-x5 btn-primary'><i class='fa fa-close'></i> delete</a>";
                            echo "</div>";
                            echo '<h3>'.$cat['name'] . '</h3>';
                            echo "<div class='full-view'>";
                                echo '<p>';if($cat['descreption'] == ''){echo 'this category has no description';}else{echo $cat['descreption'];}  echo '</p>';
                                // echo '<span> ordering is'. $cat['ordering'] . '</span>';
                                if($cat['visiblty'] == 1){echo '<span class="visiblty"><i class="fa fa-eye"></i> hidden</span>';} 
                                if($cat['allow_comment'] == 1){echo '<span class="commenting"><i class="fa fa-close"></i>  comment disable</span>';}
                                if($cat['allow_ads'] == 1){echo '<span class="advertises"><i class="fa fa-close"></i> ads disable</span>';}
                           echo "</div>";
                        echo "</div>";
                        echo "<hr>";
                    }
                    ?>
                </div>

            </div>
            <a href="categories.php?do=add" class="btn add-category btn-primary"><i class="fa-solid fa-plus"></i><?php echo lang('ADD_CATEGORIES') ?></a>
        </div>
        <?php
    }elseif($do == 'add'){ ?>
         <!-- add categories page -->
        <h1 class="text-center"><?php echo lang('ADD_CATEGORIES') ?></h1>
        <div class="container ">
            <form class="form-horizontal" action="?do=insert" method="POST">
                <!-- start name field -->
                <div class="form-group  form-group-lg">
                    <label class="col-sm-2 control-label" for=""><?php echo lang('NAME') ?></label>
                    <div class="col-sm-10 col-md-4">
                        <input type="text" name="name"  class="form-control " autocomplete="off" required="requierd" placeholder="name of the category">
                    </div>
                </div>
                <!-- end name field -->
                <!-- start description field -->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label" for=""><?php echo lang('DESCRIPTION') ?></label>
                    <div class="col-sm-10 col-md-4">
                        <input type="text" name="description" class=" form-control"  placeholder="describe the category" > 
                    </div>
                </div>
                <!-- end description field -->
                <!-- start ordering field -->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label" for=""><?php echo lang('ORDERING') ?></label>
                    <div class="col-sm-10 col-md-4">
                        <input type="number" name="ordering" class="form-control"  placeholder="number to arring the categories">
                    </div>
                </div>
                <!-- end ordering field -->
                <!-- start visibel field -->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label" for=""><?php echo lang('VISIBEL') ?></label>
                    <div class="col-sm-10 col-md-4">
                        <div>
                            <input id="vis-yes" type="radio" name="visibelty" value="0" checked>
                            <label for="vis-yes">yes</label>
                        </div>
                        <div>
                            <input id="vis-no" type="radio" name="visibelty" value="1">
                            <label for="vis-no">no</label>
                        </div>
                    </div>
                </div>
                <!-- end visibel field -->
                  <!-- start commenting field -->
                  <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label" for=""><?php echo lang('ALLOW_COMMENTING') ?></label>
                    <div class="col-sm-10 col-md-4">
                        <div>
                            <input id="com-yes" type="radio" name="commenting" value="0" checked>
                            <label for="com-yes">yes</label>
                        </div>
                        <div>
                            <input id="com-no" type="radio" name="commenting" value="1">
                            <label for="com-no">no</label>
                        </div>
                    </div>
                </div>
                <!-- end commenting field -->
                        <!-- start ads field -->
                        <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label" for=""><?php echo lang('ALLOW_ADS') ?></label>
                    <div class="col-sm-10 col-md-4">
                        <div>
                            <input id="ads-yes" type="radio" name="ads" value="0" checked>
                            <label for="ads-yes">yes</label>
                        </div>
                        <div>
                            <input id="ads-no" type="radio" name="ads" value="1">
                            <label for="ads-no">no</label>
                        </div>
                    </div>
                </div>
                <!-- end ads field -->
                <!-- start submit field -->
                <div class="form-group form-group-lg">
                    <div class="col-sm-offset-2 col-sm-10">
                        <input type="submit" value="add category" class="btn btn-primary ">
                    </div>
                </div>
                <!-- end submit field -->
            </form>
        </div>
        
        <?php
    }elseif($do == 'insert'){
            //insert category page
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            echo "<h1 class='text-center'>insert category</h1>";
            echo "<div class='container'>";
            // get varibal from the form
            $name    = $_POST['name'];
            $desc    = $_POST['description'];
            $order   = $_POST['ordering'];
            $visibel = $_POST['visibelty'];
            $comment = $_POST['commenting'];
            $ads     = $_POST['ads'];
                //check if category exist in database
                $check = checkItem("name", "categories", $name);
                    
            if ($check == 1) {
                $theMsg = '<div class="alert alert-danger">sorry this category is exist</div>';
                redirectHome($theMsg, 'back');
            }else{
                    //insert category info in database
                    $stmt = $con->prepare("INSERT INTO
                                            categories(name, descreption, ordering, visiblty, 	allow_comment, allow_ads)
                                            VALUES(:zname, :zdesc, :zorder, :zvisibel, :zcomment, :zads) ");
                    $stmt->execute(array(
                        'zname' =>  $name,
                        'zdesc' => $desc,
                        'zorder' => $order,
                        'zvisibel' => $visibel,
                        'zcomment' => $comment,
                        'zads' => $ads,
                    ));                     
                    // echo success massage
                    echo "<div class='container'>";

                    $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' record inserted</div>';
                    redirectHome($theMsg, 'back');
                    echo "</div>";
                }
            
        
        }else{
            $theMsg = '<div class= "alert alert-danger"sory you can not browse this page directly</div>';
                redirectHome($theMsg, 'back');
        }
        echo "</div>";
        
    }elseif($do == 'edit'){//edit page
        echo 'welcom to edit page';
        //check if get requst catid is numeric & get the integer value of it 
        $catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0;
        // select all data depend on this id  
        $stmt = $con->prepare("SELECT * FROM categories WHERE  id = ? ");
        //execute query 
        $stmt->execute(array($catid));
       //fetch the data 
        $cat = $stmt->fetch();
        //the row count 
        $count = $stmt->rowCount();
        // if theres  sush id show the form 
        if ($count > 0){ ?>
            <h1 class="text-center"><?php echo lang('EDIT_CATEGORIES') ?></h1>
            <div class="container ">
                <form class="form-horizontal" action="?do=update" method="POST">
                    <input type="hidden" name="catid" value="<?php echo $catid?>">
                    <!-- start name field -->
                    <div class="form-group  form-group-lg">
                        <label class="col-sm-2 control-label" for=""><?php echo lang('NAME') ?></label>
                        <div class="col-sm-10 col-md-4">
                            <input type="text" name="name"  class="form-control " required="requierd" placeholder="name of the category" value="<?php echo $cat['name'] ?>">
                        </div>
                    </div>
                    <!-- end name field -->
                    <!-- start description field -->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label" for=""><?php echo lang('DESCRIPTION') ?></label>
                        <div class="col-sm-10 col-md-4">
                            <input type="text" name="description" class=" form-control"  placeholder="describe the category" value="<?php echo $cat['descreption'] ?>"> 
                        </div>
                    </div>
                    <!-- end description field -->
                    <!-- start ordering field -->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label" for=""><?php echo lang('ORDERING') ?></label>
                        <div class="col-sm-10 col-md-4">
                            <input type="number" name="ordering" class="form-control"  placeholder="number to arring the categories" value="<?php echo $cat['ordering'] ?>">
                        </div>
                    </div>
                    <!-- end ordering field -->
                    <!-- start visibel field -->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label" for=""><?php echo lang('VISIBEL') ?></label>
                        <div class="col-sm-10 col-md-4">
                            <div>
                                <input id="vis-yes" type="radio" name="visibelty" value="0" <?php if($cat['visiblty'] == 0){echo 'checked';} ?>  >
                                <label for="vis-yes">yes</label>
                            </div>
                            <div>
                                <input id="vis-no" type="radio" name="visibelty" value="1"  <?php if($cat['visiblty'] == 1){echo 'checked';} ?>>
                                <label for="vis-no">no</label>
                            </div>
                        </div>
                    </div>
                    <!-- end visibel field -->
                    <!-- start commenting field -->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label" for=""><?php echo lang('ALLOW_COMMENTING') ?></label>
                        <div class="col-sm-10 col-md-4">
                            <div>
                                <input id="com-yes" type="radio" name="commenting" value="0"  <?php if($cat['allow_comment'] == 0){echo 'checked';} ?>>
                                <label for="com-yes">yes</label>
                            </div>
                            <div>
                                <input id="com-no" type="radio" name="commenting" value="1"  <?php if($cat['allow_comment'] == 1){echo 'checked';} ?>>
                                <label for="com-no">no</label>
                            </div>
                        </div>
                    </div>
                    <!-- end commenting field -->
                            <!-- start ads field -->
                            <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label" for=""><?php echo lang('ALLOW_ADS') ?></label>
                        <div class="col-sm-10 col-md-4">
                            <div>
                                <input id="ads-yes" type="radio" name="ads" value="0"  <?php if($cat['allow_ads'] == 0){echo 'checked';} ?>>
                                <label for="ads-yes">yes</label>
                            </div>
                            <div>
                                <input id="ads-no" type="radio" name="ads" value="1"  <?php if($cat['allow_ads'] == 1){echo 'checked';} ?>>
                                <label for="ads-no">no</label>
                            </div>
                        </div>
                    </div>
                    <!-- end ads field -->
                    <!-- start submit field -->
                    <div class="form-group form-group-lg">
                        <div class="col-sm-offset-2 col-sm-10">
                            <input type="submit" value="save category" class="btn btn-primary ">
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
    }elseif($do == 'update'){
            echo "<h1 class='text-center'>update catrgory page</h1>";
            echo "<div class='container'>";
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            // get varibal from the form
            $id      = $_POST['catid'];
            $name    = $_POST['name'];
            $desc   = $_POST['descreption'];
            $order   = $_POST['ordering'];
            $visible   = $_POST['visibelty'];
            $comment   = $_POST['commenting'];
            $ads   = $_POST['ads'];
                //update the data base with this info 
                $stmt = $con->prepare("UPDATE categories SET name = ?, descreption = ?, ordering = ?, visiblty = ?, allow_comment = ?, allow_ads = ? WHERE id= ?"); 
                $stmt->execute(array($name, $desc,$order, $visible,$comment,$ads, $id)); 
                // echo success massage
            $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' record update</div>';
            redirectHome($theMsg, 'back');
            }else{
            $theMsg = '<div class= "alert alert-danger"sory you can not browse this page directly</div>';
            redirectHome($theMsg);
        }
        echo "</div>";
    }elseif($do == 'delete'){
        echo "<h1 class='text-center'>delete category page</h1>";
        echo "<div class='container'>";
                //check if get requst catid is numeric & get the integer value of it 
                $catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0;
                // select all data depend on this id  
                $check = checkItem("id", "categories", $catid);
                // if theres  sush id show the form 
                if ($check > 0){
                    $stmt = $con->prepare("DELETE FROM categories WHERE id = :zid");
                    $stmt->bindparam(":zid", $catid);
                    $stmt->execute();
                    // echo success massage
                    $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' record deleted</div>';
                    redirectHome($theMsg , 'back');
                }else{
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