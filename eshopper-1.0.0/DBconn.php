<?php
$connection = new mysqli('localhost','root','','gd_project');
if(!$connection){
    die(mysqli_error($connection));
}


?>