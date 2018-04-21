<?php
/**
 * Created by PhpStorm.
 * User: jayani
 * Date: 4/12/2018
 * Time: 4:45 PM
 */

require "../function/function.php";
$conn = connection();
session_start();

if (!isset($_SESSION['user'])) {
    header("Location:../login");
} else if (!isset($_SESSION['party']) || $_SESSION['party'] == "") {
    header("location: ../partyCreate/");
}else if (!isset($_SESSION['itenary'])) {
    header("location: ../tripCreate/");
}

$user_id = $_SESSION['user'];
$party_id = $_SESSION['party'];
$itenary_id = $_SESSION['itenary'];

require('../pdf/PDF.php');
$pdf = new PDF();
$pdf->AddPage();
$pdf->SetTitle("Trips For You");

//party details
$query2 = "SELECT * from party_details WHERE party_id = '$party_id'";
$result2 = mysqli_query($conn, $query2);
$results = mysqli_fetch_assoc($result2);

$pdf->SetFont('Times','',12);
$pdf->Cell(0,10,'Lead name: '.$results["lead_name"],0,2,'L');
$pdf->Cell(0,10,'Phone number: '.$results["phone_number"],0,2,'L');
$pdf->Cell(0,10,'Email address: '.$results["email"],0,2,'L');
$pdf->Cell(0,10,'Hotel address: '.$results["hotel_address"],0,2,'L');
$pdf->Cell(0,10,'Flight Number: '.$results["flight_number"],0,2,'L');
$pdf->Cell(0,10,'Notes: '.$results["notes"],0,2,'L');

$pdf->Ln(10);

//table-Trip details
$pdf->SetFont('Arial', 'B', 9);
$query1 = "SELECT `COLUMN_NAME` FROM `INFORMATION_SCHEMA`.`COLUMNS` WHERE `TABLE_SCHEMA`='golf_travel_route' AND `TABLE_NAME`='trip'";
//    $query1 = "SELECT `COLUMN_NAME` FROM `INFORMATION_SCHEMA`.`COLUMNS` WHERE `TABLE_SCHEMA`='eigendem_golf_travel_route' AND `TABLE_NAME`='trip'";

$result1 = mysqli_query($conn, $query1);
//    $header[] = mysqli_fetch_assoc($result1);
$column_names = [];
while ($header = mysqli_fetch_assoc($result1)) {
    array_push($column_names,$header);
}
if ($column_names > 0) {
    foreach ($column_names as $heading) {
        foreach ($heading as $column_heading)
            if($column_heading != "trip_id" && $column_heading != "itenary_id" && $column_heading != "trip_status" && $column_heading != "flight_number"){
                if($column_heading == "number_of_pessengers"){
                    $column_heading = "No. pessengers";
                }
                if($column_heading == "travel_date"){
                    $column_heading = "Travel date";
                }
                if($column_heading == "travel_time"){
                    $column_heading = "Travel time";
                }
                if($column_heading == "travel_from"){
                    $column_heading = "From";
                }
                if($column_heading == "travel_to"){
                    $column_heading = "To";
                }
                if ($column_heading == "travel_price") {
                    $column_heading = "Cost ( £ )";
                }
                if ($column_heading == "car_type_id") {
                    $column_heading = "Car type";
                }
                $pdf->Cell(28, 10, $column_heading, 1,0,'C');
            }

    }
}
//code for print data
$query2 = "SELECT * from trip WHERE trip_status = 'Saved' and itenary_id = '$itenary_id' ORDER BY travel_date,travel_time";
$result2 = mysqli_query($conn, $query2);
$results = [];
while ($header1 = mysqli_fetch_assoc($result2)) {
    array_push($results,$header1);
}

if ($results > 0) {
    foreach ($results as $row) {
        $pdf->SetFont('Arial', '', 10);
        $pdf->Ln();
        $pdf->Cell(28, 10, $row['travel_date'], 1,0,'C');
        $pdf->Cell(28, 10, $row['travel_time'], 1,0,'C');

        $from = $row['travel_from'];
        $from_query = "SELECT destination_name FROM destinations WHERE destination_id = '$from'";
        $result_from = mysqli_query($conn, $from_query);
        $from_names = mysqli_fetch_assoc($result_from);
        $pdf->Cell(28, 10, $from_names["destination_name"], 1,0,'C');

        $to = $row['travel_to'];
        $to_query = "SELECT destination_name FROM destinations WHERE destination_id = '$to'";
        $result_to = mysqli_query($conn, $to_query);
        $to_names = mysqli_fetch_assoc($result_to);
        $pdf->Cell(28, 10, $to_names["destination_name"], 1,0,'C');

        $pdf->Cell(28, 10, $row['number_of_pessengers'], 1,0,'C');

        $car_id= $row['car_type_id'];

        $car_type= null;
        if($car_id == 1){
            $car_type = "Saloon";
        }elseif ($car_id== 2){
            $car_type = "Van";
        }else{
            $car_type="Van + Traier";
        }
        $pdf->Cell(28, 10,$car_type, 1,0,'C');
        $pdf->Cell(28, 10, $row['travel_price'], 1,0,'C');

    }
}
$pdf->Ln(15);

$query3 = "SELECT total_price from itenary WHERE itenary_id = '$itenary_id'";
$result3 = mysqli_query($conn, $query3);
$results3 = mysqli_fetch_assoc($result3);

$pdf->SetFont('Times','',12);
$pdf->Cell(0,10,'Total Price: '.$results3["total_price"],0,2,'R');

$pdf->Cell(0,10,'Status: Saved',0,2,'L');
$pdf->Cell(0,10,'Authorised: Calvin J Brown',0,2,'L');
$pdf->Cell(0,10,'Contact number: +98-7635190',0,2,'L');

$pdf->Output();