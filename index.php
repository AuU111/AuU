<?php

session_start();

$_SESSION["repcounter"] = 0;

include 'dbh.php';
include 'live.php';
include 'calibrationangle.php';
include 'counter.php';
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Do you even lift, bro?</title>
	<link rel="shortcut icon" href="img/favicon.ico">
	<!-- Bootstrap CSS https://getbootstrap.com/docs/4.3/getting-started/introduction/ -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<!-- Style.css -->
	<link rel="stylesheet" href="css/style.css">
	<!-- Lightbox Image Gallery https://cdnjs.com/libraries/lightbox2 -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.1/css/lightbox.min.css">
	<!-- Google Fonts https://fonts.google.com/ -->
	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
</head>
<body data-spy="scroll" data-target="#navbarResponsive">

	<!-- Start Home Section -->
	<div id="home">

		<!-- Navigation -->
		<nav class="navbar navbar-expand-md fixed-top">
			<a href="#" class="navbar-brand"><img src="img/nest.png" alt=""></a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive">
				<span class="custom-toggler-icon"><i class="fas fa-bars"></i></span>
			</button>

			<div class="collapse navbar-collapse" id="navbarResponsive">
				<ul class="navbar-nav ml-auto">
					<li class="nav-item">
						<a href="#home" class="nav-link">Home</a>
					</li>
					<li class="nav-item">
						<a href="#calibrate" class="nav-link">Calibrate</a>
					</li>
                   <li class="nav-item">
                        <a href="#history" class="nav-link">History</a>
                    </li>
                    <li class="nav-item">
                        <a href="#testimonials" class="nav-link">Rep Counter</a>
                    </li>
                </ul>
            </div>
        </nav>
                        <!-- End Navigation -->

		<!-- Start Landing Page Image-->
		<div class="landing">
            <img src="landing.jpg" alt="Backsquat" width=100%>
			<div class="home-wrap">
				<div class="home-inner"></div>
			</div>
		</div>
		<!-- End Landing Page Image -->

		<!-- Start Landing Page Content -->
		<div class="col-12 caption">
			<h1 class="text-light text-uppercase pb-3 pb-md-4">Do you even lift, bro?</h1>
			<a href="#calibrate" class="btn btn-outline-light">Get Started</a>
		</div>
		<!-- End Landing Page Content-->

	</div>
	<!-- End Home Section -->


	<!-- Start Calibrate Section -->
	<div id="calibrate" class="offset">

		<!-- Start Jumbotron -->
		<div class="jumbotron text-center pt-5 mb-0">

			<h2 class="heading">Calibrate</h2>
			<div class="heading-underline"></div>

			<!-- Start Row -->
			<div class="row justify-content-center mt-5">

				<div class="col-md-6 col-lg-4 calibrate pb-4 pb-lg-2">

                    <h4 class="text-uppercase pt-3 pb-2"><b><i>'Squat Mate'</i></b> Current Reading</h4>
					<p class="lead">

                    <div id="show"></div>
                    <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
                    <script type="text/javascript" src="jquery.js"></script>
                    <script type="text/javascript">
                        $(document).ready(function() {
                            setInterval(function () {
                                $('#show').load('live.php')
                            }, 1000);
                        });
                    </script>
                    </p>
				</div>

				<div class="col-md-6 col-lg-4 calibrate pb-4 pb-lg-2">
					<i class="fas fa-arrow-circle-down fa-3x"></i>
					<h4 class="text-uppercase pt-3 pb-2"><b><i>Calibration Button</i></b></h4>

                    <td width="108" height="52" align="left" valign="bottom">
                        <form method="POST" action=''>
                            <input type="SUBMIT" class="style19" name="use_button" value="Calibrate NOW"></form>

                        <?php
                            if(isset($_POST['use_button'])) {
                                $_SESSION["calangle"] = $_SESSION["live_angle"];
                            }
                        echo "Current calibration distance is " . $_SESSION["calangle"] . "cm";
                        ?>
                    </td>
				</div>
			</div>
			<!-- End Row -->
		</div>
		<!-- End Jumbotron -->
	</div>
	<!-- End Calibrate Section -->

    <!-- Start HISTORY Section -->
    <div id="history" class="offset">

        <!-- Start Container-Fluid -->
        <div class="container-fluid text-center py-5 mx-0">

            <h2 class="heading">History</h2>
            <div class="heading-underline"></div>

            <div class="row justify-content-center">
                <div class="col-10">

                    <form action="" method="post">
                        How many reps in last set?<br>
                        <input type="text" name="reps"><br><br>
                        <input type="submit"><br>
                    </form>



                    <?php
                    $lastreps = $_POST["reps"];

                    $servername = "localhost";
                    $username = "myuser";
                    $password = "mypassword";
                    $dbname = "training";
                    $port = "3306";

                    $conn = mysqli_connect($servername, $username, $password, $dbname, $port);

                    // Check connection
                    if (!$conn) {
                        die('Connect Error (' . mysqli_connect_errno() . ') '
                            . mysqli_connect_error());
                    }

                    echo "<div class='row-fluid'>";

                    echo "<div class='col-xs-6'>";
                    echo "<div class='table-responsive'>";

                    echo "<table class='table table-striped table-hover table-inverse'>";

                    echo "<tr>";
                    echo "<th>Time</th>";
                    echo "<th>Depth (cm)</th>";
                    echo "<th>Speed</th>";
                    echo "<th>Good Rep?</th>";
                    echo "</tr>";

                    $sql = "SELECT timestamp, distance, speed FROM lifting ORDER BY timestamp DESC limit $lastreps";
                    $result = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . $row["timestamp"] . "</td>";
                            echo "<td>" . $row["distance"] . "</td>";
                            echo "<td>" . $row["speed"] . "</td>";
                            if ($_SESSION["calangle"] >= $row["distance"]) {
                                $tempVar = 'Success';
                            } else {
                                $tempVar = 'Fail';
                            }
                            echo "<td>" . $tempVar . "</td>";
                            echo "</tr>";
                        }

                    } else {

                    }
                    echo "</table>";
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";
                    ?>
                </div>
            </div>
        </div>
        <!-- End Container-Fluid -->
    </div>
    <!-- End HISTORY Section -->

	<div id="testimonials" class="offset">

        <!-- Start  (REP COUNTER) Section -->
		<div class="jumbotron text-center pb-5 mb-0">

			<h2 class="heading">Rep Counter</h2>
			<div class="heading-underline"></div>

			<div class="row justify-content-center">

				<div class="text-center">  <!-- original     <div class="col-11 col-sm-10">  -->
                    <div class="row pt-3">
                        <p class="lead">

                        <div id="showcounter"></div>
                        <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
                        <script type="text/javascript" src="jquery.js"></script>
                        <script type="text/javascript">
                            $(document).ready(function() {
                                setInterval(function () {
                                    $('#showcounter').load('counter.php')
                                }, 3000);
                            });
                        </script>
                        </p>

                    </div>

                    <div>
                    <br>
                     <form action="" method="post">
                        <input type="hidden" value="t">
                        <input type="submit" value="Reset Rep Count" name="reset_count"><br>
                    </form>

                        <?php
                        if (isset($_POST['reset_count']) ) {
                            $_SESSION["repcounter"] = 0;
                        }
                        ?>
					</div> <!-- End Row -->
				</div> <!-- End Column-->
			</div> <!-- End Row -->
		</div>
		<!-- End Jumbotron -->
	</div>
	<!-- End Testimonials Section -->
</body>
</html>