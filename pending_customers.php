<html>
<head><title>Pending Customers</title>
</head>
<link rel="stylesheet" type="text/css" href="css/pending_customers.css"/>
<body>

<?php  
	//session_start();
	include 'header.php' ;
	include 'staff_profile_header.php' ;
	include 'db_connect.php';

?>

<div class="application_search">
<form method="post">
<input type="text" name="application_no" placeholder="Application number" required>
<input type="submit" name="search_application" value="Search">

</form>
</div>
<div class="pending_customers_container">


<table border="1px" cellpadding="10">
			   <th>#</th>
			   <th>Application No.</th>
			   <th>Name</th>
			   <th>Gender</th>
			   <th>Mobile</th>
			   <th>Email</th>
			   <th>Landline</th>
			   <th>DOB</th>
			   <th>PAN</th>
			   <th>Citizenship</th>
			   <th>Home Address</th>
			   <th>Office Address</th>
			   <th>Country</th>
			   <th>State</th>
			   <th>City</th>
			   <th>Pin</th>
			   <th>Area Loc.</th>
			   <th>Nominee Name</th>
			   <th>Nominee A/c no</th>
			   <th>Accoount Type</th>
			   <th>Application Date</th>

<?php

	
	if(isset($_POST['search_application'])){
		if(empty($_POST['application_no'])){

			echo '<script>alert("Please enter application number")</script>';
		}
		else{   


			$application_no  = $_SESSION['application_no'] = $_POST['application_no'];
			$sql = "SELECT * from pending_accounts Where Application_no = '$application_no' ";
			$result = $conn->query($sql);
			
			if ($result->num_rows > 0) {   
					  $Sl_no = 1; 
			// output data of each row
				while($row = $result->fetch_assoc()) {
					
				echo '
					<tr>
					<td>'.$Sl_no++.'</td>
					<td>'.$row['Application_no'].'</td>
					<td>'.$row['Name'].'</td>
					<td>'.$row['Gender'].'</td>
					<td>'.$row['Mobile_no'].'</td>
					<td>'.$row['Email_id'].'</td>
					<td>'.$row['Landline_no'].'</td>
					<td>'.$row['DOB'].'</td>
					<td>'.$row['PAN'].'</td>
					<td>'.$row['CITIZENSHIP'].'</td>
					<td>'.$row['Home_Addr'].'</td>
					<td>'.$row['Office_Addr'].'</td>
					<td>'.$row['Country'].'</td>
					<td>'.$row['State'].'</td>
					<td>'.$row['City'].'</td>
					<td>'.$row['Pin'].'</td>
					<td>'.$row['Area_Loc'].'</td>
					<td>'.$row['Nominee_name'].'</td>
					<td>'.$row['Nominee_ac_no'].'</td>
					<td>'.$row['Account_type'].'</td>
					<td>'.$row['Application_Date'].'</td>
					</tr>';
			}
			
			
		}
		
		else{
		
			echo '<script>alert("Application not found")</script>';
		}
		 
		}
	}	

?>

</table>
</div>
<form method="post">
<div class="approve">
<input type="submit" name="approve_cust" value="Approve">
</div>
</form>

<?php	

include 'account_approve_process.php';


include 'footer.php'; ?> 
</body>
</html>




