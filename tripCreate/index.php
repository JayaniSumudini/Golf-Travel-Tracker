<?php
// instantiate product object -----------------------------------------------------
include_once 'Trip.php';
require "../function/function.php";
$conn = connection();
session_start();



$query = "SELECT * FROM destinations  WHERE destination_type = 'PLACE'";
$places_result = mysqli_query($conn, $query);
$places[] = mysqli_fetch_assoc($places_result);


//check session keys and redirect to right place -----------------------------------------------------
if (!isset($_SESSION['user'])) {
    header("Location:../login");
} else if (!isset($_SESSION['party']) || $_SESSION['party'] == "") {
    header("location: ../partyCreate/");
} else if (!isset($_SESSION['trips'])) {
    $_SESSION['trips'] = [];
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
        print("<script>alert('error while create itineary ');</script>");
    }
}

// Add new row to the plan  -----------------------------------------------------
if (isset($_POST['add'])) {
    $trip = new Trip();
    $trip->travel_date = convert_date_format($_POST['travel_date']);
    $trip->travel_time = mysqli_real_escape_string($conn, $_POST['travel_time']);
    $trip->travel_from_to = remove_first_character($_POST['travel_from_to']);
    $trip->place_from_to = mysqli_real_escape_string($conn, $_POST['place_from_to']);
    $trip->number_of_pessengers = mysqli_real_escape_string($conn, $_POST['number_of_pessengers']);
    $trip->number_of_saloon = mysqli_real_escape_string($conn, $_POST['number_of_saloon']);
    $trip->number_of_van = mysqli_real_escape_string($conn, $_POST['number_of_van']);
    $trip->number_of_bus = mysqli_real_escape_string($conn, $_POST['number_of_bus']);
    $trip->number_of_caoch = mysqli_real_escape_string($conn, $_POST['number_of_caoch']);
    $trip->travel_price = calculate_travel_price($_POST['place_from_to'],$_POST['number_of_saloon'],$_POST['number_of_van'],$_POST['number_of_bus'],$_POST['number_of_caoch'],$conn);
    array_push($_SESSION['trips'], $trip);
}

// Saving new iterenary to DB when creating a new one  -----------------------------------------------------
if (isset($_POST['save'])) {
    $query = "SELECT total_price FROM itenary WHERE itenary_id='$itenary_id'";
    $var1 = mysqli_query($conn, $query);
    $total_prices[] = mysqli_fetch_assoc($var1);
    $total_price = $total_prices[0]["total_price"];


    $insertQuery = "INSERT INTO trip (travel_date,travel_time,travel_from_to,place_from_to,number_of_pessengers,travel_price,itenary_id,number_of_saloon,number_of_van,number_of_bus,number_of_caoch) VALUES";
    foreach ($_SESSION['trips'] as $tripValues) {
        $total_price = $total_price + $tripValues->travel_price;
        $insertQuery .= "('$tripValues->travel_date','$tripValues->travel_time',$tripValues->travel_from_to,$tripValues->place_from_to,$tripValues->number_of_pessengers,$tripValues->travel_price,$itenary_id,$tripValues->number_of_saloon,$tripValues->number_of_van,$tripValues->number_of_bus,$tripValues->number_of_caoch),";
    }
    $insertQuery .= ";";
    $insertQuery = str_replace(',;', ';', $insertQuery);
    if ($conn->query($insertQuery)) {
        print("<script>alert('New records created successfully');</script>");
    } else {
        print("<script>alert('error while insert data');</script>");
    }

    $updateQuery = "UPDATE itenary SET total_price = $total_price WHERE itenary_id='$itenary_id'";
    if ($conn->query($updateQuery)) {
        $total_prices=null;
    }else{

    }
    $_SESSION['trips'] = [];
}

