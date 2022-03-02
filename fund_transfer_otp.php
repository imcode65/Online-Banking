<html>
	<head><title>OTP Verification</title>
	<link rel="stylesheet" type="text/css" href="css/fund_transfer_otp.css">
	</head>
<body>
	<?php include 'header.php' ; 
			include 'customer_profile_header.php'; 
			$sender_mob = $_SESSION['sender_mob'];
			$hidden_mob_no = substr($sender_mob, 0, 3)."XXXX".substr($sender_mob, 7, 10);
			$ref_no = $_SESSION['ref_no'];
	
	?>
	<label class="OTP_msg">OTP with Ref no.<?php echo $ref_no." sent to <b>".$hidden_mob_no."</b> please verify to complete your transaction <br><br> *OTP :".$_SESSION['fund_trnsfer_otp']."" ; ?></label>

		<div class="fund_transfer_otp_container">
		<form method="post">
		<input type="text" name="otpcode" placeholder="OTP Code">
		<input type="submit" name="verify-btn" value="Verify">
		</form>
		</div>
	<?php include 'footer.php' ;  ?>
</body>
</html>

<?php /*
if(isset($_POST['verify-btn'])){

	if(!is_numeric($_POST['trnsf_amount'])){

		echo '<script>alert("Invalid amount")</script>';
	}
	
	else{ 

		
	$sender_ac_no = $_SESSION['Account_No'];	//Sender's Account_No
	$trnsf_amount=$_POST['trnsf_amount'];	
	include 'db_connect.php';
	$cust_id = $_SESSION['customer_Id']; 

	//Receivers details require_onced for transaction
	$beneficiary_ac_no = $_POST['beneficiary'];
	$sql = "SELECT * FROM bank_customers WHERE Account_no = $beneficiary_ac_no ";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();
	$receiver_ac_no = $row['Account_no'];
	$receiver_custmr_id = $row['Customer_ID'];
	$receiver_name = $row['Username'];
	$receiver_ifsc= $row['IFSC_Code'];
	$receiver_mob = $row['Mobile_no'];
	$receiver_netbal = $row['Current_Balance'] + $trnsf_amount;
	$receiver_passbk = "passbook_".$receiver_custmr_id;
	
	
	//Senders Details require_onced for transaction 
	$sql = "SELECT * FROM bank_customers WHERE Account_no = '$sender_ac_no' " ;
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();
	$sender_custmr_id = $row['Customer_ID'];
	$sender_name = $row['Username'];
	$sender_ifsc = $row['IFSC_Code'];
	$sender_mob = $row['Mobile_no'];
	$sender_ac_no = $row['Account_no'];
	$sender_netbal = $row['Current_Balance'] - $trnsf_amount;
	$sender_passbk = "passbook_".$sender_custmr_id;


	if($row['Current_Balance'] < $trnsf_amount){

		echo '<script>alert("Insufficient balance")
					   location="fund_transfer.php";		
						</script>';

	}

	else {

		// Set autocommit to off
	$conn->autocommit(FALSE);
	
	//Add transferring amount to receiver's available balance	
	$sql1 = "Update bank_customers SET Current_Balance = '$receiver_netbal' WHERE bank_customers.Account_no = '$receiver_ac_no '";
	
	
	//Subtract transferring amount from sender's available balance
	$sql2 = "Update bank_customers SET Current_Balance ='$sender_netbal'  WHERE bank_customers.Account_no = '$sender_ac_no' ";
	
	
	//Generate Transaction ID
		$transaction_id = mt_rand(100,999).mt_rand(1000,9999).mt_rand(10,99);
		
		//Transaction Date

		date_default_timezone_set('Asia/Kolkata'); 
		$transaction_date = date("d/m/y h:i:s A");
		
		//Narration
		$remark = $_POST['trnsf_remark'];

		//Sender's Transaction Description
		$Transac_description = $receiver_name ."/".$receiver_ac_no."/".$receiver_ifsc;
		
		// Insert Statement into Sender Passbook
		$sql3 = "INSERT INTO $sender_passbk(Transaction_id,Transaction_date,Description,Cr_amount,Dr_amount,Net_Balance,Remark)
		VALUES ('$transaction_id','$transaction_date','$Transac_description','0','$trnsf_amount','$sender_netbal','$remark')";
			
		
		//Receiver's Transaction Description
		$Transac_description = $sender_name."/".$sender_ac_no."/".$sender_ifsc;
		
		// Insert Statement into Receiver Passbook
		$sql4 = "INSERT INTO $receiver_passbk (Transaction_id,Transaction_date,Description,Cr_amount,Dr_amount,Net_Balance,Remark)
		VALUES ('$transaction_id','$transaction_date','$Transac_description','$trnsf_amount','0','$receiver_netbal','$remark')";
		
  
	if($conn->query($sql1) == TRUE && $conn->query($sql2) == TRUE &&  $conn->query($sql3) == TRUE && $conn->query($sql4) == TRUE ){
				
			$conn->commit();

				date_default_timezone_set('Asia/Kolkata'); 
				$date_time = date("d/m/y h:i:s A");

	//SMS Integration for Fund Transfer notification to both the Sender and the Receiver-------------------------------
			///------------To the sender------------

				require_once('textlocal.class.php');
				$apikey = 'Mzie479SxfY-Z7slYf9AI3zVXCAu0G5skUBQVYOfRU';
				$textlocal = new Textlocal(false,false,$apikey);
				$numbers = array($sender_mob);
				$sender = 'TXTLCL';
				$hidden_ac_no  = "XXXXXXXX".substr($sender_ac_no, 8, 13);
				$message = 'Your a/c no.'.$hidden_ac_no.' is debited with Rs.'.$trnsf_amount.' on '.$date_time.' Transaction ID is '.$transaction_id.'' ;
			
				try {
					$result = $textlocal->sendSms($numbers, $message, $sender);
					print_r($result);
				} catch (Exception $e) {
					die('Error: ' . $e->getMessage());
				}

				//-------------------------------------------------------------------------------------
				//-------------------To the receiver----------------------------------------------------
				
				require_once('textlocal.class.php');
				$apikey = 'Mzie479SxfY-Z7slYf9AI3zVXCAu0G5skUBQVYOfRU';
				$textlocal = new Textlocal(false,false,$apikey);
				$numbers = array($receiver_mob);
				$sender = 'TXTLCL';
				$hidden_ac_no  = "XXXXXXXX".substr($receiver_ac_no, 8, 13);
				$message = 'Your a/c no.'.$hidden_ac_no.' is credited with Rs.'.$trnsf_amount.' on '.$date_time.' Transaction ID is '.$transaction_id.'' ;
			
				try {
					$result = $textlocal->sendSms($numbers, $message, $sender);
					print_r($result);
				} catch (Exception $e) {
					die('Error: ' . $e->getMessage());
				}

				//-------------------------------------------------------------------------------------------	
		//-------------------------------------------------------------------------------------------- 

			echo '<script>alert("Transaction Successfull.")
			location="fund_transfer.php"</script>';
							
		}	

		else{
			
			
			echo "Transaction failed!\nPlease contact bank<br>".$conn->error;
			$conn->rollback();
		
			
		}


		}



	}
	
	
			
	}  */
	
