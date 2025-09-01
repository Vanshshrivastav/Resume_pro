<?php
session_start();

require 'Dbconnection.php';

$username = $_POST['username'];
$password = $_POST['password'];
$email = $_POST['email'];

if(!empty($username) && !empty($email) && !empty($password)){
    mysqli_query($con,"insert into users(username,email,password) values('$username','$email','$password')") or die(mysqli_error($con));
    echo "<script>alert('Register succesefull '); window.location.href = 'login.php';</script>";
}else{
   echo "<script>alert('Register fail '); window.location.href = 'Register.php';</script>";
}

?>