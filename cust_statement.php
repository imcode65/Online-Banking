

<html>
    <head><title>Statement</title>
    
    <link rel="stylesheet" type="text/css" href="css/cust_statement.css" />
    <style>

#customer_profile .link5{

    background-color: rgba(5, 21, 71,0.4);
    
}

</style>
    
      <?php include 'header.php' ; ?></head>
<body>
    
	
        <?php include 'customer_profile_header.php' ?>	
		
<?php 

if($_SESSION['customer_login'] == true)
{
	


}	

	else{
   
    header('location:customer_login.php');

	}

?>
		
		
           
        <div class="cust_statement_container_head">
         <label class="heading">Bank Statement</label>
         </div>
         <div class="cust_statement_container">
         <div class="cust_statement">
                
                <table>
                <th>#</th>
                <th>Date</th>
                <th>Transaction Id</th>
                <th>Description</th>
                <th>Cr</th>
                <th>Dr</th>
                <th>Balance</th>
                <?php

    $cust_id = $_SESSION['customer_Id'];
    
	$sql = "SELECT * from passbook_$cust_id ORDER BY Id DESC";
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
    </div>
 <br>
    </body>
    <?php include 'footer.php' ; ?>
</html>