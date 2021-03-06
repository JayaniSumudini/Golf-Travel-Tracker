<?php

session_start();
require "../function/function.php";
$conn = connection();
if (isset($_SESSION['user']) && isset($_SESSION['user_role'])) {
    header("location: ../partyCreate/");
}

$errorRequired = "";
$errorUserError = "";

if ($_POST) {
    $user_email = mysqli_real_escape_string($conn, $_POST['user_email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);


    if (empty($user_email) || empty($password)) {
        $errorRequired = "Fill the required fields";
    } else {
        $query = "SELECT * FROM user_details WHERE user_email='$user_email'";
        $result = mysqli_query($conn, $query);
        $row[] = mysqli_fetch_assoc($result);

        if ($row[0]["password"] == $password) {
            $_SESSION['user'] = $row[0]['user_id'];
            $_SESSION['user_role'] = $row[0]['user_role'];
        } else {
            $errorUserError = "User email or password is incorrect!";
        }

        mysqli_free_result($result);
        mysqli_close($conn);

        if (isset($_SESSION['user']) != "") {
            header("location: ../partyCreate/");
        }
    }

}
?>


<!DOCTYPE HTML>
<!--
	Aesthetic by gettemplates.co
	Twitter: http://twitter.com/gettemplateco
	URL: http://gettemplates.co
-->
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Traveler &mdash; Free Website Template, Free HTML5 Template by GetTemplates.co</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Free HTML5 Website Template by GetTemplates.co"/>
    <meta name="keywords"
          content="free website templates, free html5, free template, free bootstrap, free website template, html5, css3, mobile first, responsive"/>
    <meta name="author" content="GetTemplates.co"/>

    <!-- Facebook and Twitter integration -->
    <meta property="og:title" content=""/>
    <meta property="og:image" content=""/>
    <meta property="og:url" content=""/>
    <meta property="og:site_name" content=""/>
    <meta property="og:description" content=""/>
    <meta name="twitter:title" content=""/>
    <meta name="twitter:image" content=""/>
    <meta name="twitter:url" content=""/>
    <meta name="twitter:card" content=""/>

    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700" rel="stylesheet">

    <!-- Animate.css -->
    <link rel="stylesheet" href="../css/animate.css">
    <!-- Icomoon Icon Fonts-->
    <link rel="stylesheet" href="../css/icomoon.css">
    <!-- Themify Icons-->
    <link rel="stylesheet" href="../css/themify-icons.css">
    <!-- Bootstrap  -->
    <link rel="stylesheet" href="../css/bootstrap.css">

    <!-- Magnific Popup -->
    <link rel="stylesheet" href="../css/magnific-popup.css">

    <!-- Magnific Popup -->
    <link rel="stylesheet" href="../css/bootstrap-datepicker.min.css">

    <!-- Owl Carousel  -->
    <link rel="stylesheet" href="../css/owl.carousel.min.css">
    <link rel="stylesheet" href="../css/owl.theme.default.min.css">

    <!-- Theme style  -->
    <link rel="stylesheet" href="../css/style.css">

    <!-- Modernizr JS -->
    <script src="../js/modernizr-2.6.2.min.js"></script>
    <!-- FOR IE9 below -->
    <!--[if lt IE 9]>
    <script src="../js/respond.min.js"></script>
    <![endif]-->

</head>
<body style="background-image: url(../images/background.jpg); background-size: cover">

<header id="gtco-header" class="gtco-cover gtco-cover-md" role="banner"
        style="background: transparent">
    <div class="gtco-container">
        <div class="row">
            <div class="col-md-12 col-md-offset-0 text-left">

                <ul class="nav nav-tabs">


                    <div class="row row-mt-15em">
                        <div class="col-md-7 mt-text animate-box" data-animate-effect="fadeInUp">
                            <img src="../images/logo.png">
                        </div>
                        <div class="col-md-4 col-md-push-1 animate-box" data-animate-effect="fadeInRight">
                            <div class="form-wrap">
                                <div class="tab">
                                    <div class="tab-content">

                                        <div id="login" class="tab-content-inner active" data-content="signup">
                                            <h3 style="text-align:center">Login</h3>
                                            <form role="form" action="index.php" method="post">
                                                <div class="row form-group">
                                                    <div class="col-md-12">
                                                        <label for="login-user_email">User Email</label>
                                                        <input type="text" id="user_email" name="user_email" required
                                                               class="form-control">
                                                    </div>
                                                </div>
                                                <div class="row form-group">
                                                    <div class="col-md-12">
                                                        <label for="login-password">Password</label>
                                                        <input type="password" name="password" id="password" required
                                                               class="form-control">
                                                    </div>
                                                </div>

                                                <span class="error-text"
                                                      style="color: #f54c53;font-size: 13px;"><?php echo $errorRequired ?></span>
                                                <span class="error-text"
                                                      style="color: #f54c53;font-size: 13px;"><?php echo $errorUserError ?></span>

                                                <div class="row form-group">
                                                    <div class="col-md-6">
                                                        <input type="submit" class="btn btn-primary btn-block"
                                                               value="Login">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <a href="../signup/">
                                                            <input type="button" class="btn btn-primary btn-block"
                                                                   value="Sign Up">
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="row form-group">
                                                    <a href="../forgotPassword/">Forgot Password</a>
                                                </div>
                                            </form>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


            </div>
        </div>
    </div>
</header>

<!-- jQuery -->
<script src="../js/jquery.min.js"></script>
<!-- jQuery Easing -->
<script src="../js/jquery.easing.1.3.js"></script>
<!-- Bootstrap -->
<script src="../js/bootstrap.min.js"></script>
<!-- Waypoints -->
<script src="../js/jquery.waypoints.min.js"></script>
<!-- Carousel -->
<script src="../js/owl.carousel.min.js"></script>
<!-- countTo -->
<script src="../js/jquery.countTo.js"></script>

<!-- Stellar Parallax -->
<script src="../js/jquery.stellar.min.js"></script>

<!-- Magnific Popup -->
<script src="../js/jquery.magnific-popup.min.js"></script>
<script src="../js/magnific-popup-options.js"></script>

<!-- Datepicker -->
<script src="../js/bootstrap-datepicker.min.js"></script>


<!-- Main -->
<script src="../js/main.js"></script>

</body>
</html>

