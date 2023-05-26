<?php
session_start();

$isSignedIn = false;
$type = '';
$name = '';
if (isset($_SESSION['login']) == 'done') {
    $username = $_SESSION['email'];
    $type = $_SESSION['type'];

    $isSignedIn = true;
}
include_once '../DB-CONFIG.php';

$link = mysqli_connect(DBHOST, UNAME, UPWD, DBNAME);
if (mysqli_connect_errno()) {
    $dbErr = "Server Error! Please try again later!";
} else {


    $query = "SELECT *  FROM $type WHERE email = '$username' ";

    $result = mysqli_query($link, $query);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);

        $name = $row['firstName'] . ' ' . $row['lastName'];
    } else {
    }


    $reservationQuery = "SELECT * FROM reservation WHERE user = '$username' ";
    $reservation = mysqli_query($link, $reservationQuery);

    $contactsQuery = "SELECT * FROM contacts WHERE user = '$username' ";
    $contacts = mysqli_query($link, $contactsQuery);
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Goali</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="../assets/img/favicon.png" rel="icon">
    <link href="../assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,600;1,700&family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Inter:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="../assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="../assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="../assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
    <link href="../assets/vendor/aos/aos.css" rel="stylesheet">
    <!-- Template Main CSS File -->


    <link href="../assets/css/main.css" rel="stylesheet">
    <link href="../assets/css/roro.css" rel="stylesheet">

    <!-- =======================================================
  * Template Name: Logis - v1.2.1
  * Template URL: https://bootstrapmade.com/logis-bootstrap-logistics-website-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>
    <!-- ======= Header ======= -->
    <header id="header" class="header d-flex align-items-center fixed-top header-cstm">
        <div class="container-fluid container-xl d-flex align-items-center justify-content-between">

            <a href=" ../index.php" class="logo d-flex align-items-center">
                <!-- Uncomment the line below if you also wish to use an image logo -->
                <!-- <img src="../assets/img/logo.png" alt=""> -->
                <h1>Goali</h1>
            </a>
            <i class="mobile-nav-toggle mobile-nav-show bi bi-list"></i>
            <i class="mobile-nav-toggle mobile-nav-hide d-none bi bi-x"></i>
            <nav id="navbar" class="navbar">
                <ul>
                    <li><a href=" ../index.php" class="active">Home</a></li>
                    <li><a href="./pitches.php" class="active">Pitches</a></li>

                    <?php
                    if (!$isSignedIn) {
                        echo ' <li><a class="get-a-quote" href="./SignUp.php">Register</a></li>          <li><a class="cta-btn" href="./pages/SignIn.php">Login</a></li>
            ';
        } else {
            echo '
            <form method="post" action="../controllers/signOut.php">
 
        <button type="submit" class="active bg-transparent border-0 ms-2" >Sign out</button>
 
        </form>
';
            if ($type == 'user') {
                            echo ' <li><a class="get-a-quote" href="./user.php">Profile</a></li>';
                        }
                        if ($type == 'pitch') {
                            echo ' <li><a class="get-a-quote" href="./pitch.php">Profile</a></li>';
                        }
                    }
                    ?>
                </ul>
            </nav><!-- .navbar -->

        </div>
    </header><!-- End Header -->
    <!-- End Header -->



    <main id="main">

        <div class="container my-5">
            <div class="row">
                <div class="col-sm-3 ">
                    <div class="card shadow-lg">
                        <div class="card-header text-center">
                            <h3><?php echo  $name ?> </h3>
                        </div>
                        <hr class="hr-horizontal">
                        <div class="card-body ">
                            <ul class="nav nav-pills flex-sm-column mb-sm-5" data-toggle="slider-tab" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#pills-home1" type="button" role="tab" aria-controls="home" aria-selected="true">Reservations</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#pills-profile1" type="button" role="tab" aria-controls="profile" aria-selected="false">Contacts</button>
                                </li>

                            </ul>
                        </div>

                    </div>
                </div>
                <div class="col-sm-9 ">
                    <div class="">

                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-home1" role="tabpanel" aria-labelledby="pills-home-tab1">
                                <div class="card shadow-lg">
                                    <div class="card-header text-center">
                                        <h3>Reservations </h3>
                                    </div>
                                    <div class="card-body">
                                        <?php

                                        
                                        while ($res = mysqli_fetch_array($reservation)) {


                                            $stadium_id = $res['stadium_id'];

                                            $photosQuery = "SELECT * FROM photos WHERE stadium_id = '$stadium_id' ";
                                            $photos = mysqli_query($link, $photosQuery);


                                            $queryKarem = "SELECT * FROM stadium WHERE id = '$stadium_id' ";
                                            $stadium = mysqli_query($link, $queryKarem);

                                            $row1 = mysqli_fetch_assoc($stadium);



                                            $r_id = $res['renting_slot_id'];

                                            $queryZain = "SELECT * FROM renting_slot WHERE id = '$r_id' ";
                                            $slot = mysqli_query($link, $queryZain);

                                            $row2 = mysqli_fetch_assoc($slot);


                                            echo '
<div class="show2 row rounded bg-white mt-4">

<div class="col-md-5 px-0">
<img src="../assets/img/new-header.jpg" class="img-fluid w-100">
</div>
<div class="col-md-7">
<div class="card-block p-3">
    <h4 class="card-title mt-0"><strong>' . $row1['name'] . '</strong></h4>
    <p class="text-secondary">
        <strong>' . $row1['location'] . '</strong>
    </p>
    <ul class="list-inline mt-auto">
        <li class="list-inline-item">' . $row2['day'] . '<span>|</span></li>
        <li class="list-inline-item">' . $row2['start_time'] . ' - ' . $row2['end_time'] . '</li>
    </ul>
    <ul class="list-inline mt-auto">
        <li class="list-inline-item">
            <p>Statues: <span > ' . $res['Statues'] . '</span> </p>
        </li>
        <li>
        
        </li>
        <li class="list-inline-item"><button id="previewFormattedSchedules" class="sp-btn-size lsc-btn-adjust btn btn-secondary" data-bs-toggle="modal" data-bs-target="#pitch' . $res['id'] . '">details</button>
        <div class="modal modal-xl fade" id="pitch' . $res['id'] . '" tabindex="-1" aria-labelledby="pitch' . $res['id'] . '" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
       <div class="modal-header">
           <h5 class="modal-title">' . $row1['name'] . '</h5>
           <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
       </div>
       <!--- comment---> <img src="assets\img\Pitch.jpg" alt="">
       <div class="modal-body">
       <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
      
       <div class="carousel-inner">';
                                            while ($tt = mysqli_fetch_array($photos)) {
                                                echo '
         <div class="carousel-item active">
           <img src="../controllers/image/' . $tt['filename'] . '" class="d-block w-100" alt="...">
         </div>
         ';
                                            }


                                            echo '
       </div>
       <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
         <span class="carousel-control-prev-icon" aria-hidden="true"></span>
         <span class="visually-hidden">Previous</span>
       </button>
       <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
         <span class="carousel-control-next-icon" aria-hidden="true"></span>
         <span class="visually-hidden">Next</span>
       </button>
       </div>
       <br>
       <hr>
       <div>
       <p> ' . $row1['descreption'] . ' </p>
       <br>
       <hr>
      
      
      
      
        </div>
             </div>
       <div class="modal-footer">';
                                            if ($res['Statues'] != 'canceled') {
                                                echo '       
        <form method="post" action="../controllers/canselRes.php">
        <input type="text" hidden name="ID" id="ID" value="' . $res['id'] . '">
 
        <button type="submit" class="btn btn-danger" >Cansel reservation</button>
 
        </form>';
                                            }

                                            echo '
           <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
       </div>
            </div>
        </div>            </div>
        </div>        </div>

              </div>';
                                        }
                                        ?>

                                    </div>
                                </div>

                            </div>
                            <div class="tab-pane fade" id="pills-profile1" role="tabpane2" aria-labelledby="pills-profile-tab2">
                                <div class="card shadow-lg">
                                    <div class="card-header text-center">
                                        <h3>Contacts </h3>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Stadium</th>
                                                    <th scope="col">subject</th>
                                                    <th scope="col">Massage</th>
                                                    <th scope="col">Response</th>

                                                </tr>
                                            </thead>
                                            <?php
                                            echo '<tbody>
       ';
                  while ($cc = mysqli_fetch_array($contacts)) {

                    $stadium = $cc['stadium_id'];




                    $queryKarem = "SELECT * FROM stadium WHERE id = '$stadium' ";
                    $stadium = mysqli_query($link, $queryKarem);

                    $row2=mysqli_fetch_assoc($stadium);



                    echo '
                                          <tr>
                                          <td>' . $cc['id'] . '</td>

                                          <td scope="row">' . $row2['name'] .'</td>
                                          <td>' . $cc['subject'] . '</td>
                                          <td>' . $cc['msg'] . '</td>
                                          <td>' . $cc['reply'] . '</td>

                                      </tr>
                                          ';
                  }

                  echo '
   </tbody>' ?>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </main><!-- End #main -->

    <!-- ======= Footer ======= -->
    <footer id="footer" class="footer">

        <div class="container">
            <div class="row gy-4">
                <div class="col-lg-5 col-md-12 footer-info">
                    <a href=" ../index.php" class="logo d-flex align-items-center">
                        <span>GOALI</span>
                    </a>
                    <p>Through GOALI you can reserve a football pitch whenever and wherever you desire. As you don't have to pay any deposit or make any phone calls with the pitch's owner</p>
                    <div class="social-links d-flex mt-4">
                        <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
                        <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
                    </div>
                </div>

                <div class="col-lg-2 col-6 footer-links">
                    <h4>Useful Links</h4>
                    <ul>
                        <li><a href="#">Home</a></li>
                        <li><a href="#">Services</a></li>
                        <li><a href="#">Terms of service</a></li>
                        <li><a href="#">Privacy policy</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-12 footer-contact text-center text-md-start">
                    <h4>Contact Us</h4>
                    <p>
                        King Khalid Road <br>
                        Riyadh, 39485<br>
                        SAUDI ARABIA <br><br>
                        <strong>Phone:</strong> +966 55 188 1231<br>
                        <strong>Email:</strong> info@example.com<br>
                    </p>

                </div>

            </div>
        </div>

        <div class="container mt-4">
            <div class="copyright">
                &copy; Copyright <strong><span>GOALI</span></strong>. All Rights Reserved
            </div>
        </div>

    </footer><!-- End Footer -->
    <!-- End Footer -->

    <a href="#" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <div id="preloader"></div>

    <!-- Vendor JS Files -->
    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/vendor/purecounter/purecounter_vanilla.js"></script>
    <script src="../assets/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="../assets/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="../assets/vendor/aos/aos.js"></script>
    <script src="../assets/vendor/php-email-form/validate.js"></script>

    <!-- Template Main JS File -->
    <script src="../assets/js/main.js"></script>

</body>

</html>