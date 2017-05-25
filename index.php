<?php
session_start();
require_once 'class.user.php';
$user_login = new USER();


$conn = mysqli_connect("localhost", "root", "12345678", "hotel");

//get the viewcompany.php page while passing a session with the company id
if(isset($_GET['viewcompany'])){
  $_SESSION['companySession']=$_GET['viewcompany'];
  header("Location: viewcompany.php");
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
                <a class="navbar-brand page-scroll" href="#page-top">Hotel Radius</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a class="page-scroll" href="#services">Services</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#hotels">Hotels</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#contact">Contact</a>
                    </li>
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

    <header>
        <div class="header-content">
            <div class="header-content-inner">
                <h1 id="homeHeading">Hotel Booking plartform</h1>
                <hr>
                <p>View Hotels and book at affordable prices.!</p>
                <a href="#hotels" class="btn btn-primary btn-xl page-scroll">Check out Hotels</a>
            </div>
        </div>
    </header>

    <section id="services">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading">Services</h2>
                    <hr class="primary">
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <i class="fa fa-4x  fa-usd text-primary sr-icons"></i>
                        <h3>Affordable</h3>
                        <p class="text-muted">Booking hotels is affordable taking into consideration of people in all works of life. Save your money searching for hotels from agencies</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <i class="fa fa-4x fa-check text-primary sr-icons"></i>
                        <h3>Relliable</h3>
                        <p class="text-muted">We have a huge database of hotels. In this case you can compare hotels and choose the one you prefer.!</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <i class="fa fa-4x fa-life-ring text-primary sr-icons"></i>
                        <h3>Simplicity</h3>
                        <p class="text-muted">You don't need skills to use this website. It is as simple as it gets. Just a few clicks and you have reserved a room in a hotel.Its your world.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <i class="fa fa-4x fa-group text-primary sr-icons"></i>
                        <h3>Marketing</h3>
                        <p class="text-muted">We provide marketing to hotels</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="hotels" style="padding:5px">
            <div class="container-fluid">
                <div class="row no-gutter">
                  <?php
                  $responseCompanies = $conn->query("SELECT * FROM tbl_users WHERE loginType='company'");
                  while($rowCompanies=$responseCompanies->fetch_array()){
                    ?>
                    <div class="col-lg-4 col-sm-6  ">
                      <span class="popup-gallery">
                        <?php
                        $name = $rowCompanies['userName'];
                        $response = $conn->query("SELECT * FROM tbl_prof WHERE userName='$name'");
                        $prow=$response->fetch_array();
                        $_SESSION['picName'] = $prow['userName'];
                        if (!$prow['image']){
                          ?>
                          <a href="upload/noimage-team.png" class="portfolio-box">
                            <img src="upload/noimage-team.png" class="img-responsive" style="width:100%; height:300px" alt="">
                          <?php
                        } else{
                          ?>
                          <a href="upload/<?php echo $prow['image']; ?>" class="portfolio-box">
                            <img src="upload/<?php echo $prow['image']; ?>" class="img-responsive" style="width:100%; height:300px" alt="">
                          <?php
                        }
                         ?>
                             <div class="portfolio-box-caption">
                                 <div class="portfolio-box-caption-content">
                                     <div class="project-category text-faded">

                                        <?php echo $rowCompanies['userName']; ?>
                                     </div>
                                 </div>
                             </div>
                         </a>
                       </span>
                       <hr>
                         <center><a href="?viewcompany=<?php echo $rowCompanies['userID']; ?>"><span class="fa fa-folder-open-o">View <?php echo $rowCompanies['userName']; ?></span></a></center>
                         <br>
                     </div>
                    <?php
                  }
                  ?>


      </div>
    </div>
    </section>
    <aside class="bg-dark">
        <div class="container text-center">
            <div class="call-to-action">
                <h2>Register your hotel with us!</h2>
                <a href="signup.php" class="btn btn-default btn-xl sr-button">Register Now!</a>
            </div>
        </div>
    </aside>


    <section id="contact">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 text-center">
                    <h2 class="section-heading">Let's Get In Touch!</h2>
                    <hr class="primary">
                    <p>Ready to register your company with us? Give us a call or send us an email and we will get back to you as soon as possible!</p>
                </div>
                <div class="col-lg-4 col-lg-offset-2 text-center">
                    <i class="fa fa-phone fa-3x sr-contact"></i>
                    <p>+254712991415</p>
                </div>
                <div class="col-lg-4 text-center">
                    <i class="fa fa-envelope-o fa-3x sr-contact"></i>
                    <p><a href="mailto:piper@gmail.com">piper@gmail.com</a></p>
                </div>
            </div>
        </div>
    </section>


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
