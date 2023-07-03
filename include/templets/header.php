<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?php getTitele() ?></title>
        <link rel="stylesheet" href=<?= $css ."all.css" ?> >
        <link rel="stylesheet" href= <?= $css ."all.min.css" ?>>
        <link rel="stylesheet" href=<?= $css . "bootstrap.css" ?>>
        <link rel="stylesheet" href=<?= $css . "frontend.css" ?>>
    </head>
<body>
  <div class="upper-bar">
    <div class="container">
      <?php
    if (isset($_SESSION['user'])){ ?>
      <!-- <div class="btn-group">
        <span class="btn dropdown-toggel" data-toggel="dropdown">
          <?php echo $sessionUser ?>
          <span class="caret"></span>
        </span>
        <ul class="dropdown-menu">
          <li><a href="profile.php">my profile</a></li>
          <li><a href="newad.php">new item</a></li>
          <li><a href="logout.php">logout</a></li>
        </ul>
      </div> -->
    <?php
    echo 'welcom ' . $sessionUser. ' '; //redirect to ashpord page
    echo '<a href="profile.php">my profile</a>';
    echo ' - <a href="newad.php">new ad</a>';
    echo ' - <a href="logout.php">logout</a>';
    $userStatus = checkUserStatus($sessionUser);
    if($userStatus == 1){
      echo 'your membership need to actived by admin';
    }
}else{
  ?>
        <a href="login.php">
          <span class="pull-right">Login/Signup</span>
        </a>
        <?php }?>
    </div>
  </div>
  <div class="navbar">
  <a class="navbar-brand" href="index.php">Homepage</a>
            <?php
               foreach(getCat() as $cat){
              echo 
               ' <a href="categories.php?pageid=' . $cat['id'] .  '">
               '. $cat['name'] . 
               '</a>';
            }
           ?>
 
</div>





    
