<?php
include 'DBconn.php';
if(isset($_POST['submit'])){
    $Email = $_POST['email'];
    $Password = $_POST['password'];
    $sql = "select * from users where Email  = '$Email' and Password ='$Password'";
    $res  = mysqli_query($connection,$sql);



    $row = mysqli_fetch_array($res);
        
    session_start();
    $_SESSION['UserID']=$row['id'];
    $_SESSION['Email']=$row['Email'];
    //$_SESSION['RoleFk'] = $row['RoleFk'];
    $_SESSION['Name'] = $row['Name'];

    if($row){
        if($row['Role']==2){
        header('location:index1.php');

    }
    else{
        header('location:Dashbord.php');
    }
    }
    else{
        header('location:signin.php');
    }
    
}



?>