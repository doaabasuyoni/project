<?php
$server="database-2.c0r0ncclxwvt.us-east-1.rds.amazonaws.com";
$user = "admin";
$pass="asdf##1234";
$db="image";
$conn = mysqli_connect($host,$user,$pass,$db);
if(!$conn){
echo "<script>alert('error connected');</script>";
echo "error".mysqli_connect_errno();
}
?>
