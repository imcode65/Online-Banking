<?php  ob_start();  ?>
<?php
include 'db_connect.php';
if(isset($_POST['login-btn'])){
	
if(isset($_POST['customer_id'])){

  //with hashing
// $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

$password = $_POST['password'];
$customer_id = $_POST['customer_id'];
}
    
		$sql="SELECT * FROM bank_customers where Customer_ID='$customer_id' and Password='$password' ";
		$result = $conn->query($sql);
		$row = $result->fetch_assoc();
		if($customer_id != $row['Customer_ID'] && $password != $row['Password']){
			
		echo '<script>alert("Incorrect Id/Password.")</script>';
			
		
	}
			
			
		else{
			
      
		$_SESSION['customer_login'] = true;
        $_SESSION['Balance'] = $row['Current_Balance'];
		$_SESSION['Username'] = $row['Username'];
		$_SESSION['Account_No'] = $row['Account_no'];
		$_SESSION['Account_type'] = $row['Account_type'];
		$_SESSION['Customer_Photo'] = $row['Customer_Photo'];
		$_SESSION['Mobile_no']	= $row['Mobile_no'];
		$_SESSION['IFSC_Code'] = $row['IFSC_Code'];
		$_SESSION['Email_ID']= $row['Email_ID'];
		$_SESSION['customer_Id'] = $customer_id;
		$_SESSION['Debit_Card_No'] =$row['Debit_Card_No'];
		$_SESSION['Nominee_name'] = $row['Nominee_name'];
		$_SESSION['Nominee_ac_no'] = $row['Nominee_ac_no'];
		$_SESSION['Branch'] = $row['Branch'];
		$_SESSION['Cheque'] = $row['Cheque'];
		date_default_timezone_set('Asia/Kolkata'); 
		$_SESSION['this_login'] = date("d/m/y h:i:s A");

 //SMS Integration to notify customer login----------------------------------

				/*	$mob_no = $row['Mobile_no'];
					require('textlocal.class.php');
					$apikey = 'Mzie479SxfY-Z7slYf9AI3zVXCAu0G5skUBQVYOfRU';
					$textlocal = new Textlocal(false,false,$apikey);
					$numbers = array($mob_no);
					$sender = 'TXTLCL';
					$ipaddress = $_SERVER['REMOTE_ADDR'];
					$message = 'Hello '.$row['Username'].' you just logged in to your Internet banking account IP Address : '.$ipaddress.'';
					

					
						try {
							$result = $textlocal->sendSms($numbers, $message, $sender);
							print_r($result);
						} catch (Exception $e) {
							die('Error: ' . $e->getMessage());
						}  */

	//-------------------------------------------------------------------------

		header('location:customer_profile.php');
		}

}



?>