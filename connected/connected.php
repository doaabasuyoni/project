<?php
$host="localhost";
$user = "root";
$pass="";
$db="doaa";
$conn = mysqli_connect($host,$user,$pass,$db);
if(!$conn){
echo "<script>alert('error connected');</script>";
echo "error".mysqli_connect_errno();
}


?>