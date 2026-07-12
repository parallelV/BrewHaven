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
   GET ID
========================== */

if (!isset($_GET['id'])) {

    header("Location: categories.php");
    exit();

}

$id = (int)$_GET['id'];

/* ==========================
   CHECK IF CATEGORY IS USED
========================== */

$used = mysqli_query(
    $conn,
    "SELECT id
     FROM products
     WHERE category_id='$id'
     LIMIT 1"
);

if(mysqli_num_rows($used)>0){

    $_SESSION['message'] = "Cannot delete category because it is being used by one or more products.";

    $_SESSION['messageClass'] = "danger";

    header("Location: categories.php");
    exit();

}

/* ==========================
   DELETE
========================== */

$delete = mysqli_query(
    $conn,
    "DELETE FROM categories
     WHERE id='$id'"
);

if($delete){

    $_SESSION['message'] = "Category deleted successfully.";

    $_SESSION['messageClass'] = "success";

}else{

    $_SESSION['message'] = "Failed to delete category.";

    $_SESSION['messageClass'] = "danger";

}

header("Location: categories.php");
exit();

?>