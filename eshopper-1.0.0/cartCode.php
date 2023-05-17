<?php
include 'DBconn.php';
session_start();
$id = substr($_POST["cart"],1,);

echo $_POST["cart"][0];
if($_POST["cart"][0]=='l'){
    $userId= $_SESSION['UserID'];
    $sql = "insert into shppoingcart values('',$id,$userId)";
    mysqli_query($connection,$sql);
    header('location:Laptop.php');
}
else{
    $userId= $_SESSION['UserID'];
    $sql = "insert into hardwareshoppingcart values('',$id,$userId)";
    mysqli_query($connection,$sql);
    header('location:Hardware.php');
}
