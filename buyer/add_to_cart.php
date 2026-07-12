<?php

session_start();

/* ==========================
   LOGIN REQUIRED
========================== */

if(!isset($_SESSION['user_id'])){

    $_SESSION['message'] = "Please login first.";

    $_SESSION['messageClass'] = "danger";

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

if($_SERVER['REQUEST_METHOD'] != "POST"){

    header("Location: shop.php");

    exit();

}

/* ==========================
   GET DATA
========================== */

$user_id = $_SESSION['user_id'];

$product_id = (int)$_POST['product_id'];

$quantity = (int)$_POST['quantity'];

if($quantity <= 0){

    $quantity = 1;

}
/* ==========================
   CHECK EXISTING CART ITEM
========================== */

$check = mysqli_query(

    $conn,

    "SELECT *

     FROM cart

     WHERE

     user_id='$user_id'

     AND

     product_id='$product_id'

     LIMIT 1"

);

if(mysqli_num_rows($check)>0){

    $cart = mysqli_fetch_assoc($check);

    $newQuantity = $cart['quantity'] + $quantity;

    mysqli_query(

        $conn,

        "UPDATE cart

        SET quantity='$newQuantity'

        WHERE id='".$cart['id']."'"

    );

}else{

    mysqli_query(

        $conn,

        "INSERT INTO cart

        (user_id, product_id, quantity)

        VALUES

        (

        '$user_id',

        '$product_id',

        '$quantity'

        )"

    );

}

/* ==========================
   SUCCESS
========================== */

$_SESSION['message'] = "Product added to cart!";

$_SESSION['messageClass'] = "success";

header("Location: shop.php");

exit();

?>