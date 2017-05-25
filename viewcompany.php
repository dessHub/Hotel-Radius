<?php
session_start();
require_once 'class.user.php';
$user_login = new USER();

$conn = mysqli_connect("localhost", "root", "12345678", "hotel");


//get the viewcompany.php page while passing a session with the company id
if(isset($_GET['book'])){
  $booked = 'Yes';
  $SQL = $conn->prepare("UPDATE tbl_rooms SET booked=? WHERE id=?");
  $SQL->bind_param("si",$booked, $_GET['book']);
  $SQL->execute();
}

if(isset($_SESSION['companySession'])){
  $companyId = $_SESSION['companySession'];
}

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Hotel Radius</title>

    <!-- Bootstrap Core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>

    <!-- Plugin CSS -->
    <link href="vendor/magnific-popup/magnific-popup.css" rel="stylesheet">

    <!-- Theme CSS -->
    <link href="vendor/creative/css/creative.min.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body id="page-top">

    <nav id="mainNav" class="navbar navbar-default navbar-fixed-top">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span> Menu <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand page-scroll" href="index.php">Hotel Radius</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">

                    <li>
                      <?php if($user_login->is_logged_in()!="")
                              {

                                $stmt = $user_login->runQuery("SELECT * FROM tbl_users WHERE userID=:uid");
                                $stmt->execute(array(":uid"=>$_SESSION['userSession']));
                                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                      ?>
                      <a class="page-scroll" href="login.php"><?php echo $row['userName']?></a>
                      <?php
                            } else {
                       ?>
                       <a class="page-scroll" href="login.php">Log in</a>
                       <?php
                            }
                        ?>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>
    <?php
    $responseCompanies = $conn->query("SELECT * FROM tbl_users WHERE userId='$companyId'");
    $rowCompanies=$responseCompanies->fetch_array();
      ?>
    <aside class="bg-dark">
        <div class="container text-center">
            <div class="call-to-action">
                <h2>Hello! Welcome to <?php echo $rowCompanies['userName']; ?>.</h2>
                <hr class="star-primary">
            </div>
        </div>
    </aside>
    <section style="padding:5px">
            <div class="container">
                <div class="row">
                                         <div class="col-lg-8 col-lg-offset-2"><br>
                                                 <?php
                                                 $name = $rowCompanies['userName'];
                                                 $response = $conn->query("SELECT * FROM tbl_prof WHERE userName='$name'");
                                                 $prow=$response->fetch_array();
                                                 $_SESSION['picName'] = $prow['userName'];
                                                 if (!$prow['image']){
                                                   ?>
                                                   <img src="upload/noimage-team.png" class="img-responsive img-centered img-thumbnail" style="width:100%;" alt="">
                                                   <?php
                                                 } else{
                                                   ?>
                                                   <img src="upload/<?php echo $prow['image']; ?>" class="img-responsive img-centered img-thumbnail" style="width:100%;" alt="">
                                                  <?php
                                                 }
                                                  ?>
                                                  <div class="row"><br><br>
                                                    <div class="col-md-4">
                                                      <center><h4>About us</h4></center>
                                                      <hr>
                                                      <?php echo $rowCompanies['about']; ?>
                                                    </div>
                                                    <div class="col-md-4">
                                                      <center><h4>Location</h4></center>
                                                      <hr>
                                                      <?php
                                                      $responseBranches = $conn->query("SELECT * FROM tbl_base WHERE companyName='$name'");
                                                      while($rowBranches=$responseBranches->fetch_array()){
                                                        ?>
                                                        <li>
                                                        <?php echo $rowBranches['companyBranch']; ?>
                                                         </li>
                                                        <?php
                                                      }?>
                                                    </div>
                                                    <div class="col-md-4">
                                                      <center><h4>Rooms</h4></center>
                                                      <hr>
                                                      <ol>
                                                      <?php
                                                      $responseRooms = $conn->query("SELECT * FROM tbl_rooms WHERE companyName='$name'");
                                                      while($rowRooms=$responseRooms->fetch_array()){
                                                        ?>

                                                        <li><ul><li>
                                                        <span class="fa fa-home"> <?php echo $rowRooms['roomType']; ?><span>
                                                        </li>
                                                            <li>
                                                        <span class="fa fa-user"> <?php echo $rowRooms['capacity']; ?><span>
                                                        </li>
                                                            <li>
                                                        <span class="fa fa-usd "> <?php echo $rowRooms['price']; ?><span>
                                                        </li>
                                                            <?php
                                                            $option='Yes';
                                                             if ($rowRooms['booked']==$option){?>
                                                              <div class='alert alert-danger'>
                                                              <button class='close' data-dismiss='alert'>&times;</button>
                                                              <strong>Sorry!</strong> Room Booked!
                                                             </div>
                                                             <?php
                                                           } else {
                                                             ?>
                                                             <div class='alert alert-success'>
                                                             <button class='close' data-dismiss='alert'>&times;</button>
                                                             <strong>Room Available. Hurry!</strong>
                                                            </div>
                                                             <a href="?book=<?php echo $rowRooms['id']; ?>"><i class="fa fa-shopping-cart">Book Room</i></a>
                                                             <?php
                                                           }?>
                                                      </ul>
                                                      </li>

                                                        <?php
                                                      }?>
                                                      </ol>
                                                    </div>
                                                  </div>
                                         </div>
                                     </div>
                                 </div>
    </section>
    <aside class="bg-dark">
        <div class="container text-center">
            <div class="call-to-action">
                <h2>Thank you for checking us out. Contact us</h2>
                <hr class="star-primary">
                <ul class="list-inline item-details">
                  <li>Email:
                      <strong><a href="#"><?php echo $rowCompanies['userEmail']; ?></a>
                      </strong>
                  </li>
                  <li>Phone:
                      <strong><a href="#"><?php echo $rowCompanies['userPhone']; ?></a>
                      </strong>
                  </li>
              </ul>
            </div>
        </div>
    </aside>

    <!-- jQuery -->
    <script src="vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
    <script src="vendor/scrollreveal/scrollreveal.min.js"></script>
    <script src="vendor/magnific-popup/jquery.magnific-popup.min.js"></script>

    <!-- Theme JavaScript -->
    <script src="vendor/creative/js/creative.min.js"></script>

</body>

</html>
