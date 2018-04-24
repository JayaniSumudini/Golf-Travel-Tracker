<?php
/**
 * Created by PhpStorm.
 * User: jayani
 * Date: 3/21/2018
 * Time: 12:49 AM
 */
require "../function/function.php";
$conn = connection();
$reset_key=$user_email=$password_error = '';
 if (isset($_GET['token']) && isset($_GET['email'])) {
     $token = $_GET['token'];
     $user_email = $_GET['email'];

     $query = "SELECT reset_key FROM user_details WHERE user_email='$user_email'";
     $result = mysqli_query($conn, $query);
     $row[] = mysqli_fetch_assoc($result);
     $reset_key = $row[0]["reset_key"];

     if($token != $reset_key){
         print("<script>
                 alert('Incorrect token!');
                 window.location.href='../forgotPassword';
               </script>");
     }
    //check the token is correct by checking db
    //then get email and recover password - jayani
} else {
    // Fallback behaviour goes here
     header("location: ../forgotPassword/");
}
 
 if ($_POST['save_password']) {
//    $user_email = mysqli_real_escape_string($conn, $_POST['user_email']);
    $password1 = mysqli_real_escape_string($conn, $_POST['password1']);
    $password2 = mysqli_real_escape_string($conn, $_POST['password2']);

    if($password1 != $password2){
        $password_error = "Password Does not matched";
        header("location: ../resetPassword");
    }else{
        $query_password = "UPDATE user_details SET password = '$password1' WHERE user_email='$user_email'";
        if ($conn->query($query_password)) {
            $password_error='';
            header("location: ../login");
            
        }else{
            $password_error = 'Connection Error!';
        }
    }
    mysqli_close($conn);

}

?>

<!DOCTYPE HTML>
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

    <!--    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">-->
    <!--    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>-->
    <!--    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>-->
</head>
<body>

<header id="gtco-header" class="gtco-cover gtco-cover-md" role="banner"
        style="background-image: url(../images/img_bg_2.jpg)">
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

                                        <div id="signup" class="tab-pane fade in active">
                                            <h3 style="text-align:center">Password Reset</h3>
                                            <form class="form-signin" method="POST" type="submit">
                                                <h2 class="form-signin-heading">Forgot Password</h2>
                                                <div class="input-group">
                                                    <span class="input-group-addon icon-lock" id="basic-addon1"></span>
                                                    <input type="password" id="password1" name="password1" class="form-control"
                                                           placeholder="New Password" required>
                                                           </div>
                                                           <div></div>
                                                           <div class="input-group">
                                                    <span class="input-group-addon icon-repeat" id="basic-addon1"></span>
                                                           
                                                           
                                                           <input type="password" id="password2" name="password2" class="form-control"
                                                           placeholder="ReEnter New Password" required>
                                                </div>
                                                <br/>
                                                <span style="font-weight: bold;color: red"><?php echo($password_error); ?></span>
                                                <input class="btn btn-primary btn-block" type="submit" id="save_password"
                                                       name="save_password" value="Save New Password">
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

