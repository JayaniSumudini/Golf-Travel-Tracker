<?php
session_start();

if (!isset($_SESSION['user']) || !isset($_SESSION['user_role'])) {
    header("Location:../login");
} elseif ($_SESSION['user_role'] != 'ADMIN') {
    header("Location:../login");
}


if (isset($_POST['confirm'])) {
    if ($_SESSION['user_role'] == 'ADMIN') {
        $updateQuery = "UPDATE trip SET trip_status = 'Accepted' WHERE itenary_id='$itenary_id' AND trip_status='Submited' OR trip_status='ToBeAcceptance'";
    } else {
        $updateQuery = "UPDATE trip SET trip_status = 'ToBeAcceptance' WHERE itenary_id='$itenary_id' AND trip_status='AdminChanged'";
    }
    $conn->query($updateQuery);
    header("location: index.php");
    exit;
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.min.js"></script>
</head>
<body>

<!---------------------------------------------------------------------------------------------------------------->
<nav class="navbar navbar-inverse" style="border-radius: 0px;border: none;">
    <?php
    require "../navbar/index.php";
    ?>
</nav>
<!---------------------------------------------------------------------------------------------------------------->

<?php
require "../function/function.php";
$conn = connection();
?>











<div class="gtco-container">

<nav class="navbar navbar-inverse sidebar" role="navigation">
    <div class="container-fluid">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-sidebar-navbar-collapse-1">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
<!--			<a class="navbar-brand" href="#">Admin Panel</a>-->
		</div>
		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse" id="bs-sidebar-navbar-collapse-1">
        <ul class="nav navbar-nav">
				<li  class="active"><a href="/web/admin/">Home<span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-home"></span></a></li>
				<li><a href="/web/admin/manageVehical.php">Manage Vehicles<span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-user"></span></a></li>
                <li><a href="/web/admin/manageDestination.php">Manage Destinations<span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-user"></span></a></li>
			</ul>
		</div>
	</div>
</nav>


    <div class="row">
        <div class="col-md-12 col-md-offset-0 text-left">

            <div class="row row-mt-15em" style="margin-top: 4em;">
                <div class="col-md-12  mt-text animate-box" data-animate-effect="fadeInUp"
                     style="margin-top:1em">

                    <h2>All Trip Bookings</h2>
                    <?php
                    $query = "SELECT * FROM party_details ORDER BY create_date_and_time";
                    $result = $conn->query($query);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            ?>
                            <div class="col-md-6"
                                 style="border: 1px solid #09C6AB;padding:6px 15px;margin-bottom: 3px;border-radius: 3px; font-size: 14px">
                                <div class="row">

                                    <div class="col-sm-8">
                                        <b>Leader Name : </b><?php echo($row["lead_name"]); ?><br>
                                        <b>Phone Number : </b><?php echo($row["phone_number"]); ?><br>
                                        <b>Email : </b><?php echo($row["email"]); ?><br>
                                        <b>Part Created Time : </b><?php echo($row["create_date_and_time"]); ?>
                                        <br>
                                    </div>
                                    <div class="col-sm-4">
                                        <form role="form" action='index.php' method='POST'>
                                            <input type='hidden' name='party_id'
                                                   value='<?php echo($row["party_id"]); ?> '>
                                            <?php
                                            $party_id1 = $row["party_id"];
                                            $query_get_itenary_id = "SELECT itenary_id FROM itenary  WHERE party_id = '$party_id1'";
                                            $result2 = mysqli_query($conn, $query_get_itenary_id);
                                            $row2[] = mysqli_fetch_assoc($result2);
                                            $itenary_id2 = $row2[0]["itenary_id"];
                                            $row2 =null;
                                            $query3 = "SELECT * FROM trip WHERE (trip_status = 'Submited' OR trip_status = 'AdminChanged' OR trip_status ='ToBeAcceptance' OR trip_status ='Accepted') and itenary_id = '$itenary_id2'";
                                            $addList3 = $conn->query($query3);
                                            if ($addList3->num_rows == 0) {
                                                $query4 = "SELECT * FROM trip WHERE trip_status = 'Saved' and itenary_id = '$itenary_id2'";
                                                $addList4 = $conn->query($query4);
                                                if($addList4->num_rows== 0){
                                                    $query5 = "SELECT * FROM trip WHERE trip_status = 'Added' and itenary_id = '$itenary_id2'";
                                                    $addList5 = $conn->query($query5);
                                                    if($addList5->num_rows!=0){
                                                        ?>
                                                        <input type="button" class="btn btn-sm btn-primary btn-block"
                                                               id="save_show" name="save_show"
                                                               value="Have only Added trip" style="font-size: 12px; padding: 3px; cursor:default">
                                                        <?php
                                                    }else{
                                                        ?>
                                                        <input type="button" class="btn btn-sm btn-danger btn-block"
                                                               id="save_show" name="save_show"
                                                               value="No Trip Yet" style="font-size: 12px; padding: 3px; cursor:default">
                                                        <?php
                                                    }
                                                }else{
                                                    ?>
                                                    <input type="button" class="btn btn-sm btn-success btn-block"
                                                           id="save_show" name="save_show"
                                                           value="Have only Save trip" style="font-size: 12px; padding: 3px; cursor:default">
                                                    <?php
                                                }
                                            }else{
                                                ?>
                                            <input type="submit" class="btn btn-sm btn-info btn-block"
                                                   id="view" name="view"
                                                   value="View Trip" style="font-size: 12px; padding: 3px;">
                                            <?php
                                            }
                                            ?>


                                        </form>
                                        <?php
                                        if (isset($_POST['view'])) {
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
                    }else{
                        ?>
                        <h3 align="center" style="color: #adadad">No Party Available</h3>
                        <?php
                    }
                    ?>
                </div>

            </div>
        </div>
    </div>

</div>


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

<script> $(document).ready(function () {

$('#sidebarCollapse').on('click', function () {
    $('#sidebar').toggleClass('active');
});

});</script>

</body>
</html>
