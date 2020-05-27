<?php

include 'dbh.php';
include 'live.php';
include 'calibrationangle.php';

session_start();

$servername = "localhost";
$username = "myuser";
$password = "mypassword";
$dbname = "calibration";
$port = "3306";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$thevalue = $_SESSION["live_angle"];
//echo $thevalue;

if (isset($_POST['nw_update'])) {

    if (empty($thevalue)) {

        die("Enter plannername");
    } else {




        $sql = "INSERT INTO cal_angle (angle) VALUES ('$thevalue')";

        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();

        echo "<br> ". $_SESSION["calangle"];

        $_SESSION["calangle"] = $_SESSION["live_angle"];
        echo "<br> ". $_SESSION["live_angle"];
        echo "<br> ". $_SESSION["calangle"];


    }
}
?>


