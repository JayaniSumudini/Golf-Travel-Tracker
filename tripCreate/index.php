<?php
// instantiate product object -----------------------------------------------------
include_once 'Trip.php';
require "../function/function.php";
$conn = connection();
session_start();


$save_error = $itineary_error = $delete_error = $dropdown_from_error = $dropdown_to_error = $car_type_error = $added_error = "";

//check session keys and redirect to right place -----------------------------------------------------
if (!isset($_SESSION['user'])) {
    header("Location:../login");
} else if (!isset($_SESSION['party']) || $_SESSION['party'] == "") {
    header("location: ../partyCreate/");
}

//If comes to edit a iternary get all the saved data to the screen -----------------------------------------------------
$party_id = $_SESSION['party'];
$query = "SELECT itenary_id FROM itenary  WHERE party_id = '$party_id'";
$result = mysqli_query($conn, $query);
$row[] = mysqli_fetch_assoc($result);

if ($row[0]["itenary_id"] != null || $row[0]["itenary_id"] != "") {
    $_SESSION['itenary'] = $row[0]["itenary_id"];
    $itenary_id = $_SESSION['itenary'];
} else {
    $status = 'SAVED';
    $query = "INSERT INTO itenary (party_id,status) VALUES ('$party_id','$status')";
    if ($conn->query($query)) {
        $_SESSION['itenary'] = $conn->insert_id;
        $itenary_id = $_SESSION['itenary'];
    } else {
        $itineary_error = "error while create itineary";
    }
}

// Add new row to the plan  -----------------------------------------------------
if (isset($_POST['add'])) {
    $trip = new Trip();
    $trip->travel_date = convert_date_format($_POST['travel_date']);
    $trip->travel_time = mysqli_real_escape_string($conn, $_POST['travel_time']);
    $trip->travel_from = mysqli_real_escape_string($conn, $_POST['travel_from']);
    $trip->travel_to = mysqli_real_escape_string($conn, $_POST['travel_to']);
    $trip->number_of_pessengers = mysqli_real_escape_string($conn, $_POST['number_of_pessengers']);
    $trip->car_type_id = mysqli_real_escape_string($conn, $_POST['car']);
    $trip->travel_price = calculate_travel_price($_POST['travel_from'], $_POST['travel_to'], $_POST['car'], $conn);
    $trip->trip_status = 'Added';
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
        $total_price = $total_price + $trip->travel_price;
        $insertQuery = "INSERT INTO trip (travel_date,travel_time,travel_from,travel_to,number_of_pessengers,travel_price,itenary_id,car_type_id,trip_status,flight_number) 
                        VALUES ('$trip->travel_date','$trip->travel_time',$trip->travel_from,$trip->travel_to,$trip->number_of_pessengers,$trip->travel_price,$itenary_id,$trip->car_type_id,'$trip->trip_status','$trip->flight_number')";
        if ($conn->query($insertQuery)) {
            $updateQuery = "UPDATE itenary SET total_price = $total_price WHERE itenary_id='$itenary_id'";
            if ($conn->query($updateQuery)) {
                $total_prices = null;
            }
        } else {
            $added_error = "error while insert data";
        }


    }
    header("location: index.php");
    exit;
}

// Saving new iterenary to DB when creating a new one  -----------------------------------------------------
if (isset($_POST['save'])) {
    $updateQuery = "UPDATE trip SET trip_status = 'Saved' WHERE itenary_id='$itenary_id' AND trip_status='Added'";
    $conn->query($updateQuery);
    $total_prices = null;
}

if (isset($_POST['submit'])) {
    $updateQuery = "UPDATE trip SET trip_status = 'Submited' WHERE itenary_id='$itenary_id' AND trip_status='Saved'";
    $conn->query($updateQuery);
    $total_prices = null;
    $user = $_SESSION['user'];
    $mailbody = "Dear Admin,\n\nCongratulations!!!\n\n$user submited a new trip.";
//    $email= "calvinjbrown@gmail.com";
    $email= "jayanisumudini@gmail.com";
    mail($email,"You have new trip",$mailbody,"From:back9tours@eigendemo.info\r\n");
    header("location: index.php");
    exit;

}

