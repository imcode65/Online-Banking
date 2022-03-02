<?php
ob_start();
include 'header.php';
include 'customer_profile_header.php' ;
if($_SESSION['customer_login'] != true){

	header('location:customer_login.php');
	return 0;
	}

	

?>

<html>
<head>
<title>Fund Transfer</title>
<link rel="stylesheet" type="text/css" href="css/fund_transfer.css"/>    
<style>
#customer_profile .link4{

background-color: rgba(5, 21, 71,0.4);

}
    </style>
 </head>
<body>


    <div class="fundtransfer_conainer">
   
        <br>
        <span>IMPS (24x7 Instant Payment)</span><br><br>
		
        <div class="fund_transfer">
			<div class="beneficiary_btn">
				<form id="form1" method="post">
					<a href="add_beneficiary.php"><input class="beneficiary" type="submit" name="add_beneficiary" value="Add beneficiary"></a>
					<input class="beneficiary" type="submit" name="delete_beneficiary" value="Delete beneficiary">
					<input class="beneficiary" type="submit" name="view_beneficiary" value="View beneficiary">
			</div>
	</form>
					<br>
					<form id="form2" method="post">
					<select name ="beneficiary" required >
					<option class="default" value="" disabled selected>Select Beneficiery</option>

					<?php

		include 'db_connect.php';
		$cust_id = $_SESSION['customer_Id']; 
		$sql = "SELECT * from beneficiary_$cust_id ";
		$result = $conn->query($sql);
		while($row = $result->fetch_assoc()){
							
						echo '
						'; ?>
						
		 <option value="<?php echo $row['Beneficiary_ac_no']; ?>"> <?php echo
		  $row['Beneficiary_name']."-".$row['Beneficiary_ac_no']; ?> </option>
					
		<?php } ?>
				</select><br>
				<input type="text" name="trnsf_amount" placeholder="Amount" required><br>
				<input type="text" name="trnsf_remark" placeholder="Remark"><br>
				<input type="submit" name="fnd_trns_btn" value="Send"><br>
		</div>
		</form>
		
    </div>
             

    </body>
    <?php include 'footer.php' ; ?>
</html>

<?php

if(isset($_POST['add_beneficiary'])){

	header("location:add_beneficiary.php");
}

if(isset($_POST['delete_beneficiary'])){

	header("location:delete_beneficiary.php");
}

if(isset($_POST['view_beneficiary'])){

	header("location:view_beneficiary.php");

}
?>


<?php 
/*
if(isset($_POST['fnd_trns_btn'])){

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
	
	
			
	} */
	
?>

<?php 

if(isset($_POST['fnd_trns_btn'])){

	$_SESSION['trnsf_remark'] = $_POST['trnsf_remark'];

	if(!is_numeric($_POST['trnsf_amount'])){

		echo '<script>alert("Invalid amount")</script>';
	}
	
	else{ 

		
	$sender_ac_no = $_SESSION['Account_No'];	//Sender's Account_No

	$_SESSION['trnsf_amount'] = $trnsf_amount = $_POST['trnsf_amount'];	

	include 'db_connect.php';

	//Receivers account number
	$_SESSION['beneficiary_ac_no'] = $beneficiary_ac_no = $_POST['beneficiary'];
	
	//Check Senders Minimum balance
	$sql = "SELECT * FROM bank_customers WHERE Account_no = '$sender_ac_no' " ;
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();
	$_SESSION['sender_mob'] = $sender_mob = $row['Mobile_no'];
	$sender_name = $row['Username'];
	if($row['Current_Balance'] < $trnsf_amount){

		echo '<script>alert("Insufficient balance")
					   location="fund_transfer.php";		
						</script>';

	}

	else {

		$_SESSION['fund_trnsfer_otp'] = $otp_fund_trnsfer = mt_rand(100,999).mt_rand(100,999);


		//SMS Integration for send OTP to Sender to complete transaction-------------
			///------------To the sender------------
			// require_once('textlocal.class.php');
			// $apikey = 'Mzie479SxfY-Z7slYf9AI3zVXCAu0G5skUBQVYOfRU';
			// $textlocal = new Textlocal(false,false,$apikey);
			// $numbers = array($sender_mob);
			// $sender = 'TXTLCL';
			$_SESSION['ref_no'] = $ref_no = mt_rand(1000,9999);
			// $message = 'Hello '.$sender_name.' OTP with Ref no.'.$ref_no.' to complete your transaction is '.$otp_fund_trnsfer.'';
		
			// try {
			// 	$result = $textlocal->sendSms($numbers, $message, $sender);
			// 	print_r($result);
			// } catch (Exception $e) {
			// 	die('Error: ' . $e->getMessage());
			// }

			//-----------------------------------------------------------------------------------  
		header("Location:fund_transfer_otp.php");
	}
}

}

	
?>