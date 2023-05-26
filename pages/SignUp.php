<?php
$usernameErr = $lastNameErr = $firstNameErr = $pwdErr = $dbErr = "";
$username = $firstName  = $lastName = $pwd = "";
$type = "user";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["username"])) {
        $usernameErr = "Username is required";
    } else {
        $username = test_input($_POST["username"]);
        // check if name only contains letters and whitespace
        if (!filter_var($username, FILTER_VALIDATE_EMAIL)) {
            $usernameErr = "Invalid email format";
        }
    }

    if (empty($_POST["pwd"])) {
        $pwdErr = "Password is required";
    } else {
        $pwd = test_input($_POST["pwd"]);
    }

    if (empty($_POST["firstName"])) {
        $firstNameErr = "First Name is required";
    } else {
        $firstName = test_input($_POST["firstName"]);
    }
    if (empty($_POST["lastName"])) {
        $lastNameErr = "last Name is required";
    } else {
        $lastName = test_input($_POST["lastName"]);
    }

    if (empty($_POST["type"])) {
        $typeErr = "type is required";
    } else {
        $type = test_input($_POST["type"]);
    }
    if (empty($usernameErr) && empty($pwdErr) && empty($firstNameErr) && empty($lastNameErr)) {
        //check through database
        include_once '../DB-CONFIG.php';
        $link = mysqli_connect(DBHOST, UNAME, UPWD, DBNAME);
        if (mysqli_connect_errno()) {
            $dbErr = "Server Error! Please try again later!";
        } else {

            $query = "SELECT * FROM $type "
                . "WHERE '$username' = email ";
            $result = mysqli_query($link, $query);
            echo json_encode($result, JSON_HEX_TAG);

            if (mysqli_num_rows($result) > 0) {
                $usernameErr = "Username is used";
            } else {
                $query = "INSERT INTO $type (email, pwd,firstName, lastName)  VALUES('$username',' $pwd','$firstName','$lastName');";
                $result = mysqli_query($link, $query);
                echo json_encode($result, JSON_HEX_TAG);
                if ($result ) {
                    mysqli_close($link);
                    session_start();
                    $_SESSION['login'] = 'done';
                    $_SESSION['type'] = $type;
                    $_SESSION['email'] = $username;

                    header('location:../index.php');
                } else {
                    $dbErr = "Wrong username or passwrod!";
                    mysqli_close($link);
                }
            }
        }
    }
}

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>
<!doctype html>
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
    <link href="../assets/css/omar.css" rel="stylesheet">

</head>

<body class="text-center">

    <main class="form-signin w-100 m-auto">
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

            <h1 class="h3 mb-3 fw-normal">Register Now!</h1>

            <?php
            if (!empty($dbErr)) {
                echo "<div class = 'alert alert-danger' role = 'alert'>
                        $dbErr
                    </div>";
            }
            if (isset($_GET['error'])) {
                echo "<div class = 'alert alert-danger' role = 'alert'>" .
                    $_GET['error']
                    . "</div>";
            }
            ?>

            <div class="form-floating">
                <input type="email" class="form-control <?php if (!empty($usernameErr)) echo 'is-invalid'; ?>" id="floatingInput" placeholder="name@example.com" name="username" value="<?php echo $username; ?>">
                <label for="floatingInput">Email address</label>
                <?php
                if (!empty($usernameErr))
                    echo "<div style='text-align:left;' class='invalid-feedback'>" . $usernameErr . "</div>";
                ?>
            </div>
            <div class="form-floating">
                <input type="text" class="form-control <?php if (!empty($firstNameErr)) echo 'is-invalid'; ?>" id="floatingInput" placeholder="Roro" name="firstName" value="<?php echo $firstName; ?>">
                <label for="floatingInput">First name</label>
                <?php
                if (!empty($firstNameErr))
                    echo "<div style='text-align:left;' class='invalid-feedback'>" . $firstNameErr . "</div>";
                ?>
            </div>
            <div class="form-floating">
                <input type="text" class="form-control <?php if (!empty($lastNameErr)) echo 'is-invalid'; ?>" id="floatingInput" placeholder="Lubbad" name="lastName" value="<?php echo $lastName; ?>">
                <label for="floatingInput">Last name</label>
                <?php
                if (!empty($lastNameErr))
                    echo "<div style='text-align:left;' class='invalid-feedback'>" . $lastNameErr . "</div>";
                ?>
            </div>


            <div class="form-floating">
                <input type="password" class="form-control <?php if (!empty($pwdErr)) echo 'is-invalid'; ?>" id="floatingPassword" placeholder="Password" name="pwd">
                <label for="floatingPassword">Password</label>
                <?php
                if (!empty($pwdErr))
                    echo "<div style='text-align:left;' class='invalid-feedback'>" . $pwdErr . "</div>";
                ?>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="type" id="exampleRadios2" value="user" checked>
                <label class="form-check-label" for="exampleRadios2">
                    User
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="type" id="exampleRadios1" value="pitch">
                <label class="form-check-label" for="exampleRadios1">
                    Pitch Owner
                </label>
            </div>


            <button class="w-100 btn btn-lg btn-primary" type="submit">Sign up</button>
            <p>Alread had an account? <a href="./SignIn.php">click here</a></p>
            <a href="../index.php">Home</a>
            <p class="mt-5 mb-3 text-muted">&copy; 2022–2022</p>
        </form>
    </main>

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