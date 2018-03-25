<?php
// instantiate product object
include_once 'Trip.php';
require "../function/function.php";
$conn = connection();
session_start();
if (!isset($_SESSION['user'])) {
    header("Location:../login");
} else if (!isset($_SESSION['party']) || $_SESSION['party'] == "") {
    header("location: ../partyCreate/");
} else if (!isset($_SESSION['trips'])) {
    $_SESSION['trips'] = [];
}
$party_id = $_SESSION['party'];
$query = "SELECT itenary_id
              FROM itenary 
              WHERE party_id = '$party_id'";

$result = mysqli_query($conn, $query);
$row[] = mysqli_fetch_assoc($result);
if ($row[0]["itenary_id"] != null || $row[0]["itenary_id"] != "") {
    $_SESSION['itenary'] = $row[0]["itenary_id"];
    $itenary_id = $_SESSION['itenary'];
} else {
    $status = 'SAVED';
    $query = "INSERT INTO itenary (party_id,status)
              VALUES ('$party_id','$status')";
    if ($conn->query($query)) {
        $_SESSION['itenary'] = $conn->insert_id;
        $itenary_id = $_SESSION['itenary'];
    } else {
        print("<script>alert('error while create itineary ');</script>");
    }
}
if (isset($_POST['add'])) {
    $var1 = $_POST['travel_date'];
    $date = DateTime::createFromFormat('m/d/Y', $var1);
    $travel_date = $date->format('Y-m-d');

    $trip = new Trip();
    $trip->travel_date = mysqli_real_escape_string($conn, $travel_date);
    $trip->travel_time = mysqli_real_escape_string($conn, $_POST['travel_time']);
    $trip->travel_from = mysqli_real_escape_string($conn, $_POST['travel_from']);
    $trip->travel_to = mysqli_real_escape_string($conn, $_POST['travel_to']);
    $trip->number_of_pessengers = mysqli_real_escape_string($conn, $_POST['number_of_pessengers']);
    $trip->travel_price = calculate_travel_price($_POST['travel_from'], $_POST['travel_to']);
    array_push($_SESSION['trips'], $trip);
}

if (isset($_POST['save'])) {
//    $travel_price = 'null';
    $insertQuery = "INSERT INTO trip (travel_date,travel_time,travel_from,travel_to,number_of_pessengers,travel_price,itenary_id) VALUES";
    foreach ($_SESSION['trips'] as $tripValues) {
        $insertQuery .= "('$tripValues->travel_date','$tripValues->travel_time',$tripValues->travel_from,$tripValues->travel_to,$tripValues->number_of_pessengers,$tripValues->travel_price,$itenary_id),";
    }
    $insertQuery .= ";";
    $insertQuery = str_replace(',;', ';', $insertQuery);
    if ($conn->query($insertQuery)) {
        print("<script>alert('New records created successfully');</script>");
    } else {
        print("<script>alert('error while insert data');</script>");
    }
    $_SESSION['trips'] = [];
}

