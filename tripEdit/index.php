<?php
// instantiate product object -----------------------------------------------------
include_once '../tripCreate/Trip.php';
require "../function/function.php";
$conn = connection();
session_start();

$current_price = $itenary_id =null;
$save_error = $itineary_error = $delete_error = $dropdown_from_error = $dropdown_to_error = $car_type_error = $added_error= "";

//check session keys and redirect to right place -----------------------------------------------------
if (!isset($_SESSION['user'])) {
    header("Location:../login");
} else if (!isset($_SESSION['party']) || $_SESSION['party'] == "") {
    header("location: ../partyCreate/");
}
if (!isset($_SESSION['editTrip'])) {
    header("Location:../tripCreate");
}else{
    $edit_row = $_SESSION['editTrip'];
    $trip_id = $edit_row['trip_id'];
    $current_price = $edit_row['travel_price'];
    $itenary_id = $edit_row['itenary_id'];
}


if (isset($_POST['submit'])) {

    $trip = new Trip();
    $trip->travel_date = convert_date_format($_POST['travel_date']);
    $trip->travel_time = mysqli_real_escape_string($conn, $_POST['travel_time']);
    $trip->travel_from = mysqli_real_escape_string($conn, $_POST['travel_from']);
    $trip->travel_to = mysqli_real_escape_string($conn, $_POST['travel_to']);
    $trip->number_of_pessengers = mysqli_real_escape_string($conn, $_POST['number_of_pessengers']);
    $trip->car_type_id = mysqli_real_escape_string($conn, $_POST['car']);
    $trip->travel_price = calculate_travel_price($_POST['travel_from'], $_POST['travel_to'], $_POST['car'], $conn);

    $status_query = "SELECT trip_status FROM trip WHERE trip_id='$trip_id'";
    $var_status = mysqli_query($conn, $status_query);
    $statuses[] = mysqli_fetch_assoc($var_status);
    $status = $statuses[0]["trip_status"];
    $trip->trip_status = 'Added';
    if($_SESSION['user_role'] != 'ADMIN'){
        if($status == 'AdminChanged'){
            $trip->trip_status = 'ToBeAcceptance';
        }
    }
    if($_SESSION['user_role'] == 'ADMIN'){
        $trip->trip_status = 'AdminChanged';
    }
    $trip->flight_number = mysqli_real_escape_string($conn, $_POST['flight_number']);;

    if ($trip->travel_from == "None") {
        $dropdown_from_error = "Please select place";
    } elseif ($trip->travel_to == "None") {
        $dropdown_to_error = "Please select place";
    } else {
        $query = "SELECT total_price FROM itenary WHERE itenary_id='$itenary_id'";
        $var1 = mysqli_query($conn, $query);
        $total_prices[] = mysqli_fetch_assoc($var1);
        $total_price = $total_prices[0]["total_price"];
        $total_price = $total_price - $current_price;
        $total_price = $total_price + $trip->travel_price;

        $insertQuery = "UPDATE trip SET travel_date='$trip->travel_date',travel_time='$trip->travel_time',travel_from=$trip->travel_from,travel_to=$trip->travel_to,number_of_pessengers=$trip->number_of_pessengers,travel_price=$trip->travel_price,car_type_id=$trip->car_type_id,trip_status='$trip->trip_status',flight_number='$trip->flight_number' 
                        WHERE trip_id='$trip_id'";

        if ($conn->query($insertQuery)) {
            $updateQuery = "UPDATE itenary SET total_price = $total_price WHERE itenary_id='$itenary_id'";
            if ($conn->query($updateQuery)) {
                $total_prices = null;
                $_SESSION['editTrip'] = null;
                echo "<script>
                     window.location.href='../tripCreate';
                  </script>";
            }
        } else {
            $added_error = "error while insert data";
            echo "<script>window.location.href='../tripEdit';</script>";
        }
    }

    mysqli_close($conn);
}

