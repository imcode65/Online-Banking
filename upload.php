<html>
<head>
<title>Profile Image</title>
<link rel="stylesheet" type="text/css" href="css/cust_photo_upload.css"/>
</head>
<body>

<?php 
	ob_start();
  include 'header.php' ;
  include 'customer_profile_header.php';
if($_SESSION['customer_login'] != true)
	
{
	
	 header('location:customer_login.php');
	

}	
	
?> 

<form action="upload.php" method="post" enctype="multipart/form-data">
<div class="file_upload">
<input type="file" name="image" required><br><br>
<input type="submit" name="submit" value="Upload">
</div>
</form>
<br>



<?php

if(isset($_POST['submit'])){
	
	

$file = $_FILES['image']['tmp_name'];

$image=addslashes(file_get_contents($_FILES['image']['tmp_name']));

echo "<br>";

$image_name=addslashes($_FILES['image']['name']);
$image_size= getimagesize($_FILES['image']['tmp_name']);

if($image_size == FALSE){
	
	echo '<script>alert("Selected File is not an image.\nPlease select an image file.")</script>';	
	
}
	
	else{
		
		include 'db_connect.php';
		$customer_id=$_SESSION['customer_Id'];
		
	// Update Photo of a customer
$sql="UPDATE bank_customers SET  Customer_Photo='$image' WHERE bank_customers.Customer_ID=$customer_id ";

//Display Updated Photo
$sql2="SELECT Customer_Photo FROM bank_customers WHERE Customer_ID=$customer_id";
    $result = $conn->query($sql2);
    if($result->num_rows > 0){
	$row = $result->fetch_assoc();
			
		
	}


if ($conn->query($sql) == TRUE) {
	
    echo "Photo uploaded successfully!";
	
	header('location:customer_profile.php');
	
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
		
		
	}

}

else{
	
	echo '<script>alert("Please Select an Image file to Upload!")</script>';
	
}

include 'footer.php';
?>

</body>
