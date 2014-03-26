<?php
/**
 * @author: Jonathan Hollingsworth
 * @description: Login
 */

// Required files
require "common/dbconnection.php";

$email = $_REQUEST["emailInput"];
$password = $_REQUEST["passwordInput"];

$sql = "select adminUsersId from adminusers where email=? and password=?";

$stmt = $con->prepare($sql);
$stmt->bind_param("ss",$email, $password);
$stmt->execute();
$stmt->bind_result($adminUserId);
$stmt->fetch();

if ($adminUserId > 0 ) {
    header("Location: ../landing.php");
    die();
} else {
    header("Location: ../login.html");
    die();
}

//$mediaId = mysqli_insert_id($con);

