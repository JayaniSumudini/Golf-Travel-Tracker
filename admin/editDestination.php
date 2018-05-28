<?php
/**
 * Created by PhpStorm.
 * User: jayani
 * Date: 5/25/2018
 * Time: 9:57 PM
 */

session_start();
$delete_error = $added_error = "";
if (!isset($_SESSION['user']) || !isset($_SESSION['user_role'])) {
    header("Location:../login");
} elseif ($_SESSION['user_role'] != 'ADMIN') {
    header("Location:../login");
}

if (!isset($_SESSION['editDestination'])) {
    header("Location:../manageDestination.php");
} else {
    $edit_row = $_SESSION['editDestination'];
    $destination_id = $edit_row['destination_id'];
    $destination_name = $edit_row['destination_name'];

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
                    <li><a href="/web/admin/manageVehical.php">Manage Vehicles<span
                                    style="font-size:16px;"
                                    class="pull-right hidden-xs showopacity glyphicon glyphicon-user"></span></a></li>

                    <li class="active"><a href="/web/admin/manageDestination.php">Manage Destinations<span
                                    style="font-size:16px;"
                                    class="pull-right hidden-xs showopacity glyphicon glyphicon-user"></span></a>
                    </li>

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

                    <h2>Edit Destination</h2>
                    <form role="form" action='addDestination.php' method='POST'>
                        <div class="row form-group" id="isSelect">

                            <div class="col-md-3">
                                <label for="destination_name_input">Destination Name</label>
                                <span style="font-weight: bold;color: red">*</span>
                            </div>
                            <div class="col-md-3">
                                <input type="text" required
                                       id="destination_name_input"
                                       name="destination_name_input"
                                       class="form-control">
                            </div>
                        </div>

                        <form role="form" action='addDestination.php' method='POST'>
                            <div class="row form-group" id="isSelect">
                                <table id="data_table" class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th style="padding-top: 12px;padding-bottom: 12px;text-align: left;background-color: #4CAF50;color: white;border: 1px solid #ddd;">
                                            Destination Name
                                        </th>
                                        <th style="padding-top: 12px;padding-bottom: 12px;text-align: left;background-color: #4CAF50;color: white;border: 1px solid #ddd;">
                                            Distance
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $sql_query = "SELECT * FROM destinations ORDER BY destination_id";
                                    $resultset = mysqli_query($conn, $sql_query) or die("database error:" . mysqli_error($conn));
                                    while ($destination = mysqli_fetch_assoc($resultset)) {
                                        ?>
                                        <td hidden
                                            style="border: 1px solid #ddd;"><?php echo $destination['destination_id']; ?></td>
                                        <td style="border: 1px solid #ddd;"><?php echo $destination['destination_name']; ?></td>
                                        <td style="border: 1px solid #ddd;"><input type="number" required
                                                                                   class="w3-input"
                                                                                   id="<?php echo($destination['destination_id']) ?>distance_input"
                                                                                   name="<?php echo($destination['destination_id']) ?>distance_input">
                                        </td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>

                            <div class="row form-group" id="isSelect">
                                <div class="col-md-4">
                                    <input type="submit" id="add" name="add"
                                           class="btn btn-sm btn-primary " value="Add New Destination"
                                           style="float: right;margin-top: 20px; width: 90%">
                                </div>
                            </div>
                        </form>
                        <?php
                        if (isset($_POST['add'])) {
                            $destination_name_input = isset($_POST['destination_name_input']) ? $_POST['destination_name_input'] : "";
                            $query = "INSERT INTO destinations (destination_name) VALUES ('$destination_name_input')";
                            if ($conn->query($query)) {
                                $destination_id = $conn->insert_id;
                            } else {
                                $itineary_error = "error while create itineary";
                            }

                            $sql_query1 = "SELECT * FROM destinations ORDER BY destination_id";
                            $resultset1 = mysqli_query($conn, $sql_query1) or die("database error:" . mysqli_error($conn));
                            $input_array = [];
                            while ($destination = mysqli_fetch_assoc($resultset1)) {
                                $id = $destination['destination_id'];
                                $destination_id_existing = $destination['destination_id'];
                                $input = $destination['destination_id'] . 'distance_input';
                                $value = isset($_POST[$input]) ? $_POST[$input] : 0;
                                add_distance($destination_id_existing, $destination_id, $value, $conn);

                                $input = $value = $destination_id_existing = null;

                            }


                            print("<script>
                                                 window.location.href='manageDestination.php';
                                             </script>");
                        }


                        function add_distance($destination_id_existing, $destination_id, $distance, $conn)
                        {
                            /*then add to distance table*/
                            if ($destination_id_existing <= $destination_id) {
                                $travel_from = $destination_id_existing;
                                $travel_to = $destination_id;
                            } else {
                                $travel_from = $destination_id;
                                $travel_to = $destination_id_existing;
                            }

                            $query = "INSERT INTO distance (travel_from,travel_to,distance) VALUES ($travel_from,$travel_to,$distance)";
                            if ($conn->query($query)) {
                                $travel_from = $travel_to = $query = null;
                            } else {
                                $insert_error = "error while create itineary";
                            }
                        }


                        ?>
                    </form>
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