if (isset($_POST['confirm'])) {
    if($_SESSION['user_role']=='ADMIN'){
        $updateQuery = "UPDATE trip SET trip_status = 'Accepted' WHERE itenary_id='$itenary_id' AND trip_status='Submited' OR trip_status='ToBeAcceptance'";
    }else{
        $updateQuery = "UPDATE trip SET trip_status = 'ToBeAcceptance' WHERE itenary_id='$itenary_id' AND trip_status='AdminChanged'";
    }
    $conn->query($updateQuery);
    header("location: index.php");
    exit;
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
//    $query1 = "select vehicle_price from vehicle where vehicle_id='$vehicle_id'";
    $query1 = "select vehicle_price from vehicle_destination_price_mapper where destination_id='$travel_from' and vehicle_id='$vehicle_id'";
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

function convert_date_format_to_display($travel_date)
{
    $date = DateTime::createFromFormat('Y-m-d', $travel_date);
    return $date->format('d/m/Y');
}

if (isset($_POST['print'])) {
    header("location: ../print/");
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
                    <form role="form" action="index.php" method="post">
                        <input type="submit" id="edit_plan" name="edit_plan"
                               class="btn btn-md btn-info" value="Edit trip details"
                               style="float: right;margin-top: 30px;">
                        <?php
                        if ($_SESSION['user_role'] == 'ADMIN') {
                            ?>
                            <script type="text/javascript">$('#edit_plan').hide()</script>
                            <?php
                        }
                        ?>
                        <?php
                        if (isset($_POST['edit_plan'])) {
                            $party_id1 = $_SESSION['party'];
                            $query1 = "SELECT * FROM party_details WHERE party_id='$party_id1'";
                            $result1 = $conn->query($query1);
                            $row1 = $result1->fetch_assoc();
                            $_SESSION['editParty'] = $row1;
                            $_SESSION['istrip'] = true;
                            print("<script>
                                    window.location.href='../partyEdit';
                                   </script>");
                        }
                        ?>
                    </form>

                    <div class="row row-mt-15em" style="margin-top: 4em;">
                        <div class="col-md-12 animate-box" data-animate-effect="fadeInRight">
                            <div class="form-wrap"
                                 style="box-shadow: none; border: 1px solid #09C6AB; border-top: 5px solid #09C6AB;">
                                <div class="tab">
                                    <div class="tab-content">
                                        <div id="trip" class="tab-content-inner active">
                                            <h3 id="title_user" style="text-align:center">Plan your trip</h3>
                                            <h3 id="title_admin" style="text-align:center">Trip details</h3>
                                            <?php
                                            if ($_SESSION['user_role'] == 'ADMIN') {
                                                ?>
                                                <script type="text/javascript">$('#title_user').hide()</script>
                                                <?php
                                            }
                                            ?>
                                            <?php
                                            if ($_SESSION['user_role'] != 'ADMIN') {
                                                ?>
                                                <script type="text/javascript">$('#title_admin').hide()</script>
                                                <?php
                                            }
                                            ?>
                                            <form role="form" action="index.php" method="post">
                                                <div class="row form-group">
                                                    <span style="-webkit-text-fill-color: red" id="errorSpan"></span>
                                                </div>

                                                <div style="border:solid 1px #09C6AB;border-radius: 5px; padding: 16px;margin-bottom: 20px" id="div1">
                                                    <?php
                                                    if ($_SESSION['user_role'] == 'ADMIN') {
                                                        ?>
                                                    <script type="text/javascript">$('#div1').hide()</script>
                                                    <?php
                                                    }
                                                    ?>
                                                    <h4>Add New Trip to your plan</h4>
                                                    <span style="font-weight: bold;color: red"><?php echo($itineary_error); ?></span>
                                                    <div class="row form-group" id="isSelect">
                                                        <div class="col-md-2">
                                                            <label for="login-username">Date</label>
                                                            <span style="font-weight: bold;color: red">*</span>
                                                            <input data-provide="datepicker" type="text" data-date-format="dd/mm/yyyy"
                                                                   id="travel_date"
                                                                   name="travel_date"
                                                                   class="form-control">
                                                        </div>

                                                        <div class="col-md-2">
                                                            <label for="login-username">Time</label>
                                                            <span style="font-weight: bold;color: red">*</span>
                                                            <input type="time" id="travel_time"
                                                                   name="travel_time"
                                                                   class="form-control">
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
                                                                        <option value="<?php echo($rowValue["destination_id"]); ?>">
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
                                                                        <option value="<?php echo($rowValue["destination_id"]); ?>">
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
                                                                   class="form-control">
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
                                                                        <option value="<?php echo($rowValue["vehicle_id"]); ?>">
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
                                                                   class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="row form-group" id="isSelect">
                                                        <div class="col-md-10">
                                                            <span id="added_count" name="added_count" style="float: right;margin-top: 20px; padding: 8px 20px; background:#f39c12; color: #fff; border-radius: 3px">
                                                                <?php
                                                                $query1 = "SELECT * FROM trip WHERE trip_status = 'Added' and itenary_id = $itenary_id";
                                                                $query2 = "SELECT * FROM trip WHERE itenary_id = $itenary_id";
                                                                $addList = $conn->query($query1);
                                                                $List = $conn->query($query2);
                                                                if($List->num_rows == 0){
                                                                    echo("Create Your Own Trip");
                                                                }
                                                                else {
                                                                    if($addList->num_rows == 0){
                                                                        echo("All the Trips are SAVED ");
                                                                    }
                                                                    else{
                                                                        echo("You have to SAVE ");
                                                                        echo($addList->num_rows);
                                                                        echo(" number of Trips.");
                                                                    }
                                                                }

                                                                 ?>
                                                            </span>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label for="login-username"></label>
                                                            <input type="submit" id="add" name="add"
                                                                   class="btn btn-sm btn-primary " value="Add"
                                                                   style="float: right;margin-top: 20px; width: 90%">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row form-group">
                                                    <div class="col-md-12" style="overflow-x:auto; width: 100%">
                                                        <table class="table table-bordered">
                                                            <!--                                                            <colgroup>-->
                                                            <!--                                                                <col style="width:105px">-->
                                                            <!--                                                            </colgroup>-->
                                                            <thead>
                                                            <tr style="font-weight: 800;">
                                                                <th>Date</th>
                                                                <th>Time</th>
                                                                <th>From</th>
                                                                <th>Flight No</th>
                                                                <th>To</th>
                                                                <th>Passengers</th>
                                                                <th>Vehicle type</th>
                                                                <th>Price(£)</th>
                                                                <th>status</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            <?php
                                                            $itenary_id = $_SESSION['itenary'];
                                                            if($_SESSION['user_role']== 'ADMIN'){
                                                                $query = "SELECT * FROM trip WHERE itenary_id='$itenary_id' AND (trip_status='Submited' OR trip_status='AdminChanged' OR trip_status='ToBeAcceptance' OR trip_status='Accepted') ORDER BY travel_date,travel_time ";
                                                            }else{
                                                                $query = "SELECT * FROM trip WHERE itenary_id='$itenary_id' ORDER BY travel_date,travel_time ";
                                                            }

                                                            $tripList = $conn->query($query);
                                                            if ($tripList->num_rows > 0) {
                                                                while ($rowValue = $tripList->fetch_assoc()) {
                                                                    ?>
                                                                    <tr>
                                                                        <td><?php echo(convert_date_format_to_display($rowValue["travel_date"])); ?></td>
                                                                        <td><?php echo(date("H:i", strtotime($rowValue["travel_time"]))); ?></td>
                                                                        <td>
                                                                            <?php
                                                                            $destination_id1 = $rowValue["travel_from"];
                                                                            $query1 = "SELECT destination_name FROM destinations WHERE destination_id = '$destination_id1'";
                                                                            $destination_name1 = mysqli_query($conn, $query1);
                                                                            $destination_names1[] = mysqli_fetch_assoc($destination_name1);
                                                                            echo($destination_names1[0]["destination_name"]);
                                                                            $destination_names1 = null;
                                                                            ?></td>
                                                                        <td><?php echo($rowValue["flight_number"]); ?></td>
                                                                        <td><?php
                                                                            $destination_id2 = $rowValue["travel_to"];
                                                                            $query2 = "SELECT destination_name FROM destinations WHERE destination_id = '$destination_id2'";
                                                                            $destination_name2 = mysqli_query($conn, $query2);
                                                                            $destination_names2[] = mysqli_fetch_assoc($destination_name2);
                                                                            echo($destination_names2[0]["destination_name"]);
                                                                            $destination_names2 = null;
                                                                            ?></td>
                                                                        <td><?php echo($rowValue["number_of_pessengers"]); ?></td>
                                                                        <td><?php
                                                                            $car_type_id = $rowValue["car_type_id"];
                                                                            $query3 = "select vehicle_name from vehicle where vehicle_id='$car_type_id'";
                                                                            $result3 = mysqli_query($conn, $query3);
                                                                            $row3 = mysqli_fetch_assoc($result3);
                                                                            echo ($row3["vehicle_name"]);
                                                                            ?></td>
                                                                        <td align="right"><?php echo($rowValue["travel_price"]); ?></td>
                                                                        <td><?php
                                                                            if ($rowValue["trip_status"] == 'Added') {
                                                                                echo '<span style="color:#ff2a2f;">';
                                                                                echo($rowValue["trip_status"]);
                                                                                echo '</span>';
                                                                            } elseif ($rowValue["trip_status"] == 'Saved') {
                                                                                echo '<span style="color:#0e2eff;">';
                                                                                echo($rowValue["trip_status"]);
                                                                                echo '</span>';
                                                                            } elseif ($rowValue["trip_status"] == 'Submited') {
                                                                                echo '<span style="color:#74ff26;">';
                                                                                echo($rowValue["trip_status"]);
                                                                                echo '</span>';
                                                                            }elseif ($rowValue["trip_status"] == 'AdminChanged') {
                                                                                echo '<span style="color:#ffbb56;">';
                                                                                echo("Admin Changed");
                                                                                echo '</span>';
                                                                            }elseif ($rowValue["trip_status"] == 'ToBeAcceptance') {
                                                                                echo '<span style="color:#ff05bf;">';
                                                                                echo("To Be Acceptance");
                                                                                echo '</span>';
                                                                            }elseif ($rowValue["trip_status"] == 'Accepted') {
                                                                                echo '<span style="color:#090909;">';
                                                                                echo("Accepted");
                                                                                echo '</span>';
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                        <td>
                                                                            <form method="post" action="">
                                                                                <input type='hidden' name='trip_id'
                                                                                       value='<?php echo($rowValue["trip_id"]); ?> '>
                                                                                <?php
                                                                            $trip_id = $rowValue["trip_id"];
                                                                            $status_query1 = "SELECT trip_status FROM trip WHERE trip_id='$trip_id'";
                                                                            $var_status1 = mysqli_query($conn, $status_query1);
                                                                            $statuses1[] = mysqli_fetch_assoc($var_status1);
                                                                            $status1 = $statuses1[0]["trip_status"];
                                                                            $statuses1 = null;?>

                                                                                <input type="submit" <?php if(($status1=='Submited' || $status1=='ToBeAcceptance'  || $status1=='Accepted') && $_SESSION['user_role'] !='ADMIN' ) {?> disabled="disabled" <?php } ?>
                                                                                       class="btn btn-sm btn-danger"
                                                                                       id="delete" name="delete"
                                                                                       value="Delete"
                                                                                       style="font-size: 12px; padding: 3px;">

                                                                                <span style="font-weight: bold;color: red"><?php echo($delete_error); ?></span>
                                                                                <input type="submit" <?php if(($status1=='Submited' || $status1=='ToBeAcceptance') && $_SESSION['user_role'] !='ADMIN') {?> disabled="disabled" <?php } ?>
                                                                                       class="btn btn-sm "
                                                                                       id="edit_trip" name="edit_trip"
                                                                                       value="edit_trip"
                                                                                       style="font-size: 12px; padding: 3px;">
                                                                            </form>
                                                                        </td>
                                                                        <?php
                                                                        if (isset($_POST['delete'])) {
                                                                            $query = "SELECT total_price FROM itenary WHERE itenary_id='$itenary_id'";
                                                                            $var = mysqli_query($conn, $query);
                                                                            $total_prices[] = mysqli_fetch_assoc($var);
                                                                            $total_price = $total_prices[0]["total_price"];

                                                                            $trip_id = isset($_POST['trip_id']) ? $_POST['trip_id'] : "";
                                                                            $query = "SELECT travel_price FROM trip WHERE trip_id='$trip_id'";
                                                                            $var = mysqli_query($conn, $query);
                                                                            $travel_prices[] = mysqli_fetch_assoc($var);
                                                                            $travel_price = $travel_prices[0]["travel_price"];

                                                                            $total_price = $total_price - $travel_price;

                                                                            $updateQuery = "UPDATE itenary SET total_price = $total_price WHERE itenary_id='$itenary_id'";
                                                                            if ($conn->query($updateQuery)) {
                                                                                $total_prices = null;
                                                                            } else {

                                                                            }
                                                                            $queryDelete = "DELETE FROM trip WHERE trip_id='$trip_id'";
                                                                            if ($conn->query($queryDelete)) {
                                                                                print("<script>
//                                                                                alert('Party removed');
                                                                                window.location.href='../tripCreate';
                                                                                </script>");
                                                                            } else {
                                                                                $delete_error = "Error when remove ! ";
                                                                            }
                                                                            $_POST = array();
                                                                        }


                                                                        if (isset($_POST['edit_trip'])) {
                                                                            $trip_id2 = isset($_POST['trip_id']) ? $_POST['trip_id'] : "";
                                                                            $query2 = "SELECT * FROM trip WHERE trip_id='$trip_id2'";
                                                                            $result2 = $conn->query($query2);
                                                                            $row2 = $result2->fetch_assoc();
                                                                            $_SESSION['editTrip'] = $row2;
                                                                            print("<script>
                                                                                window.location.href='../tripEdit';
                                                                                    </script>");
                                                                        }

                                                                        ?>
                                                                    </tr>

                                                                    <?php
                                                                }
                                                            }
                                                            ?>
                                                            </tbody>
                                                            <tr style="font-weight: 800;">
                                                                <td colspan="7">Total Price For Trip (£)</td>
                                                                <td align="right"><?php
                                                                    $query = "SELECT total_price FROM itenary WHERE itenary_id='$itenary_id'";
                                                                    $total_price = mysqli_query($conn, $query);
                                                                    $total_prices[] = mysqli_fetch_assoc($total_price);
                                                                    $total_show_price = $total_prices[0]["total_price"];

                                                                    if($_SESSION["user_role"] == 'ADMIN'){
                                                                        $queryPrice = "SELECT travel_price FROM trip WHERE itenary_id='$itenary_id' AND (trip_status='Saved' OR trip_status='Added')";
                                                                        $query_total_price = $conn->query($queryPrice);
                                                                        if($query_total_price->num_rows >0){
                                                                            $remove_value = 0;
                                                                            while ($rowValue = $query_total_price->fetch_assoc()) {
                                                                                $remove_value = $remove_value + $rowValue["travel_price"];
                                                                            }
                                                                            $total_show_price=$total_show_price-$remove_value;
                                                                        }

                                                                    }
                                                                    echo number_format((float)$total_show_price, 2, '.', '');
                                                                    $total_prices = null;
                                                                    $total_show_price = null;
                                                                    ?></td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="row form-group">
                                                    <div class="col-md-6">
                                                        <div class="col-md-6">
                                                            <input type="submit" class="btn btn-primary btn-block"
                                                                   id="print" name="print"
                                                                   value="Print">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input type="submit" class="btn btn-primary btn-block"
                                                                   id="submit" name="submit"
                                                                   value="Submit">
                                                        </div>
                                                        <?php
                                                        if ($_SESSION['user_role'] == 'ADMIN') {
                                                            ?>
                                                            <script type="text/javascript">$('#submit').hide()</script>
                                                            <?php
                                                        }
                                                        ?>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="col-md-6">
                                                            <input type="submit" class="btn btn-primary btn-block"
                                                                   id="confirm" name="confirm"
                                                                   value="Confirm">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input type="submit" class="btn btn-primary btn-block"
                                                                   id="save" name="save"
                                                                   value="Save">
                                                            <span style="font-weight: bold;color: red"><?php echo($save_error); ?></span>

                                                        </div>
                                                        <?php
                                                        if ($_SESSION['user_role'] == 'ADMIN') {
                                                            ?>
                                                            <script type="text/javascript">$('#save').hide()</script>
                                                            <?php
                                                        }
                                                        ?>
                                                        <div class="col-md-6">
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

