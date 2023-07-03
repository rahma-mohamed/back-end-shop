<?php
ob_start();
session_start();
$pageTitele = 'homepage';
include "int.php"; ?>

<div class="container">
    <div class="row">
    <?php 
    $allItems = getAllFrom('items');
    foreach($allItems as $item){
        echo '<div class="col-sm-6 col-md-3">';
            echo '<div class="thumbnail item-box">';
                echo '<span class="price-tag">'.$item['price'] .'</span>';
                echo '<img class="img-responsive" src="layout/imgs/img1.jpg" alt=""/>';
                echo '<div class="caption">';
                    echo '<h3><a href="items.php?itemid='.$item['item_ID'].'">'. $item['name'] . '</a></h3>';
                    echo '<p>'. $item['description'] . '</p>';
                echo '</div>';
            echo '</div>';
        echo '</div>';
  
    }
    ?>
    </div>
</div>
<?php
include $tpl .'footer.php';
ob_end_flush();
?>

