<?php
   	include("add_training_connect.php");
   	$dblink=Connection();

	$query = "INSERT INTO lifting (distance, speed) 
	          VALUES (".$_GET["sensor1"].", ".$_GET["sensor2"].")";
	
	if (mysqli_query($dblink, $query)) {
		echo "New record created successfully";
	} else {
		echo "Error: " . $query . "<br>" . mysqli_error($dblink);
	}
	mysqli_close($dblink);
?>
