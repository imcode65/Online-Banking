<html>
<head>
    
    <title>Internet Banking Registration</title>
    <link rel="stylesheet" type="text/css" href="css/ebanking_reg_form.css">
    </head>
    <body>
       <?php include'header.php';?>
       <div class="ebanking_reg_form_container_parent">
       <h3>Internet Banking Registration</h3>
        <div class="ebanking_reg_form_container_child">
        <form method="post">
            <input type="text" name="holder_name" placeholder="Account Holder Name" required/>
            <input type="text" name="accnum" placeholder="Account Number" required />
            <input type="text" name="dbtcard" placeholder="Debit Card Number" required />
            <input type="text" name="dbtpin" placeholder="Debit Card Pin" required/>   
            <input type="text" name="mobile" placeholder="Registered Mobile (10 Digit)" required />
            <input type="text" name="pan_no" placeholder="PAN Number" required />
            <input type="text" name="dob" placeholder="Date of Birth" onfocus="(this.type='date')" required />
            <input type="text" name="last_trans" placeholder="Last Transaction ($)"required />
            <input type="password" name="password" placeholder="Password" minlength=7 required/>
            <input type="password" name="cnfrm_password" placeholder="Confirm Password" required/>
            <input type="submit" name="submit" value="Submit"/>
            </form>
            </div>
    </div>

<?php  

if(isset($_POST['submit'])){

    if(empty($_POST['holder_name']) || empty($_POST['accnum']) ||
    empty($_POST['dbtcard']) || empty($_POST['dbtcard']) ||
    empty($_POST['dbtpin']) || 
    empty($_POST['mobile']) || empty($_POST['pan_no']) ||
    empty($_POST['dob']) || empty($_POST['password']) ||
    empty($_POST['cnfrm_password'])){

        echo '<script>alert("Field should not be empty")</script>';
    }

    else{

    include 'db_connect.php';
    
    $holder_name = $_POST['holder_name'];
    $account_no=$_POST['accnum']; 
	$debitcard_no=$_POST['dbtcard'];
	$debitcrd_pin=$_POST['dbtpin'];
	$mobileno=$_POST['mobile'];
	$pan=$_POST['pan_no'];
	$dob= $_POST['dob'];
    $last_trans=$_POST['last_trans'];

    //Without Hashing
    $password=$_POST['password'];
    $cnfrm_password = $_POST['cnfrm_password'];

   

        
        //Get Customer ID
        $sql1 = "SELECT * FROM bank_customers WHERE Account_no = '$account_no'";
        $result1 = $conn->query($sql1);
        $row1 = $result1->fetch_assoc();
        $custmr_id = $row1['Customer_ID'];

        if($result1->num_rows > 0){
        
       //Get Last transaction (Dr) amount
        $sql2 = "SELECT  Cr_amount FROM passbook_$custmr_id WHERE Id=(SELECT max(Id) FROM passbook_$custmr_id) ";
        $result2 = $conn->query($sql2);
        $row2 = $result2->fetch_assoc();
        echo $last_trans_cr = $row2['Cr_amount'];

        //Get Last transaction (Cr) amount
        $sql3 = "SELECT  Dr_amount FROM passbook_$custmr_id WHERE Id=(SELECT max(Id) FROM passbook_$custmr_id)  ";
        $result3 = $conn->query($sql3);
        $row3 = $result1->fetch_assoc();
        echo $last_trans_dr = $row3['Dr_amount'];

        

        if($row1['Username'] != $holder_name ){

            echo '<script>alert("Incorrect Account Holder Name")</script>';
        }

        elseif($row1['Debit_Card_No'] != $debitcard_no){
            
            echo '<script>alert("Incorrect Debit Card Number")</script>';
 
        }

        elseif($row1['Debit_Card_Pin'] != $debitcrd_pin){

            echo '<script>alert("Incorrect Pin")</script>';
         }

         elseif($row1['Mobile_no'] != $mobileno){

            echo '<script>alert("Incorrect PAN number")</script>';
        }

        elseif($row1['PAN'] != $pan ){

            echo '<script>alert("Incorrect Mobile Number")</script>';
        }

        elseif($row1['DOB'] != $dob){

            echo '<script>alert("Incorrect Date of Birth\nPlease enter Date of Birth as on PAN Card")</script>';

        }

        elseif($row2['Cr_amount'] != $last_trans && $row3['Dr_amount'] != $last_trans ){

            echo '<script>alert("Incorrect Last Transaction Details")</script>';

        }

        elseif( $password != $cnfrm_password){

            echo '<script>alert("Password and Confirm password should be same")</script>';

        }
        
        elseif($row1['Password'] != NULL){

            echo '<script>alert("You have already registerd for Internet banking, you cannot register again")
            location="customer_login.php"</script>';

        }


        else{

            //$conn->autocommit(FALSE);
            //$password = password_hash($_POST['password'], PASSWORD_BCRYPT);

            $sql="UPDATE bank_customers SET  Password='$password' WHERE bank_customers.Customer_ID= '$custmr_id' ";
		    $conn->query($sql);
		    if($result=$conn->query($sql)== TRUE){


                // require_once('textlocal.class.php');
				// $apikey = 'Mzie479SxfY-Z7slYf9AI3zVXCAu0G5skUBQVYOfRU';
				// $textlocal = new Textlocal(false,false,$apikey);
				// $numbers = array($mobileno);
				// $sender = 'TXTLCL';
				// $hidden_ac_no  = "XXXXXXXX".substr($receiver_ac_no, 8, 13);
				// $message = 'Your customer ID for Internet Banking is '.$custmr_id.'' ;
			
				// try {
				// 	$result = $textlocal->sendSms($numbers, $message, $sender);
				// 	print_r($result);
				// } catch (Exception $e) {
				// 	die('Error: ' . $e->getMessage());
				// }

				//-------------------------------------------------------------------------------------------	
			
				
			echo '<script>alert("Registration Successfull\n\nCustomer ID : '.$custmr_id.' \n\nPlease use this customer id to login")</script>';
			
            }
            else{

                echo '<script>alert("Registration Failed")</script>';
                
            }   

            

        }

     }

            else{

                echo '<script>alert("Account number not found")</script>';
            }

        }
        }

?>

	
	
<?php include'footer.php';?>
    
    </body>
</html>