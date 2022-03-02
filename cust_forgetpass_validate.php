<?php
	$customer_id = $_POST['cust_id'];
	$debitcard = $_POST['dbt_crd'];
	$dbt_pin = $_POST['dbt_crdpin'];
	$mob_no = $_POST['mobile_no'];
	
	include 'db_connect.php';
	
	$sql = "SELECT Username,Password,Customer_ID, Mobile_no,Debit_Card_No,Debit_Card_Pin FROM bank_customers WHERE Customer_ID = '$customer_id'";
	$result = $conn->query($sql);

	if(!is_numeric($customer_id) || !is_numeric($debitcard) || !is_numeric($dbt_pin) || !is_numeric($mob_no)){
		echo '<script>alert("Incorrect format")</script>';	
	}
	
	else{

	if($result->num_rows > 0){
	$row = $result->fetch_assoc();
	if($mob_no == $row['Mobile_no'] && $debitcard == $row['Debit_Card_No'] && $dbt_pin == $row['Debit_Card_Pin']){

			$otp = "SBI".mt_rand(10000,99999);
			$_SESSION['cust_id'] = $row['Customer_ID'];
			$_SESSION['forgetpass_otp'] = $otp;
			$hidden_mob_no = substr($mob_no, 0, 3)."XXXX".substr($mob_no, 7, 10);
		//-------------------------------------------------------------------------------	
		//SMS Integration for OTP  -----------------------------------------------------
						
					require('textlocal.class.php');
					$apikey = 'Mzie479SxfY-Z7slYf9AI3zVXCAu0G5skUBQVYOfRU';
					$textlocal = new Textlocal(false,false,$apikey);
					$numbers = array($mob_no);
					$sender = 'TXTLCL';
					$message = 'Hello '.$row['Username'].' your OTP is : '.$otp;
					
						try {
							$result = $textlocal->sendSms($numbers, $message, $sender);
							print_r($result);
						} catch (Exception $e) {
							die('Error: ' . $e->getMessage());
						}
						
		//--------------------------------------------------------------------------------------				
		//--------------------------------------------------------------------------------------		
		echo '<script>alert("OTP sent to your registered mobile number '.$hidden_mob_no.' \nPlease verify to get your password")
		location="cust_forgetpassotpverify.php"</script>';

		
		
	}
	

		else{

			if($mob_no != $row['Mobile_no'] && $debitcard == $row['Debit_Card_No'] && $dbt_pin == $row['Debit_Card_Pin']){

				echo '<script>alert("Incorrect Mobile number.\n Please enter registered mobile number.")</script>';
			}
			else{
				if($mob_no == $row['Mobile_no'] && $debitcard != $row['Debit_Card_No'] && $dbt_pin == $row['Debit_Card_Pin']){

					echo '<script>alert("Incorrect Decit Card number")</script>';
				}
				else{

					if($mob_no == $row['Mobile_no'] && $debitcard == $row['Debit_Card_No'] && $dbt_pin != $row['Debit_Card_Pin']){
						echo '<script>alert("Incorrect Decit Card pin.")</script>';
					}
						else{
							if($mob_no != $row['Mobile_no'] && $debitcard != $row['Debit_Card_No'] && $dbt_pin != $row['Debit_Card_Pin']){
								echo '<script>alert("All fields incorrect.")</script>';
							}
							else{
								if($mob_no == $row['Mobile_no'] && $debitcard != $row['Debit_Card_No'] && $dbt_pin != $row['Debit_Card_Pin']){
								echo '<script>alert("Incorrect Debit Card details.")</script>';
								}
								else{
									if($mob_no != $row['Mobile_no'] && $debitcard != $row['Debit_Card_No']){

										echo '<script>alert("Mobile number and Debit Card Number mismatch")</script>';
									}
							
								}
							}
							
						}
					}
				}

			}
		
	}

	else{

		echo '<script>alert("Customer not found!")</script>';
	}

}

?>