if (isset($_POST['cancel'])) {
    echo "<script>
             window.location.href='../tripCreate';
          </script>";
}

function calculate_travel_price($travel_from, $travel_to, $vehicle_id, $conn)
{
    $travel_price = 0;

    if ($travel_from <= $travel_to) {
        $query = "select * from distance where travel_from='$travel_from' and travel_to='$travel_to'";
    } else {
        $query = "select * from distance where travel_from='$travel_to' and travel_to='$travel_from'";
    }
    $result = mysqli_query($conn, $query);
    $row[] = mysqli_fetch_assoc($result);

//    if ($car_type == 1) {
//        $travel_price = 1.8 * $row[0]["distance"];
//    } elseif ($car_type == 2) {
//        $travel_price = 2 * $row[0]["distance"];
//    } elseif ($car_type == 3) {
//        $travel_price = 2.1 * $row[0]["distance"];
//    } else {
//        $car_type_error = "please select car type";
//    }
    $query1 = "select vehicle_price from vehicle where vehicle_id='$vehicle_id'";
    $result1 = mysqli_query($conn, $query1);
    $row1 = mysqli_fetch_assoc($result1);
    $travel_price = $row1["vehicle_price"] * $row[0]["distance"];
    $cost = 0;
    $cost = $travel_price;
    if ($travel_price < 10) {
        $cost = 10;
    }
    return $cost;
}

