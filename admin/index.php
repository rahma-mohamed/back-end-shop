<?php
session_start();
$noNavbar = '' ;
$pageTitele = 'login';
if (isset($_SESSION['username'])){
    header('Location:dashboard.php'); //redirect to ashpord page
}
include "int.php";



// check if user coming from http post request
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $username = $_POST['user'];
    $password = $_POST['pass'];
    $hashedpass = sha1($password);
    // check if user exist ib database
    $stmt = $con->prepare("SELECT
                                UserID, username, password 
                           FROM
                                 users 
                            WHERE username = ? 
                            AND
                                 password = ?
                            AND
                                 GroupID = 1
                            LIMIT 1");
    $stmt->execute(array($username, $hashedpass));
    $row = $stmt->fetch();
    $count = $stmt->rowCount();
    // if count > 0 this mean the database contain record about this username
    if ($count > 0) {
        $_SESSION['username'] = $username ; //regester session name
        $_SESSION['ID'] = $row['UserID'] ; //regester session id
        header('Location:dashboard.php'); //redirect to ashpord page
        exit();
    }
}
?>
<form class="login" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
    <h4 class="text-center">Admin login</h4>
    <input  class="form-control" type="text" name="user" placeholder="username" autocomplete="off">
    <input  class="form-control" type="password" name="pass" placeholder="password" autocomplete="new-password">
    <input  class="btn btn-primary btn-block " type="submit" value="login">
</form>

<?php
include $tpl .'footer.php';
?>

