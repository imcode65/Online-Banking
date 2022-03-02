

<html>
    <head><title>Customer Details</title>
    
    <link rel="stylesheet" type="text/css" href="css/view_customer_by_acc_no.css" />
    
      <?php include 'header.php' ?></head>
<body>
	<?php include 'staff_profile_header.php' ?>
    
    <div class="view_cust_byac_container_outer">
    <form method="POST">
        <input name="account_no" placeholder="Customer Account No"><br>
        <input type="submit" name="submit_view" value="Submit">

    </form>
    </div>
    
    <?php 

    if(isset($_POST['submit_view'])){
        $cust_ac=$_POST['account_no'];
        include 'db_connect.php'; 
        $sql="SELECT * FROM bank_customers where Account_no= '$cust_ac'";
        $result = $conn->query($sql);
        if($result->num_rows > 0){
        $row = $result->fetch_assoc();

	    echo '<div class="view_cust_byac_container_inner">
            <div class="cust_details">
                <span class="heading">Customer Details</span><br>
                <label>Customer Id : '.$row['Customer_ID'].'</label>
                <label>Account Number : '.$row['Account_no'].'</label>
                 <label>Account Name : '.$row['Username']. '</label>
                <label>Account Type : '.$row['Account_type']. '</label>
                <label>IFSC Code : '.$row['IFSC_Code']. '</label>
                <label>Branch : '.$row['Branch'].'</label>
                <label>Available Balance : $'.$row['Current_Balance'].'</label>
                <label>Mobile No : '.$row['Mobile_no'].'</label>
                <label>Debit Card No : '.$row['Debit_Card_No'].'</label>
                <label>Nominee Name : '.$row['Nominee_name'].'</label>
                <label>Nominee Ac/no : '.$row['Nominee_ac_no'].'</label>
                <label>Email Id : '.$row['Email_ID'].'</label>
            </div>
            </div>'; 
    
    }

    else{

        echo '<script>alert("Customer not found")</script>';
    }
}
    
    ?>

    </body>
    <?php include 'footer.php' ?>
</html>