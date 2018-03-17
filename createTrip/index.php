<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location:../login");
}

if ($_POST) {
    require "../function/function.php";
    $conn = connection();
    $lead_name = mysqli_real_escape_string($conn, $_POST['lead_name']);
    $phone_number = mysqli_real_escape_string($conn, $_POST['phone_number']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $number_in_party = mysqli_real_escape_string($conn, $_POST['number_in_party']);
    $hotel_address = mysqli_real_escape_string($conn, $_POST['hotel_address']);
    $flight_number = mysqli_real_escape_string($conn, $_POST['flight_number']);
    $notes = mysqli_real_escape_string($conn, $_POST['notes']);
    $user_id = $_SESSION['user'];

    if ($email != "" || $email != null) {
        $query = "INSERT INTO party_details (lead_name,phone_number,email,hotel_address,flight_number,notes,user_id,number_in_party)
              VALUES ('$lead_name','$phone_number','$email','$hotel_address','$flight_number','$notes','$user_id','$number_in_party')";
        if ($conn->query($query)) {
            $_SESSION['hasParty']=true;
            echo "<script>
                    alert('Succefully saved your details!');
                    window.location.href='../planner';
                  </script>";
        } else {
            print("<script>alert('error while registering you');</script>");
        }
    } else {
        echo "<script>alert('Email can not be null!');</script>";
    }

    mysqli_close($conn);
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
<body>

<header id="gtco-header" class="gtco-cover gtco-cover-md" role="banner"
        style="background: #fff">
    <div class="gtco-container">
        <div class="row">
            <div class="col-md-12 col-md-offset-0 text-left">

                <ul class="nav nav-tabs">


                    <div class="row row-mt-15em" style="margin-top: 4em;">
                        <div class="col-md-4  mt-text animate-box" data-animate-effect="fadeInUp">
                            Enter Some text here for explain the trip planner
                        </div>
                        <div class="col-md-7 col-md-push-1 animate-box" data-animate-effect="fadeInRight">
                            <div class="form-wrap"
                                 style="box-shadow: none; border: 1px solid #09C6AB; border-top: 5px solid #09C6AB;">
                                <div class="tab">
                                    <div class="tab-content">

                                        <div id="login" class="tab-content-inner active" data-content="signup">
                                            <h3 style="text-align:center">Basic Details about your trip</h3>

                                            <form role="form" action="index.php" method="post">
                                                <div class="row form-group">
                                                    <div class="col-md-12">
                                                        <label for="login-username">Lead Name</label>
                                                        <input type="text" id="lead_name" name="lead_name"
                                                               class="form-control">
                                                    </div>
                                                </div>

                                                <div class="row form-group">
                                                    <div class="col-md-12">
                                                        <label for="login-username">Phone Number</label>
                                                        <input type="text" id="phone_number" name="phone_number"
                                                               class="form-control">
                                                    </div>
                                                </div>

                                                <div class="row form-group">
                                                    <div class="col-md-12">
                                                        <label for="login-username">Email</label>
                                                        <input type="text" id="email" name="email"
                                                               class="form-control">
                                                    </div>
                                                </div>

                                                <div class="row form-group">
                                                    <div class="col-md-12">
                                                        <label for="login-username">Number in Party</label>
                                                        <input type="text" id="number_in_party" name="number_in_party"
                                                               class="form-control">
                                                    </div>
                                                </div>

                                                <div class="row form-group">
                                                    <div class="col-md-12">
                                                        <label for="login-username">Hotel Address</label>
                                                        <input type="text" id="hotel_address" name="hotel_address"
                                                               class="form-control">
                                                    </div>
                                                </div>

                                                <div class="row form-group">
                                                    <div class="col-md-12">
                                                        <label for="login-username">Flight Number</label>
                                                        <input type="text" id="flight_number" name="flight_number"
                                                               class="form-control">
                                                    </div>
                                                </div>

                                                <div class="row form-group">
                                                    <div class="col-md-12">
                                                        <label for="login-username">Notes</label>
                                                        <textarea type="text" id="notes" name="notes" rows="4"
                                                                  class="form-control"></textarea>
                                                    </div>
                                                </div>


                                                <div class="row form-group">
                                                    <div class="col-md-12">
                                                        <input type="submit" class="btn btn-primary btn-block"
                                                               value="Itinerary Planner">
                                                    </div>
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