function convert_date_format($travel_date)
{
    $date = DateTime::createFromFormat('d/m/Y', $travel_date);
    return $date->format('Y-m-d');
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

    <script type='text/javascript' src='http://code.jquery.com/jquery.min.js'></script>

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

                        <div class="col-md-12 animate-box" data-animate-effect="fadeInRight">
                            <div class="form-wrap"
                                 style="box-shadow: none; border: 1px solid #09C6AB; border-top: 5px solid #09C6AB;">
                                <div class="tab">
                                    <div class="tab-content">

                                        <div id="login" class="tab-content-inner active" data-content="signup">
                                            <h3 style="text-align:center">Plan your trip</h3>
                                            <form role="form" action="index.php" method="post">
                                                <div class="row form-group">
                                                    <span style="-webkit-text-fill-color: red" id="errorSpan"></span>
                                                </div>
                                                <div style="border:solid 1px #09C6AB;border-radius: 5px; padding: 16px;margin-bottom: 20px">
                                                    <h4>Add New Trip to your plan</h4>
                                                    <span style="font-weight: bold;color: red"><?php echo($itineary_error); ?></span>
                                                    <div class="row form-group" id="isSelect">
                                                        <div class="col-md-2">
                                                            <label for="login-username">Date</label>
                                                            <span style="font-weight: bold;color: red">*</span>
                                                            <input data-provide="datepicker" type="text" data-date-format="dd/mm/yyyy"
                                                                   id="travel_date"
                                                                   name="travel_date"
                                                                   class="form-control" value="<?php
                                                            $date = DateTime::createFromFormat('Y-m-d', $edit_row['travel_date']);
                                                            echo($date->format('d/m/Y'))?>">
                                                        </div>

                                                        <div class="col-md-2">
                                                            <label for="login-username">Time</label>
                                                            <span style="font-weight: bold;color: red">*</span>
                                                            <input type="time" id="travel_time"
                                                                   name="travel_time"
                                                                   class="form-control" value="<?php echo($edit_row['travel_time'])?>">
                                                        </div>

                                                        <div class="col-md-2">
                                                            <label for="login-username">From</label>
                                                            <span style="font-weight: bold;color: red">*</span>
                                                            <select class="form-control" name="travel_from">
                                                                <option>None</option>
                                                                <?php
                                                                $query = "SELECT destination_id,destination_name FROM destinations";
                                                                $travelList = $conn->query($query);
                                                                if ($travelList->num_rows > 0) {
                                                                    while ($rowValue = $travelList->fetch_assoc()) {
                                                                        ?>
                                                                        <option value="<?php echo($rowValue["destination_id"]); ?>"  <?=$edit_row['travel_from'] == $rowValue["destination_id"] ? ' selected="selected"' : '';?>>
                                                                            <?php echo($rowValue["destination_name"]); ?></option>
                                                                        <?php
                                                                    }
                                                                }
                                                                ?>
                                                            </select>
                                                            <span style="font-weight: bold;color: red"><?php echo($dropdown_from_error); ?></span>
                                                        </div>

                                                        <div class="col-md-2">
                                                            <label for="login-username">To</label>
                                                            <span style="font-weight: bold;color: red">*</span>
                                                            <select class="form-control" name="travel_to">
                                                                <?php
                                                                $query = "SELECT destination_id,destination_name FROM destinations";
                                                                $placeList = $conn->query($query);
                                                                if ($placeList->num_rows > 0) {
                                                                    while ($rowValue = $placeList->fetch_assoc()) {
                                                                        ?>
                                                                        <option value="<?php echo($rowValue["destination_id"]); ?>" <?=$edit_row['travel_to'] == $rowValue["destination_id"] ? ' selected="selected"' : '';?>>
                                                                            <?php echo($rowValue["destination_name"]); ?></option>
                                                                        <?php
                                                                    }
                                                                }
                                                                ?>
                                                            </select>
                                                            <span style="font-weight: bold;color: red"><?php echo($dropdown_to_error); ?></span>

                                                            <script>
                                                                var $dropdown1 = $("select[name='travel_from']");
                                                                var $dropdown2 = $("select[name='travel_to']");

                                                                $dropdown1.change(function () {
                                                                    $dropdown2.empty().append($dropdown1.find('option').clone());
                                                                    var selectedItem = $(this).val();
                                                                    if (selectedItem) {
                                                                        $dropdown2.find('option[value="' + selectedItem + '"]').remove();
                                                                    }
                                                                });
                                                            </script>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label for="login-username">Number of pessengers</label>
                                                            <span style="font-weight: bold;color: red">*</span>
                                                            <input type="number" id="number_of_pessengers"
                                                                   name="number_of_pessengers"
                                                                   class="form-control" value="<?php echo($edit_row['number_of_pessengers'])?>">
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label for="login-username">Car</label>
                                                            <span style="font-weight: bold;color: red">*</span>

                                                            <select class="form-control" name="car">
                                                                <option>None</option>
                                                                <?php
                                                                $query = "SELECT vehicle_id,vehicle_name FROM vehicle";
                                                                $vehicleList = $conn->query($query);
                                                                if ($vehicleList->num_rows > 0) {
                                                                    while ($rowValue = $vehicleList->fetch_assoc()) {
                                                                        ?>
                                                                        <option value="<?php echo($rowValue["vehicle_id"]); ?>" <?=$edit_row['car_type_id'] == $rowValue["vehicle_id"] ? ' selected="selected"' : '';?>>
                                                                            <?php echo($rowValue["vehicle_name"]); ?></option>
                                                                        <?php
                                                                    }
                                                                }
                                                                ?>
                                                            </select>

                                                            <span style="font-weight: bold;color: red"><?php echo($car_type_error); ?></span>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label for="login-username">Flight NO:</label>
                                                            <input type="text" id="flight_number"
                                                                   name="flight_number"
                                                                   class="form-control" value="<?php echo($edit_row['flight_number'])?>">
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="row form-group">
                                                    <div class="col-md-6">
                                                        <div class="col-md-6">
                                                            <input type="submit" class="btn btn-primary btn-block"
                                                                   id="submit" name="submit"
                                                                   value="Save Changes">

                                                            <input type="submit" class="btn btn-primary btn-block"
                                                                   id="cancel" name="cancel"
                                                                   value="Cancel Changes">

                                                            <span style="font-weight: bold;color: red"><?php echo($save_error); ?></span>
                                                        </div>
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

