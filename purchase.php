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

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Purchases | Hotel Radius</title>

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

      </nav>

          <!-- /.row -->
          <div class="row">
              <div class="col-md-8 col-md-offset-2">
                  <div class="panel panel-default" style="padding-left:10px; padding-right:10px;">
                    <!-- panel-heading -->
                    <div class="panel-heading">
                        <i class="fa fa-group fa-fw"></i> Customers
                    </div>
                      <!-- /.panel-heading -->
                      <div class="panel-body">
                        <?php
                        $name = $row['userName'];
                        $aok = 'Yes';

                        $responseCustomers = $conn->query("SELECT * FROM tbl_rooms WHERE companyName='$name' AND booked='$aok'");

                        while($rowCustomers=$responseCustomers->fetch_array()){
                          ?>
                          <span><strong>Name:</strong> <?php echo $rowCustomers['customerName']; ?></span><br>
                          <span><strong>Phone Number:</strong> <?php echo $rowCustomers['phoneNumber']; ?></span><br>
                          <span><strong>Room Type:</strong> <?php echo $rowCustomers['roomType']; ?></span><br>
                          <span><strong>Capacity:</strong> <?php echo $rowCustomers['capacity']; ?></span><br>
                          <span><strong>Price:</strong> <?php echo $rowCustomers['price']; ?></span>

                          <hr>
                          <?php } ?>
                      </div>
                      <!-- /.panel-body -->
                  </div>
                  <!-- /.panel -->
              </div>

          </div>
          <!-- /.row -->

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
