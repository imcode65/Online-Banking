
<html>
<head><title>EMI Calculator</title></head>
<div class="emi_calc_div">
<form method ="post">
<input type="text" name="amount" placeholder="Loan Amount">
<input type="text" name="rate" placeholder="Interest Rate">
<input type="text" name="tenure" placeholder="Loan Tenure (Year)">
<input type="submit" name="submit" value="Calculate" >

</div>
</form>
</dody>
</html>

<?php
if(isset($_POST['submit'])){

$amount =$_POST['amount'];
$rate =$_POST['rate'];
$tenure =$_POST['tenure'];
$emi = $amount * $rate * (pow(1 + $rate, $tenure) / (pow(1 + $rate, $tenure) - 1));
$emi = $amount * $rate/100;
$total = $emi + $amount;
echo "<h3>Loan EMI : ".$emi."</h3><br>";
echo "<h3>Total Payment (Amount + Interest) : ".$total."</h3> <br>";

}