?>


<?php
echo $_SESSION['fund_trnsfer_otp'];
if(isset($_POST['verify-btn'])){


    $otpcode = $_POST['otpcode']; 

    if($otpcode == $_SESSION['fund_trnsfer_otp']){                       //Session1

     $sender_ac_no = $_SESSION['Account_No'];	//Sender's Account_No     //SESSION2
     
     $trnsf_amount = $_SESSION['trnsf_amount'];  //Transfer Amount        //SESSION3
    

     //Receivers details require_onced for transaction
    $beneficiary_ac_no = $_SESSION['beneficiary_ac_no'];                   //SESSION4

    
    include 'db_connect.php';
   // $cust_id = $_SESSION['customer_Id']; 
  
	$sql = "SELECT * FROM bank_customers WHERE Account_no = $beneficiary_ac_no ";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();
	$receiver_ac_no = $row['Account_no'];
	$receiver_custmr_id = $row['Customer_ID'];
	$receiver_name = $row['Username'];
	$receiver_ifsc= $row['IFSC_Code'];
	$receiver_mob = $row['Mobile_no'];
	$receiver_netbal = $row['Current_Balance'] + $trnsf_amount;
	$receiver_passbk = "passbook_".$receiver_custmr_id;
	
	
	//Senders Details require_onced for transaction 
	$sql = "SELECT * FROM bank_customers WHERE Account_no = '$sender_ac_no' " ;
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();
	$sender_custmr_id = $row['Customer_ID'];
	$sender_name = $row['Username'];
	$sender_ifsc = $row['IFSC_Code'];
	$sender_mob = $row['Mobile_no'];
	$sender_ac_no = $row['Account_no'];
	$sender_netbal = $row['Current_Balance'] - $trnsf_amount;
	$sender_passbk = "passbook_".$sender_custmr_id;


     	// Set autocommit to off
	$conn->autocommit(FALSE);
	
	//Add transferring amount to receiver's available balance	
	$sql1 = "Update bank_customers SET Current_Balance = '$receiver_netbal' WHERE bank_customers.Account_no = '$receiver_ac_no '";
	
	
	//Subtract transferring amount from sender's available balance
	$sql2 = "Update bank_customers SET Current_Balance ='$sender_netbal'  WHERE bank_customers.Account_no = '$sender_ac_no' ";
	
	
	//Generate Transaction ID
		$transaction_id = mt_rand(100,999).mt_rand(1000,9999).mt_rand(10,99);
		
		//Transaction Date

		date_default_timezone_set('Asia/Kolkata'); 
		$transaction_date = date("d/m/y h:i:s A");
		
		//Narration
		$remark = $_SESSION['trnsf_remark'];                                    //SESSION56

		//Sender's Transaction Description
		$Transac_description = $receiver_name ."/".$receiver_ac_no."/".$receiver_ifsc;
		
		// Insert Statement into Sender Passbook
		$sql3 = "INSERT INTO $sender_passbk(Transaction_id,Transaction_date,Description,Cr_amount,Dr_amount,Net_Balance,Remark)
		VALUES ('$transaction_id','$transaction_date','$Transac_description','0','$trnsf_amount','$sender_netbal','$remark')";
			
		
		//Receiver's Transaction Description
		$Transac_description = $sender_name."/".$sender_ac_no."/".$sender_ifsc;
		
		// Insert Statement into Receiver Passbook
		$sql4 = "INSERT INTO $receiver_passbk (Transaction_id,Transaction_date,Description,Cr_amount,Dr_amount,Net_Balance,Remark)
		VALUES ('$transaction_id','$transaction_date','$Transac_description','$trnsf_amount','0','$receiver_netbal','$remark')";
		
  
	if($conn->query($sql1) == TRUE && $conn->query($sql2) == TRUE &&  $conn->query($sql3) == TRUE && $conn->query($sql4) == TRUE ){
				
			$conn->commit();

				date_default_timezone_set('Asia/Kolkata'); 
				$date_time = date("d/m/y h:i:s A");

	//SMS Integration for Fund Transfer notification to both the Sender and the Receiver-------------------------------
			///------------To the sender------------

				// require_once('textlocal.class.php');
				// $apikey = 'Mzie479SxfY-Z7slYf9AI3zVXCAu0G5skUBQVYOfRU';
				// $textlocal = new Textlocal(false,false,$apikey);
				// $numbers = array($sender_mob);
				// $sender = 'TXTLCL';
				// $hidden_ac_no  = "XXXXXXXX".substr($sender_ac_no, 8, 13);
				// $message = 'Your a/c no.'.$hidden_ac_no.' is debited with Rs.'.$trnsf_amount.' on '.$date_time.' Transaction ID is '.$transaction_id.'' ;
			
				// try {
				// 	$result = $textlocal->sendSms($numbers, $message, $sender);
				// 	print_r($result);
				// } catch (Exception $e) {
				// 	die('Error: ' . $e->getMessage());
				// }

				//-------------------------------------------------------------------------------------
				//-------------------To the receiver----------------------------------------------------
				
				// require_once('textlocal.class.php');
				// $apikey = 'Mzie479SxfY-Z7slYf9AI3zVXCAu0G5skUBQVYOfRU';
				// $textlocal = new Textlocal(false,false,$apikey);
				// $numbers = array($receiver_mob);
				// $sender = 'TXTLCL';
				// $hidden_ac_no  = "XXXXXXXX".substr($receiver_ac_no, 8, 13);
				// $message = 'Your a/c no.'.$hidden_ac_no.' is credited with Rs.'.$trnsf_amount.' on '.$date_time.' Transaction ID is '.$transaction_id.'' ;
			
				// try {
				// 	$result = $textlocal->sendSms($numbers, $message, $sender);
				// 	print_r($result);
				// } catch (Exception $e) {
				// 	die('Error: ' . $e->getMessage());
				// }

				//-------------------------------------------------------------------------------------------	
		//-------------------------------------------------------------------------------------------- */
        
            unset($_SESSION['fund_trnsfer_otp']);
            unset($_SESSION['trnsf_amount']);
            unset($_SESSION['beneficiary_ac_no']);
            unset($_SESSION['trnsf_remark']);

			echo '<script>alert("Transaction Successful!")
			location="fund_transfer.php"</script>';
							
		}	

		else{
			
			
			echo "Transaction failed!\nPlease contact bank<br>".$conn->error;
			$conn->rollback();
		
			
        }
        
    }

    else{

        echo '<script>alert("Incorrect OTP\n\nPlease try again")</script>';
    }



}

?>
