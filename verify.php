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

 $statusY = "Y";
 $statusN = "N";

 $stmt = $user->runQuery("SELECT userID,userStatus FROM tbl_users WHERE userID=:uID AND tokenCode=:code LIMIT 1");
 $stmt->execute(array(":uID"=>$id,":code"=>$code));
 $row=$stmt->fetch(PDO::FETCH_ASSOC);
 if($stmt->rowCount() > 0)
 {
  if($row['userStatus']==$statusN)
  {
   $stmt = $user->runQuery("UPDATE tbl_users SET userStatus=:status WHERE userID=:uID");
   $stmt->bindparam(":status",$statusY);
   $stmt->bindparam(":uID",$id);
   $stmt->execute();

   $msg = "
             <div class='alert alert-success'>
       <button class='close' data-dismiss='alert'>&times;</button>
       <strong>Welcome to Hotel Radius!</strong>  Your Account is Now Activated : <a href='login.php'>Login here</a>
          </div>
          ";
  }
  else
  {
   $msg = "
             <div class='alert alert-danger'>
       <button class='close' data-dismiss='alert'>&times;</button>
       <strong>Sorry !</strong>  Your Account is already Activated : <a href='login.php'>Login here</a>
          </div>
          ";
  }
 }
 else
 {
  $msg = "
         <div class='alert alert-danger'>
      <button class='close' data-dismiss='alert'>&times;</button>
      <strong>Sorry !</strong>  No Account Found : <a href='signup.php'>Signup here</a>
      </div>
      ";
 }
}

?>
<!DOCTYPE html>
<html>
  <head>
    <title>Confirm Registration | Hotel Radius</title>
    <!-- Bootstrap -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="vendor/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
    <link href="vendor/assets/styles.css" rel="stylesheet" media="screen">
     <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <script src="js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
  </head>
  <body id="login">
    <div class="container">
  <?php if(isset($msg)) { echo $msg; } ?>
    </div> <!-- /container -->
    <script src="vendors/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>
