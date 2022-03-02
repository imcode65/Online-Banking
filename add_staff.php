<html>
<head></head>
<title>Add Staff</title>
<body>
<?php include 'header.php' ;
        include 'admin_profile_header.php' ;
?>

<div class="add_staff_container">
<br>
<form method="post">
<input type="text" name="Staff_name" placeholder="Staff Name" required><br>
<input type="text" name="Mobile_no" placeholder="Mobile no (10 Digits)" required><br>
<input type="text" name="email" placeholder="Email Id" required><br>
<select name="gender" required>
<option value="" disabled selected>Gender</option>
<option value="Male">Male</option>
<option value="Female">Female</option>
</select><br>
<input type="text" name="pan_no" placeholder="Pan No" required ><br>
<input type="text" name="citizenship" placeholder="CITIZENSHIP No" required><br>
<input type="date" name="dob" required ><br>
<select name="dept" required>
<option value="" disabled selected>Department</option>
<option value="Revenue" >Revenue</option>
<option value="Cash Deposit" >Cash Deposit</option>
</select><br>
<input type="text" name="address" placeholder="Address"><br>
<input type="submit" name="submit" value="Add Staff"><br>
</form><br>
</div>
<?php  include 'footer.php'; ?>
</body>
</html>


<?php
if(isset($_POST['submit'])){

    include 'db_connect.php';

    echo $staff_name = $_POST['Staff_name'];
    echo $staff_id = '1011'.mt_rand(100,999);
    echo $staff_password = mt_rand(100000,999999);
    echo $staff_mobile_no = $_POST['Mobile_no'];
    echo $staff_email = $_POST['email'];
    echo $staff_gender = $_POST['gender'];
    echo $staff_department = $_POST['dept'];
    echo $staff_dob = $_POST['dob'];
    echo $staff_pan_no = $_POST['pan_no'];
    echo $staff_citizenship = $_POST['citizenship'];
    echo $staff_address = $_POST['address'];
    
    
    
    $sql = "INSERT INTO bank_staff (Staff_name,Staff_id,Password,Mobile_no,Email_id,Gender,
    Department,DOB,CITIZENSHIP,PAN,Home_addr)
    VALUES('$staff_name','$staff_id','$staff_password','$staff_mobile_no','$staff_email','$staff_gender',
    '$staff_department','$staff_dob','$staff_citizenship','$staff_pan_no','$staff_address') ";

    if($conn->query($sql) == TRUE){

        echo '<script>alert("New Staff Added Successfully\n\nStaff Id is '.$staff_id.'\n\nPassword is '.$staff_password.'")</script>';

    }

    else
     { 
        echo "<br>Error".$sql."<br>".$conn->error;

}

}

?>