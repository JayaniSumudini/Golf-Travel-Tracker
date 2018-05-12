<?php
session_start();

if (!isset($_SESSION['user']) || !isset($_SESSION['user_role'])) {
    header("Location:../login");
} elseif ($_SESSION['user_role'] != 'ADMIN') {
    header("Location:../login");
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
    <div class="col-sm-12"><h2>SUMMERY</h2></div>

    <div class="col-sm-4">

        <div class="col-sm-12">
            <?php
            $query = "SELECT COUNT(*) AS sum FROM user_details";
            $result = $conn->query($query);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    ?>
                    <div style="width: 90%;background: #002a80;color: #ffffff;border-radius: 5px;padding: 10px;text-align: center;margin: 5px auto">
                        <span>Total Users </span><br>
                        <span style="font-size: 60px;font-weight: bolder; line-height: 1 "><?php echo($row["sum"]); ?></span>
                    </div>
                    <?php
                };
            }
            ?>
        </div>

        <div class="col-sm-12">
            <?php
            $query = "SELECT COUNT(*) AS sum FROM party_details";
            $result = $conn->query($query);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    ?>
                    <div style="width: 90%;background: #002a80;color: #ffffff;border-radius: 5px;padding: 10px;text-align: center;margin: 5px auto">
                        <span>Total Parties </span><br>
                        <span style="font-size: 60px;font-weight: bolder; line-height: 1 "><?php echo($row["sum"]); ?></span>
                    </div>
                    <?php
                };
            }
            ?>
        </div>
    </div>
    <div class="col-sm-8">

        <!--        ====================================================================================================-->
        <canvas id="myChart" width="500" height="300"></canvas>


        <script>
            var ctx = document.getElementById("myChart").getContext("2d");
            var myChart = new Chart(ctx, {
                type: "horizontalBar",
                data: {
                    labels: ["ADDED","SAVED","SUBMITED","ADMIN CHANGED","TO Be ACCEPTANCE","ACCEPTED"],
                    datasets: [{
                        data: [
                            <?php
                            $save = $subbmited = $accepted = $adminChanged = 0;

                            $query = "SELECT COUNT(*) AS sum FROM trip WHERE trip_status = 'Added'";
                            $result = $conn->query($query);
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo($row["sum"]);
                                }
                            }
                            ?> ,
                            <?php
                            $save = $subbmited = $accepted = $adminChanged = 0;

                            $query = "SELECT COUNT(*) AS sum FROM trip WHERE trip_status = 'Saved'";
                            $result = $conn->query($query);
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo($row["sum"]);
                                }
                            }
                            ?> ,
                            <?php
                            $save = $subbmited = $accepted = $adminChanged = 0;

                            $query = "SELECT COUNT(*) AS sum FROM trip WHERE trip_status = 'Submited'";
                            $result = $conn->query($query);
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo($row["sum"]);
                                }
                            }
                            ?> ,
                            <?php
                            $save = $subbmited = $accepted = $adminChanged = 0;

                            $query = "SELECT COUNT(*) AS sum FROM trip WHERE trip_status = 'AdminChanged'";
                            $result = $conn->query($query);
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo($row["sum"]);
                                }
                            }
                            ?> ,
                            <?php
                            $save = $subbmited = $accepted = $adminChanged = 0;

                            $query = "SELECT COUNT(*) AS sum FROM trip WHERE trip_status = 'ToBeAcceptance'";
                            $result = $conn->query($query);
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo($row["sum"]);
                                }
                            }
                            ?>,
                            <?php
                            $save = $subbmited = $accepted = $adminChanged = 0;

                            $query = "SELECT COUNT(*) AS sum FROM trip WHERE trip_status = 'Accepted'";
                            $result = $conn->query($query);
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo($row["sum"]);
                                }
                            }
                            ?> ],
                        backgroundColor: ["#ff2a2f","#0e2eff","#74ff26","#ffbb56","#ff05bf","#090909"],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    },
                    title: {
                        display: true,
                        text: 'Summery of total trip states'
                    },
                    legend: false
                }
            });
        </script>

        <!--        ==================================================================================================-->

    </div>


</div>


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
