<?php
session_start();

$servername = "localhost";
$username = "myuser";
$password = "mypassword";
$dbname = "training";
$port = "3306";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname, $port);

// Check connection
if (!$conn) {
    die('Connect Error (' . mysqli_connect_errno() . ') '
        . mysqli_connect_error());
}

$sql = "SELECT timestamp, distance FROM lifting ORDER BY timestamp DESC LIMIT 1";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
            echo "The live distance being received is " . $row['distance'] . "cm";
        $_SESSION["live_angle"] = $row['distance'];
    }
} else {

}
?>
