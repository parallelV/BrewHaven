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
   REQUEST VALIDATION
========================== */

if ($_SERVER['REQUEST_METHOD'] != "POST") {

    header("Location: cart.php");
    exit();

}

/* ==========================
   GET DATA
========================== */

$user_id = (int)$_SESSION['user_id'];

$cart_id = (int)$_POST['cart_id'];

$quantity = (int)$_POST['quantity'];

if($quantity < 1){

    $quantity = 1;

}

/* ==========================
   VERIFY CART ITEM
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
   UPDATE QUANTITY
========================== */

mysqli_query(

    $conn,

    "UPDATE cart

     SET quantity='$quantity'

     WHERE id='$cart_id'"

);

$_SESSION['message']="Cart updated successfully.";

$_SESSION['messageClass']="success";

header("Location: cart.php");

exit();

?>