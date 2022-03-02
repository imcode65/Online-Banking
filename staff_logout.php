<?php 



	session_start();
	
		include 'db_connect.php';
		// Update date & time
		
		$staff_id=$_SESSION['staff_id'];
		$last_login=$_SESSION['staff_last_login'];
		
		$sql="UPDATE bank_staff SET Last_login = '$last_login' WHERE bank_staff.Staff_id ='$staff_id' ";
		$conn->query($sql);
	
		session_destroy();
		session_unset();
	
	header('location:staff_login.php');
	
	
?>