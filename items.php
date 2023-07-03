<?php
ob_start();
session_start();
$pageTitele = 'show items';
include 'int.php';
$itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;
$stmt = $con->prepare("SELECT
                             items.* , categories.name AS category_name,
                             users.username
                        FROM
                             items 
                        INNER JOIN
                            categories
                         ON 
                            categories.id =items.cat_ID 
                        INNER JOIN
                            users
                        ON
                            user.UserID = items.member_ID
                        WHERE 
                            item_ID = ?");
$stmt->execute(array($itemid));
$count = $stmt->rowCount();
if($count > 0){


$item = $stmt->fetch();
?>
<h1 class="text-center"><?php echo $item['name'] ?></h1>
<div class="container">
    <div class="row">
        <div class="col-md-3">
        <img class="img-responsive img-thumbnail center-block" src="layout/imgs/img1.jpg" alt=""/>
        </div>
        <div class="col-md-9 item-info">
            <h2><?php echo $item['name'] ?></h2>
            <p><?php echo $item['description'] ?></p>
            <ul class="list-unstyled">
            <li><?php echo $item['add_date'] ?></li>
            <li><span> price </span>:<?php echo $item['price'] ?></li>
            <li><span> made in </span>:<?php echo $item['country_made'] ?></li>
            <li><span> category </span>: <a href="categories.php?pageid=<?php echo $item['cat_ID']?>"><?php echo $item['category_name'] ?></a></li>
            <li><span> add by </span>:<a href=""><?php echo $item['username'] ?></a></li>
            </ul>
        </div>
    </div>
    <hr class="ccostme-hr">
    <div class="row">
        <div class="col-md-3">
            user image
        </div>
        <div class="col-md-9">
            user comment
        </div>
    </div>
</div>
<?php
}else{
    echo 'there is no id';
}
 include $tpl . 'footer.php';
 ob_end_flush();
?>