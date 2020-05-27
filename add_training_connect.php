<?php
	function Connection(){
		$servername="localhost";
		$username="myuser";
		$password="mypassword";
		$dbname="training";
		$port="3306";
	
		// Create connection   	
		$dblink = mysqli_connect($servername, $username, $password,$dbname, $port);
		// Check connection
		if (!$dblink) {
			die("connection failed!: " . mysqli_connect_error());
		}
		echo "connected successfully to the database <br>";
	return $dblink;
	}
?>
