


<html>
    <head><title>My Profile</title>
    <link rel="stylesheet" type="text/css" href="css/customer_profile_myprofile.css">
    <style>
#customer_profile .link2{

background-color: rgba(5, 21, 71,0.4);

}
    </style>

</head>
<body>
    <?php include 'header.php';
          include 'customer_profile_header.php' ?>
          <?php 
        $cust_id= $_SESSION['customer_Id'];
        include 'db_connect.php'; 
        $sql="SELECT * FROM bank_customers where Customer_ID= '$cust_id' ";
		$result = $conn->query($sql);
        $row = $result->fetch_assoc();
 
?>
<div class="myprofile_container">
    <div class="customer_profile_photo">

   <!-- <?php echo '<img class="custmr_img" src="data:image/jpeg;base64,'.base64_encode($row['Customer_Photo']).'"'; ?> onerror="this.src='img/customers/No_image.jpg'"  height="130" width="120"/><br>  -->
    </div>
    <div class="customer_profile_details">
    <label>Name : <?php echo $row['Username']; ?> </label><br>
    <label>Sex : <?php echo $row['Gender']; ?> </label><br>
    <label>Mobile No : <?php echo $row['Mobile_no']; ?> </label><br>
    <label>Landline : <?php echo $row['Landline_no']; ?> </label><br>
    <label>Addresss : <?php echo $row['Home_Addr']; ?> </label><br>
    <label>Currency : <?php echo 'INR' ; ?> </label><br>
    <label>Country : <?php echo $row['Country']; ?> </label><br>
    <label>State : <?php echo $row['State']; ?> </label><br>
    <label>City : <?php echo $row['City']; ?> </label><br>
    <label>Pin Code : <?php echo $row['Pin_code']; ?> </label><br>
    <label>Account Opening Date : <?php echo $row['Ac_Opening_Date']; ?> </label><br>
</div>
</div>





<?php include 'footer.php'; ?>
</dody>
</html>