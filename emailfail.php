<?php
session_start();
require_once 'class.user.php';
$user = new USER();

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

if(isset($_POST['btn-submit']))
{
 $email = $_POST['txtemail'];

 $stmt = $user->runQuery("SELECT userID FROM tbl_users WHERE userEmail=:email LIMIT 1");
 $stmt->execute(array(":email"=>$email));
 $row = $stmt->fetch(PDO::FETCH_ASSOC);
 if($stmt->rowCount() == 1)
 {
  $id = base64_encode($row['userID']);
  $code = md5(uniqid(rand()));

  $stmt = $user->runQuery("UPDATE tbl_users SET tokenCode=:token WHERE userEmail=:email");
  $stmt->execute(array(":token"=>$code,"email"=>$email));

  require 'PHPMailer/PHPMailerAutoload.php';
  $mail = new PHPMailer;
  $mail->isSMTP();
  $mail->SMTPSecure = 'tls';
  $mail->SMTPAuth = true;
  $mail->Host = 'smtp.gmail.com';
  $mail->Port = 587;
  $mail->Username = 'yourgmailmail@gmail.com';
  $mail->Password = 'gmailpassword';
  $mail->setFrom('DoNotReply@gmail.com', 'Hotel Radius');
  $mail->addAddress($email);
  $mail->Subject = 'Hotel Radius Account confirmation';
  $mail->Body = "Hello $email,
  We got a request to resend you an confirmation email.
  Click Following Link To activate Your account if you sent the request.
  http://localhost:8080/HotelRadius/resendemail.php?id=$id&code=$code

  Thanks,";
  //send the message, check for errors
  if (!$mail->send()) {
    $msg = "
      <div class='alert alert-danger'>
       <button class='close' data-dismiss='alert'>&times;</button>
       <strong>Error!</strong>  Could'nt send email to $email.
                     Please try again.
        </div>
      ";
  } else {
    $msg = "<div class='alert alert-success'>
         <button class='close' data-dismiss='alert'>&times;</button>
         We've sent an email to $email.
                        Please click on the link in the email to activate your account.
          </div>";
  }
 }
 else
 {
  $msg = "<div class='alert alert-danger'>
     <button class='close' data-dismiss='alert'>&times;</button>
     <strong>Sorry!</strong>  this email not found.
       </div>";
 }
}
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Email Failed | Hotel Radius</title>
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
    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php">Hotel Radius</a>
        </div>
        <!-- /.navbar-header -->

        <ul class="nav navbar-top-links navbar-right">
          <li>
            <a  href="login.php">Login</a>
          </li>
          <li>
            <a  href="signup.php">Signup</a>
          </li>
        </ul>
        <!-- /.navbar-top-links -->
        <!-- /.navbar-static-side -->
    </nav>
    <div class="container">

      <form class="form-signin" method="post">
        <h2 class="form-signin-heading">Resend Email</h2><hr />

         <?php
   if(isset($msg))
   {
    echo $msg;
   }
   else
   {
    ?>
    <div class='alert alert-info'>
    Please enter your email address. You will receive a link to activate your account via email!
    </div>
                <?php
   }
   ?>

        <input type="email" class="input-block-level" placeholder="Email address" name="txtemail" required />
      <hr />
        <button class="btn btn-danger btn-primary" type="submit" name="btn-submit">Send email</button>
      </form>

    </div> <!-- /container -->
    <script src="vendor/bootstrap/js/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>
