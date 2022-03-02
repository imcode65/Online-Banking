<?php 
include 'header.php' ;
include 'customer_profile_header.php';
if($_SESSION['customer_login'] == FALSE)
{
	 header('location:customer_login.php');

}


?>
<html>
 <head><title>My Profile</title>
 <link rel="stylesheet" type="text/css" href="css/customer_profile.css" />
</head>
<body>


<?php 
        $cust_id= $_SESSION['customer_Id'];
        include 'db_connect.php'; 
        $sql="SELECT * FROM bank_customers where Customer_ID= '$cust_id' ";
		$result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $current_bal = $row['Current_Balance'];
    
		

?>

    <div class="cust_profile_container">
            <div class="acc_details">
                <span class="heading">Account Details</span><br>
                <label>Customer Id : <?php echo $_SESSION['customer_Id']; ?></label>
                <label>Account Number : <?php echo $_SESSION['Account_No']; ?></label>
                 <label>Account Name : <?php echo $_SESSION['Username']; ?></label>
                <label>Account Type : <?php echo $_SESSION['Account_type']; ?></label>
                <label>Available Balance : $<?php echo $current_bal ; ?></label>  
            </div>
    <div class="statement">
                <label class="heading">Bank Statement</label>
                <table>
                <th width="5%">#</th>
                <th width="15%">Date</th>
                <th width="15%">Trans. Id</th>
                <th width="31%">Description</th>
                <th width="10%">Cr.</th>
                <th width="10%">Dr.</th>
                <th width="20%">Total</th>
                <?php

    $cust_id = $_SESSION['customer_Id'];
    
	$sql = "SELECT * from passbook_$cust_id ORDER By Id DESC LIMIT 10";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {	   
			  $Sl_no = 1; 
    // output data of each row
		while($row = $result->fetch_assoc()) {
			
		echo '
			<tr>
            <td>'.$Sl_no++.'</td>
            <td>'.$row['Transaction_date'].'</td>
			<td>'.$row['Transaction_id'].'</td>
			<td>'.$row['Description'].'</td>
			<td>'.$row['Cr_amount'].'</td>
			<td>'.$row['Dr_amount'].'</td>
			<td>$'.$row['Net_Balance'].'</td>
			</tr>';
	}
	
	
}

?>
                </table>
    </div>
</div>

</body>
<?php include 'footer.php' ; ?>
</html>


