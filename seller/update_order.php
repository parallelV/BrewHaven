<?php

session_start();

/* ==========================
   SECURITY
========================== */

if (!isset($_SESSION['user_id'])) {
    header("Location: ../buyer/login.php");
    exit();
}

if ($_SESSION['role'] != "admin") {
    header("Location: ../buyer/shop.php");
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

    header("Location: orders.php");
    exit();

}

/* ==========================
   GET DATA
========================== */

$order_id = (int)$_POST['order_id'];

$status = mysqli_real_escape_string(
    $conn,
    trim($_POST['status'])
);

/* ==========================
   VALID STATUS
========================== */

$allowed = array(
    "Pending",
    "Preparing",
    "Completed",
    "Cancelled"
);

if(!in_array($status,$allowed)){

    $_SESSION['message']="Invalid order status.";
    $_SESSION['messageClass']="danger";

    header("Location: orders.php");
    exit();

}

/* ==========================
   CHECK ORDER
========================== */

$check = mysqli_query(
    $conn,
    "SELECT id
     FROM orders
     WHERE id='$order_id'
     LIMIT 1"
);

if(mysqli_num_rows($check)==0){

    $_SESSION['message']="Order not found.";
    $_SESSION['messageClass']="danger";

    header("Location: orders.php");
    exit();

}

/* ==========================
   UPDATE ORDER
========================== */

$result = mysqli_query(
    $conn,
    "UPDATE orders
     SET status='$status'
     WHERE id='$order_id'"
);

if($result){

    $_SESSION['message']="Order updated successfully!";
    $_SESSION['messageClass']="success";

}else{

    $_SESSION['message']="Failed to update order.";
    $_SESSION['messageClass']="danger";

}

header("Location: orders.php");
exit();

?>