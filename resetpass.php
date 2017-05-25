<?php
require_once 'class.user.php';
$user = new USER();

if(empty($_GET['id']) && empty($_GET['code']))
{
 $user->redirect('login.php');
}

if(isset($_GET['id']) && isset($_GET['code']))
{
 $id = base64_decode($_GET['id']);
 $code = $_GET['code'];

 if($user->is_logged_in()!="")
 {
   $stmt = $user->runQuery("SELECT * FROM tbl_users WHERE userID=:uid");
   $stmt->execute(array(":uid"=>$_SESSION['userSession']));
   $row = $stmt->fetch(PDO::FETCH_ASSOC);
   if($row['loginType']=="admin"){
     $user->redirect('adminhome.php');
   }else if($row['loginType']=="company"){
     $user->redirect('companyhome.php');
   }else {
     $user->redirect('home.php');
   }
 }

 if($stmt->rowCount() == 1)
 {
  if(isset($_POST['btn-reset-pass']))
  {
   $pass = $_POST['pass'];
   $cpass = $_POST['confirm-pass'];

   if($cpass!==$pass)
   {
    $msg = "<div class='alert alert-block'>
      <button class='close' data-dismiss='alert'>&times;</button>
      <strong>Sorry!</strong>  Password Doesn't match.
      </div>";
   }
   else
   {
    $cpass = md5($cpass);
    $stmt = $user->runQuery("UPDATE tbl_users SET userPass=:upass WHERE userID=:uid");
    $stmt->execute(array(":upass"=>$cpass,":uid"=>$rows['userID']));

    $msg = "<div class='alert alert-success'>
      <button class='close' data-dismiss='alert'>&times;</button>
      Password Changed.
      </div>";
    header("refresh:5;index.php");
   }
  }
 }
 else
 {
  exit;
 }


}

?>
<!DOCTYPE html>
<html>
  <head>
    <title>Password Reset | Hotel Radius</title>
    <!-- Bootstrap -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="vendor/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
    <link href="vendor/assets/styles.css" rel="stylesheet" media="screen">
     <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
  </head>
  <body id="login">
    <div class="container">
     <div class='alert alert-success'>
   <strong>Hello!</strong>  <?php echo $rows['userName'] ?> reset your forgotten password.
  </div>
        <form class="form-signin" method="post">
        <h3 class="form-signin-heading">Password Reset.</h3><hr />
        <?php
        if(isset($msg))
  {
   echo $msg;
  }
  ?>
        <input type="password" class="input-block-level" placeholder="New Password" name="pass" required />
        <input type="password" class="input-block-level" placeholder="Confirm New Password" name="confirm-pass" required />
      <hr />
        <button class="btn btn-large btn-primary" type="submit" name="btn-reset-pass">Reset Your Password</button>

      </form>

    </div> <!-- /container -->
    <script src="vendor/bootstrap/js/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>
