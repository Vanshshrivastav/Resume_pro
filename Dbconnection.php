<?php
$con = mysqli_connect("localhost", "root", "") or die(mysqli_error($con));

mysqli_select_db($con,"dbresume");

if (!$con) {
    die("Connection Failed: " . mysqli_connect_error());
}
?>