function calculate_travel_price($place_from_to,$number_of_saloon,$number_of_van,$number_of_bus,$number_of_caoch,$conn)
{
    $travel_price = 0;
    $query = "SELECT * FROM destinations  WHERE destination_id = '$place_from_to'";
    $result = mysqli_query($conn, $query);
    $row[] = mysqli_fetch_assoc($result);
    $travel_price = $travel_price + ($row[0]["saloon_price"]*$number_of_saloon);
    $travel_price = $travel_price + ($row[0]["van_price"]*$number_of_van);
    $travel_price = $travel_price + ($row[0]["mini_bus_price"]*$number_of_bus);
    $travel_price = $travel_price + ($row[0]["coach_price"]*$number_of_caoch);

    return $travel_price;
}
function convert_date_format($travel_date){
    $date = DateTime::createFromFormat('m/d/Y', $travel_date);
    return $date->format('Y-m-d');
}

function remove_first_character($variable){
    return substr($variable, 1);
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
                                                <!-- <div class="row form-group">
                                                    <div class="col-md-5">
                                                        <span style="-webkit-text-fill-color: red" id="errorSpan"></span>
                                                        <select class="form-control" required name="travel" onchange='hideselect(this.value)';>
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
                                                            document.getElementById('travel_from_to').disabled = booleanValue;
                                                            document.getElementById('place_from_to').disabled = booleanValue;
                                                            document.getElementById('number_of_pessengers').disabled = booleanValue;
                                                            document.getElementById('add').disabled = booleanValue;
                                                        }
                                                        $(document).on('click',function(e){
                                                            if((e.target.id == "travel_date" || e.target.id == "travel_time" ||e.target.id == "travel_from_to" ||e.target.id == "place_from_to" ||e.target.id == "number_of_pessengers" ||e.target.id == "add") && e.target.disabled){
                                                                // alert("The textbox is clicked.");
                                                                document.getElementById("errorSpan").textContent="Please Select a your tranfer type first";
                                                            }
                                                        });
                                                    </script>
                                                </div> -->
                                                <div class="row form-group">
                                                    <span style="-webkit-text-fill-color: red" id="errorSpan"></span>
                                                </div>
                                                <div style="border:solid 1px #09C6AB;border-radius: 5px; padding: 16px;margin-bottom: 20px">
                                                <h4>Add New Trip to your plan</h4>
                                                <div class="row form-group" id="isSelect">
                                                    <!-- <div class="col-md-2">
                                                        <label for="login-username">Type</label>

                                                        <select class="form-control" required name="travel"
                                                                onchange='hideselect(this.value)' ;>
                                                            <option value="NONE">NONE</option>
                                                            <option value="RAIL">RAIL TRANSFERS</option>
                                                            <option value="CITY">CITY TRANSFERS</option>
                                                            <option value="AIRPORT">AIRPORT TRANSFERS</option>
                                                            <option value="GOLF">GOLF COURSES</option>
                                                        </select>
                                                        <script type="text/javascript">
                                                            window.onload = function () {
                                                                setDisable(true);
                                                            };

                                                            function hideselect(value) {
                                                                if (value === "NONE" || value === "" || value === null || value === 'un') {
                                                                    setDisable(true);
                                                                    console.log('click');
                                                                } else {
                                                                    setDisable(false);
                                                                    document.getElementById("errorSpan").textContent = "";
                                                                }
                                                            }

                                                            function setDisable(booleanValue) {
                                                                document.getElementById('travel_date').disabled = booleanValue;
                                                                document.getElementById('travel_time').disabled = booleanValue;
                                                                document.getElementById('travel_from_to').disabled = booleanValue;
                                                                document.getElementById('place_from_to').disabled = booleanValue;
                                                                document.getElementById('number_of_pessengers').disabled = booleanValue;
                                                                document.getElementById('add').disabled = booleanValue;
                                                            }

                                                            $(document).on('click', function (e) {
                                                                if ((e.target.id == "travel_date" || e.target.id == "travel_time" || e.target.id == "travel_from_to" || e.target.id == "place_from_to" || e.target.id == "number_of_pessengers" || e.target.id == "add") && e.target.disabled) {
                                                                    // alert("The textbox is clicked.");
                                                                    document.getElementById("errorSpan").textContent = "Please Select a your tranfer type first";
                                                                }
                                                            });
                                                        </script>
                                                    </div> -->

                                                    <div class="col-md-2">
                                                        <label for="login-username">Date</label>
                                                        <input data-provide="datepicker" type="text" id="travel_date" required
                                                               name="travel_date"
                                                               class="form-control">
                                                    </div>

                                                    <div class="col-md-2">
                                                        <label for="login-username">Time</label>
                                                        <input type="text" id="travel_time" required
                                                               name="travel_time"
                                                               class="form-control">
                                                    </div>

                                                    <div class="col-md-2">
                                                        <label for="login-username">From/To</label>
                                                        <select class="form-control" required name="travel_from_to">
                                                        <?php
                                                        $query = "SELECT * FROM destinations  WHERE destination_type = 'TRAVEL'";
                                                        $travelList = $conn->query($query);
                                                        if ($travelList->num_rows > 0) {
                                                            while ($rowValue = $travelList->fetch_assoc()) {
                                                                ?>
                                                                    <option value="T<?php echo($rowValue["destination_id"]); ?>">To <?php echo($rowValue["destination_name"]); ?></option>
                                                                    <option value="F<?php echo($rowValue["destination_id"]); ?>">From <?php echo($rowValue["destination_name"]); ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                        </select>
                                                    </div>

                                                    <div class="col-md-2">
                                                        <label for="login-username">Place From/To</label>
                                                        <select class="form-control" required name="place_from_to" >
                                                        <?php
                                                        $query = "SELECT * FROM destinations  WHERE destination_type = 'PLACE'";
                                                        $placeList = $conn->query($query);
                                                        if ($placeList->num_rows > 0) {
                                                            while ($rowValue = $placeList->fetch_assoc()) {
                                                                ?>
                                                                    <option value="<?php echo($rowValue["destination_id"]); ?>"><?php echo($rowValue["destination_name"]); ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                        </select>
                                                    </div>

<!--                                                    <div class="col-md-2">-->
<!--                                                        <label for="login-username">Distance</label>-->
<!--                                                        <input type="number" id="distance" disabled-->
<!--                                                               name="distance"-->
<!--                                                               class="form-control">-->
<!--                                                    </div>-->

<!--                                                    <div class="col-md-2">-->
<!--                                                        <label for="login-username">Travel Time</label>-->
<!--                                                        <input type="number" id="travel_time" disabled-->
<!--                                                               name="travel_time"-->
<!--                                                               class="form-control">-->
<!--                                                    </div>-->

                                                    <div class="col-md-2">
                                                        <label for="login-username">Number of pessengers</label>
                                                        <input type="number" id="number_of_pessengers" required
                                                               name="number_of_pessengers"
                                                               class="form-control">
                                                    </div>

                                                </div>

                                                <div class="row form-group" id="isSelect">
                                                    <div class="col-md-2">
                                                        <label for="login-username">Saloon (4 pax)</label>
                                                        <input type="number" id="number_of_saloon" required
                                                               name="number_of_saloon"
                                                               class="form-control">
                                                    </div>

                                                    <div class="col-md-2">
                                                        <label for="login-username">Van (8 pax)</label>
                                                        <input type="number" id="number_of_van" required
                                                               name="number_of_van"
                                                               class="form-control">
                                                    </div>

                                                    <div class="col-md-2">
                                                        <label for="login-username">Mini Bus (12 pax)</label>
                                                        <input type="number" id="number_of_bus" required
                                                               name="number_of_bus"
                                                               class="form-control">
                                                    </div>

                                                    <div class="col-md-2">
                                                        <label for="login-username">Caoch (16 pax)</label>
                                                        <input type="number" id="number_of_caoch" required
                                                               name="number_of_caoch"
                                                               class="form-control">
                                                    </div>

<!--                                                    <div class="col-md-2">-->
<!--                                                        <label for="login-username">Price(£)</label>-->
<!--                                                        <input type="number" id="travel_price" disabled-->
<!--                                                               name="travel_price"-->
<!--                                                               class="form-control">-->
<!--                                                    </div>-->

                                                    <div class="col-md-2">
                                                        <label for="login-username"></label>
                                                        <input type="submit" id="add" name="add"
                                                           class="btn btn-sm btn-primary " value="Add" style="float: right;margin-top: 30px;">
                                                    </div>

                                                    <div class="col-md-2">
                                                        <input type="button" id="added_count" name="added_count"
                                                               class="btn btn-md btn-info" value="<?php
                                                                echo(sizeof($_SESSION['trips']));
                                                                echo(" Trips added");?>" style="float: right;margin-top: 30px;">
                                                    </div>

                                                </div>
</div>
                                                <!-- <div class="row">
                                                    <input type="submit" id="add" name="add"
                                                           class="btn btn-primary" value="Add" style="float: right">
                                                </div> -->

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
                                                                <th>Passengers</th>
                                                                <th>Saloon</th>
                                                                <th>Van</th>
                                                                <th>Mini Bus</th>
                                                                <th>Caoch</th>
                                                                <th>Price(£)</th>
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
                                                                            $flight_numbers[] = mysqli_fetch_assoc($flight_number);
                                                                            echo($flight_numbers[0]["flight_number"]);
                                                                            ?></td>
                                                                        <td>
                                                                            <?php
                                                                                $destination_id1 = $rowValue["travel_from_to"];
                                                                                $query1 = "SELECT destination_name FROM destinations WHERE destination_id = '$destination_id1'";
                                                                                $destination_name1 = mysqli_query($conn, $query1);
                                                                                $destination_names1[] = mysqli_fetch_assoc($destination_name1);
                                                                                echo($destination_names1[0]["destination_name"]);
                                                                                $destination_names1 = null;
                                                                             ?></td>

<!--                                                                        <td>--><?php //echo($rowValue["place_from_to"]); ?><!--</td>-->
                                                                        <td><?php
                                                                            $destination_id2 = $rowValue["place_from_to"];
                                                                            $query2 = "SELECT destination_name FROM destinations WHERE destination_id = '$destination_id2'";
                                                                            $destination_name2 = mysqli_query($conn, $query2);
                                                                            $destination_names2[] = mysqli_fetch_assoc($destination_name2);
                                                                            echo($destination_names2[0]["destination_name"]);
                                                                            $destination_names2 = null;
                                                                            ?></td>
                                                                        <td><?php echo($rowValue["number_of_pessengers"]); ?></td>
                                                                        <td><?php echo($rowValue["number_of_saloon"]); ?></td>
                                                                        <td><?php echo($rowValue["number_of_van"]); ?></td>
                                                                        <td><?php echo($rowValue["number_of_bus"]); ?></td>
                                                                        <td><?php echo($rowValue["number_of_caoch"]); ?></td>
                                                                        <td><?php echo($rowValue["travel_price"]); ?></td>
                                                                        <td>
                                                                            <form method="post" action="">
                                                                                <input type='hidden' name='trip_id'
                                                                                       value='<?php echo($rowValue["trip_id"]); ?> '>
                                                                                <input type="submit"
                                                                                       class="btn btn-sm btn-danger"
                                                                                       id="delete" name="delete"
                                                                                       value="Delete"
                                                                                       style="font-size: 12px; padding: 3px;">
                                                                                <input type="submit"
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
                                                                                $total_prices=null;
                                                                            }else{

                                                                            }
                                                                            $queryDelete = "DELETE FROM trip WHERE trip_id='$trip_id'";
                                                                            if ($conn->query($queryDelete)) {
                                                                                print("<script>
//                                                                                alert('Party removed');
                                                                                window.location.href='../tripCreate';
                                                                                </script>");
                                                                            } else {
                                                                                print("<script>alert('Error when remove ! ');</script>");
                                                                            }
                                                                            $_POST = array();
                                                                        }

                                                                        ?>
                                                                    </tr>

                                                                    <?php
                                                                }
                                                            }
                                                            ?>
                                                            <tr style="font-weight: 800;">
                                                                <td colspan="10">Total Price For Trip</td>
                                                                <td><?php
                                                                    $query = "SELECT total_price FROM itenary WHERE itenary_id='$itenary_id'";
                                                                    $total_price = mysqli_query($conn, $query);
                                                                    $total_prices[] = mysqli_fetch_assoc($total_price);
                                                                    echo($total_prices[0]["total_price"]);
                                                                    $total_prices=null;
                                                                    ?></td>
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

