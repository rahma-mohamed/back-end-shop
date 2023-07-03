<div class="navbar">
  <a href="dashboard.php"><?php echo lang('HOME_ADMIN') ?></a>
  <a href="categories.php"><?php echo lang('CATEGORIES') ?></a>
  <a href="items.php"><?php echo lang('ITEMS') ?></a>
  <a href="members.php"><?php echo lang('MEMBERS') ?></a>
  <!-- <a href="#news"><?php echo lang('STATISTICS') ?></a> -->
  <a href="comments.php"><?php echo lang('COMMENTS') ?></a>
  <!-- <a href="#news"><?php echo lang('LOGS') ?></a> -->
  <div class="dropdown">
    <button class="dropbtn"><?php echo lang('NAME') ?>
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
      <a href="../index.php">visit shop</a>
      <a href="members.php?do=edit&userid=<?php echo $_SESSION['ID'] ?>"><?php echo lang('EDIT') ?></a>
      <a href="#"><?php echo lang('SET') ?></a>
      <a href="logout.php"><?php echo lang('OUT') ?></a>
    </div>
  </div> 
</div>
<!--&userid=<?php echo $_SESSION['ID'] ?>  -->