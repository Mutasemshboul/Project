<?php
include 'DBconn.php';
session_start();
$id = $_POST["cart"];
$userId=$_SESSION['UserID'];
$sql = "insert into shppoingcart values('',$id,$userId)";
mysqli_query($connection,$sql);
header('location:Laptop.php');
?>