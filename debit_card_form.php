<html>
<head><title>Apply Debit Card</title>
<link rel="stylesheet" type="text/css" href="css/debit_card_form.css">
</head>
<body>
    <?php include 'header.php' ?>
<div class="debit_card_form_container">
    <br>
<form method="POST">
<input type="text" name="holder_name" placeholder="Account Holder Name"><br>
<input type="text" name="dob" placeholder="Date of Birth" onfocus="(this.type='date')"><br>
<input type="text" name="pan" placeholder="PAN"><br>
<input type="text" name="mob" placeholder="Registered Mobile (10 Digit)"><br>
<input type="text" name="acc_no" placeholder="Account No"><br>
<input type="submit" name ="dbt_crd_submit" value"Submit" ><br>
<form>
</div>
</body>
<?php include 'footer.php' ?>
</html>

<?php

if(isset($_POST['dbt_crd_submit'])){
    $holder_name = $_POST['holder_name'];
    $dob = $_POST['dob'];
    $pan = $_POST['pan'];
    $mob = $_POST['mob'];
    $acc_no = $_POST['acc_no'];
    if(empty($_POST['holder_name']) || empty($_POST['dob']) || empty($_POST['pan']) ||empty($_POST['mob']) ||empty($_POST['acc_no'])){

        echo '<script>alert("No field should be empty")</script>';
    }
    else{

    include 'db_connect.php'; 
    $sql = "SELECT * FROM bank_customers WHERE Account_no = '$acc_no' ";
    $result = $conn->query($sql);
    if($result->num_rows <= 0){

        echo '<script>alert("No Data match with the details provided")</script>';

    }
    
    else{

    $row = $result->fetch_assoc();
    if(!is_numeric($mob) || (strlen($mob) > 10 || strlen($mob) < 10)){

        echo '<script>alert("Invalid Mobile Number\nPlease enter 10 Digit registered mobile number")</script>';

        }

        elseif($mob != $row['Mobile_no']){

            echo '<script>alert("Please enter your registered mobile number")</script>';
        }
        elseif($holder_name != $row['Username']){

            echo '<script>alert("Incorrect Account Holder Name")</script>';
            echo $row['Username'];
        }
        elseif($dob != $row['DOB']){

            echo '<script>alert("Incorrect Date of Birth\nPlease enter Date of Birth as on PAN Card")</script>';
    
        }
        elseif($pan != $row['PAN']){

            echo '<script>alert("Incorrect PAN Number")</script>';

        }
     

        else{
            //-------------------------------------------------------------------'

            //Code to Issue Debit Card since all the provided details are correct
            
            $mob_no = $row['Mobile_no'];
           if($row['Debit_Card_No'] === NULL){

            $debit_card = "4213".mt_rand(1000,9999).mt_rand(1000,9999);
            $debit_card_pin = mt_rand(10,99).mt_rand(10,99);
            $sql = "UPDATE bank_customers SET Debit_Card_No = '".$debit_card."', Debit_Card_Pin = '".$debit_card_pin."' WHERE Account_no = '$acc_no' ";
            if($conn->query($sql) == TRUE ){


                //SMS Integration for Debit Card Details  -----------------------------------------------------
						
					// require('textlocal.class.php');
					// $apikey = 'Mzie479SxfY-Z7slYf9AI3zVXCAu0G5skUBQVYOfRU';
					// $textlocal = new Textlocal(false,false,$apikey);
					// $numbers = array($mob_no);
					// $sender = 'TXTLCL';
					// $message = 'Hello '.$row['Username'].' Your Debit Card No is : '.$debit_card.' with the auto generated pin : '.$debit_card_pin.' Please change this pin as soon as possible';

					
					// 	try {
					// 		$result = $textlocal->sendSms($numbers, $message, $sender);
					// 		print_r($result);
					// 	} catch (Exception $e) {
					// 		die('Error: ' . $e->getMessage());
					// 	}
						
		//--------------------------------------------------------------------------------------				
		//--------------------------------------------------------------------------------------
	


            echo '<script>alert("Debit Card issued successfully.\n\nIt will be delivered to your home address soon.\n\nYour Debit Card No is : '.$debit_card.' and Pin is : '.$debit_card_pin.'\n\n Please change this pin as soon as possible.")</script>';
                
            }
            //--------------------------------------------------------------------
        }

        else{

            echo '<script>alert("You have already applied for debit card\n\nYour Debit Card number is : '.$row['Debit_Card_No'].'")</script>';
        }

        }
    
    }
}

}
?>
