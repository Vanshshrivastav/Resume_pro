<?php
require "Dbconnection.php";

if (isset($_GET["id"])) {

    $user_id = $_GET["id"];

    mysqli_query($con, "DELETE FROM user WHERE id = $user_id") or die(mysqli_error($con));

    mysqli_close($con);

    header("Location: display.php?msg=Record Deleted");
    exit;
} else {
    echo "Invalid Request!";
}
?>