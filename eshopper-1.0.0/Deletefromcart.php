<?php
include 'DBconn.php';
session_start();
$id = $_POST["Delete"];
$userId=$_SESSION['UserID'];
$sql = "delete from shppoingcart  where Id = $id ";
mysqli_query($connection,$sql);
header('location:cart.php');
?>