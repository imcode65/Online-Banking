
<html>
<head>
<title>Forget Password</title>

<link rel="stylesheet" type="text/css" href="css/cust_forgetpass.css"/>
</head>
<body>
<?php include 'header.php'; ?>
<div class="forgetpass_cotainer">
<p>Forget Password</p>
<form method="post">
<input type="text" name="cust_id" placeholder="Customer ID" required /><br>
<input type="text" name="dbt_crd" placeholder="Debit Card Number" required /><br>
<input type="text" name="dbt_crdpin" placeholder="Debit Card Pin"required /><br>
<input type="text" name="mobile_no" placeholder="Registerd Mobile no" required /><br>
<input type="submit" name="sendotp" value="Submit"><br>
</form><br>
</div>
</div>
</body>
</html>


<?php 
include 'footer.php';
if(isset($_POST['sendotp'])){
	session_start();
	include 'cust_forgetpass_validate.php';

}


?>

