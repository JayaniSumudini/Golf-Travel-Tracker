<?php
session_start();
$register_error = "";
if (!isset($_SESSION['user'])) {
    header("Location:../login");
}

if (isset($_POST['submit'])) {
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
            $_SESSION['party'] = $conn->insert_id;
            $_SESSION['trips'] = [];

            echo "<script>
                    window.location.href='../tripCreate';
                  </script>";
        } else {
            $register_error = "error while registering you";
        }
    } else {
        echo "<script>window.location.href='../partyCreate';</script>";
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

<!---------------------------------------------------------------------------------------------------------------->
<nav class="navbar navbar-inverse" style="border-radius: 0px;border: none;">
    <?php
    require "../navbar/index.php";
    ?>
</nav>
<!---------------------------------------------------------------------------------------------------------------->

<header id="gtco-header" class="gtco-cover gtco-cover-md" role="banner"
        style="background: #fff">
    <div class="gtco-container">
        <div class="row">
            <div class="col-md-12 col-md-offset-0 text-left">

                <ul class="nav nav-tabs">


                    <div class="row row-mt-15em" style="margin-top: 4em;">
                        <div class="col-md-5  mt-text animate-box" data-animate-effect="fadeInUp"
                             style="margin-top:1em">
                            <?php
                            require "../function/function.php";
                            $conn = connection();
                            ?>
                            <h4>Your Existing Trips</h4>
                            <?php
                            $query = "SELECT * FROM party_details WHERE user_id =" . $_SESSION['user'];
                            $result = $conn->query($query);
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    ?>

                                    <div class="col-md-12"
                                         style="border: 1px solid #09C6AB;padding:10px;margin-bottom: 3px;border-radius: 3px; font-size: 14px">
                                        <div class="row">

                                            <div class="col-sm-9">
                                                <b>Leader : </b><?php echo($row["lead_name"]); ?><br>
                                                <b>Phone Number : </b><?php echo($row["phone_number"]); ?><br>
                                                <b>Email : </b><?php echo($row["email"]); ?><br>
                                            </div>
                                            <div class="col-sm-3 ">
                                                <form role="form" action='index.php' method='POST'>
                                                    <input type='hidden' name='party_id'
                                                           value='<?php echo($row["party_id"]); ?> '>
                                                    <input type="submit" class="btn btn-sm btn-success btn-block"
                                                           id="edit" name="edit"
                                                           value="Edit" style="font-size: 12px; padding: 3px;">
                                                    <input type="submit" class="btn btn-sm btn-danger btn-block"
                                                           id="delete" name="delete"
                                                           value="Delete" style="font-size: 12px; padding: 3px;">
                                                </form>
                                                <?php
                                                if (isset($_POST['delete'])) {
//                                                    print("<script> alert('delete'); </script>");
                                                    $party_id = isset($_POST['party_id']) ? $_POST['party_id'] : "";
                                                    $queryDelete = "DELETE FROM party_details WHERE party_id='$party_id'";
                                                    if ($conn->query($queryDelete)) {
                                                        $_SESSION['party'] = "";
                                                        $_SESSION['trips'] = [];
                                                        print("<script>
//                                                                alert('Party removed');
                                                                 window.location.href='../tripCreate';
                                                                </script>");
                                                    } else {
                                                        print("<script>alert('Error when remove ! ');</script>");
                                                    }
                                                    $_POST = array();
                                                }

                                                if (isset($_POST['edit'])) {
                                                    $_SESSION['party'] = isset($_POST['party_id']) ? $_POST['party_id'] : "";
                                                    $_SESSION['trips'] = [];
                                                    echo "<script>
                                                            window.location.href='../tripCreate';
                                                          </script>";
                                                }
                                                ?>
                                            </div>

                                        </div>
                                    </div>

                                    <?php
                                }
                            }
                            ?>
                        </div>
                        <div class="col-md-6 col-md-push-1 animate-box" data-animate-effect="fadeInRight">
                            <div class="form-wrap"
                                 style="box-shadow: none; border: 1px solid #09C6AB; border-top: 5px solid #09C6AB;">
                                <div class="tab">
                                    <div class="tab-content">

                                        <div id="login" class="tab-content-inner active" data-content="signup">
                                            <h3 style="text-align:center">Create Your New Trip</h3>

                                            <form role="form" action="index.php" method="post">
                                                <div class="row form-group">
                                                    <div class="col-md-12">
                                                        <label for="login-username">Lead Name</label>
                                                        <span style="font-weight: bold;color: red">*</span>
                                                        <input type="text" id="lead_name" name="lead_name" required
                                                               class="form-control">
                                                    </div>
                                                </div>

                                                <div class="row form-group">
                                                    <div class="col-md-12">
                                                        <label for="login-username">Phone Number</label>
                                                        <span style="font-weight: bold;color: red">*</span>
                                                        <input type="number" id="phone_number" name="phone_number" required
                                                               class="form-control">
                                                    </div>
                                                </div>

                                                <div class="row form-group">
                                                    <div class="col-md-12">
                                                        <label for="login-username">Email</label>
                                                        <span style="font-weight: bold;color: red">*</span>
                                                        <input type="email" id="email" name="email" required
                                                               class="form-control">
                                                    </div>
                                                </div>

                                                <div class="row form-group">
                                                    <div class="col-md-12">
                                                        <label for="login-username">Number in Party</label>
                                                        <span style="font-weight: bold;color: red">*</span>
                                                        <input type="number" id="number_in_party" name="number_in_party" required
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
                                                        <span style="font-weight: bold;color: red">*</span>
                                                        <input type="text" id="flight_number" name="flight_number" required
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
                                                    <span style="font-weight: bold;color: red"><?php echo($register_error);?></span>
                                                    <div class="col-md-12">
                                                        <input type="submit" class="btn btn-primary btn-block"
                                                               id="submit" name="submit"
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

