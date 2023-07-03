<?php
session_start();
$pageTitele = 'cerate new ad';
include "int.php";
if(isset($_SESSION['user'])){
?>
<h1 class="text-center">cerate new item</h1>
<div class="cerate-ad block">
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">cerate new item</div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-8">
                    <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                    <!-- start name field -->
                    <div class="form-group  form-group-lg">
                        <label class="col-sm-3 control-label" for=""><?php echo lang('NAME') ?></label>
                        <div class="col-sm-10 col-md-9">
                            <input type="text" name="name" data-class=".live-titel" class="form-control live " required="requierd" placeholder="name of the item">
                        </div>
                    </div>
                    <!-- end name field -->
                    <!-- start description field -->
                    <div class="form-group  form-group-lg">
                        <label class="col-sm-3 control-label" for="">description</label>
                        <div class="col-sm-10 col-md-9">
                            <input type="text" name="description" data-class=".live-desc" class="form-control live " required="requierd" placeholder="description of the item">
                        </div>
                    </div>
                    <!-- end description field -->
                        <!-- start price field -->
                        <div class="form-group  form-group-lg">
                        <label class="col-sm-3 control-label" for=""><?php echo lang('PRICE') ?></label>
                        <div class="col-sm-10 col-md-4">
                            <input type="text" name="price" data-class=".live-price" class="form-control live " required="requierd" placeholder="price of the item">
                        </div>
                    </div>
                    <!-- end price field -->
                    <!-- start cuntry field -->
                    <div class="form-group  form-group-lg">
                        <label class="col-sm-3 control-label" for=""><?php echo lang('CUNTRY') ?></label>
                        <div class="col-sm-10 col-md-9">
                            <input type="text" name="country"  class="form-control live-country " required="requierd" placeholder="country of made">
                        </div>
                    </div>
                    <!-- end cuntry field -->
                    <!-- start status field -->
                    <div class="form-group  form-group-lg">
                        <label class="col-sm-3 control-label" for=""><?php echo lang('STATUS') ?></label>
                        <div class="col-sm-10 col-md-9">
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
                        <label class="col-sm-3 control-label" for=""><?php echo lang('MEMBER' ) ?></label>
                        <div class="col-sm-10 col-md-9">
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
                        <label class="col-sm-3 control-label" for=""><?php echo lang('CATEGORY' ) ?></label>
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
                    <div class="col-md-4">
                                    <div class="thumbnail item-box live-preview">
                                         <span class="price-tag live-price">0</span>
                                        <img class="img-responsive" src="layout/imgs/img1.jpg" alt=""/>
                                        <div class="caption">
                                            <h3 class="live-titel">titel</h3>
                                            <p class="live-desc">description</p>
                                        </div>
                                    </div>
                                    </div>
                    </div>

                 

                </div>
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

