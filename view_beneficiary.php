<?php 

include 'header.php';
include 'customer_profile_header.php' ;
if($_SESSION['customer_login'] == FALSE){

    header("location:customer_login.php");
    return 0;
}

include 'db_connect.php';

$cust_id = $_SESSION['customer_Id']; 
$sql = "SELECT * from beneficiary_$cust_id";
$result1 = $conn->query($sql);
if($result1->num_rows <= 0){

    echo '<script>alert("No Beneficiary found")
    location="fund_transfer.php"</script>';

}



    
?>


<html>
<body>
<head><titleView Beneficiary></title>
<link rel="stylesheet" type="text/css" href="css/view_beneficiary.css"/>
</head>
    <div class="delete_beneficiary_container">
        <table border=1px>
            <th>Sl.No</<th>
            <th>Beneficiary name</<th>
            <th>Beneficiary A/c no</<th>
            <th>IFSC code</<th>
            <th>Status</<th>
            <th>Date Added</<th><br>
<?php

    include 'db_connect.php';

    $cust_id = $_SESSION['customer_Id']; 
    $sql = "SELECT * from beneficiary_$cust_id";
    $result = $conn->query($sql);
    if($result->num_rows > 0){
        $Sl_no = 1 ;
        while($row = $result->fetch_assoc()){
            
            echo '
            <tr>
            <td>'.$Sl_no++.'</td>
			<td>'.$row['Beneficiary_name'].'</td>
            <td>'.$row['Beneficiary_ac_no'].'</td>
            <td>'.$row['IFSC_code'].'</td>
            <td>'.$row['Status'].'</td>
            <td>'.$row['Date_added'].'</td>
             ';

        }

    }

    else{

         echo '<script>alert("No Beneficiary found")</script>';
    }


?>

</table>

            <input type="submit" name="go_back" value="Go back" onclick="history.back()" >

<?php include 'footer.php' ; ?>
</body>
</html>

<?php 



if(isset($_POST['delete_beneficiary'])){

    $row_to_delete_id = $_POST['radio'];

    $sql = "DELETE from beneficiary_$cust_id WHERE id = $row_to_delete_id ";
    if($conn->query($sql)  == TRUE){

        echo '<script>alert("Beneficiary Deleated Successfully")</script>';
        header("location:delete_beneficiary.php");
        
    }

    else{

        echo $sql.$conn->error();
    }

 }

?>