function calculate_travel_price($travel_from, $travel_to)
{
    $travel_price = 0;


    return $travel_price;
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
                                                    <div class="col-md-5">
                                                        <span style="-webkit-text-fill-color: red" id="errorSpan"></span>
                                                        <select required name="travel" onchange='hideselect(this.value)';>
                                                            <option value="NONE">NONE</option>
                                                            <option value="RAIL">RAIL TRANSFERS</option>
                                                            <option value="CITY">CITY TRANSFERS</option>
                                                            <option value="AIRPORT">AIRPORT TRANSFERS</option>
                                                            <option value="GOLF">GOLF COURSES</option>
                                                        </select>
                                                    </div>
                                                    <script type="text/javascript">
                                                        window.onload = function () {
                                                            setDisable(true);
                                                        };

                                                        function hideselect(value) {
                                                            if (value === "NONE" || value === "" || value === null|| value==='un') {
                                                                setDisable(true);
                                                                console.log('click');
                                                            } else {
                                                                setDisable(false);
                                                                document.getElementById("errorSpan").textContent="";
                                                            }
                                                        }

                                                        function setDisable(booleanValue) {
                                                            document.getElementById('travel_date').disabled = booleanValue;
                                                            document.getElementById('travel_time').disabled = booleanValue;
                                                            document.getElementById('travel_from').disabled = booleanValue;
                                                            document.getElementById('travel_to').disabled = booleanValue;
                                                            document.getElementById('number_of_pessengers').disabled = booleanValue;
                                                            document.getElementById('add').disabled = booleanValue;
                                                        }
                                                        $(document).on('click',function(e){
                                                            if((e.target.id == "travel_date" || e.target.id == "travel_time" ||e.target.id == "travel_from" ||e.target.id == "travel_to" ||e.target.id == "number_of_pessengers" ||e.target.id == "add") && e.target.disabled){
                                                                // alert("The textbox is clicked.");
                                                                document.getElementById("errorSpan").textContent="Please Select a your tranfer type first";
                                                            }
                                                        });
                                                    </script>
                                                </div>
                                                <div class="row form-group" id="isSelect">
                                                    <div class="col-md-2">
                                                        <label for="login-username">Date</label>
                                                        <input data-provide="datepicker" type="text" id="travel_date"
                                                               name="travel_date"
                                                               class="form-control">
                                                    </div>

                                                    <div class="col-md-2">
                                                        <label for="login-username">Time</label>
                                                        <input type="text" id="travel_time"
                                                               name="travel_time"
                                                               class="form-control">
                                                    </div>

                                                    <div class="col-md-2">
                                                        <label for="login-username">From</label>
                                                        <input type="text" id="travel_from" name="travel_from"
                                                               class="form-control">
                                                    </div>

                                                    <div class="col-md-2">
                                                        <label for="login-username">To</label>
                                                        <input type="text" id="travel_to" name="travel_to"
                                                               class="form-control">
                                                    </div>

                                                    <div class="col-md-2">
                                                        <label for="login-username">Number</label>
                                                        <input type="number" id="number_of_pessengers"
                                                               name="number_of_pessengers"
                                                               class="form-control">
                                                    </div>

                                                    <div class="col-md-2">
                                                        <label for="login-username"></label>
                                                        <input type="submit" id="add" name="add"
                                                               class="btn btn-primary btn-block" value="Add">
                                                    </div>
                                                </div>


                                                <div class="row form-group">
                                                    <div class="col-md-12">
                                                        <table class="table table-bordered">
                                                            <thead>
                                                            <tr style="font-weight: 800;">
                                                                <th>Date</th>
                                                                <th>Time</th>
                                                                <th>Flight No</th>
                                                                <th>From</th>
                                                                <th>To</th>
                                                                <th>Number Of passengers</th>
                                                                <th>Price</th>
                                                                <th></th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            <?php
                                                            $itenary_id = $_SESSION['itenary'];
                                                            $query = "SELECT * FROM trip WHERE itenary_id='$itenary_id'";
                                                            $tripList = $conn->query($query);
                                                            if ($tripList->num_rows > 0) {
                                                                while ($rowValue = $tripList->fetch_assoc()) {
                                                                    ?>
                                                                    <tr>
                                                                        <td><?php echo($rowValue["travel_date"]); ?></td>
                                                                        <td><?php echo($rowValue["travel_time"]); ?></td>
                                                                        <td><?php
                                                                            $query = "SELECT flight_number FROM party_details WHERE party_id='$party_id'";
                                                                            $flight_number = mysqli_query($conn, $query);
                                                                            $rowflight[] = mysqli_fetch_assoc($flight_number);
                                                                            echo($rowflight[0]["flight_number"]);
                                                                            ?></td>
                                                                        <td><?php echo($rowValue["travel_from"]); ?></td>
                                                                        <td><?php echo($rowValue["travel_to"]); ?></td>
                                                                        <td><?php echo($rowValue["number_of_pessengers"]); ?></td>
                                                                        <td><?php echo($rowValue["travel_price"]); ?></td>
                                                                        <td><input type='hidden' name='trip_id'
                                                                                   value='<?php echo($rowValue["trip_id"]); ?> '>
                                                                            <input type="submit"
                                                                                   class="btn btn-sm btn-danger btn-block"
                                                                                   id="delete" name="delete"
                                                                                   value="Delete"
                                                                                   style="font-size: 12px; padding: 3px;">
                                                                        </td>
                                                                        <?php
                                                                        if (isset($_POST['delete'])) {
                                                                            $trip_id = isset($_POST['trip_id']) ? $_POST['trip_id'] : "";
                                                                            $queryDelete = "DELETE FROM trip WHERE trip_id='$trip_id'";
                                                                            if ($conn->query($queryDelete)) {
                                                                                print("<script>
//                                                                                alert('Party removed');
                                                                                window.location.href='../tripCreate';
                                                                                </script>");
                                                                            } else {
                                                                                print("<script>alert('Error when remove ! ');</script>");
                                                                            }
                                                                        }

                                                                        ?>
                                                                    </tr>

                                                                    <?php
                                                                }
                                                            }
                                                            ?>
                                                            <tr style="font-weight: 800;">
                                                                <td colspan="6">Total Price For Trip</td>
                                                                <td>120</td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>

                                                <div class="row form-group">
                                                    <div class="col-md-6">
                                                        <div class="col-md-6">
                                                            <input type="button" class="btn btn-primary btn-block"
                                                                   id="print" name="print"
                                                                   value="Print">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input type="submit" class="btn btn-primary btn-block"
                                                                   id="submit" name="submit"
                                                                   value="Submit">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="col-md-6">
                                                            <input type="button" class="btn btn-primary btn-block"
                                                                   id="confirm" name="confirm"
                                                                   value="Confirm">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input type="submit" class="btn btn-primary btn-block"
                                                                   id="save" name="save"
                                                                   value="save">
                                                        </div>
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

