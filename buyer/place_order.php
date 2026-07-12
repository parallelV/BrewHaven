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
   REQUEST
========================== */

if ($_SERVER['REQUEST_METHOD'] != "POST") {

    header("Location: checkout.php");
    exit();

}

/* ==========================
   GET DATA
========================== */

$user_id = (int)$_SESSION['user_id'];

$payment_method = mysqli_real_escape_string(
    $conn,
    trim($_POST['payment_method'])
);

$total_amount = (float)$_POST['total_amount'];

if($total_amount <= 0){

    $_SESSION['message'] = "Your cart is empty.";

    $_SESSION['messageClass'] = "danger";

    header("Location: cart.php");
    exit();

}

/* ==========================
   LOAD CART ITEMS
========================== */

$cart = mysqli_query(

    $conn,

    "SELECT

    cart.*,

    products.price

    FROM cart

    INNER JOIN products

    ON cart.product_id = products.id

    WHERE cart.user_id = '$user_id'"

);

if(mysqli_num_rows($cart)==0){

    $_SESSION['message'] = "Your cart is empty.";

    $_SESSION['messageClass'] = "danger";

    header("Location: cart.php");
    exit();

}
/* ==========================
   CREATE ORDER
========================== */

$sql = "INSERT INTO orders
(
    user_id,
    total_amount,
    payment_method,
    status
)

VALUES
(
    '$user_id',
    '$total_amount',
    '$payment_method',
    'Pending'
)";

if(!mysqli_query($conn, $sql)){

    $_SESSION['message'] = "Failed to create order.";

    $_SESSION['messageClass'] = "danger";

    header("Location: checkout.php");
    exit();

}

/* ==========================
   GET ORDER ID
========================== */

$order_id = mysqli_insert_id($conn);

/* ==========================
   RESET CART POINTER
========================== */

mysqli_data_seek($cart, 0);
/* ==========================
   SAVE ORDER ITEMS
========================== */

while($item = mysqli_fetch_assoc($cart)){

    $price = $item['price'];

    $quantity = $item['quantity'];

    $subtotal = $price * $quantity;

    $insertItem = "INSERT INTO order_items
    (
        order_id,
        product_id,
        quantity,
        price,
        subtotal
    )

    VALUES
    (
        '$order_id',
        '".$item['product_id']."',
        '$quantity',
        '$price',
        '$subtotal'
    )";

    if(!mysqli_query($conn, $insertItem)){

        $_SESSION['message'] = "Failed to save order items.";

        $_SESSION['messageClass'] = "danger";

        header("Location: checkout.php");
        exit();

    }

}
/* ==========================
   CLEAR CART
========================== */

mysqli_query(

    $conn,

    "DELETE

     FROM cart

     WHERE user_id='$user_id'"

);

/* ==========================
   SUCCESS
========================== */

$_SESSION['message'] = "Your order has been placed successfully!";

$_SESSION['messageClass'] = "success";

/* ==========================
   REDIRECT
========================== */

header("Location: my_orders.php");

exit();

?>