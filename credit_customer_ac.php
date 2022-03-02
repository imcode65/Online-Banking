<html>
<head><title>Staff Home</title>
<link rel="stylesheet" type="text/css" href="css/credit_customer_ac.css" />
</head>
<body>
<?php
	include 'header.php' ;
    include 'staff_profile_header.php' ;?>
    <div class="cust_credit_container">
	<form method="post">
    <input class="customer" type="text" name="customer_account_no" placeholder="Customer A/c No" required><br>
    <input class="customer" type="text" name="credit_amount" placeholder="Amount" required><br>
    <input class="customer" type="submit" name="credit_btn" value="Credit" >
    </form><br>
</div>
<?php include'footer.php'; ?>
</body>
</html>


<?php 
if(isset($_POST['credit_btn'])){

    $cust_ac_no = $_POST['customer_account_no'];
    $credit_amount = $_POST['credit_amount'];

	if(!is_numeric($_POST['credit_amount'])){

		echo '<script>alert("Invalid amount")</script>';
	}
	
	else{ 
    
	include 'db_connect.php';

	//Customer details required for transaction
	$sql = "SELECT * FROM bank_customers WHERE Account_no = $cust_ac_no ";
    $result = $conn->query($sql);
    if($result->num_rows > 0){
    $row = $result->fetch_assoc();
	$customer_ac_no = $row['Account_no'];
	$customer_id = $row['Customer_ID'];
	$customer_name = $row['Username'];
	$customer_ifsc= $row['IFSC_Code'];
	$customer_mob = $row['Mobile_no'];
	$customer_netbal = $row['Current_Balance'] + $credit_amount;
	$customer_passbk = "passbook_".$customer_id;
	

    
    	//Generate Transaction ID
		$transaction_id = mt_rand(100,999).mt_rand(1000,9999).mt_rand(10,99);
		
		//Transaction Date

		date_default_timezone_set('Asia/Kolkata'); 
		$transaction_date = date("d/m/y h:i:s A");
		
		//Remark or Narration
		$remark = "Cash Deposit";
			
		//customer's Transaction Description
        $Transac_description = "Cash Deposit/".$transaction_id;
		
		date_default_timezone_set('Asia/Kolkata'); 
		$date_time = date("d/m/y h:i:s A");

		//SMS Integration for Fund Transfer notification to both the Sender and the customer--------------
			///------------To the sender------------

				// require('textlocal.class.php');
				// $apikey = 'Mzie479SxfY-Z7slYf9AI3zVXCAu0G5skUBQVYOfRU';
				// $textlocal = new Textlocal(false,false,$apikey);
				// $numbers = array($customer_mob);
				// $sender = 'TXTLCL';
				// $hidden_ac_no  = "XXXXXXXX".substr($customer_ac_no ,8 , 13);
				// $message = 'Your a/c no.'.$hidden_ac_no.' is credited with Rs.'.$credit_amount.' on '.$date_time.' Transaction ID is '.$transaction_id.'' ;
			
				// try {
				// 	$result = $textlocal->sendSms($numbers, $message, $sender);
				// 	print_r($result);
				// } catch (Exception $e) {
				// 	die('Error: ' . $e->getMessage());
				// }

				//-------------------------------------------------------------------------------------
				//-------------------To the customer---------------------------------------------------- 
				

        // Set autocommit to off
        $conn->autocommit(FALSE);
	
	//Add amount to customer's available balance	
	$sql1 = "Update bank_customers SET Current_Balance = '$customer_netbal' WHERE bank_customers.Account_no = '$customer_ac_no '";
		
	// Insert Statement into customer Passbook
	$sql2 = "INSERT INTO $customer_passbk (Transaction_id,Transaction_date,Description,Cr_amount,Dr_amount,Net_Balance,Remark)
	VALUES ('$transaction_id','$transaction_date','$Transac_description','$credit_amount','0','$customer_netbal','$remark')";
		
  
	if($conn->query($sql1) == TRUE && $conn->query($sql2) == TRUE ){
				
			$conn->commit();
		


	
			echo '<script>alert("Amount credited Successfully to customer account")</script>';
							
		}	

		else{
			
			
			echo '<script>alert("Transaction failed\n\nReason:\n\n'.$conn->error.'")</script>';
			$conn->rollback();
		
			
        }
    }

    else{

        echo '<script>alert("Incorrect Account Number")</script>';
    }

	}
	

			
	}
	
?>