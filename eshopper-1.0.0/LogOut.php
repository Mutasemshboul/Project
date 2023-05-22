<?php 
include 'DBconn.php';

session_start();
//include 'FinalRatting.php';
$a = $connection;

include 'FinalRatting.php';

session_unset();
session_destroy();
session_write_close();

    header('location:signin.php');

?>