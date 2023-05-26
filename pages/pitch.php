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
      <div class="container">

        <div class="section-header">
          <span>Your pitchs</span>
          <h2>Your pitchs</h2>

        </div>

        <div class="row justify-content-center">
          <div class="col-lg-12 my-5">
            <div class="modal modal-xl fade" id="new" tabindex="-1" aria-labelledby="new" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                  <form method="post" id="newpitch-form" class="newpitch-form" action="../controllers/newPitch.php">
                    <div class="modal-body">
                      <h1>New Pitch !</h1>
                      <hr />
                      <br />
                      <div class="row">
                        <div class="col-md-6 form-group">
                          <input type="text" name="name" class="form-control" id="name" placeholder="Pitch name" required>
                        </div>
                        <div class="col-md-12 form-group mt-3 ">
                          <input type="text" class="form-control" name="location" id="location" placeholder="Location " required>
                        </div>
                      </div>
                      <input type="text" hidden name="user" id="user" value="<?php echo $username ?>">

                      <div class="form-group mt-3">
                        <textarea class="form-control" name="descreption" rows="5" placeholder="Descreption" required></textarea>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="submit" class="btn btn-primary">Save</button>

                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <button data-bs-toggle="modal" data-bs-target="#new" class="btn btn-primary">Make new Pitch !</button>

          </div>
          <div class="col-lg-12">

            <div class="accordion accordion-flush" id="faqlist">
              <div class="row gx-5 gx-sm-3 gx-lg-5 gy-lg-5 gy-3 pb-3 projects">


                <div class="modal modal-xl fade" id="modalcontainer" tabindex="-1" aria-labelledby="modalcontainer" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title">Pitch name</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <img src="assets\img\Pitch.jpg" alt="">

                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                      </div>
                    </div>
                  </div>
                </div>



                <!-- Button trigger modal -->

                <?php
                $query = "SELECT * FROM stadium WHERE username = '$username' ";
                $result = mysqli_query($link, $query);
                if (!$result) {
                  die('not result');
                }
                $i = 0;
                while ($row = mysqli_fetch_array($result)) {

                  $photosQuery = "SELECT * FROM photos WHERE stadium_id = '$row[id]' ";
                  $Photos = mysqli_query($link, $photosQuery);

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
 <div class="modal-body">
 <div>


 <div class="accordion accordion-flush p-5" id="accordionExample">
                  












   <div class="accordion-item">
 <h2 class="accordion-header" id="heading1">
 <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1" aria-expanded="false" aria-controls="collapse1">
 General
 </button>
 </h2>
 <div id="collapse1" class="accordion-collapse collapse" aria-labelledby="heading1" data-bs-parent="#accordionExample">
 <div class="accordion-body">
 <div id="contact" class="contact">
   <div class="container" data-aos="fade-up">
                  
                  
     <div class="row gy-4 ">
                  

                  
       <div class="col-lg-12">
       <form method="post" id="Updateitch-form" class="Updateitch-form" action="../controllers/updatePitch.php">
           
           <div class="row">
               <div class="col-md-6 form-group">
                   <input type="text" name="name" class="form-control" id="name" placeholder="Pitch name" value="' . $row['name'] . '" required>
               </div>
               <div class="col-md-12 form-group mt-3 ">
                   <input type="text" class="form-control" name="location" id="location" placeholder="Location "value="' . $row['location'] . '" required>
               </div>
           </div>
           <input type="text" hidden name="user" id="user" value="' . $row['username'] . '">
           <input type="text" hidden name="ID" id="user" value="' . $row['id'] . '">

           <div class="form-group mt-3">
               <textarea class="form-control" name="descreption" rows="5" placeholder="' . $row['descreption'] . ' " value="' . $row['descreption'] . '" required></textarea>
           </div>
       </div>
       <div class="modal-footer">
           <button type="submit" class="btn btn-primary">Save</button>
                  
           <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
       </div>

   </form>
                  
       </div><!-- End Contact Form -->
                  
                  
   </div>
 </div><!-- End Contact Section -->
 </div>
 </div>
   </div>















   <div class="accordion-item">
 <h2 class="accordion-header" id="heading2">
 <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2" aria-expanded="false" aria-controls="collapse2">
 photos 
 </button>
 </h2>
 <div id="collapse2" class="accordion-collapse collapse " aria-labelledby="heading2" data-bs-parent="#accordionExample">
 <div class="accordion-body">
 <div id="contact" class="contact">
                  
 <form method="POST" action="../controllers/addPhoto.php" enctype="multipart/form-data">
 <div class="row">
 <div class="col-8">

 <div class="form-group">
     <input class="form-control" type="file" name="uploadfile" value="" />
 </div>
 </div>

 <input type="text" hidden name="user" id="user" value="' . $row['username'] . '">
 <input type="text" hidden name="ID" id="ID" value="' . $row['id'] . '">
 <div class="col-4">

 <div class="form-group">
     <button class="btn btn-primary" type="submit" name="upload">UPLOAD</button>
 </div>
 </div>

 </div>

 </form>
 <br />
 <hr />
 <table class="table table-striped ">
 <thead>
     <tr>
         <th scope="col">#</th>
         <th scope="col">Filname</th>
         <th scope="col">Link</th>
     </tr>
 </thead>
 <tbody>

 ';
                  while ($ss = mysqli_fetch_array($Photos)) {
                    echo '
                                   <tr>
                                     <th scope="row">' . $ss['id'] . '</th>
                                     <td>' . $ss['filename'] . '</td>
                                     <td><a target="_blank" href="../controllers/image/' . $ss['filename'] . '" class="sp-btn-size lsc-btn-adjust btn btn-secondary" >
                                     View</a></td>
                                     </tr> ';
                  }
                  echo '

   </tbody>
 </table>
 </div>
 </div>
 </div>
 </div>
 











 <div class="accordion-item">
 <h2 class="accordion-header" id="heading3">
 <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3" aria-expanded="false" aria-controls="collapse3">
 Renting slots
 </button>
 </h2>
 <div id="collapse3" class="accordion-collapse collapse" aria-labelledby="heading3" data-bs-parent="#accordionExample">
 <div class="accordion-body">
   <div id="contact" class="contact">
                    
   <form method="post" id="Updateitch-form" class="Updateitch-form" action="../controllers/addRentingSlot.php">
           
   <div class="row">
       <div class="col-md-4 form-group my-3">
       <label for="day">Day</label>

           <input type="date" name="date" class="form-control" id="date"   required>
       </div>
       <div class="col-md-4 form-group my-3 ">
       <label for="start">Start time</label>

           <input type="time" class="form-control" name="start" id="location" required>
       </div>
       <div class="col-md-4 form-group my-3 ">
       <label for="end">End time</label>

       <input type="time" class="form-control" name="end" id="location"  required>
   </div>
   <input type="text" hidden name="user" id="user" value="' . $row['username'] . '">
   <input type="text" hidden name="ID" id="ID" value="' . $row['id'] . '">


 </div>
 <div class="modal-footer">
   <button type="submit" class="btn btn-primary">Save</button>
          
 </div>

   </form>
   </div>
 </div>
 <hr />
 <br />
   
 <table class="table table-striped">
 <thead>
     <tr>
         <th scope="col">#</th>
         <th scope="col">Date</th>
         <th scope="col">start time</th>
         <th scope="col">end time</th>
     </tr>
 </thead>
 <tbody>
 ';

                  while ($tt = mysqli_fetch_array($RentingSlots)) {
                    echo '
   <tr>
   <td scope="row">' . $tt['id'] . '</td>
   <td>' . $tt['day'] . '</td>
   <td>' . $tt['start_time'] . '</td>
   <td>' . $tt['end_time'] . '</td>

 </tr>
   ';
                  }


                  echo '
 </tbody>
 </table>
 </div>
 </div>












 <div class="accordion-item">
 <h2 class="accordion-header" id="heading4">
 <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
 Renting status
 </button>
 </h2>
 <div id="collapse4" class="accordion-collapse collapse " aria-labelledby="heading4" data-bs-parent="#accordionExample">
 <div class="accordion-body">
   <div id="contact" class="contact">
                    
   <table class="table table-striped">
   <thead>
       <tr>
           <th scope="col">user</th>
           <th scope="col">Date and time</th>
           <th scope="col">Massage</th>
           <th scope="col">Actions</th>

       </tr>
   </thead>
   <tbody>
       ';
                  while ($tt = mysqli_fetch_array($Reservation)) {

                    $r_id = $tt['renting_slot_id'];
                    $user = $tt['user'];

                    $queryZain = "SELECT * FROM renting_slot WHERE id = '$r_id' ";
                    $slot = mysqli_query($link, $queryZain);

                    $row1=mysqli_fetch_assoc($slot);


                    $queryKarem = "SELECT * FROM user WHERE email = '$user' ";
                    $user = mysqli_query($link, $queryKarem);

                    $row2=mysqli_fetch_assoc($user);



                    echo '
                                          <tr>
                                          <td scope="row">' . $row2['firstName'] .'  ' . $row2['lastName'] .'</td>
                                          <td>' . $row1['day'] . ' - ' . $row1['start_time'] . ' - ' . $row1['end_time'] . '</td>
                                          <td>' . $tt['msg'] . '</td>
                                          <td>
                                          ';
                                            if ($tt['Statues'] == 'Pending') {
                                                echo '       
        <form method="post" action="../controllers/confirmRes.php">
        <input type="text" hidden name="ID" id="ID" value="' . $tt['id'] . '">
 
        <button type="submit" class="btn btn-success" >Confirm</button>
 
        </form>';
                                            }else{
                                              echo $tt['Statues'];
                                            }

                                            echo '
                                          </td>

                                      </tr>
                                          ';
                  }

                  echo '
   </tbody>
 </table>
   </div>
 </div>
 </div>
 </div>













 <div class="accordion-item">
 <h2 class="accordion-header" id="heading5">
 <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse5" aria-expanded="false" aria-controls="collapse5">
 Messages 
 </button>
 </h2>
 <div id="collapse5" class="accordion-collapse collapse " aria-labelledby="heading5" data-bs-parent="#accordionExample">
 <div class="accordion-body">
   <div id="contact" class="contact">
                    
   <table class="table table-striped">
   <thead>
       <tr>
           <th scope="col">User</th>
           <th scope="col">Subject</th>

           <th scope="col">Message</th>
           <th scope="col">Your reply</th>

       </tr>
   </thead>
   <tbody>
       ';
                  while ($cc = mysqli_fetch_array($contacts)) {

                    $user = $cc['user'];




                    $queryKarem = "SELECT * FROM user WHERE email = '$user' ";
                    $user = mysqli_query($link, $queryKarem);

                    $row2=mysqli_fetch_assoc($user);



                    echo '
                                          <tr>
                                          <td scope="row">' . $row2['firstName'] .'  ' . $row2['lastName'] .'</td>
                                          <td>' . $cc['subject'] . '</td>
                                          <td>' . $cc['msg'] . '</td>
                                          <td>
                                          ';
                                            if ($cc['reply'] == null) {
                                                echo '       
        <form method="post" action="../controllers/reply.php">
        <input type="text" hidden name="ID" id="ID" value="' . $cc['id'] . '">
 
        <div class="form-group mt-3">
        <textarea class="form-control" name="reply" rows="3" placeholder="Your reply" required></textarea>
      </div>

        <button type="submit" class="btn btn-sm btn-success" >Reply</button>
 
        </form>';
                                            }else{
                                              echo $cc['reply'];
                                            }

                                            echo '
                                          </td>
                                      </tr>
                                          ';
                  }

                  echo '
   </tbody>
 </table>

   </div>
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