<?php
/**
if($_SESSION[Customer_login] == FALSE ){

header("location:customer_login.php");

}
*/
	
?>


<html>
<head></title>Receipt</title>

<style>
.receipt_container{
	color:2C4E86;
	width:40%;
	margin:5% auto;
	background-color:rgb(185, 237, 234);
	padding:1%;
	border:1px solid rgba(44, 78, 134,0.5);
}

.receipt_container label{
	display:block;
	margin:5%;
}

</style>
</head>
<body>
<?php include 'header.php';
	   include 'customer_profile_header.php'; 
 ?>
 
 <div class="receipt_container">
 <label>To : <?php echo "" ; ?></label>
 <label>From : <?php echo "" ; ?></label>

 <label>Amount : <?php echo "" ; ?></label>
 <label>Transacton Id : <?php echo ""; ?></label>
 <label>Date :<?php echo date("d/m/y"); ?></label> 
 <label>Time : <?php echo date("h:i:s A"); ?></label>
 </div>



<?php include 'footer.php'  ?>
<body>
</html>