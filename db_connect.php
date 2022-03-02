<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "bnkms";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
	header('location:server_down.php');
} 
else{
	// echo "Connection Established";
}

?>