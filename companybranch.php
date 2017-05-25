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

$conn = mysqli_connect("localhost", "root", "12345678", "hotel");

/* code for data insert */
if(isset($_POST['save']))
{
     // get values
   	$compname =  $_POST['companyName'];
   	$compbranch = $_POST['companyBranch'];
   	$means = $_POST['category'];

  $SQL = $conn->prepare("INSERT INTO tbl_base(companyName, companyBranch, category) VALUES(?,?,?)");
  $SQL->bind_param('sss',$compname, $compbranch, $means);
  $SQL->execute();

  if(!$SQL)
  {
   echo $MySQLiconn->error;
  }
}
/* code for data insert */


/* code for data delete */
if(isset($_GET['del']))
{
 $SQL = $conn->prepare("DELETE FROM tbl_base WHERE id=".$_GET['del']);
 $SQL->bind_param("i",$_GET['del']);
 $SQL->execute();
 header("Location: companybranch.php");
}
/* code for data delete */



/* code for data update */
if(isset($_GET['edit']))
{
 $SQL = $conn->query("SELECT * FROM tbl_base WHERE id=".$_GET['edit']);
 $Row = $SQL->fetch_array();
}

if(isset($_POST['update']))
{
 $SQL = $conn->prepare("UPDATE tbl_base SET companyName=?, companyBranch=?, category=? WHERE id=?");
 $SQL->bind_param("sssi",$_POST['companyName'], $_POST['companyBranch'], $_POST['category'], $_GET['edit']);
 $SQL->execute();
 header("Location: companybranch.php");
}
/* code for data update */

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

    <title>Branch | Hotel Radius</title>

    <!-- Bootstrap CSS File  -->
    <link rel="stylesheet" type="text/css" href="vendor/bootstrap-3.3.5-dist/css/bootstrap.css"/>

    <!-- MetisMenu CSS -->
    <link href="vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="vendor/dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <script src="vendor/jquery/jquery.min.js"></script>
<!--<script src="http://code.jquery.com/jquery-1.9.1.js"></script>-->
<!-- Load jQuery UI Main JS  -->
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>

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

                    <li class="divider"></li>
                    <li><a href="companybranch.php"><i class="fa fa-sitemap fa-fw"></i>My Branch</a></li>
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

                      <!-- /.panel-heading -->
                      <div class="panel-body">

                        <div class="row">
                            <div class="col-md-12">
                             <form method="post">
                              <div class="form-group">
                                  <label for="companyName">Company Name</label>
                                  <input type="text" name="companyName" placeholder="" class="form-control" value="<?php echo $row['userName']?>" autofocus required/>
                              </div>

                                <div class="form-group">
                                    <label for="companyBranch">Branch</label>
                                    <input type="text" name="companyBranch" placeholder="eg. Places you have branches." value="<?php  if(isset($_GET['edit'])) echo $Row['companyBranch'];  ?>" class="form-control"/>
                                </div>

                                <div class="form-group">
                                    <label for="category">Category</label>
                                    <input type="text" name="category" placeholder="" value="<?php  if(isset($_GET['edit'])){ echo $Row['category']; } else { echo $row['category']; } ?>" class="form-control"/>
                                </div>
                                <?php
                                if(isset($_GET['edit']))
                                {
                                 ?>
                                 <button type="submit" class="btn btn-primary" name="update">Update Record</button>
                                 <?php
                                }
                                else
                                {
                                 ?>
                                 <button type="submit" class="btn btn-primary" name="save">Add Record</button>
                                 <?php
                                }
                                ?>
                              </form>
                              </div>

                            </div>

                        <br /><br />

                        <table class="table table-bordered table-hover" width="100%" align="center">
                          <tr class="info">
                            <!--<th>No.</th>-->
                            <th>Company</th>
                            <th>Branch</th>
                            <th>Means</th>
                            <th>Action</th>
                          </tr>
                          <?php
                          $name = $row['userName'];
                          $res = $conn->query("SELECT * FROM tbl_base WHERE companyName='$name'");
                          while($Row=$res->fetch_array())
                          {
                           ?>
                          <tr>
                            <td><?php echo $Row['companyName']; ?></td>
                            <td><?php echo $Row['companyBranch']; ?></td>
                            <td><?php echo $Row['category']; ?></td>
                            <td>
                              <a href="?edit=<?php echo $Row['id']; ?>">Edit</a>
                              <a href="?del=<?php echo $Row['id']; ?>">Delete</a>
                            </td>
                          </tr>
                          <?php
                          }
                          ?>
                        </table>

                      </div>
                      <!-- /.panel-body -->
                  </div>
                  <!-- /.panel -->
              </div>

              <!-- /.col-lg-8 -->
              <div class="col-lg-4">
                  <div class="panel panel-default">
                      <div class="panel-heading">
                          <i class="fa fa-location-arrow fa-fw"></i>
                      </div>
                      <!-- /.panel-heading -->
                      <div class="panel-body">
                          <div class="list-group">

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


<!-- // Modal -->

<!-- Bootstrap Core JavaScript -->
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>

<!-- Metis Menu Plugin JavaScript -->
<script src="vendor/metisMenu/metisMenu.min.js"></script>

<!-- Custom Theme JavaScript -->
<script src="vendor/dist/js/sb-admin-2.js"></script>

</body>
</html>
