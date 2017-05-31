
<?php
session_start();
require_once 'class.user.php';
$user_home = new USER();

if(!$user_home->is_logged_in())
{
 $user_home->redirect('login.php');
}

$stmt = $user_home->runQuery("SELECT * FROM tbl_users WHERE userID=:uid");
$stmt->execute(array(":uid"=>$_SESSION['userSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if(isset($_POST['btn-edit-profile']))
{
 $uname = $_POST['name'];
 $uphone = $_POST['phone'];
 $umail = $_POST['email'];
 $about = $_POST['about'];
 $website = $_POST['website'];

 $stmt = $user_home->runQuery("UPDATE tbl_users SET userName=:nam, userPhone=:phon, userEmail=:mail, about=:abt, website=:web WHERE userID=:uid");
 $stmt->execute(array(":nam"=>$uname,":phon"=>$uphone, ":mail"=>$umail, ":abt"=>$about, ":web"=>$website,":uid"=>$row['userID']));

header("refresh:0;profpic.php");
 $msg = "<div class='alert alert-success'>
 <button class='close' data-dismiss='alert'>&times;</button>
  Profile updated.
 </div>";
}

$conn = mysqli_connect("localhost", "root", "12345678", "hotel");

//get the profpic.php page
if(isset($_POST['editpic'])){
  header("Location: profpic.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Profile | Hotel Radius</title>

    <!-- Bootstrap CSS File  -->
    <link rel="stylesheet" type="text/css" href="vendor/bootstrap-3.3.5-dist/css/bootstrap.css"/>

    <!-- Custom CSS -->
    <link href="vendor/dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <!-- jQuery -->
    <script src="vendor/jquery/jquery.min.js"></script>
</head>
<body>


  <div id="wrapper">

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
              <a class="fa fa-home" href="companyhome.php">Home</a>
            </li>

            <li class="dropdown get_tooltip" data-toggle="tooltip" data-placement="bottom" title="View your profile">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    Hello <?php echo $row['userName']?>!
                    <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                </a>
                <ul class="dropdown-menu dropdown-user">
                    <li><a href="profpic.php"><i class="fa fa-user fa-fw"></i> User Profile</a>
                    </li>
                    <li><a href="purchase.php"><i class="fa fa-usd fa-fw"></i> Purchases</a>
                    </li>
                    <li class="divider"></li>
                    <li><a href="logout.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                    </li>
                </ul>
                <!-- /.dropdown-user -->
            </li>
          </ul>
          <!-- /.navbar-top-links -->
          <div class="navbar-default sidebar" role="navigation">
              <div class="sidebar-nav navbar-collapse">
                  <ul class="nav" id="side-menu">
                    <li class="sidebar-search">
                      <?php
                      $name = $row['userName'];
                      $response = $conn->query("SELECT * FROM tbl_prof WHERE userName='$name'");
                      $prow=$response->fetch_array();
                      $_SESSION['picName'] = $prow['userName'];
                      if (!$prow['image']){
                        ?>
                        <img src="upload/noimage-team.png" class="img-responsive img-circle" alt="">
                        <?php
                      } else{
                        ?>
                        <img src="upload/<?php echo $prow['image']; ?>" class="img-responsive img-circle" alt=""></br>
                        <?php
                      }
                       ?>
                        <form role="form" method="post">
                          <button class="btn btn-outline btn-primary btn-block" name="editpic">Edit Profile</button>
                      </form>
                    </li>
                  </ul>
              </div>
              <!-- /.sidebar-collapse -->
          </div>
      </nav>

      <div id="page-wrapper">
          <!-- /.row -->
          <div class="row">
              <div class="col-lg-8">
                  <div class="panel panel-default">
                      <div class="panel-heading">
                          <i class="fa fa-upload"></i>
                      </div>
                      <div class="panel-body">
                        <span id="message"></span>
                        <?php
                        $name = $_SESSION['picName'];
                        $re = $conn->query("SELECT * FROM tbl_prof WHERE userName='$name'");
                        $rows = $re->fetch_array();
                        if (!$rows){
                          ?>
                          <form id="uploadimage" action="" method="post">
                          <div id="image_preview" ><center><img id="previewing" src="//placehold.it/600x350/99223" class="img-responsive"/></center></div>
                          <hr id="line">
                          <label>Add Profile Picture</label><br/>
                          <div class="form-group">
                          <input type="text" name="userName" id="userName" placeholder="Company Name" value="<?php echo $row['userName']?>"  required />
                          </div>
                          <div class="form-group">
                          <input type="file" name="file" id="file" required />
                          </div>
                          <div class="form-group" >
                          <input type="submit" value="Upload" class="btn btn-outline btn-primary btn-block" />
                          </div>
                          </form>
                          <?php
                        }else{
                          ?>
                          <form id="editimage" action="" method="post">
                          <div id="image_preview" ><center><img id="previewing" src="//placehold.it/600x350/99223" class="img-responsive"/></center></div>
                          <hr id="line">
                          <label>Edit Profile Picture</label><br/>
                          <div class="form-group">
                          <input type="text" name="userName" id="userName" placeholder="Company Name" value="<?php echo $row['userName']?>"  required />
                          </div>
                          <div class="form-group">
                          <input type="file" name="file" id="file" required />
                          </div>
                          <div class="form-group">
                          <input type="hidden" name="id" value="<?php echo $rows['id']; ?>" required />
                          </div>
                          <div class="form-group" >
                          <input type="submit"  value="Edit" class="btn btn-outline btn-primary btn-block" />
                          </div>
                          </form>
                          <?php
                        }
                          ?>
                      </div>
                      <!-- /.panel-body -->
                  </div>

              </div>

              <!-- /.col-lg-8 -->
              <div class="col-lg-4">
                  <div class="panel panel-default">
                      <div class="panel-heading">
                          <i class="fa fa-user fa-fw"></i>Details
                      </div>
                      <!-- /.panel-heading -->
                      <div class="panel-body">
                          <div class="list-group">
                                <form class="form-signin" method="post">
                                <?php
                                if(isset($msg))
                                 {
                                  echo $msg;
                                 }
                                 ?>
                                  <div class="form-group">
                                    <label for="name">User Name</label>
                                    <input  class="form-control input-block" placeholder="" name="name" value="<?php echo $row['userName']?>" autofocus required />
                                  </div>
                                  <div class="form-group">
                                    <label for="email">Email</label>
                                <input  class="form-control input-block" placeholder="" name="email" value="<?php echo $row['userEmail']?>" type="email" required />
                                </div>
                                <div class="form-group">
                                  <label for="phone">Phone Number</label>
                                <input  class="form-control input-block" placeholder="" name="phone" value="<?php echo $row['userPhone']?>" required />
                                </div>
                                <div class="form-group">
                                  <label for="about">About</label>
                                <textarea class="form-control input-block" placeholder="About Us" name="about" value="<?php echo $row['about']?>" required ><?php echo $row['about']?></textarea>
                                </div>
                                <div class="form-group">
                                  <label for="website">Website</label>
                                <input  class="form-control input-block" placeholder="Website(optional)" name="website" value="<?php echo $row['website']?>"/>
                                </div>
                                <hr />
                                <button class="btn btn-outline  btn-primary btn-block" type="submit" name="btn-edit-profile">Edit Profile</button>
                              </form>

                          </div>
                          <!-- /.list-group -->
                      </div>
                      <!-- /.panel-body -->
                  </div>
                  <!-- /.panel -->
              </div>
              <!-- /.col-lg-6 -->
          </div>
          <!-- /.row -->
      </div>
      <!-- /#page-wrapper -->

  </div>


<!-- image JS file-->
<script src="scripts/script1.js"></script>
<script src="scripts/piceditscript.js"></script>


<!-- Bootstrap Core JavaScript -->
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>

<!-- Metis Menu Plugin JavaScript -->
<script src="vendor/metisMenu/metisMenu.min.js"></script>

<!-- Custom Theme JavaScript -->
<script src="vendor/dist/js/sb-admin-2.js"></script>

</body>
</html>
