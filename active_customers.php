<html>
<head><title>Active Customers</title>
</head>
<link rel="stylesheet" type="text/css" href="css/active_customers.css"/>
<body>

<?php  

	include 'header.php' ;
	include 'staff_profile_header.php' ;
	include 'db_connect.php';


?>
<div class="active_customers_container">

<table border="1px" cellpadding="10">
			   <th>#</th>
			   <th>Username</th>
			   <th>Customer ID</th>
			   <th>Account No.</th>
			   <th>Mobile No.</th>
			   <th>Email ID</th>
			   <th>DOB</th>
			   <th>Current Balance</th>
			   <th>PAN</th>
			   <th>Citizenship</th>
			   <th>Debit Card No.</th>
			   <th>CVV</th>
			   <th>Last_Login</th>
			   <th>LastTransaction</th>
			   <th>Account Status</th>


<?php

	
	
	$sql = "SELECT * from bank_customers";
	$result = $conn->query($sql);
	
	if ($result->num_rows > 0) {	   
			  $Sl_no = 1; 
    // output data of each row
		while($row = $result->fetch_assoc()) {
			
		echo '
			<tr>
			<td>'.$Sl_no++.'</td>
			<td>'.$row['Username'].'</td>
			<td>'.$row['Customer_ID'].'</td>
			<td>'.$row['Account_no'].'</td>
			<td>'.$row['Mobile_no'].'</td>
			<td>'.$row['Email_ID'].'</td>
			<td>'.$row['DOB'].'</td>
			<td>$'.$row['Current_Balance'].'</td>
			<td>'.$row['PAN'].'</td>
			<td>'.$row['CITIZENSHIP'].'</td>
			<td>'.$row['Debit_Card_No'].'</td>
			<td>'.$row['CVV'].'</td>
			<td>'.$row['Last_Login'].'</td>
			<td>$'.$row['LastTransaction'].'</td>
			<td>'.$row['Account_Status'].'</td>
			</tr>';
	}
	
	
}

?>

</table>
</div>

<?php include 'footer.php'; ?> 
</body>
</html>




