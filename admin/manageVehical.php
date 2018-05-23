<?php
session_start();
$delete_error = $added_error = "";
//$_SESSION['is_edit'] = false;
if (!isset($_SESSION['user']) || !isset($_SESSION['user_role'])) {
    header("Location:../login");
} elseif ($_SESSION['user_role'] != 'ADMIN') {
    header("Location:../login");
}


if (isset($_POST['save'])) {
    /*$vehicle_name_input = isset($_POST['vehicle_name_input']) ? $_POST['vehicle_name_input'] : "";
    $vehicle_price_input = isset($_POST['vehicle_price_input']) ? $_POST['vehicle_price_input'] : "";
    $insertQuery = "INSERT INTO vehicle (vehicle_name,vehicle_price)
                    VALUES ('$vehicle_name_input',$vehicle_price_input)";
    if ($conn->query($insertQuery)) {

    } else {
        $added_error = "error while insert data";
    }*/

    $_SESSION['is_edit'] = false;
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
                <button type="button" class="navbar-toggle" data-toggle="collapse"
                        data-target="#bs-sidebar-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <div class="collapse navbar-collapse" id="bs-sidebar-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li><a href="/web/admin/">Home<span style="font-size:16px;"
                                                        class="pull-right hidden-xs showopacity glyphicon glyphicon-home"></span></a>
                    </li>
                    <li class="active"><a href="/web/admin/manageVehical.php">Manage Vehicles<span
                                    style="font-size:16px;"
                                    class="pull-right hidden-xs showopacity glyphicon glyphicon-user"></span></a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!--car edit-->
    <div class="row">
        <div class="col-md-12 col-md-offset-0 text-left">

            <div class="row row-mt-15em" style="margin-top: 4em;">
                <div class="col-md-12  mt-text animate-box" data-animate-effect="fadeInUp"
                     style="margin-top:1em">

                    <h2>Vehicle Details</h2>
                    <form role="form" action='manageVehical.php' method='POST'>
                        <div class="row form-group" id="isSelect">
                            <div class="col-md-4">
                                <label>Vehicle Name</label>
                                <span style="font-weight: bold;color: red">*</span>
                                <input type="text" required
                                       id="vehicle_name_input"
                                       name="vehicle_name_input"
                                       class="form-control">
                            </div>

                            <div class="col-md-2">
                                <label>Vehicle Price</label>
                                <span style="font-weight: bold;color: red">*</span>
                                <input type="text" required
                                       id="vehicle_price_input"
                                       name="vehicle_price_input"
                                       class="form-control">
                            </div>
                            <div class="col-md-2">
                                    <input type="submit" id="add" name="add"
                                           class="btn btn-sm btn-primary " value="Add"
                                           style="float: right;margin-top: 20px; width: 90%">
                            </div>
                        </div>
                        <?php
                        if (isset($_POST['add'])) {
                            $vehicle_name_input = isset($_POST['vehicle_name_input']) ? $_POST['vehicle_name_input'] : "";
                            $vehicle_price_input = isset($_POST['vehicle_price_input']) ? $_POST['vehicle_price_input'] : "";
                            $insertQuery = "INSERT INTO vehicle (vehicle_name,vehicle_price) 
                                            VALUES ('$vehicle_name_input',$vehicle_price_input)";
                            if ($conn->query($insertQuery)) {

                            } else {
                                $added_error = "error while insert data";
                            }
                        }


                        ?>
                    </form>
                    <?php
                    $query = "SELECT * FROM vehicle ORDER BY vehicle_id";
                    $result = $conn->query($query);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            ?>
                            <div class="col-md-6"
                                 style="border: 1px solid #09C6AB;padding:6px 15px;margin-bottom: 3px;border-radius: 3px; font-size: 14px">
                                <div class="row">

                                    <div class="col-sm-8">
                                        <b>Vehicle Name : </b><?php echo($row["vehicle_name"]); ?><br>
                                        <b>Vehicle Price : </b><?php echo($row["vehicle_price"]); ?><br>
                                        <br>
                                    </div>
                                    <div class="col-sm-4">
                                        <form role="form" action='manageVehical.php' method='POST'>
                                            <input type='hidden' name='vehicle_id'
                                                   value='<?php echo($row["vehicle_id"]); ?> '>
                                            <input type="submit" class="btn btn-sm btn-info btn-block"
                                                   id="edit" name="edit"
                                                   value="Edit" style="font-size: 12px; padding: 3px;">
                                            <input type="submit" class="btn btn-sm btn-danger btn-block"
                                                   id="delete" name="delete"
                                                   value="Delete" style="font-size: 12px; padding: 3px;">
                                        </form>
                                        <?php
                                        if (isset($_POST['delete'])) {
                                            $vehicle_id = isset($_POST['vehicle_id']) ? $_POST['vehicle_id'] : "";
                                            $queryDelete = "DELETE FROM vehicle WHERE vehicle_id='$vehicle_id'";
                                            if ($conn->query($queryDelete)) {
                                                print("<script>
                                                                                window.location.href='../admin/manageVehical.php';
                                                                                </script>");
                                            } else {
                                                $delete_error = "Error when remove ! ";
                                            }
                                        }

                                        if (isset($_POST['edit'])) {

                                        }
                                        ?>
                                    </div>

                                </div>
                            </div>

                            <?php
                        }
                    } else {
                        ?>
                        <h3 align="center" style="color: #adadad">No Vehicles Available</h3>
                        <?php
                    }
                    ?>
                </div>

            </div>
        </div>
    </div>
    <!--end car edit-->
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

<!--<script> $(document).ready(function () {-->
<!---->
<!--        $('#sidebarCollapse').on('click', function () {-->
<!--            $('#sidebar').toggleClass('active');-->
<!--        });-->
<!---->
<!--    });</script>-->

</body>
</html>
