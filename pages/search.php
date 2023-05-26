<?php
session_start();

$isSignedIn = false;
$type = '';
$name = '';
$username = '';
$search = $_POST['search'];

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

  if ($username) {

    $query = "SELECT *  FROM $type WHERE email = '$username' ";

    $result = mysqli_query($link, $query);
    if (mysqli_num_rows($result) > 0) {
      $row = mysqli_fetch_array($result);

      $name = $row['firstName'] . ' ' . $row['lastName'];
    } else {
    }
  }
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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>
</head>

<body>
  <!-- ======= Header ======= -->
  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl d-flex align-items-center justify-content-between">

      <a href=" ../index.php" class="logo d-flex align-items-center">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <!-- <img src="assets/img/logo.png" alt=""> -->
        <h1>Goali</h1>
      </a>
      <i class="mobile-nav-toggle mobile-nav-show bi bi-list"></i>
      <i class="mobile-nav-toggle mobile-nav-hide d-none bi bi-x"></i>
      <nav id="navbar" class="navbar">
        <ul>
          <li><a href="../index.php" class="active">Home</a></li>
          <li><a href="Pitches.php" class="active">Pitches</a></li>

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

  <!-- ======= Hero Section ======= -->
  <section id="hero" class="hero d-flex align-items-center">
    <div class="container">
      <div class="row gy-4 d-flex justify-content-between">
        <div class="col-lg-6 order-2 order-lg-1 d-flex flex-column justify-content-center">
          <h2 data-aos="fade-up">Group up and play together</h2>
          <p data-aos="fade-up" data-aos-delay="100">Through GOALI you can reserve a football pitch whenever and wherever you desire. As you don't have to pay any deposit or make any phone calls with the pitch's owner</p>


          <div class="row gy-4" data-aos="fade-up" data-aos-delay="400">

            <div class="col-lg-3 col-6">
              <div class="stats-item text-center w-100 h-100">
                <span data-purecounter-start="0" data-purecounter-end="232" data-purecounter-duration="1" class="purecounter"></span>
                <p>Pitch</p>
              </div>
            </div><!-- End Stats Item -->

            <div class="col-lg-3 col-6">
              <div class="stats-item text-center w-100 h-100">
                <span data-purecounter-start="0" data-purecounter-end="12721" data-purecounter-duration="1" class="purecounter"></span>
                <p>Users</p>
              </div>
            </div><!-- End Stats Item -->

            <div class="col-lg-3 col-12">
              <div class="stats-item text-center w-100 h-100">
                <span data-purecounter-start="0" data-purecounter-end="21941" data-purecounter-duration="1" class="purecounter"></span>
                <p>Reservations</p>
              </div>
            </div><!-- End Stats Item -->

          </div>
        </div>

        <div class="col-lg-5 order-1 order-lg-2 hero-img" data-aos="zoom-out">
          <img src="../assets/img/Soccer-rafiki.png" class="img-fluid mb-3 mb-lg-0" alt="">
        </div>

      </div>
    </div>
  </section><!-- End Hero Section -->

  <main id="main">

    <div>
      <div class="container">

        <div class="section-header">
          <span>Reserve your pitch</span>
          <h2>Reserve your pitch</h2>

        </div>
        <form method="post" id="" action="search.php">
          <div class="row">
          <label for="floatingInput">Search</label>

            <div class="col-9">

              <input type="text" class="form-control " placeholder="Search by name or location" name="search">
            </div>
            <div class="col-3">
              <button class="btn btn-primary" type="submit">Search</button>
            </div>
          </div>

        </form>
        <hr />

        <div class="row justify-content-center">
          <div class="col-lg-12">

            <div class="accordion accordion-flush" id="faqlist">
              <div class="row gx-5 gx-sm-3 gx-lg-5 gy-lg-5 gy-3 pb-3 projects">


                <?php
                $query = "SELECT * FROM stadium where name like '%" . $search . "%' or location like '%" . $search . "%'";
                $result = mysqli_query($link, $query);
                if (!$result) {
                  die('not result');
                }
                $i = 0;
                while ($row = mysqli_fetch_array($result)) {

                  $photosQuery = "SELECT * FROM photos WHERE stadium_id = '$row[id]' ";
                  $photos = mysqli_query($link, $photosQuery);

                  $RentingSlotsQuery = "SELECT * FROM renting_slot WHERE stadium_id = '$row[id]' ";
                  $RentingSlots = mysqli_query($link, $RentingSlotsQuery);

                  $ReservationQuery = "SELECT * FROM reservation WHERE stadium_id = '$row[id] ' ";
                  $Reservation = mysqli_query($link, $ReservationQuery);

                  $contactsQuery = "SELECT * FROM contacts WHERE stadium_id = '$row[id]' ";
                  $contacts = mysqli_query($link, $contactsQuery);

                  echo '        
    <div class="modal modal-xl fade" id="pitch' . $row['id'] . '" tabindex="-1" aria-labelledby="pitch' . $row['id'] . '" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
 <div class="modal-header">
     <h5 class="modal-title">' . $row['name'] . '</h5>
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
 <p> ' . $row['descreption'] . ' </p>
 <br>
 <hr>








 <div class="accordion-item">
      <h2 class="accordion-header" id="headingTwo">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
   Contact us
        </button>
      </h2>
      <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
        <div class="accordion-body">
   <div id="contact" class="contact">
  <div class="container" data-aos="fade-up">


    <div class="row gy-4 mt-4">


    <div class="col-lg-12">

';
                  if (!$isSignedIn) {
                    echo ' <p>please log in first</p>
  ';
                  } else {
                    echo '
  
  <form action="../controllers/addContact.php"  method="post" role="form" >
  <div class="row">


  </div>
  <div class="form-group mt-3">
    <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject" required>
  </div>
  <div class="form-group mt-3">
    <textarea class="form-control" name="message" rows="5" placeholder="Message" required></textarea>
  </div>
  <input type="text" hidden name="user" id="user" value="' . $username . '">
  <input type="text" hidden name="ID" id="ID" value="' . $row['id'] . '">

  <div class="text-center"><button class="btn btn-primary" type="submit">Send Message</button></div>
  </form>
  ';
                  }



                  echo '
      </div><!-- End Contact Form -->

    </div>

  </div>
   </div><!-- End Contact Section -->
        </div>
      </div>
    </div>










    <div class="accordion-item">
      <h2 class="accordion-header" id="headingThree">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
   Reserve now
        </button>
      </h2>
      <div id="collapseThree" class="accordion-collapse collapse " aria-labelledby="headingThree" data-bs-parent="#accordionExample">
        <div class="accordion-body">
   <div id="contact" class="contact">

  <form action="../controllers/addReservetion.php" method="post" role="form" >

  <input type="text" hidden name="user" id="user" value="' . $username . '">
  <input type="text" hidden name="ID" id="ID" value="' . $row['id'] . '">

    <p>Please choose time and date:</p>


    <div class="modalButtons">
    ';
                  while ($t2 = mysqli_fetch_array($RentingSlots)) {

                    echo '
                    <input type="radio" class="btn-check" name="choosen" id="option' . $t2['id'] . '" autocomplete="off" value="' . $t2['id'] . '">
                    <label class="btn btn-outline-success" for="option' . $t2['id'] . '">
                    <p class="p-0 m-0" >' . $t2['start_time'] . ' - ' . $t2['end_time'] . '</p>
                    <p class="p-0 m-0" >' . $t2['day'] . '</p></label>
   ';
                  }


                  echo '


    </div>
    <div class="form-group mt-3">
    <textarea class="form-control" name="message" rows="3" placeholder="Message" required></textarea>
  </div>
    <div class="text-center"><button class="btn btn-primary" type="submit" style="margin-top: 10px;">Submit</button></div>
  </form>
   </div>
        </div>
      </div>
    </div>






  </div>
       </div>
 <div class="modal-footer">
     <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
 </div>
      </div>
  </div>
        </div>';
                  echo '<div class="col-xl-3 col-md-4 col-sm-6 project ui branding">
  <div data-bs-toggle="modal" data-bs-target="#pitch' . $row['id'] . '" class="service-work card border-0 text-white shadow-sm overflow-hidden mx-5 m-sm-0">
      <div class="service">
 <img class="card-img " src="../assets/img/new-header.jpg" alt="Card image cap">
      </div>
      <div class="service-work-vertical card-img-overlay d-flex align-items-end">
 <div class="service-work-content text-left text-light">
     <span class="btn btn-outline-light rounded-pill mb-lg-3 px-lg-4 light-300">' . $row['name'] . ' </span>
 </div>
      </div>
  </div>
        </div>';
                }
                ?>



                <!-- Button trigger modal -->


              </div>
            </div>
          </div>
        </div>
      </div>
    </div><!-- End Frequently Asked Questions Section -->




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

        <div class="col-lg-4 col-8 footer-links">

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