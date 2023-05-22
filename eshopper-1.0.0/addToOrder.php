<?php
include 'DBconn.php';
session_start();
$userId=$_SESSION['UserID'];
echo $userId;
$sql = "SELECT * FROM `hardwareshoppingcart` WHERE UserId  =$userId ";
$result = mysqli_query($connection,$sql);
while($rwo = mysqli_fetch_array($result)){
    $proId  = $rwo['HardwareId'];
    echo $proId." ";
    $sql2="insert into orders values('',$userId,$proId)";
    mysqli_query($connection,$sql2);
}

$sql3 = "delete from hardwareshoppingcart where UserId   = $userId";
mysqli_query($connection,$sql3);
header('location:cart.php');





?>