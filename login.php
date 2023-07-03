<?php
ob_start();
session_start();
$noNavbar = '' ;
$pageTitele = 'login';
if (isset($_SESSION['user'])){
    header('Location:index.php'); //redirect to ashpord page
}
include 'int.php' ;
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(isset($_POST['login'])){
    $user = $_POST['username'];
    $pass = $_POST['password'];
    $hashedpass = sha1($pass);
    // check if user exist ib database
    $stmt = $con->prepare("SELECT
                                 username, password 
                           FROM
                                 users 
                            WHERE username = ? 
                            AND
                                 password = ?");
    $stmt->execute(array($user, $hashedpass));
    $count = $stmt->rowCount();
    // if count > 0 this mean the database contain record about this username
    if ($count > 0) {
        $_SESSION['user'] = $user ; //regester session name
        header('Location:index.php'); //redirect to ashpord page
        exit();
    }
}else{
    $formerrors = array();
     $username = $_POST['username'];
     $password = $_POST['password'];
     $email = $_POST['email'];
    if(isset($username)){
        $filteredUser = filter_var($username, 'FILTER_SANITIZE_STRING');
        if(strlen($filteredUser)< 4){
            $formerrors[]= 'username must be larger ';
        }
    }
    if(isset($password)){
        $pass= sha1($password);
        if($pass != sha1($password)){
            $formerrors[]= 'password must be comblex ';
        }
    }
    if(isset($email)){
        $filteredEmail = filter_var($email, 'FILTER_SANITIZE_EMAIL');
        if(filter_var($filteredEmail, 'FILTER_SANITIZE_EMAIL')!= true){
            $formerrors[]= 'email is not valied  ';
        }
    }
    if (empty($formerrors)){
        $check= checkItem("username", "users", $username);
        if($check == 1){
            $formerrors[]= 'this user is exist ';
        }
        

    }
    else{
        //insert user info in database
        $stmt = $con->prepare("INSERT INTO
        users(username, password, Email, regStauts, Date)
        VALUES(:zuser, :zpass, :zmail, 0, now()) ");
              $stmt->execute(array(
              'zuser' => $username,
              'zpass' => sha1($password),
              'zmail' => $email
              
              ));                     
              // echo success massage
              $succesMsg = 'congrats you are anew user';
  }
}
}
?>
<div class="container login-page">
    <h1 class="text-center"><span class="selected" data-class="login">Login</span> | <span data-class="signup">Signup</span></h1>
    <!-- start login form -->
    <form class="login" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
        <input class="form-control" type="text" name="username" autocomplete="off" placeholder="type your username" required>
        <input class="form-control" type="password" name="password" autocomplete="new-password" placeholder="type your password" required>
        <input class="btn btn-primary" type="submit" name="login"  value="Login">
    </form>
    <!-- end login form -->
     <!-- start signup form -->
    <form class="signup" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" >
        <input class="form-control" type="text" name="username" autocomplete="off" placeholder="type your username" required>
        <input class="form-control" type="password" name="password" autocomplete="new-password" placeholder="type a comblex password" required>
        <input class="form-control" type="email" name="email" placeholder="type a valid email">
        <input class="btn btn-success " type="submit" name="signup" value="Signup">
    </form>
     <!-- end signup form -->
     <div class="the-error text-center">
        <?php
            if(!empty($formerrors)){
                foreach($formerrors as $error){ 
                    echo $error . '<br/>';
                }
            }
            if(isset($succesMsg)){
                echo '<div class="msg succes">'.$succesMsg.'</div>';
            }
        ?>
     </div>
</div>
<?php
include $tpl. 'footer.php';
ob_end_flush();
?>