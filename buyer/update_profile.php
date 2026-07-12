<?php

session_start();

/* ==========================
   BUYER ONLY
========================== */

if (!isset($_SESSION['user_id'])) {

    header("Location: login.php");
    exit();

}

if ($_SESSION['role'] != "buyer") {

    header("Location: ../seller/dashboard.php");
    exit();

}

/* ==========================
   DATABASE
========================== */

include("../config/database.php");

/* ==========================
   REQUEST
========================== */

if ($_SERVER['REQUEST_METHOD'] != "POST") {

    header("Location: profile.php");
    exit();

}

$user_id = (int)$_SESSION['user_id'];

$contact = mysqli_real_escape_string(
    $conn,
    trim($_POST['contact'])
);

$address = mysqli_real_escape_string(
    $conn,
    trim($_POST['address'])
);

/* ==========================
   UPDATE PROFILE
========================== */

$update = mysqli_query(

    $conn,

    "UPDATE users

     SET

     contact='$contact',

     address='$address'

     WHERE id='$user_id'"

);

if($update){

    $_SESSION['message']="Profile updated successfully.";

    $_SESSION['messageClass']="success";

}else{

    $_SESSION['message']="Failed to update profile.";

    $_SESSION['messageClass']="danger";

}

header("Location: profile.php");

exit();

?>