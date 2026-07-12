<?php

session_start();

/* ==========================
   LOGIN REQUIRED
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
   VALIDATE
========================== */

if (!isset($_GET['id'])) {

    header("Location: cart.php");
    exit();

}

$user_id = (int)$_SESSION['user_id'];

$cart_id = (int)$_GET['id'];

/* ==========================
   VERIFY OWNER
========================== */

$check = mysqli_query(

    $conn,

    "SELECT *

     FROM cart

     WHERE

     id='$cart_id'

     AND

     user_id='$user_id'

     LIMIT 1"

);

if(mysqli_num_rows($check)==0){

    $_SESSION['message']="Invalid cart item.";

    $_SESSION['messageClass']="danger";

    header("Location: cart.php");

    exit();

}

/* ==========================
   DELETE
========================== */

mysqli_query(

    $conn,

    "DELETE

     FROM cart

     WHERE id='$cart_id'"

);

$_SESSION['message']="Item removed from cart.";

$_SESSION['messageClass']="success";

header("Location: cart.php");

exit();

?>