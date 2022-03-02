<?php  ob_start();  ?>
<?php
include 'db_connect.php';
if(isset($_POST['staff_login-btn'])){
	
if(isset($_POST['staff_id'])){
$staff_id = $_POST['staff_id'];
$password = $_POST['password'];
}
    
		$sql="SELECT * FROM bank_staff where staff_id='$staff_id' and Password='$password' ";
		$result = $conn->query($sql);
		$row = $result->fetch_assoc();
		if($staff_id != $row['staff_id'] && $password != $row['Password']){
			
		echo '<script>alert("Incorrect Id/Password.")</script>';
			
		}

			
		else{
			
		$_SESSION['staff_login'] = true;
		$_SESSION['staff_name'] = $row['staff_name'];
        $_SESSION['staff_id'] = $row['staff_id'];
		date_default_timezone_set('Asia/Kolkata'); 
		$_SESSION['staff_last_login'] = date("d/m/y h:i:s A");
		header('location:staff_profile.php');
		}
		
}



?>