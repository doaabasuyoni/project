<?php
$server="localhost";
$user = "admin";
$pass="asdf##1234";
$db="image";
$conn = mysqli_connect($server,$user,$pass,$db);
if(!$conn){
echo "<script>alert('error connected');</script>";
echo "error".mysqli_connect_errno();
}
?>
