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
   GET PRODUCT
========================== */

if (!isset($_GET['id'])) {

    header("Location: products.php");
    exit();

}

$id = (int)$_GET['id'];

$query = mysqli_query(

    $conn,

    "SELECT image
     FROM products
     WHERE id='$id'
     LIMIT 1"

);

if(mysqli_num_rows($query)==0){

    $_SESSION['message']="Product not found.";

    $_SESSION['messageClass']="danger";

    header("Location: products.php");
    exit();

}

$product = mysqli_fetch_assoc($query);

$image = $product['image'];
/* ==========================
   DELETE PRODUCT
========================== */

$delete = mysqli_query(
    $conn,
    "DELETE FROM products
     WHERE id='$id'"
);

/* ==========================
   RESULT
========================== */

if($delete){

    /* Delete image file */

    if(
        !empty($image) &&
        file_exists("../assets/images/products/" . $image)
    ){

        unlink("../assets/images/products/" . $image);

    }

    $_SESSION['message'] = "Product deleted successfully!";

    $_SESSION['messageClass'] = "success";

}else{

    $_SESSION['message'] = "Failed to delete product.";

    $_SESSION['messageClass'] = "danger";

}

header("Location: products.php");
exit();

?>