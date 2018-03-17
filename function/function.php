<?php


require "define.php";

function connection()
{
    $con = mysqli_connect(HOST, UNAME, PW, DBNAME);
    if (mysqli_connect_error()) {
        echo("Failed to connect to MySQL:" . mysqli_connect_error());
    } else return $con;
}
